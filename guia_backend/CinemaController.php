<?php

/**
 * Description of CinemaController
 *
 * @author Morettic LTDA
 */
class CinemaController {

    //put your code here
    /**
     * @Load Cinemas from Date interval if 
     */
    public static final function loadCinemaPlaces($dtFrom, $dtUntil) {
        //DB::debugMode();
        //echo "<pre>".$dtFrom. "---------".$dtUntil;
        $query = "SELECT * FROM viewCinemaPlaces where idPlace in (";
        $innerQuery = null;
        $ret = [];
        if ($dtUntil!=="-1" && $dtFrom!=="-1"&&!empty($dtUntil)) {
            $query .= "select distinct idPlaceOwner  FROM viewCinemaIDS where date(dtFrom) >= '$dtFrom' AND date(dtUntil)<= '$dtUntil ')";
            $innerQuery = " select * from Event where date(dtFrom) >= '$dtFrom'and date(dtUntil) <= '$dtUntil'";
        } else {
            $today = date("Y-m-d");
            $query .= "select distinct idPlaceOwner FROM viewCinemaIDS where date(dtUntil) >= '$today')";
            $innerQuery = " select * from Event where date(dtUntil) >= '$today'";
        }
        $cinemas = DB::query($query);
        foreach ($cinemas as $cine) {
            //echo "<pre>";var_dump($cine);die;
            $std = new stdClass();
            $std->nrPhone = $cine['nrPhone'];
            $std->deLogo = $cine['deLogo'];
            $std->deAddress = $cine['deAddress'];
            $std->nmPlace = $cine['nmPlace'];
            $std->deEmail = $cine['deEmail'];
            $std->deWebsite = $cine['deWebsite'];
            $std->idType = "3";
            $std->nrCep = $cine['cep'];
            $std->nrLat = $cine['lat'];
            $std->nrLng = $cine['lng'];
            $std->movies = [];


            $filmes = DB::query($innerQuery . " AND idPlaceOwner = " . $cine['idPlace']);
            foreach ($filmes as $movie) {
                //   var_dump($movie);
                $std1 = new stdClass();
                $std1->idEvent = $movie['idEvent'];
                $std1->deEvent = $movie['deEvent'];
                $std1->deDetail = strip_tags($movie['deDetail']);
                $std1->deImg = $movie['deImg'];
                $std1->dtFrom = formatCineDate($movie['dtFrom']);
                $std1->dtUntil = formatCineDate($movie['dtUntil']);
                $std->movies[] = $std1;
            }
            $ret[] = $std;
        }
        return $ret;
    }

}
