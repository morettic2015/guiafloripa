<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Abraham\TwitterOAuth\TwitterOAuth;

const CK = "J4AtaLvtwhGL9qCev9z2NNdu2";
const CS = "YdoxGY1vPrG1vKQdptbSz54klJEEUEebtgjSv8lVWt4IeLpLSx";
const AT = "23771711-6eB5JojomwNncwRQx79PwQ86we4z2SS5ICiyJc3rp";
const AC = "Z5gZXfaUkXA9nNUuINqr9zqPi8FVUbpIfPBjCBCJjA3tH";

/**
 * Description of TwitterBOT
 *
 * @author Morettic LTDA
 */
const PLACE_FLORIPA_ID = "19cb75100ad24124";

class TwitterBOT {

    //put your code here
    public $connection = null;
    public $profileBot = null;

    public function searchFollow($q) {
        $statuses = $this->connection->get(
                "search/tweets", ["q" => $q]
        );
        var_dump($statuses);
        foreach ($statuses->statuses as $row) {
            //var_dump($row);
            $f = $this->connection->post("friendships/create", ["screen_name" => $row->user->screen_name, "follow" => true]);
            var_dump($f);
        }
    }

    public function sendFollowersMessage($m) {
        $folowers = $this->getFollowers();
        echo "<pre>";
        $list = $folowers->users;
        foreach ($list as $p) {
            $this->sendMessage($p->screen_name, $m);
        }
    }

    public function getFollowers() {
        return $this->connection->get("followers/list", ["count" => 200]);
    }

    /**
     * @Send message to a follower
     */
    public function sendMessage($screen_name, $m) {
        return $this->connection->post("direct_messages/new", ["screen_name" => $screen_name, "text" => $m]);
    }

    public function searchTweetsReply($q) {
        $statuses = $this->connection->get(
                "search/tweets", ["q" => $q]
        );


        // echo "<pre>";
        $media1 = $this->connection->upload('media/upload', ['media' => 'img/moto-x.png']);
        $hashtags = str_replace("OR", "|", $q);
        foreach ($statuses->statuses as $row) {
            //var_dump($row);
            //echo $row->id;
            // echo $row->user->screen_name;
            // echo "<br>";
            //die;
            //die;
            // $status_id = $row->id;
            $twitt_reply = '@' . $row->user->screen_name . ' pensou ' . $hashtags . "? Download App https://app.guiafloripa.com.br!";

            $replyVet = [
                "in_reply_to_status_id" => $status_id,
                "status" => $twitt_reply,
                'media_ids' => implode(',', [$media1->media_id_string])
            ];
            //var_dump($replyVet);

            $reply = $this->connection->post("statuses/update", $replyVet);

            // var_dump($reply);
        }
    }

    public function connectTwitter($ck = CK, $cs = CS, $at = AT, $ac = AC) {
        //echo "<pre>";

        $this->connection = new TwitterOAuth($ck, $cs, $at, $ac);
        //$profileBot = $this->connection->get("account/verify_credentials");
        //var_dump($profileBot);die;
    }

    //$media1->media_id_string, $media2->media_id_string
    public function tweet($message) {
        $statues = $this->connection->post("statuses/update", [
            "status" => $message
        ]);
        return $statues;
    }

    //$media1->media_id_string, $media2->media_id_string
    public function tweetMediaLatLon($message, $lat, $long) {
        //$media1 = $this->connection->upload('media/upload', ['media' => $img1]);
        $tweet = [
            "status" => $message,
            //'media_ids' => implode(',', [$media1->media_id_string]),
            'lat' => $lat,
            'lon' => $long
        ];
        //var_dump($tweet);die;

        $statues = $this->connection->post("statuses/update", $tweet);
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

    public function tweetChannel() {
        $unparsed_json = file_get_contents("https://experienciasdigitais.com.br/wp-json/twitterbot/v1/channel");

        $tweets = json_decode($unparsed_json);
        $ret = [];
        $this->connectTwitter();
        foreach ($tweets as $t) {
            $hashtag = json_decode($t->hashtag);
          
            //var_dump($image);
            $path = '/var/www/guiafloripa.morettic.com.br/img/image_'.$t->campaign_ID.'.jpg';
            copy($t->logo, $path);
            $tweetMsg = $t->campaign_name. ' '.$t->campaign_description. ' '. $hashtag->hashtag. ' '. $t->link;
            
            $media1 = $this->connection->upload('media/upload', ['media' => $path]);
            $statues = $this->connection->post("statuses/update", [
                "status" => $tweetMsg ,
                'media_ids' => implode(',', [$media1->media_id_string])
            ]);
            $ret[] = $statues;
        }

        return $ret;
        //
        //
        //
        //
    }

    public function singleTweet() {
        $query = "SELECT * FROM view_single_tweet_guia";
        $tweet = DB::query($query);
        // echo "<pre>";
        // var_dump();
        $std = new stdClass();
        $std->tweet = $tweet[0];
        $this->connectTwitter();
        $msgTwt = $tweet[0]['tweet'] . ' - ' . $tweet[0]['link'];
        $std->response = $this->tweetMediaLatLon($msgTwt, $tweet[0]['nrLat'], $tweet[0]['nrLng']);
        return $std;
    }

    public function search($q) {
        $statuses = $this->connection->get(
                "search/tweets", ["q" => $q]
        );
        return $statuses;
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
