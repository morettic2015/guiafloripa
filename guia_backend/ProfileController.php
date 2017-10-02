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
        return $rt;
    }

}
