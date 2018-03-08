<?php

//include 'Mysql.class.php';
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

    public static function sendBroadCastPush($message, $segment = "All",$url=NULL) {
        $content = array(
            "en" => $message,
        );

        $fields = array(
            'app_id' => "c452ff74-3bc4-44ca-a015-bfdaf0779354",
            'included_segments' => array($segment),
            //'include_player_ids' => array('97923a7b-da93-43a0-9caf-0d7da34f3dae','93e2fd6a-8ac8-421d-8d0b-a169127f24a9'),
            'data' => array("app" => "GUIA"),
            'contents' => $content,
            "small_icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png",
            "large_icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png",
            "icon" => "https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png"
        );
        if(!is_null($url)){
            $fields['url'] = $url;
        }
//a9bc10f7-c8b0-416e-ad0a-342efb9a4adc
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
                $day = date("l");
                if ($day === "Tuesday") {
                    return PushController::sendBroadCastPush($message, "Floripa");
                } else {
                    return PushController::sendBroadCastPush($message);
                }
            }
            DB::disconnect();
        } catch (Exception $e) {
            $bug = BugTracker::addIssueBugTracker(10, "BACKEND", "dailyNotification() " . $e->getFile(), $e->getMessage());
            return $bug;
        }
    }

    /**
     * @Carrega o total de filmes em estreia no Guia
     */
    public static function estreiasPush() {
        $conn = new MysqlDB();
        $conn->execute("select count(titulo) as total_estreias from wp_cn_filme where id in (select id_wp_cn_filme from wp_cn_filme_post  where estreia = 2 and FROM_UNIXTIME(dtend)>now());");
        //Primarias Lazer

        if ($row = $conn->hasNext()) {
            //var_dump($row);
            $cines = CinemaController::countMovieTheaters();
            $total = $row['total_estreias'];
            $message = "Hoje tem $total estreias e $cines filmes em cartaz na região.";
            return PushController::sendBroadCastPush($message, "Floripa","http://www.guiafloripa.com.br/cinema/cinema-todos");

            // echo $message; die;
        }
        return new stdClass();
    }

    /**
     * @Carrega um evento random do dia
     */
    public static function randomEvents() {
        $dayOfWeek = date("D");
        $query = "select deEvent,idEvent from viewEventPlaces where ((DATE_FORMAT(dtFrom ,'%Y-%m-%d')>= (DATE_FORMAT((now()- INTERVAL  360 MINUTE),'%Y-%m-%d')) 
								and DATE_FORMAT(dtUntil,'%Y-%m-%d')<DATE_FORMAT(NOW() + INTERVAL 600 MINUTE,'%Y-%m-%d')))
                    union
                    select deEvent,idEvent from viewEventPlaces where (NOW() between dtFrom and dtUntil) 
                    and (deRecurring like '$dayOfWeek' or deRecurring like '[]') order by RAND() DESC limit 1";
        $eventos = DB::query($query); // mi

        if (count($eventos) > 0) {
            //var_dump($eventos);
            $event = $eventos[0]['deEvent'];
            $idEvent = $eventos[0]['idEvent'];
            $std = new stdClass();
            $std->idEvent = $idEvent;
            $std->urlEvent = "http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=".$idEvent;
            $std->event = $event;
            $std->message = "Hoje $event";
            $std->push = PushController::sendBroadCastPush($std->message, "Floripa",$std->urlEvent);
            return $std;
        } else {
            return new stdClass();
        }
    }

}

?>
