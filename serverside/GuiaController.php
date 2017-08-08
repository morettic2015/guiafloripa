<?php

//Database configuration
DB::$user = 'guia';
DB::$password = 'Gu14Fl0r1p@';
DB::$dbName = 'guiafloripa_app';
DB::$host = 'localhost';
DB::$port = '3306';
DB::$error_handler = 'my_error_handler';

class GuiaController extends stdClass {

    /**
     *   @ Recupera todos os eventos apresentados hoje com todas as categorias
     */
    public static function getEventosDeHoje() {
        $today = date("Y-m-d");
        DB::query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

        $query = "select * from viewEventPlaces where dtUntil >= '$today'";
        $eventos = DB::query($query); // misspelled SELECTvardump(
        // var_dump($eventos);
        // die;
        //Return Object
        $stdGuia = new stdClass();
        $stdGuia->e = [];
        foreach ($eventos as $row) {
            $std = new stdClass();
            $std->nrPhone = $row['nrPhone'];
            $std->deLogo = $row['deLogo'];
            $std->deAddress = ($row['deAddress']);
            $std->deEvent = ($row['deEvent']);
            $std->deDetail = ($row['deDetail']);
            $std->dtFrom = $row['dtFrom'];
            $std->dtUntil = $row['dtUntil'];
            $std->idType = $row['idType'];
            $std->nrCep = $row['nrCep'];
            $std->nrLat = $row['nrLat'];
            $std->nrLng = $row['nrLng'];
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
     * Insert or update Places and Events
     * */
    public static function insertUpdateEvent($url, $id) {
        $json = file_get_contents($url);
        $rows = json_decode($json);
        echo $url;
        echo $id;
        var_dump($rows);

        DB::debugMode();

        DB::query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

        foreach ($rows as $obj) {
            echo time() . "*********************************************\n";
            var_dump($obj);

            if (is_null($obj->geo->lat)) {
                continue;
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
            $std = new stdClass();
            $std->nrPhone = $row['nrPhone'];
            $std->deLogo = $row['deLogo'];
            $std->deAddress = $row['deAddress'];
            $std->deEvent = $row['deEvent'];
            $std->deDetail = $row['deDetail'];
            $std->dtFrom = $row['dtFrom'];
            $std->dtUntil = $row['dtUntil'];
            $std->idType = $row['idType'];
            $std->nrCep = $row['nrCep'];
            $std->nrLat = $row['nrLat'];
            $std->nrLng = $row['nrLng'];
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

}

/* * ****
 *    Database Handlers
 */

function my_error_handler($params) {
    echo "Error: " . $params['error'] . "<br>\n";
    echo "Query: " . $params['query'] . "<br>\n";
    die; // don't want to keep going if a query broke
}
