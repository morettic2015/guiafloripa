<?php

include 'Mysql.class.php';
//Database configuration
DB::$user = 'guia';
DB::$password = 'Gu14Fl0r1p@';
DB::$dbName = 'guiafloripa_app';
DB::$host = 'localhost';
DB::$port = '3306';
DB::$encoding = 'utf8'; // defaults to latin1 if omitted
DB::$error_handler = 'my_error_handler';

class GuiaController extends stdClass {

    /**
     * @Search for Places by Type
     */
    public static function getPlacesByType($std) {
        //DB::debugMode();
        $stdGuia = new stdClass();
        $stdGuia->e = array();
        //Find places with the given ID (category)
        $query = "SELECT * FROM guiafloripa_app.Place where idPlace in (select fkIdPlace from PlaceType where fkIdType = " . $std->types . ")";
        $places = DB::query($query);
        $tp = $std->types;
        foreach ($places as $row) {
            $std = new stdClass();
            $std->nrPhone = $row['nrPhone'];
            $std->deLogo = $row['deLogo'];
            $std->deAddress = $row['deAddress'];
            //$std->deEvent = $row['deEvent'];
            $std->dePlace = $row['dePlace'];
            $std->dtFrom = $row['dtFrom'];
            $std->nmPlace = ($row['nmPlace']);
            //$std->dtUntil = $row['dtUntil'];
            $std->idType = $tp;
            $std->nrCep = $row['nrCep'];
            $std->nrLat = $row['nrLat'];
            $std->nrLng = $row['nrLng'];
            //Adiciona to array
            $stdGuia->e[] = $std;
        }
        //Close connection
        DB::disconnect();
        //Return Std Object to be Serialized to JSON
        return $stdGuia;
    }

    /**
     *   @ Recupera todos os eventos apresentados hoje com todas as categorias
     */
    public static function getEventosDeHoje() {
        $today = date("Y-m-d");
        DB::query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

        $query = "select * from viewEventPlaces where date(dtUntil) >= '$today'";
        $eventos = DB::query($query); // misspelled SELECTvardump(
        //Return Object
        $stdGuia = new stdClass();
        $stdGuia->e = [];
        foreach ($eventos as $row) {

            $img = is_null($row['deLogo']) ? (is_null($row['deImg']) ? 'default' : $row['deImg']) : $row['deLogo'];

            $std = new stdClass();
            $std->nrPhone = $row['nrPhone'];
            $std->deLogo = $img;
            $std->deAddress = ($row['deAddress']);
            $std->nmPlace = ($row['nmPlace']);
            $std->deEvent = ($row['deEvent']);
            $std->deDetail = ($row['deDetail']);
            $std->dtFrom = $row['dtFrom'];
            $std->dtUntil = $row['dtUntil'];
            $std->idType = $row['idType'];
            $std->nrCep = $row['nrCep'];
            $std->nrLat = $row['nrLat'];
            $std->nrLng = $row['nrLng'];
            $std->deImg = $row['deImg'];
            //Adiciona
            $stdGuia->e[] = $std;
        }
        //get types descriptions
        $query = "SELECT * FROM Type;";
        //RUn qyery
        $types = DB::query($query); // misspelled SELECT
        //Prepare another return
        $stdGuia->t = [];
        foreach ($types as $row) {
            $std = new stdClass();
            $std->idType = $row['idType'];
            $std->deType = $row['deType'];
            $stdGuia->t[] = $std;
        }
        //Merge array with Cinemas from today
        $cine = CinemaController::loadCinemaPlaces(null,null);
        $stdGuia->e = array_merge($stdGuia->e, $cine);
        //Close Connection
        DB::disconnect();
        return $stdGuia;
    }

    public static function cronEventCategory($type, $id) {
        $yesterday = strtotime("today -2000min");
        $timestamp = strtotime('today +2000min');

        $conn = new MysqlDB();

        $query = "select * from view_events as a left join view_places as b on a.event_id_place = b.ID where event_dtstart >= $yesterday  and event_dtend <= $timestamp  and  a.event_id in ( select object_id from $type) ";
        $conn->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $conn->execute($query); // misspelled SELECT
        echo "Init List ";
        echo "<pre>";
        $lEventos = Array();

        while ($row = $conn->hasNext()) {
            var_dump($row);
            $eventRow = new stdClass();
            $eventRow->event_id = $row['event_id'];
            $eventRow->event_tit = $row['event_tit'];
            $eventRow->event_info = $row['event_info'];
            $eventRow->event_dtend = $row['event_dtend'];
            $eventRow->event_dtstart = $row['event_dtstart'];
            $eventRow->event_id_place = $row['event_id_place'];
            $eventRow->ID = $row['ID'];
            $eventRow->tit = $row['tit'];
            $eventRow->info = $row['info'];
            $eventRow->endereco = $row['endereco'];
            $eventRow->telefone = $row['telefone'];
            $eventRow->cidade = $row['cidade'];
            $eventRow->email = $row['email'];
            $eventRow->geo = GeocoderController::geocodeQuery($eventRow->endereco . ", " . $eventRow->cidade);
            GuiaController::insertUpdateEvent($eventRow, $id);
        }

        $conn->closeConn();
    }

