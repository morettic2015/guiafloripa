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
        if ($dtUntil !== "-1" && $dtFrom !== "-1" && !empty($dtUntil)) {
            $query .= "SELECT fkPlace FROM SubCategory where dtEnd >= now() and date(dtStart) >= '$dtFrom' AND date(dtEnd)<= '$dtUntil '  and fkType = 3)";
            $innerQuery = " select * from viewMovieTheater where date(dtFrom) >= '$dtFrom'and date(dtUntil) <= '$dtUntil'";
        } else {
            $today = date("Y-m-d");
            $query .= "SELECT fkPlace FROM SubCategory where dtEnd >= now() and fkType = 3 group by fkPlace)";
            $innerQuery = " select * from viewMovieTheater where date(dtUntil) >= now()";
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
            $std->idPlace = $cine['idPlace'];
            $std->nrLat = $cine['lat'];
            $std->nrLng = $cine['lng'];
            $std->movies = [];

            //echo $innerQuery . " AND idPlaceOwner = " . $cine['idPlace'];
            $filmes = DB::query($innerQuery . " AND idPlaceOwner = " . $cine['idPlace']);
            foreach ($filmes as $movie) {
                //   var_dump($movie);
                $std1 = new stdClass();
                $std1->idPlace = $cine['idPlace'];
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
        //Close database connection
        DB::disconnect();
        return $ret;
    }

    public static final function countMovieTheaters() {
        $today = date("Y-m-d");
        $query = "SELECT * FROM viewCinemaPlaces where idPlace in (SELECT fkPlace FROM SubCategory where dtEnd >= now() and fkType = 3 group by fkPlace)";
        $innerQuery = " select * from viewMovieTheater where date(dtUntil) >= '$today'";
        $cinemas = DB::query($query);
        $total = 0;
        foreach ($cinemas as $cine) {
            //echo $innerQuery . " AND idPlaceOwner = " . $cine['idPlace'];
            DB::query($innerQuery . " AND idPlaceOwner = " . $cine['idPlace']);
            $total+= intval(DB::count());
        }
        //Close database connection
        DB::disconnect();
        return $total;
    }

}
