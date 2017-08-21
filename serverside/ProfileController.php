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


        return $rt;
    }

}
