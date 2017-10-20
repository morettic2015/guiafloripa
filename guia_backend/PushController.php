<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * $response = sendMessage();
  $return["allresponses"] = $response;
  $return = json_encode( $return);

  print("\n\nJSON received:\n");
  print($return);
  print("\n");
 */

class PushController extends stdClass {

    public static function sendBroadCastPush($message) {
        $content = array(
            "en" => $message,
        );

        $fields = array(
            'app_id' => "c452ff74-3bc4-44ca-a015-bfdaf0779354",
            'included_segments' => array('All'),
            'data' => array("app" => "GUIA"),
            'contents' => $content,
            "small_icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png",
            "large_icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png",
            "icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png"
        );

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZWU4ODYxN2YtNTk4ZS00ODE2LTliNjMtNTU1M2ViNTQxOWZi'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    //$users = array("","","","","");
    public static function sendMessageToUser($users, $message) {
        $content = array(
            "en" => $message,
        );

        $fields = array(
            'app_id' => "c452ff74-3bc4-44ca-a015-bfdaf0779354",
            'include_player_ids' => $users,
            'data' => array("foo" => "bar"),
            'contents' => $content,
            "small_icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png",
            "large_icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png",
            "icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png"
        );

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZWU4ODYxN2YtNTk4ZS00ODE2LTliNjMtNTU1M2ViNTQxOWZi'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    public static function dailyNotification() {
        try {
            // DB::debugMode();
            $query = "select * from viewEventPlaces where dtFrom >= now()- INTERVAL 1 DAY and dtUntil<=NOW() + INTERVAL 1 DAY";
            $eventos = DB::query($query);
            $counter = DB::count();
            //counter of events
            //  echo $counter;
            //Has events today
            if ($counter > 0) {
                $message = $counter . " Eventos em Floripa Hoje a sua escolha!";
                // $query = "SELECT userID FROM guiafloripa_app.Profile";
                //     $users = DB::query($query);
                //   $ids = DBHelper::verticalSlice($users, 'userID');



                return PushController::sendBroadCastPush($message);
            }
            DB::disconnect();
        } catch (Exception $e) {
            $bug = BugTracker::addIssueBugTracker(10, "BACKEND", "dailyNotification() ".$e->getFile(), $e->getMessage());
            return $bug;
        }
    }
}

?>
