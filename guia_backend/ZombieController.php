<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include 'Mysql.class.php';
/**
 * Description of ZombieController
 *
 * @author Morettic LTDA
 */
class ZombieController {

    //Select where not in for each category reference: remote!
    public static final function getAllLivingIdsFromRemoteByCategory() {


        $queries = "select event_id from view_events where event_id in(
                        select object_id from view_lazer_ids
                        union 
                        select object_id from view_cultura_ids
                        union 
                        select object_id from view_gratuitos_ids
                        union 
                        select object_id from view_eventos_ids
                        union 
                        select object_id from view_infantil_ids
                    )";

        $mdb = new MysqlDB();
        $mdb->execute($queries); // misspelled SELECT
        $str = "(";
        while ($r = $mdb->hasNext()) {
            $str .= $r['event_id'];
            $str .= ",";
        }
        $str .= "0)";


        $mdb->closeConn(); //Clon origin connection

       // DB::debugMode();

        DB::query("UPDATE guiafloripa_app.Event set statusKO = 'OFF' where idEvent not in $str and idType in (2,6,7,4,9)");

        $query = "SELECT * FROM guiafloripa_app.Event where idEvent not in $str and idType in (2,6,7,4,9)";

        $results = DB::query($query);
        echo "<pre>";

        foreach ($results as $r) {
            echo $r['deEvent'] . '-' . $r['idEvent'] . '/n<br>';
        }

        DB::disconnect();

        echo $query;
        die;
    }

}
