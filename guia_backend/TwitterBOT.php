<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Abraham\TwitterOAuth\TwitterOAuth;

const CK = "GnNVtbzbh8Tkm1J9qaOttxoC0";
const CS = "nENAHgpUrY8ZQxmDesMcyiwX6AinkPVCEoUZ9mKJ8tdzlPqGIQ";
const AT = "887976115549208578-wIg1cwIvywVlGgP7rtVhDETI8PNBvpN";
const AC = "PwAW0AObVAFzFU3BSj4DeVRq2klseARFj33WfTF9HN2JJ";

/**
 * Description of TwitterBOT
 *
 * @author Morettic LTDA
 */
class TwitterBOT {

    //put your code here
    public $connection = null;
    public $profileBot = null;

    public function connectTwitter() {
        //echo "<pre>";

        $this->connection = new TwitterOAuth(CK, CS, AT, AC);
        $this->profileBot = $this->connection->get("account/verify_credentials");
        //var_dump($this->profileBot);
    }

    //$media1->media_id_string, $media2->media_id_string
    public function tweet($message) {
        $statues = $this->connection->post("statuses/update", [
            "status" => $message
        ]);
        return $statues;
    }

    //$media1->media_id_string, $media2->media_id_string
    public function tweetMedia($message, $img1, $img2) {
        $media1 = $this->connection->upload('media/upload', ['media' => $img1]);
        $media2 = $this->connection->upload('media/upload', ['media' => $img2]);
        $statues = $this->connection->post("statuses/update", [
            "status" => $message,
            'media_ids' => implode(',', [$media1->media_id_string, $media2->media_id_string])
        ]);
        return $statues;
    }
    //"Oi eu sou um bot #bot #floripa #balada #iambot #android #life #free #beta #night https://app.guiafloripa.com.br."
    public function dailyNewsTweet($img1, $img2) {
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
        
        $tweet;
        if ($counter > 0) {
            $message = $counter . " eventos e " . $cines . " filmes em cartaz em #Floripa #night #Lazer #Festa #Android #beta #APP https://app.guiafloripa.com.br";
            $tweet = $this->tweetMedia($message, $img1, $img2);
        }
        DB::disconnect();
        
        return $tweet;
    }

}