    /**
     *  Insert or update Cinemas
     * */
    public static function cronCinemas() {


        $yesterday = strtotime("-1 week");
        $timestamp = strtotime('tomorrow +4000min');

        //DB::debugMode();
        $query = "SELECT * from view_cinema where dtstart>= $yesterday and dtend<= $timestamp  order by post_title";

        $mdb = new MysqlDB();
        $mdb->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $eventos = $mdb->execute($query); // misspelled SELECT

        /* echo "<pre>";
          var_dump($eventos);die; */

        //https://maps.googleapis.com/maps/api/geocode/json?address=Rua%20Bocai%EF%BF%BDva,%202468%20-%20Centro&key=AIzaSyBszRC_PVudlS_S_O_ejw00pZ_fJFU3Q0o
        $cinemas = Array();

        while ($row = $mdb->hasNext()) {
            $eventRow = new stdClass();
            //var_dump($row);die;
            $eventRow->dtstart = $row['dtstart'];
            $eventRow->dtend = $row['dtend'];
            $eventRow->titulo = utf8_encode($row['titulo']);
            $eventRow->titulo_original = utf8_encode($row['titulo_original']);
            $eventRow->ano_producao = $row['ano_producao'];
            $eventRow->duracao = $row['duracao'];
            $eventRow->pais_origem = $row['pais_origem'];
            $eventRow->diretor = $row['diretor'];
            $eventRow->elenco = $row['elenco'];
            $eventRow->sinopse = $row['sinopse'];
            $eventRow->imagem_full = $row['imagem_full'];
            $eventRow->id_cn_filme_post = $row['id_cn_filme_post'];
            $eventRow->id_cn_filme = $row['id_cn_filme'];
            $eventRow->id_wp_post = $row['id_wp_post'];
            $eventRow->post_title = $row['post_title'];
            $eventRow->state = $row['state'];
            $eventRow->city = $row['city'];
            $eventRow->addressID = $row['address'];
            $eventRow->post_content = $row['post_content'];
            $eventRow->outras_informacoes_clean = strip_tags($row['outras_informacoes']);
            $eventRow->outras_informacoes_html = $row['outras_informacoes'];
            $eventRow->ID = $row['ID_POST_'];
            $eventRow->salas_horarios = $row['salas_horarios'];

            $eventRow->geo = GeocoderController::geocodeQuery($eventRow->addressID);
            GuiaController::updateCinemaEvent($eventRow);
        }
        DB::disconnect();
    }

    public static function updateCinemaEvent($obj) {

        DB::query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


        echo time() . "*********************************************\n";
        var_dump($obj);

        if (is_null($obj->geo->lat)) {
            return;
        }
        $cep = "88000-000";
        $cepvet = explode(",", $obj->geo->formatted_address);
//$vSize = count($cepvet);
        $cep1 = preg_replace('/[^0-9]/', '', $cepvet[3]);
        $cep = empty($cep1) ? $cep : $cep1;

//Insert Update Place
        DB::insertUpdate(
                'Place', array(
            'idPlace' => $obj->id_wp_post, //primary key
            'nmPlace' => ($obj->post_title),
            'nrPhone' => null,
            'deWebsite' => null,
            'deAddress' => ($obj->geo->formatted_address),
            'deLogo' => 'default',
            'dePlace' => ($obj->post_content),
            'deEmail' => null,
            'nrLat' => $obj->geo->lat,
            'nrLng' => $obj->geo->lng,
            'nrCep' => $cep,
            'idPlaceBranch' => null
                ), 'nmPlace=%s', $obj->post_title, 'deAddress=%s', $obj->geo->formatted_address, 'dePlace=%s', ($obj->post_content), 'nrLat', $obj->geo->lat, 'nrLng', $obj->geo->lng, 'nrCep=%s', $cep);
        DB::commit();


//insert update Cinema

        $dtFrom = gmdate("Y-m-d H:i:s", $obj->dtstart);
        $dtUntil = gmdate("Y-m-d H:i:s", $obj->dtend);
        DB::insertUpdate(
                'Event', array(
            'idEvent' => $obj->id_cn_filme, //primary key
            'deEvent' => ($obj->titulo_original . ", (" . $obj->ano_producao . "), " . $obj->duracao . "min  "),
            'deDetail' => ($obj->sinopse . "<br>Diretor:" . $obj->diretor . "<br>" . $obj->outras_informacoes_html . "<br>" . $obj->salas_horarios),
            'dtFrom' => $dtFrom,
            'dtUntil' => $dtUntil,
            'idPlaceOwner' => $obj->id_wp_post,
            'nrEdition' => '1',
            'deImg' => $obj->imagem_full,
            'idType' => 3
                ), 'deImg=%s', $obj->imagem_full, 'deEvent=%s', ($obj->titulo_original . ", (" . $obj->ano_producao . "), " . $obj->duracao . "min  "), 'deDetail=%s', ($obj->sinopse . "<br>Diretor:" . $obj->diretor . "<br>" . $obj->outras_informacoes_html . "<br>" . $obj->salas_horarios), 'dtFrom', $dtFrom, 'dtUntil', $dtUntil, 'nrEdition=%s', '2');
        DB::commit();
    }

