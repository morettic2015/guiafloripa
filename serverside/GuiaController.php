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
        $query = "select * from viewEventPlaces where dtUntil >= '$today'";
        $eventos = DB::query($query); // misspelled SELECT
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

    /*
    *   @ FIltra eventos pela data e pelo tipo.
    */
    public static function findEventosByDateType($dtOrigem,$dtFim,$type) {
        $today = date("Y-m-d");

        //If date is empty or another shit
        $query = "select * from viewEventPlaces where dtUntil >= '$today' and idType = ".$type;
        //
        $query2 = "select * from viewEventPlaces where idType = ".$type
                    ." and DATE(dtFrom) >= '".$dtOrigem
                    ."' AND DATE(dtUntil)<= '".$dtFim."'";
        if(empty($dtOrigem)||empty($dtFim)||$dtOrigem=="-1"||$dtFim=="-1"){
            $eventos = DB::query($query); // misspelled SELECT
        }else{
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
