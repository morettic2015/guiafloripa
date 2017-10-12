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
//$std->dtFrom = $row['dtFrom'];
            $std->nmPlace = ($row['nmPlace']);
//$std->dtUntil = $row['dtUntil'];
            $std->idType = $tp;
            $std->nrCep = $row['nrCep'];
            $std->deWebsite = $row['deWebsite'];
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
        //Set Charset
        DB::query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        //Set
        $query = "select * from viewEventPlaces where dtFrom >= now()- INTERVAL 1 DAY and dtUntil<=NOW() + INTERVAL 1 DAY";
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
            $std->dtFrom = removeOneDay($row['dtFrom']);
            $std->dtUntil = removeOneDay($row['dtUntil']);
            $std->idType = $row['idType'];
            $std->nrCep = $row['nrCep'];
            $std->nrLat = offset($row['nrLat']);
            $std->nrLng = offset($row['nrLng']);
            $std->deWebsite = $row['deWebsite'];
            $std->deImg = $row['deImg'];
            $std->printDate = printEventDate($row['dtFrom'], $row['dtUntil']);
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
        $cine = CinemaController::loadCinemaPlaces(null, null);
        $stdGuia->e = array_merge($stdGuia->e, $cine);
//Close Connection
        DB::disconnect();
        return $stdGuia;
    }

    /**
     * @Update Places & Events Image
     * @GEt From Wordpress
     */
    public static function updateImages() {
        echo "<pre>";
        $conn = new MysqlDB();
        $query = "select ID,guid,post_parent,post_id,meta_key,meta_value from wp_posts join wp_postmeta on ID = post_id where post_type = 'attachment' and guid is not null and guid like '%http%' and guid like '%.%' limit 300";
        echo $query;
        $conn->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $conn->execute($query); // misspelled SELECT
        echo "<pre>";
        $total = 0;
        while ($row = $conn->hasNext()) {
            var_dump($row);
            $total++;
        }
        echo "<br>";
        echo $total;
        $conn->closeConn();
    }

    /**
     * @Update URL from POSTS!
     * @OPENX = LInk do GUia para controlar acessos
     * @LINK DO SITE
     * @PERMALINK WORDPRESS Plugin Wordpress
     */
    public static function updateURLS() {
//DB::debugMode();
        $conn = new MysqlDB();
        $query = "  select 
                        ID,
                        concat('http://www.guiafloripa.com.br/novoads/www/delivery/ck.php?bannerid=',(select meta_value from wp_postmeta where meta_key = 'id_anuncio_openx' and post_id = ID)) as fullOpen,
                        (select meta_value from wp_postmeta where meta_key = 'id_anuncio_openx' and post_id = ID) as id_anuncio_openx, 
                        (select meta_value from wp_postmeta where meta_key = 'url_website' and post_id = ID) as urlWebsite 
                    from wp_posts 
                    where ID 
                        in (select post_id from wp_postmeta where meta_key in ('id_anuncio_openx','url_website') )";
        $conn->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $conn->execute($query); // misspelled SELECT
        echo "<pre>";
        $tot = 0;
        while ($row = $conn->hasNext()) {
//Verify whats the current URL
            $url = empty($row['id_anuncio_openx']) ? (empty($row['urlWebsite']) ? "#" : $row['urlWebsite']) : $row['fullOpen'];
            echo "<br>";
            echo $url;
            echo "<br>";
            echo $row['urlWebsite'];
            echo "<br>";
            echo $row['id_anuncio_openx'];
            echo "<br>";
            DB::query("SELECT * FROM Place WHERE idPlace=%s", $row['ID']);
            $counter = DB::count();
//Se tiver mais de ZERO ocorrências atualiza no APP
            if ($counter > 0) {
//var_dump($row);
                $tot++;
                echo $counter . " ID FOUND " . $row['ID'] . "\n";
//continue;
                DB::update('Place', array(
                    'deWebsite' => $url
                        ), "idPlace=%s", $row['ID']);
            }
        }
//Plugin Wordpress para redirecionamento 
//Não tem link nao tem OPENX link patrocinado
        $baseUrl = "http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=";
        DB::query("update Place as a set deWebsite = concat('$baseUrl',a.idPlace) where deWebsite is null");

//Imprime o total
        echo $tot . " Found"; //Total de registros 
//Close Database
        DB::disconnect(); //Close Con FROM APP
        $conn->closeConn(); //Close Con FROM 
    }

    public static function cronEventCategory($type, $id) {
        $yesterday = strtotime("-1 week");
        $timestamp = strtotime('+1 week');

        $conn = new MysqlDB();

        $query = "select * from view_events as a left join view_places as b on a.event_id_place = b.ID where event_dtstart >= $yesterday  and event_dtend <= $timestamp  and  a.event_id in ( select object_id from $type) ";
        $conn->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $conn->execute($query); // misspelled SELECT
        //echo "Init List ";
        echo "<pre>";
        $lEventos = Array();

        while ($row = $conn->hasNext()) {
            //var_dump($row);
            try {
                $eventRow = new stdClass();
                $eventRow->event_id = $row['event_id'];
                $eventRow->event_tit = $row['event_tit'];
                $eventRow->event_info = $row['event_info'];
                $eventRow->event_dtend = $row['event_dtend'];
                $eventRow->event_dtstart = $row['event_dtstart'];
                $eventRow->event_id_place = $row['event_id_place'];
                $eventRow->vevent_price_label = $row['vevent_price_label']; //@Todo Adicionar na concatenação
                $eventRow->vevent_price = $row['vevent_price']; //@Todo Adicionar na concatenação
                $eventRow->event_moreinfo = $row['event_moreinfo']; //@Todo Adicionar na concatenação
                $eventRow->ID = $row['ID'];
                $eventRow->tit = $row['tit'];
                $eventRow->info = $row['info'];
                $eventRow->endereco = $row['endereco'];
                $eventRow->telefone = $row['telefone'];
                $eventRow->cidade = $row['cidade'];
                $eventRow->email = $row['email'];
                //var_dump($eventRow);die;
                GuiaController::insertUpdateEvent($eventRow, $id);
            } catch (Exception $e) {
                var_dump($e);
            }
        }
        DB::disconnect();
        $conn->closeConn();
    }

    public static function testCinemas() {
        $yesterday = strtotime("-1 week");
        $timestamp = strtotime('tomorrow +12000min');

//DB::debugMode();
//$query = "SELECT * from view_cinema where (dtstart between $yesterday and $timestamp) or (dtend between $yesterday and $timestamp)  order by post_title";

        $query = "select * from view_cinema where id_wp_post = 13534 and dtend < now() and titulo is not null";
        echo $query;
        $mdb = new MysqlDB();
        $mdb->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $mdb->execute($query); // misspelled SELECT
//$row = $mdb->hasNext();

        echo "<pre>";
//var_dump($row);
//  var_dump($eventos);die; */
//https://maps.googleapis.com/maps/api/geocode/json?address=Rua%20Bocai%EF%BF%BDva,%202468%20-%20Centro&key=AIzaSyBszRC_PVudlS_S_O_ejw00pZ_fJFU3Q0o
//$cinemas = Array();

        while ($row = $mdb->hasNext()) {
            $eventRow = new stdClass();
            unset($row['post_content']);
            unset($row['outras_informacoes']);
            unset($row['salas_horarios']);
            var_dump($row); //die;
        }


        /*  $mdb->query("select outras_informacoes,salas_horarios,titulo,titulo_original, ano_producao, duracao,  pais_origem, diretor,    elenco,    sinopse,    imagem_full FROM wp_cn_filme order by id_wp_cn_filme DESC LIMIT 200");
          while ($row = $mdb->hasNext()) {
          $eventRow = new stdClass();
          var_dump($row); //die;
          } */
    }

    /**
     *  Insert or update Cinemas
     * */
    public static function cronCinemas() {


        $yesterday = strtotime("-8 week");
        $timestamp = strtotime('+4 week');

        $now = time();

//DB::debugMode();
        $query = "SELECT * from view_cinema where id_cn_filme is not null order by dtstart,dtend asc";
//echo $query;
        $mdb = new MysqlDB();
        $mdb->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $mdb->execute($query); // misspelled SELECT

        echo "<pre>";

        while ($row = $mdb->hasNext()) {
            $eventRow = new stdClass();
//var_dump($row); //die;
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
            $eventRow->post_title = utf8_encode($row['post_title']);
            $eventRow->state = $row['state'];
            $eventRow->city = $row['city'];
            $eventRow->addressID = $row['address'];
            $eventRow->post_content = $row['post_content'];
            $eventRow->outras_informacoes_clean = strip_tags($row['outras_informacoes']);
            $eventRow->outras_informacoes_html = $row['outras_informacoes'];
            @$eventRow->ID = $row['ID_POST_'];
            $eventRow->salas_horarios = $row['salas_horarios'];
//var_dump($eventRow);
//  echo "<br>".utf8_encode($eventRow->titulo)."CHARSET...." . mb_detect_encoding($eventRow->titulo);
// echo "<br>".utf8_encode($eventRow->titulo_original)."CHARSET...." . mb_detect_encoding($eventRow->titulo_original);

            GuiaController::updateCinemaEvent($eventRow);
            $encode = mb_detect_encoding($eventRow->titulo);
            echo date('d/m/Y', $eventRow->dtstart) . ',' . $eventRow->dtstart . "," . date('d/m/Y', $eventRow->dtend) . ',' . $eventRow->dtend . "," . mb_convert_encoding($eventRow->titulo, "utf8", $encode) . ',' . mb_detect_encoding($eventRow->titulo) . "<br>";
        }
        DB::disconnect();
        $mdb->closeConn();
    }

    public static function updateCinemaEvent($obj) {
//DB::debugMode();
        DB::query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


//echo time() . "*********************************************\n";
// var_dump($obj);
        if (is_null($obj->id_wp_post))
            return;

        $query = "SELECT count(idPlace) FROM Place where idPlace = " . $obj->id_wp_post;

        $number_accounts = DB::queryFirstField($query);
        var_dump($number_accounts);
// echo $number_accounts === "1";
//  echo "Cinema exists?" . $number_accounts;

        if (!($number_accounts[0] > 0)) {

            $obj->geo = GeocoderController::geocodeQuery($obj->addressID);
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
        }
//insert update Cinema
        echo $obj->titulo_original . " --";

//$encode = mb_detect_encoding($obj->titulo);
        $deEvent = ($obj->titulo_original . ", (" . $obj->ano_producao . "), " . $obj->duracao . "min  ");
        $deDetail = (($obj->sinopse) . "<br>Diretor:" . $obj->diretor . "<br>" . ($obj->outras_informacoes_html) . "<br>" . $obj->salas_horarios);

//echo $encode . "--------";
        $dtFrom = date("Y-m-d H:i:s", $obj->dtstart);
        $dtUntil = date("Y-m-d H:i:s", $obj->dtend);
        DB::insertUpdate(
                'Event', array(
            'idEvent' => $obj->id_cn_filme, //primary key
            'deEvent' => $deEvent,
            'deDetail' => $deDetail,
            'dtFrom' => $dtFrom,
            'dtUntil' => $dtUntil,
            'idPlaceOwner' => $obj->id_wp_post,
            'nrEdition' => '1',
            'deImg' => $obj->imagem_full,
            'idType' => 3
        ));

        DB::debugMode();
        DB::insertUpdate(
                'SubCategory', array(
            'fkPlace' => $obj->id_wp_post, //primary key
            'fkEvent' => $obj->id_cn_filme,
            'fkType' => 3,
            'dtStart' => $dtFrom,
            'dtEnd' => $dtUntil,
            'catInfo' => 'movie'
        ));
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

        $query = "SELECT count(idPlace) FROM Place where idPlace = " . $obj->ID;

        $number_accounts = DB::queryFirstField($query);
        //var_dump($number_accounts);
// echo $number_accounts === "1";
//  echo "Cinema exists?" . $number_accounts;

        if (!($number_accounts[0] > 0)) {

            //echo time() . "*********************************************\n";
            $obj->geo = GeocoderController::geocodeQuery($obj->endereco . ", " . $obj->cidade);

            if (is_null($obj->geo) || is_null($obj->geo->lat)) {
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
                'deWebsite' => "http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=" . $obj->ID,
                'deAddress' => ($obj->geo->formatted_address),
                'deLogo' => 'default',
                'dePlace' => ($obj->info),
                'deEmail' => $obj->email,
                'nrLat' => $obj->geo->lat,
                'nrLng' => $obj->geo->lng,
                'nrCep' => $cep,
                'idPlaceBranch' => null
            ));
            DB::commit();
        }