    public static function getCategoryIDS($tp) {
        return "select `wp_term_relationships`.`object_id` AS `object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_taxonomy_id` from `wp_term_taxonomy` where (`wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%$tp%'))) and (`wp_term_taxonomy`.`taxonomy` = 'segmento'))) group by `wp_term_relationships`.`object_id` order by `wp_term_relationships`.`object_id`";
    }

    /**
     * Insert or update Places and Events
     * */
    public static function insertUpdateEvent($obj, $id) {


        DB::debugMode();

        DB::query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


        echo time() . "*********************************************\n";
        var_dump($obj);

        if (is_null($obj->geo->lat)) {
            return;
        }
        $cep = "88000-000";
        $cepvet = explode(",", $obj->geo->formatted_address);
//$vSize = count($cepvet);
        $cep1 = preg_replace('/[^0-9]/', '', $cepvet[3]);
        $cep = empty($cep1) ? $cep : $cep1;

//Insert Update Place
        DB::insertUpdate(
                'Place', array(
            'idPlace' => $obj->ID, //primary key
            'nmPlace' => ($obj->tit),
            'nrPhone' => $obj->telefone,
            'deWebsite' => null,
            'deAddress' => ($obj->geo->formatted_address),
            'deLogo' => 'default',
            'dePlace' => ($obj->info),
            'deEmail' => $obj->email,
            'nrLat' => $obj->geo->lat,
            'nrLng' => $obj->geo->lng,
            'nrCep' => $cep,
            'idPlaceBranch' => null
                ), 'nmPlace=%s', $obj->tit, 'nrPhone=%s', $obj->telefone, 'deWebsite', null, 'deAddress=%s', $obj->geo->formatted_address, 'dePlace=%s', ($obj->info), 'deEmail=%s', $obj->email, 'nrLat', $obj->geo->lat, 'nrLng', $obj->geo->lng, 'nrCep=%s', $cep);
        DB::commit();
//Insert update Event
        $dtFrom = gmdate("Y-m-d H:i:s", $obj->event_dtstart);
        $dtUntil = gmdate("Y-m-d H:i:s", $obj->event_dtend);
        DB::insertUpdate(
                'Event', array(
            'idEvent' => $obj->event_id, //primary key
            'deEvent' => ($obj->event_tit),
            'deDetail' => ($obj->event_info),
            'dtFrom' => $dtFrom,
            'dtUntil' => $dtUntil,
            'idPlaceOwner' => $obj->ID,
            'nrEdition' => '1',
            'idType' => $id
                ), 'deEvent=%s', (strip_tags($obj->event_tit)), 'deDetail=%s', (strip_tags($obj->event_info)), 'dtFrom', $dtFrom, 'dtUntil', $dtUntil, 'nrEdition=%s', '2');
        DB::commit();
    }

    /*
     *   @ FIltra eventos pela data e pelo tipo.
     */

