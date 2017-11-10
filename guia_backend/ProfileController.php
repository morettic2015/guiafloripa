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
       // echo $userId . "asdasd";
        DB::insertUpdate('Profile', array(
            'idProfile' => $userId, //primary key
            'deName' => $obj->name,
            'deEmail' => $obj->email,
            'userID' => $obj->userId,
            'pushToken' => $obj->pushToken
        ));
        $rt->userID = DB::insertId();
        //Add contact to Mautic Integration
        $rt->contactID = LeadController::createContact($obj->name, null, $obj->email);
        //Add Lead to Segment
        $rt->segmentID = LeadController::addContactToSegment($rt->contactID);
        $obj->contactID = $rt->contactID;
        $obj->segmentID = $rt->segmentID;

        $configID = DB::queryFirstField("SELECT idConfig FROM guiafloripa_app.Config where profileID = $userId and type = 'FACEBOOK' and placeID is null and eventID is null");


        // var_dump($obj);
        //die;
        if (isset($obj->facebook)) {
            DB::insertUpdate('Config', array(
                'idConfig' => $configID,
                'profileID' => $userId,
                'log' => json_encode($obj),
                'type' => 'FACEBOOK')
            );
        }

        //Close connection
        DB::disconnect();

        return $rt;
    }

    /**
     * ->placeID, $data->eventID, $req->email
     * @Add to Favorite
     * @Integrate to Mautic
     * @Also create a segment to customer if does not exist
     * @Associate Lead with
     */
    public static function favoriteOne($req) {
        // DB::debugMode();
        //   var_dump($req);
        //die;
        $std = new stdClass();
        $userId = DB::queryFirstField("select idProfile from Profile where deEmail like '%" . $req->email . "%'");
        //user not found
        if (empty($userId)) {
            $std->error = "USER NOT FOUND";
            $std->code = 404;
            DB::disconnect();
            return $std;
        }
        //has favorited before this event / place???
        $query = "SELECT idConfig FROM Config WHERE profileID = $userId";
        //var_dump($req);
        //echo $req->eventID."---a--a--a";
        $eventID = "-1";
        if ($req->eventID === "-1") {//Only if has place ID
            $query .= " AND placeID = $req->placeID";
            $placeID = $req->placeID;
            //echo $query;
            $eventID = NULL;
            //  die;
        } else {
            $placeID = DB::queryFirstField("select idPlaceOwner from Event where idEvent = " . $req->eventID);
            $query .= " AND eventID = " . $req->eventID . " AND placeID = $placeID";
            $eventID = $req->eventID;
            //echo $query;
            //     die;
        }
        $favID = DB::queryFirstField($query);

        //var_dump($favID);die;
        $std->userID = $userId;
        $std->date = date('Y-m-d');

        if ($favID < 1) {
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
                $std->segmentID = $o->segmentID;
                //var_dump($std);die;
            }

            $std->contactName = DB::queryFirstField("select deName from Profile where idProfile = " . $std->userID);
            $std->lead = LeadController::createContact($std->contactName, null, $req->email);
            //echo $lead."...............";die;
            $std->response = LeadController::addContactToSegment($std->lead, $std->segmentID);
            //Save Config for Segment
            DB::insert('Config', array('placeID' => $placeID, 'log' => json_encode($std), 'type' => 'SEG'));
            ///var_dump($std->segment);die;
            //Close connection and commits
        } else {
            $std->message = "Already Exists";
        }
        DB::commit();
        DB::disconnect();
        $std->confID = $favID;

        return $std;
    }

}
