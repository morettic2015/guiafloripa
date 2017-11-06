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
            $dayOfWeek = date("D");
            $query = " select * from viewEventPlaces where ((DATE_FORMAT(dtFrom ,'%Y-%m-%d H')>= (DATE_FORMAT(now(),'%Y-%m-%d H')) 
								and DATE_FORMAT(dtUntil,'%Y-%m-%d H')<DATE_FORMAT(NOW() + INTERVAL 300 MINUTE,'%Y-%m-%d H')))
                    union
                    select * from viewEventPlaces where (NOW() between dtFrom and dtUntil) 
                    and (deRecurring like '%$dayOfWeek%' or deRecurring like '[]') order by dtUntil DESC";
            $eventos = DB::query($query);

            $counter = DB::count();
            //counter of events
            $cines = CinemaController::countMovieTheaters();
            //  echo $counter;
            //Has events today
            if ($counter > 0) {
                $message = $counter . " eventos e " . $cines . " filmes em cartaz na região";
                return PushController::sendBroadCastPush($message);
            }
            DB::disconnect();
        } catch (Exception $e) {
            $bug = BugTracker::addIssueBugTracker(10, "BACKEND", "dailyNotification() " . $e->getFile(), $e->getMessage());
            return $bug;
        }
    }

}

?>