    public static function findEventosByDateType($dtOrigem, $dtFim, $type) {
        $today = date("Y-m-d");

//If date is empty or another shit
        $query = "select * from viewEventPlaces where dtUntil >= '$today' and idType = " . $type;
//
        $query2 = "select * from viewEventPlaces where idType = " . $type
                . " and DATE(dtFrom) >= '" . $dtOrigem
                . "' AND DATE(dtUntil)<= '" . $dtFim . "'";
        if (empty($dtOrigem) || empty($dtFim) || $dtOrigem == "-1" || $dtFim == "-1") {
            $eventos = DB::query($query); // misspelled SELECT
        } else {
            $eventos = DB::query($query2); // misspelled SELECT
        }
//Return Object
        $stdGuia = new stdClass();
        $stdGuia->e = [];
        foreach ($eventos as $row) {
            $img = $row['deLogo'] === "default" ? (empty($row['deImg']) ? 'default' : $row['deImg']) : $row['deLogo'];
            $std = new stdClass();
            $std->nrPhone = $row['nrPhone'];
            $std->deLogo = $img;
            $std->deAddress = $row['deAddress'];
            $std->deEvent = $row['deEvent'];
            $std->deDetail = $row['deDetail'];
            $std->dtFrom = $row['dtFrom'];
            $std->nmPlace = ($row['nmPlace']);
            $std->dtUntil = $row['dtUntil'];
            $std->idType = $row['idType'];
            $std->nrCep = $row['nrCep'];
            $std->nrLat = $row['nrLat'];
            $std->nrLng = $row['nrLng'];
            $std->deImg = $row['deImg'];
//Adiciona
            $stdGuia->e[] = $std;
        }
//get types descriptions
        $query = "SELECT * FROM Type;";
//RUn qyery
        $types = DB::query($query); // misspelled SELECT
//Prepare another return
        $stdGuia->t = [];
        foreach ($types as $row) {
            $std = new stdClass();
            $std->idType = $row['idType'];
            $std->deType = $row['deType'];
            $stdGuia->t[] = $std;
        }
//Close Connection
        DB::disconnect();
        return $stdGuia;
    }

    /**
     *  @Insert places and create custom cat by View
     * */
    public static final function updatePlacesByCategory($view, $typeID) {
        echo "<pre>";
        DB::debugMode();
        $conn = new MysqlDB();
        $query = "select * from $view where endereco is not null order by ID desc";
        //echo $query;
        $conn->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $conn->execute($query); // misspelled SELECT
        $i = 0;
        //while ($row = $conn->hasNext()) {
        while ($row = $conn->hasNext()) {
            $obj = null;
            try {
                $obj = GeocoderController::geocodeQuery(utf8_encode($row['endereco'] . ',' . $row['cidade']));

                if (is_null($obj->lat))
                    continue;

                //CEP FROM GEOLOCATION
                $cep = $obj->cep == NULL ? "88000-000" : $obj->cep;
                //Place Description
                $dePlace = $row['post_excerpt'];
                $nmPlace = $row['post_title'];
                $email = strlen($row['email']) < 2 ? NULL : $row['email'];

                //Insert Update Place
                DB::insertUpdate(
                        'Place', array(
                    'idPlace' => $row['ID'], //primary key
                    'nmPlace' => mb_convert_encoding($nmPlace, "utf8"),
                    'nrPhone' => $row['tel'],
                    'deWebsite' => null,
                    'deAddress' => ($obj->formatted_address),
                    'deLogo' => $row['logo'],
                    'dePlace' => $dePlace,
                    'deEmail' => $email,
                    'nrLat' => $obj->lat,
                    'nrLng' => $obj->lng,
                    'nrCep' => $cep,
                    'idPlaceBranch' => null
                        ), 'deLogo=%s', $row['logo'], 'nmPlace=%s', mb_convert_encoding($nmPlace, "utf8"), 'deAddress=%s', $obj->formatted_address, 'dePlace=%s', ($dePlace), 'nrLat', $obj->lat, 'nrLng', $obj->lng, 'nrCep=%s', $cep);
                //Associate place with a given type
                $query = "insert into PlaceType values($typeID," . $row['ID'] . ",now()) on duplicate key update lastUpdate = now();";
                DB::query($query);
                DB::affectedRows();
                DB::commit();
            } catch (Exception $ex) {
                //var_dump($ex);
                logActions($ex->getMessage());
                logActions($ex->getCode());
                logActions($ex->getFile());
                logActions($ex->getLine());
                logActions($ex->getTraceAsString());
                logActions($ex);
                continue;
            }
        }
    }

}

/* * ****
 *    Database Handlers
 */

function my_error_handler($params) {
    echo "Error: " . $params['error'] . "<br>\n";
    echo "Query: " . $params['query'] . "<br>\n";
    // die; // don't want to keep going if a query broke
}
