<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 *   $data->email = $request->getAttribute('email');
  $data->name = $request->getAttribute('name');
  $data->userId = $request->getAttribute('userId');
  $data->pushToken = $request->getAttribute('pushToken');
 */

class ProfileController extends stdClass {

    /**
     * @Add contacts to Mautic Anunciantes (segment)
     */
    public static final function insertLeadAnunciantes() {
        $query = "select nmPlace, deEmail from Place where deEmail is not null and deEmail <> ' '";
        $results = DB::query($query);
        $lArray = [];
        //Para cada 
        $count = 0;
        foreach ($results as $anunciante) {
            //var_dump($anunciante);
            $lArray[$count] = new stdClass();
            $lArray[$count]->contactID = LeadController::createContact($anunciante['nmPlace'], null, $anunciante['deEmail']);
            $lArray[$count]->lead = LeadController::addAnunciante($lArray[$count]->contactID);
            $lArray[$count]->email = $anunciante['deEmail'];
            $lArray[$count]->dePlace = $anunciante['nmPlace'];
            $count++;
        }

        return $lArray;
    }

    /**
     * @Insert or Update User Profile
     */
    public static function insertUpdateProfile($obj) {
        $rt = new stdClass();
        //echo "<pre>";
        //DB::debugMode();
        $userId = DB::queryFirstField("select idProfile from Profile where deEmail like '%" . $obj->email . "%'");
        //echo $userId . "asdasd";
        DB::insertUpdate('Profile', array(
            'idProfile' => $userId, //primary key
            'deName' => $obj->name,
            'deEmail' => $obj->email,
            'userID' => $obj->userId,
            'pushToken' => $obj->pushToken
                ), array(
            'deName' => $obj->name,
            'userID' => $obj->userId,
            'pushToken' => $obj->pushToken
        ));
        //Add contact to Mautic Integration
        $rt->contactID = LeadController::createContact($obj->name, null, $obj->email);
        //Add Lead to Segment
        $rt->segmentID = LeadController::addContactToSegment($rt->contactID);

        //Close connection
        DB::disconnect();

        return $rt;
    }

    /**
     * @Add to Favorite
     */
    public static function favoriteOne($placeID, $eventID, $email) {
        DB::debugMode();
        $userId = DB::queryFirstField("select idProfile from Profile where deEmail like '%" . $email . "%'");
        if (!empty($eventID)) {
            $placeID = DB::queryFirstField("select idPlaceOwner from Event where idEvent = " . $eventID . "");
        }
        $std = new stdClass();
        $std->userID = $userId;
        $std->eventID = $eventID;
        $std->placeID = $placeID;
        $std->date = date('Y-m-d');
        //Inser user configuration
        DB::insert('Config', array('profileID' => $userId, 'placeID' => $placeID, 'eventID' => $eventID, 'log' => json_encode($std), 'type' => 'FAV'));
        $favID = DB::insertId();
        //
        $json = DB::queryFirstField("SELECT log FROM Config where type = 'SEG' and placeID = $placeID");
        //Segment for Place does not exists
        if (empty($json)) {
            $dePlace = DB::queryFirstField("SELECT dePlace FROM Place where idPlace = $placeID");
            $std->segment = LeadController::createSegment($dePlace, $dePlace, "Leads do Guia Floripa que adicionaram $dePlace aos Favoritos");
            $std->segmentID = $std->segment['list']['id'];
        } else {
            $json = DB::queryFirstField("SELECT log FROM Config where type = 'SEG' and placeID = $placeID");
            $o = json_decode($json);
            var_dump($o);die;
        }

        $std->contactName = DB::queryFirstField("select deName from Profile where idProfile = $userId");
        $std->lead = LeadController::createContact($std->contactName, null, $email);
        //echo $lead."...............";die;
        $std->response = LeadController::addContactToSegment($std->lead, $std->segmentID);
        //Save Config for Segment
        DB::insert('Config', array('placeID' => $placeID, 'log' => json_encode($std), 'type' => 'SEG'));
        ///var_dump($std->segment);die;
        //Close connection and commits
        DB::commit();
        DB::disconnect();
        $std->confID = $favID;

        return $std;
    }

}