//Insert update Event
        $dtFrom = date("Y-m-d H:i:s", $obj->event_dtstart);
        $dtUntil = date("Y-m-d H:i:s", $obj->event_dtend);

        //Update Event
        DB::insertUpdate(
                'Event', array(
            'idEvent' => $obj->event_id, //primary key
            'deEvent' => ($obj->event_tit),
            'deDetail' => ($obj->event_info) . "<br>" . $obj->vevent_price_label . ' ' . $obj->vevent_price . '<br>' . $obj->event_moreinfo,
            'dtFrom' => $dtFrom,
            'dtUntil' => $dtUntil,
            'idPlaceOwner' => $obj->ID,
            'nrEdition' => '1',
            'idType' => $id
        ));
        DB::commit();

        //Subcategory
        DB::insertUpdate(
                'SubCategory', array(
            'fkPlace' => $obj->ID, //primary key
            'fkEvent' => $obj->event_id,
            'fkType' => $id,
            'catInfo' => 'cat',
            'dtStart' => $dtFrom,
            'dtEnd' => $dtUntil
        ));
    }

    /*
     *   @ FIltra eventos pela data e pelo tipo.
     */

    public static function findEventosByDateType($dtOrigem, $dtFim, $type) {
        $today = date("Y-m-d");
        $time = strtotime($today) + 86400;
        $tomorrow = date('Y-m-d', $time);
//If date is empty or another shit
        $query = "select * from viewEventPlaceType where date(dtFrom) >= date('$today') and idType = " . $type;
//
        $query2 = "select * from viewEventPlaceType where idType = " . $type
                . " and DATE(dtFrom) >= date('" . $dtOrigem
                . "') AND DATE(dtUntil)<= date('" . $dtFim . "')";
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
            $std->deWebsite = $row['deWebsite'];
            $std->deAddress = $row['deAddress'];
            $std->deEvent = $row['deEvent'];
            $std->deDetail = $row['deDetail'];
            $std->dtFrom = removeOneDay($row['dtFrom']);
            $std->nmPlace = ($row['nmPlace']);
            $std->dtUntil = removeOneDay($row['dtUntil']);
            $std->idType = $row['idType'];
            $std->nrCep = $row['nrCep'];
            $std->nrLat = $row['nrLat'];
            $std->nrLng = $row['nrLng'];
            $std->deImg = $row['deImg'];
            $std->printDate = printEventDate($row['dtFrom'], $row['dtUntil']);
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

                var_dump($row);
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

function removeOneDay($date) {
//echo $date;die;
    $date = new DateTime($date); // For today/now, don't pass an arg.
//$date->modify("-1 day -3 hour");
//$date->modify("");
    return $date->format("d/m/Y H:i");
}

function offset($point) {
    $offset = rand(0, 1004) / 10000000;
    return floatval($point) + $offset;
}

function formatCineDate($date) {
//echo $date;die;
    $date = new DateTime($date); // For today/now, don't pass an arg.
//$date->modify("");
    return $date->format("d/m/Y");
}

function printEventDate($dtFrom, $dtUntil) {
//echo $date;die;
    $date1 = new DateTime($dtFrom); // For today/now, don't pass an arg.
    $date2 = new DateTime($dtUntil);
    $dt1 = $date1->format("d/m/Y");
    $dt2 = $date2->format("d/m/Y");

    $datePrint = "";

    if ($dt1 === $dt2) {
        $datePrint = $date1->format("d/m") . " " . $date1->format("H:i") . "-" . $date2->format("H:i");
    } else {
        $datePrint = $date1->format("d/m") . " - " . $date2->format("d/m") . " " . $date1->format("H:i") . "-" . $date2->format("H:i");
    }

    return $datePrint;
}
