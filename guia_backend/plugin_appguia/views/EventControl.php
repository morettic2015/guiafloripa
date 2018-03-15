<?php

include_once( ABSPATH . WPINC . '/class-IXR.php' );
include_once( ABSPATH . WPINC . '/class-wp-http-ixr-client.php' );
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EventController
 *
 * @Create remote evento at guiafloripa Wordpress
 * 
 * @author Morettic LTDA
 */
const WP_GUIA_USER = "appguiafloripa";
const WP_GUIA_PASS = 'gu14fl0r1p44pp2017_$bRich@';
const WP_GUIA_XMLR = 'http://www.guiafloripa.com.br/xmlrpc.php';
const WP_RELATIVEP = "/var/www/app.guiafloripa.com.br/wp-content/uploads/";
const _THUMB = "_thumbnail_id";
const _BAIRROS = 'bairros';
const _MY_EVENTS = 'my_events';
const _DURACAO = 'duracao';
const _MOREINFO = "vevent_moreinfo";
const _PRAIAS = "praias";
const _LOCATION = 'vevent_location';
const _EVENTPRICE = 'vevent_price';
const _EVENTMAIL = 'vevent_email';
const _SECTION = 'section';
const _DISCOUNT = "discount";
const _LINKFACE = "linkFace";
const _PLANOTYPE = "_plano_type";
const _VEVENT_PRICE_LABEL = 'vevent_price_label';
const _FACEBOOKEVENTID = "_facebook_event_id";
const _WHATS = "_whatsapp";

global $app_db;

class EventControl extends stdClass {

    public function updateDates($request) {
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        $qtinit = $this->getTimeFromString($request['dtStart'], $request['hrStart']);
        $qtfim = $this->getTimeFromString($request['dtEnd'], $request['hrEnd']);
        //Query timestamp from database
        $dtinit = $app_db->get_results($qtinit);
        $dtfim = $app_db->get_results($qtfim);
        //Insert new dates
        $request['dtinit'] = $dtinit;
        $request['dtfim'] = $dtfim;
        //update init date
        $query = "update wp_postmeta set meta_value = '" . $dtinit[0]->DT . "' where meta_key = 'vevent_dtstart' and post_id = " . $request['eventID'];
        $app_db->get_results($query);
        //Update finish date
        $query = "update wp_postmeta set meta_value = '" . $dtfim[0]->DT . "' where meta_key = 'vevent_dtend' and post_id = " . $request['eventID'];
        $app_db->get_results($query);
        //Insert event duration variable
        $timeAmnt = (double) ($dtfim[0]->DT + (3600 * 6)) - (double) $dtinit[0]->DT;
        $app_db->get_results($this->insertMeta($request['eventID'], _DURACAO, $timeAmnt));
        $query = "delete from wp_postmeta where meta_value = 'on' and post_id = " . $request['eventID'];
        $app_db->get_results($query); //Remove days of week
        if (isset($request['dayofweek'])) {//inser days of week
            foreach ($request['dayofweek'] as $d1) {
                $app_db->get_results($this->insertMeta($request['eventID'], $d1, 'on'));
            }
        }
    }

    public function updatePostStatus($request, $status) {

        $myEvents = "";
        foreach ($request['evento'] as $r1) {
            $myEvents .= $r1 . ",";
        }
        $myEvents .= "-1";

        $query = "update wp_posts set post_status = '" . $status . "', post_modified=now()+ INTERVAL 3 HOUR  where id in ($myEvents)";
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        $result = $app_db->get_results($query);

        $app_db->close();

        echo '<div class="notice notice-success is-dismissible"> 
                    <p><strong>Status dos eventos alterados para:<code>' . $status . '</code></strong></p>
                 </div>';
        echo '<a href="admin.php?page=app_guiafloripa_eventos" class="page-title-action">Voltar</a></h1>';
        wp_die('Sucesso!');
    }

    public function loadMyDates() {

        $lEvents = get_user_option(_MY_EVENTS, get_current_user_id());
        if (empty($lEvents)) {
            $lEvents = [];
        } else {
            $lEvents = unserialize($lEvents);
        }
        $myEvents = "";
        foreach ($lEvents as $e) {
            if (empty($e))
                continue;
            $myEvents .= $e . ",";
        }
        $myEvents .= "-1";
        //Make query
        $query = "
                SELECT 
                    a.*,
                    (select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtstart') - (2*3600) as dtStart,
                    (select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtend') - (2*3600) as dtEnd
                FROM wp_posts as a 
                where 
                    id in ($myEvents)";
        //Connect to database
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        //insert post evento
        $events = $app_db->get_results($query);

        $app_db->close();

        return $events;
    }

    public function eventsFullList() {
        $lEvents = get_user_option(_MY_EVENTS, get_current_user_id());
        if (empty($lEvents)) {
            $lEvents = [];
        } else {
            $lEvents = unserialize($lEvents);
        }
        $myEvents = "";
        foreach ($lEvents as $e) {
            if (empty($e))
                continue;
            $myEvents .= $e . ",";
        }
        $myEvents .= "-1";

        //echo $myEvents;
        //Make query
        //Connect to database
        //Only if not cached
        $events = wp_cache_get('my_events1');
        if (false === $events) {
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            $query = "
                SELECT 
                    a.*,DATE_FORMAT(a.post_modified, '%d/%m/%Y %H:%m:%s') as dt_formated,  
                    (select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtstart') - (2*3600) as dtStart,
                    (select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtend') - (2*3600) as dtEnd
                FROM wp_posts as a 
                where 
                    id in ($myEvents)";
            //echo $myEvents;
            $events = $app_db->get_results($query);
            wp_cache_set('my_events', $data);
            $app_db->close();
        }
        return $events;
    }

    public function loadMyEvents() {
        $lEvents = get_user_option(_MY_EVENTS, get_current_user_id());
        if (empty($lEvents)) {
            $lEvents = [];
        } else {
            $lEvents = unserialize($lEvents);
        }
        $myEvents = "";
        foreach ($lEvents as $e) {
            if (empty($e))
                continue;
            $myEvents .= $e . ",";
        }
        $myEvents .= "-1";

        //echo $myEvents;
        //Make query
        //Connect to database
        //Only if not cached
        $events = wp_cache_get('my_events');
        if (false === $events) {
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            $query = "
                SELECT 
                    a.*,DATE_FORMAT(a.post_modified, '%d/%m/%Y %H:%m:%s') as dt_formated,  
                    (select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtstart') - (2*3600) as dtStart,
                    (select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtend') - (2*3600) as dtEnd
                FROM wp_posts as a 
                where 
                    id in ($myEvents)";
            //echo $myEvents;
            echo $query;
            $events = $app_db->get_results($query);
            wp_cache_set('my_events', $data);
            $app_db->close();
        }

        echo '<style type="text/css">';
        echo '.wp-list-table .column-ID { width: 10%; }';
        echo '.wp-list-table .column-title { width: 48%; }';
        echo '.wp-list-table .column-rating { width: 15%; }';
        echo '.wp-list-table .column-director { width: 7%; }';
        echo '.wp-list-table .column-category { width: 15%; }';
        echo '.wp-list-table .column-deplace { width: 15%; }';
        echo '</style>';

        $vet = [];
        foreach ($events as $e1) {
            $sts = "";
            if ($e1->post_status == "draft") {
                $sts = "<center><img src='../wp-content/uploads/2017/12/d1.png'><br>Rascunho</center>";
            } else if ($e1->post_status == "trash") {
                $sts = "<center><img src='../wp-content/uploads/2017/12/t1.png'><br>Excluido</center>";
            } else {
                $sts = "<center><img src='../wp-content/uploads/2017/12/p1.png'><br>Publicado</center>";
            }
            $vet[] = array(
                'ID' => $e1->ID,
                'title' => $e1->post_title,
                'rating' => $e1->dt_formated,
                'director' => $sts,
                'category' => gmdate("d/m/Y H:i:s", $e1->dtStart),
                'deplace' => gmdate("d/m/Y H:i:s", $e1->dtEnd)
            );
        }


        return $vet;
        // die;
    }

    function __construct() {
        @session_start();
        //var_dump($this->app_db);
    }

    private function existsFace(&$conn, $faceId) {
        $query = "select * from wp_postmeta where meta_key = '" . _FACEBOOKEVENTID . "' and meta_value='" . $faceId . "'";
        $result = $conn->get_results($query);
        //var_dump($result);
        if (count($result) > 0) {
            echo '<div class="notice notice-error"> 
                    <p><strong>O Evento já foi importado. Verifique o código do Facebook</strong></p>
                 </div>';
            return true;
        }
        return false;
    }

    /**
     * @Import Events From Facebook
     */
    function importEvents($request) {
        if (isset($request['facebook_event_ids'])) {
            $eventFace = $this->loadEventFromFacebook($request);
            if (isset($eventFace->error)) {
                echo '<div class="notice notice-error"> 
                    <p><strong>O Código do evento:<code>' . $request['facebook_event_ids'] . '</code> é inválido</strong><br>' . $eventFace->error->message . '</p>
                 </div>';
                //wp_die();
                // var_dump($eventFace);
                //echo $eventFace->error;
                return NULL;
            } else {

                $placeName = $eventFace->place->name;
                $query = "select id,post_title from wp_posts where post_title like '%$placeName%' and post_type = 'anuncio';";
                $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
                if ($this->existsFace($app_db, $eventFace->id)) {
                    //Does nothing
                    $app_db->close();
                    wp_die();
                } else {
                    $result = $app_db->get_results($query);
                    //var_dump($result);
                    //echo $query;
                    $eventFace->placeGuia = $result;
                    //insert post evento
                    $current_user = wp_get_current_user();
                    $r1 = array(
                        "txtDesc" => $eventFace->description,
                        "titEvent" => $eventFace->name,
                        "placeName" => $placeName
                    );
                    $app_db->get_results($this->createInsert($r1));

                    //var_dump($app_db);
                    //get post id by title 
                    $postID = $this->loadImportedEvent($app_db, $eventFace->name);
                    $eventFace->postID = $postID;
                    //Update place if find it....
                    $this->updatePlace($app_db, $eventFace, $postID);
                    //Update list of events
                    $this->updateUserEvents($postID);
                    //Insert image if it has one and bill is enabled
                    $this->updateImageFromFace($app_db, $eventFace->cover->source, $postID);
                    //set dates
                    $faceDates = $this->splitFacebookDates($eventFace);
                    //var_dump($faceDates);
                    $this->insertDates($app_db, $faceDates->dInit, $faceDates->hInit, $faceDates->dFinish, $faceDates->hFinish, $postID);
                    //Set event email
                    $current_user = wp_get_current_user();
                    // $app_db->get_results($this->insertMeta($postID, _EVENTMAIL, $current_user->user_email));
                    // $app_db->get_results($this->insertMeta($postID, _VEVENT_PRICE_LABEL, "Ingresso:"));
                    $app_db->get_results($this->insertMeta($postID, _FACEBOOKEVENTID, $eventFace->id));
                    // $app_db->get_results($this->insertMeta($postID, _MOREINFO, "Quantos confirmaram:" . $eventFace->maybe_count));
                    //echo "FACEBOOK EVENT ID".$eventFace->id;
                    /* $eventPrice = "Promoters no face:";
                      foreach ($eventFace->admins->data as $p12) {
                      //var_dump($p12);
                      $eventPrice .= " " . $p12->name . " (" . $p12->link . ")";
                      }

                      $app_db->get_results($this->insertMeta($postID, _EVENTPRICE, $eventPrice)); */
                    $c1 = array(
                        "titEvent" => $eventFace->name,
                        "placeName" => $placeName,
                        "content_url" => $eventFace->cover->source,
                        "txtDesc" => $eventFace->description,
                        "ingresso" => $eventFace->ticket_uri,
                        "email" => $current_user->user_email,
                        "whats" => get_user_meta(get_current_user_id(), _WHATS, true),
                        "linkFace" => "https://www.facebook.com/events/" . $eventFace->id . "/"
                    );
                    $this->createCampaign($c1, $postID);
                    $app_db->close();
                }
                //  $headers[] = 'From: EXPD <root@experienciasdigitais.com.br>';
                // wp_mail("malacma@gmail.com", "Novo Evento Importado do Facebook:".$eventFace->name, $eventFace->description, $headers);

                return $eventFace;
            }
        }
    }

    private function splitFacebookDates($eventFace) {
        var_dump($eventFace);
        $dtInit = $eventFace->start_time;
        $dtFinish = $eventFace->end_time;

        $dt = new stdClass();
        $tmp = explode("T", $dtInit);

        $dt->dInit = $tmp[0];
        $dt->hInit = substr($tmp[1], 0, 5);

        $tmp = explode("T", $dtFinish);

        $dt->dFinish = $tmp[0];
        $dt->hFinish = substr($tmp[1], 0, 5);
        var_dump($dt);
        return $dt;
    }

    private function updatePlace(&$conn, $eventFace, $postID) {
        if (count($eventFace->placeGuia) > 0) {//Localizou o estabelecimento
            $conn->get_results($this->insertMeta($postID, _LOCATION, $eventFace->placeGuia[0]->id));
        } else {
            echo '<div class="notice notice-error"> 
                    <p><strong>Por favor importe ou selecione as informações do local do evento</strong></p>
                 </div>
                 ';
        }
    }

    private function loadImportedEvent(&$conn, $nameEvent) {
        $query1 = "SELECT ID FROM wp_posts where post_type='evento' and post_title = '" . $nameEvent . "' order by id desc limit 1";
        $mData = $conn->get_results($query1);
        //var_dump($mData);
        $postID = $mData[0]->ID;
        return $postID;
    }

    private function uploadFaceImage($img) {


        $imag = GetImageFromUrl($img);
        return $this->uploadImage($imag);
    }

    private function updateImageFromFace(&$conn, $url, $postID) {
        if ((!empty($url)) && get_user_meta(get_current_user_id(), _PLANOTYPE, true)) {
            $infoPicture = $this->uploadFaceImage($url);
            //var_dump($infoPicture);
            $conn->get_results($this->insertMeta($postID, _THUMB, $infoPicture['id']));
        }
    }

    function loadEventFromFacebook($request) {

        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        $url = "https://graph.facebook.com/v2.11/" . $request['facebook_event_ids'] . "?fields=id,place,owner,category,description,start_time,cover,end_time,event_times,scheduled_publish_time,is_canceled,is_draft,interested_count,name,maybe_count,ticket_uri,ticketing_privacy_uri,guest_list_enabled,timezone,type,is_page_owned,parent_group,admins{name,pic_large,link}&access_token=1405126029586258|tAryq_gM91gczqnQmKD5PwIu2ho";
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'App GuiaFloripa'
        ));
// Send the request & save response to $resp
        $resp = curl_exec($curl);
        curl_close($curl);
        return (json_decode($resp));
    }

    //put your code here
    public function loadCategories() {
        $args = array(
            'user-agent' => 'GuiaFloripaAPP',
            'headers' => array(),
        );
        $response = wp_remote_get("https://guiafloripa.morettic.com.br/portal_categorias/");
        // echo "<pre>";
        // var_dump($response['body']);
        // echo "</pre>";
        return json_decode($response['body']);
    }

    public function createInsert($request) {
        $status = isset($request['published']) ? "publish" : "draft";
        $current_user = wp_get_current_user();
        $query = "INSERT INTO `guiafloripa`.`wp_posts`  (
          `post_author`,
          `post_date`,
          `post_date_gmt`,
          `post_content`,
          `post_title`,
          `post_excerpt`,
          `post_status`,
          `comment_status`,
          `ping_status`,
          `post_name`,
          `to_ping`,
          `pinged`,
          `post_modified`,
          `post_modified_gmt`,
          `post_content_filtered`,
          `post_parent`,
          `guid`,
          `menu_order`,
          `post_type`,
          `post_mime_type`,
          `comment_count`)
          VALUES(
          57,
          NOW() + INTERVAL 5 HOUR,
          NOW() + INTERVAL 5 HOUR,
          '" . $request['txtDesc'] ."<br><b>Autor:".$current_user->user_firstname."</b>',
          '" . $request['titEvent'] . "',
          '" . $request['titEvent'] . "',
          '$status',
          'closed',
          'closed',
          '" . $request['titEvent'] . "',
          0,
          0,
          NOW() + INTERVAL 5 HOUR,
          NOW() + INTERVAL 5 HOUR,
          '" . $request['titEvent'] . "',
          '',
          '" . sanitize_title($request['titEvent'] . "_" . $request['placeName']) . "',
          0,
          'evento',
          'post',
          0);";
        return $query;
    }

    public function savePlaceImport($eventID, $eventName) {
        @session_start();
        $ne = json_decode($_SESSION['place']);
        //var_dump($ne);
        $place = new stdClass();
        foreach ($ne as $n) {
            //var_dump($n);
            //echo $eventName === $n->placeName;
           // echo $n->placeName;
            if ($n->placeName === $eventName) {
                $place->id = $n->placeID;
                $place->name = $eventName;
                break;
            }
        }
        if (isset($place->id)) {
            //var_dump($ne);
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            $place->ret = $app_db->get_results($this->insertMeta($eventID, _LOCATION, $place->id));
        }else{
            $place->error = "Não foi possível associar o evento com o negócio indicado. Tente outra vez.";
        }
        //var_dump($place);
        echo json_encode($place);
    }

    public function loadComplement($request) {
        
    }

    public function insertEvent($request) {
        //var_dump($_SESSION);
        var_dump($request);

        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        //insert post evento
        $app_db->get_results($this->createInsert($request));
        //get post id by title 
        $query1 = "SELECT ID FROM wp_posts where post_type='evento' and post_title = '" . $request['titEvent'] . "' order by id desc limit 1";
        $mData = $app_db->get_results($query1);
        //Post ID
        $postID = $mData[0]->ID;
        //insert permalink first been choosed so the meta for now just then we improve it
        $q1 = "insert into wp_postmeta (post_id,meta_key,meta_value) values (" . $postID . ",'_category_permalink'," . $request['categories'][0] . ")";
        $app_db->get_results($q1);
        //insert categories
        foreach ($request['categories'] as $cat) {
            $q1 = $this->insertCategory($postID, $cat);
            $app_db->get_results($q1);
        }
        //Reccuring days of week
        if (isset($request['dayofweek'])) {
            foreach ($request['dayofweek'] as $d1) {
                $app_db->get_results($this->insertMeta($postID, $d1, 'on'));
            }
        }
        //Insert image only if not empty
        if (!empty($request['content_url'])) {
            $infoPicture = $this->uploadImage($request['content_url']);
            // var_dump($infoPicture);
            $app_db->get_results($this->insertMeta($postID, _THUMB, $infoPicture['id']));
        }
        //Neigbhood
        $ne = json_decode($_SESSION['findNeighoodAjax']);
        if (count($ne) > 0) {
            $app_db->get_results($this->insertMeta($postID, _BAIRROS, $ne[0]->postID));
        }
        //BEach nearby
        $ne = json_decode($_SESSION['findBeachsAjax']);
        if (count($ne) > 0) {
            $app_db->get_results($this->insertMeta($postID, _PRAIAS, $ne[0]->id));
        }
        //Place owner
        $ne = json_decode($_SESSION['place']);
        if (count($ne) > 0) {
            $app_db->get_results($this->insertMeta($postID, _LOCATION, $ne[0]->placeID));
        }
        //Evento more info

        $app_db->get_results($this->insertMeta($postID, _MOREINFO, $request['more_info']));
        //Meta regiao_central
        $app_db->get_results($this->insertMeta($postID, $request['region'], '1'));
        //Meta Evento price & Info
        $app_db->get_results($this->insertMeta($postID, _EVENTPRICE, $request['vevent_price']));
        $app_db->get_results($this->insertMeta($postID, _VEVENT_PRICE_LABEL, "Ingresso:"));
        //Meta email
        if (!empty($request['email'])) {
            $app_db->get_results($this->insertMeta($postID, _EVENTMAIL, $request['email']));
        }
        //Dates
       // var_dump($request);
        $this->insertDates($app_db, $request['dtStart'], $request['hrStart'], $request['dtEnd'], $request['hrEnd'], $postID);

        //Close connection
        $app_db->close();
        //If parameter is set create prebuild templates
        //Create Campaign
        $this->createCampaign($request, $postID);

        $this->updateUserEvents($postID);


        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
        $headers[] = 'To: Morettic <malacma@gmail.com>';
        $headers[] = 'From: Experiências Digitais <root@experienciasdigitais.com.br>';
        //$headers[] = 'Cc: birthdayarchive@example.com';
        //$headers[] = 'Bcc: birthdaycheck@example.com';
// Mail it
        mail("malacma@gmail.com", "Novo Evento cadastrado", $request['titEvent'], implode("\r\n", $headers));

        return $postID;
    }

    private function insertDates(&$app_db, $dtStart, $hrStart, $dtEnd, $hrEnd, $postID) {
        $qtinit = $this->getTimeFromString($dtStart, $hrStart);
        $qtfim = $this->getTimeFromString($dtEnd, $hrEnd);
        //Query timestamp from database
        $dtinit = $app_db->get_results($qtinit);
        $dtfim = $app_db->get_results($qtfim);
        //Insert new dates
        $app_db->get_results($this->insertMeta($postID, 'vevent_dtstart', $dtinit[0]->DT));
        $app_db->get_results($this->insertMeta($postID, 'vevent_dtend', $dtfim[0]->DT));
        //Insert event duration variable
        $timeAmnt = (double) ($dtfim[0]->DT + (3600 * 6)) - (double) $dtinit[0]->DT;
        $app_db->get_results($this->insertMeta($postID, _DURACAO, $timeAmnt));
    }

    private function updateUserEvents($postID) {
        $lEvents = get_user_option(_MY_EVENTS, get_current_user_id());
        if (empty($lEvents)) {
            $lEvents = [];
        } else {
            $lEvents = unserialize($lEvents);
        }
        $lEvents[] = $postID;
        update_user_option(get_current_user_id(), _MY_EVENTS, serialize($lEvents));
    }

    /**
     * @Load complemento
     */
    public function loadComplemento($request) {
        global $wpdb;
        $query = "select "
                . " (select meta_value from wp_postmeta where meta_key='vevent_email' and post_id =" . $request['id'] . ") as email, "
                . " (select meta_value from wp_postmeta where meta_key='vevent_price' and post_id =" . $request['id'] . ") as price, "
                . " (select meta_value from wp_postmeta where meta_key='vevent_price_label' and post_id =" . $request['id'] . ") as plabel , "
                . " (select meta_value from wp_postmeta where meta_key='vevent_moreinfo' and post_id =" . $request['id'] . ") as info "
                . "from dual";
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        $data = new stdClass();
        $data->event = $app_db->get_results($query);
        $app_db->close();
        $query = "select meta_id,meta_key,meta_value from wp_posts as a left join wp_postmeta as b on a.ID = b.post_id where post_parent = " . $request['id'];
        $data->campaign = $wpdb->get_results($query);
        $wpdb->close();
        return $data;
    }

    /**
     * @Load Ajax with cached query for beachs
     */
    public function loadSearchBeachs($request) {
        $data = wp_cache_get('findBeachsAjax');
        if (false === $data) {
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            // var_dump($app_db);
            $query = "select id,post_title from wp_posts where post_parent = 2311 and post_title like '%" . $request['q'] . "%';";
            $data = $app_db->get_results($query);
            wp_cache_set('findBeachsAjax', $data);
            $app_db->close();
            @session_start();
            $_SESSION['findBeachsAjax'] = json_encode($data);
        }
        return $data;
    }

    /**
     * @Load Places by name
     */
    public function loadPlacesByName($request) {
        //var_dump($request);;
        $app_db = new wpdb(APP_USER, APP_PASS, APP_DBNM, APP_HOST);
        $query = "SELECT idPlace as placeID, upper(nmPlace) as placeName FROM guiafloripa_app.Place Where nmPlace like '%" . $request['name'] . "%' order by nmPlace ASC";
        $data = $app_db->get_results($query);

        // var_dump($data);
        $json = json_encode($data);
        ;
        //echo $json;
        $app_db->close();
        return $json;
    }

    /**
     * @Load MyPlace
     */
    public function loadMyPlace($request) {
        $data = wp_cache_get('loadMyPlace');
        if (false === $data) {
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            // var_dump($app_db);
            $query = "select id,post_title from wp_posts where id = (select meta_value from wp_postmeta where meta_key = 'vevent_location' and post_id=" . $request['id'] . ");";
            $data = $app_db->get_results($query);
            wp_cache_set('loadMyPlace', $data);
            $app_db->close();
        }
        return $data;
    }

    /**
     * @Load Ajax with cached query for neighbhood
     */
    public function loadSearchNeigh($request) {
        $data = wp_cache_get('findNeighoodAjax');
        if (false === $data) {
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            // var_dump($app_db);
            $query = "select id as postID,post_title as title from wp_posts where post_parent = 2191 and post_title like '%" . $request['q'] . "%' and post_title <> '' order by post_title asc;";
            $data = $app_db->get_results($query);
            wp_cache_set('findNeighoodAjax', $data);
            $app_db->close();
            @session_start();
            $_SESSION['findNeighoodAjax'] = json_encode($data);
        }
        return $data;
    }

    public function updateEventInfo($request) {
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        //var_dump($request);die;
        if ($request[_SECTION] === "place") {
            if (!empty($request['pResult'])) {
                $request['update2'] = $this->insertOrUpdateMeta($app_db, $request['eventID'], _LOCATION, $request['pResult']);
            }
        } else if ($request[_SECTION] === "comp") {
            global $wpdb;
            $request['update1'] = $this->insertOrUpdateMeta($app_db, $request['eventID'], _EVENTPRICE, $request['vevent_price']);
            $request['update2'] = $this->insertOrUpdateMeta($app_db, $request['eventID'], _EVENTMAIL, $request['email']);
            $request['pID'] = $wpdb->get_results("SELECT id FROM wp_posts where post_parent = " . $request['eventID']);


            $this->insertOrUpdateMeta($wpdb, $request['pID'][0]->id, _DISCOUNT, $request['discountAmount']);
            $this->insertOrUpdateMeta($wpdb, $request['pID'][0]->id, _LINKFACE, $request[_LINKFACE]);
            $this->insertOrUpdateMeta($wpdb, $request['pID'][0]->id, "youtube", $request['youtube']);
            $this->insertOrUpdateMeta($wpdb, $request['pID'][0]->id, "ticket", $request['ingresso']);
            $this->insertOrUpdateMeta($wpdb, $request['pID'][0]->id, "whats", $request['whats']);
            $this->insertOrUpdateMeta($wpdb, $request['pID'][0]->id, "email", $request['email']);
        } else if ($request[_SECTION] === "image") {
            if (!empty($request['content_url'])) {
                $request['image'] = $this->uploadImage($request['content_url']);
                $request['response'] = $this->insertOrUpdateMeta($app_db, $request['eventID'], _THUMB, $request['image']['id']);
                $query = "update wp_posts set post_parent = " . $request['eventID'] . " where post_id = " . $request['image']['id'];
                $app_db->get_results($query);
            } else {
                $query = "delete from wp_postmeta where meta_key = '" . _THUMB . "' and post_id = " . $request['eventID'];
                $request['delete'] = $app_db->get_results($query);
            }
        } else if ($request[_SECTION] === "local") {//
            $request['update1'] = $this->insertOrUpdateMeta($app_db, $request['eventID'], _BAIRROS, $request['neigh']);
            $request['update2'] = $this->insertOrUpdateMeta($app_db, $request['eventID'], _PRAIAS, $request['beach']);
            $query = "update wp_postmeta set meta_key = '" . $request['region'] . "' where meta_key like 'regiao_%' and post_id = " . $request['eventID'];
            $request['update3'] = $app_db->get_results($query);
        } else if ($request[_SECTION] === "categ") {//Remove categories
            $this->removeCategories($app_db, $request['eventID'], $request['oldCategories']);
            $request['removes'] = array();
            //insert permalink first been choosed so the meta for now just then we improve it
            $this->updatePrimaryCat($app_db, $request['eventID'], $request['categories'][0]);
            foreach ($request['categories'] as $cat) {
                $q1 = $this->insertCategory($request['eventID'], $cat);
                $request['removes'][] = $app_db->get_results($q1);
            }
        } else if ($request[_SECTION] === "dates") {
            $this->updateDates($request);
        } else if ($request[_SECTION] === "general") {
            $request['query1'] = "update wp_posts set post_title = '" . $request['titEvent'] . "', post_content = '" . $request['txtDesc'] . "' where id = " . $request['eventID'];
            $request['update'] = $app_db->get_results($request['query1']);
            $request['query2'] = "update wp_postmeta set meta_value = '" . $request['more_info'] . "' where meta_key = '" . _MOREINFO . "' and post_id = " . $request['eventID'];
            $request['update2'] = $this->insertOrUpdateMeta($app_db, $request['eventID'], _MOREINFO, $request['more_info']);
        }
        $app_db->close();
        // var_dump($request);die;
        return json_encode($request);
    }

    private function updatePrimaryCat(&$conn, $postId, $cat) {
        $query = "SELECT * from wp_postmeta where post_id = $postId and meta_key = '_category_permalink'";
        $r1 = $conn->get_results($query);
        if (count($r1) > 0) {
            return false;
        } else {
            $q1 = "insert into wp_postmeta (post_id,meta_key,meta_value) values (" . $postId . ",'_category_permalink'," . $cat . ")";
            $conn->get_results($q1);
        }
    }

    public function insertOrUpdateMeta(&$conn, $postID, $metaKey, $metaValue) {
        $query = "SELECT meta_id FROM wp_postmeta where post_id = " . $postID . " and meta_key='$metaKey'";
        $result = $conn->get_results($query);
        if ($result) {
            $query = "UPDATE wp_postmeta set meta_value = '" . $metaValue . "' where meta_id = " . $result[0]->meta_id;
            $result = $conn->get_results($query);
        } else {
            $query = $this->insertMeta($postID, $metaKey, $metaValue);
            $result = $conn->get_results($query);
        }
        return $result;
    }

    /**
     * @Load Regions
     */
    public function loadRegions($request) {
        $date = new stdClass();
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        $query = "select distinct meta_key from wp_postmeta where meta_key like 'regi%'";
        $date->regions = $app_db->get_results($query);
        $query = "select id as postID,post_title as title from wp_posts where post_parent = 2191 and post_title <> '' order by post_title asc;";
        $date->neigh = $app_db->get_results($query);
        $query = "select id,post_title from wp_posts where post_parent = 2311 and post_title <> '' order by post_title asc;";
        $date->beach = $app_db->get_results($query);
        $query = "select meta_value from wp_postmeta where post_id = " . $request['id'] . " and meta_key = '" . _BAIRROS . "'";
        $date->bairros = $app_db->get_results($query);
        $query = "select meta_value from wp_postmeta where post_id = " . $request['id'] . " and meta_key = '" . _PRAIAS . "'";
        $date->praias = $app_db->get_results($query);
        $query = "select meta_key from wp_postmeta where meta_key like 'regi%' and post_id=" . $request['id'];
        $date->mRegion = $app_db->get_results($query);
        // var_dump($date);
        $app_db->close();
        return $date;
    }

    /**
     * @Load Events Image
     */
    public function loadImage($postId) {
        $query = "select guid as img from wp_posts where id = (select meta_value from wp_postmeta where post_id = $postId and meta_key ='_thumbnail_id');";
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        //insert post evento
        $result = $app_db->get_results($query);
        $app_db->close();
        return $result;
    }

    /**
     * @Load Events dates for edition
     */
    public function loadDates($postID) {
        $query = " select "
                . " (select meta_value from wp_postmeta where meta_key = 'Mon' and post_id = $postID) as Mon, "
                . " (select meta_value from wp_postmeta where meta_key = 'Tue' and post_id = $postID) as Tue, "
                . " (select meta_value from wp_postmeta where meta_key = 'Wed' and post_id = $postID) as Wed, "
                . " (select meta_value from wp_postmeta where meta_key = 'Thu' and post_id = $postID) as Thu, "
                . " (select meta_value from wp_postmeta where meta_key = 'Fri' and post_id = $postID) as Fri, "
                . " (select meta_value from wp_postmeta where meta_key = 'Sat' and post_id = $postID) as Sat, "
                . " (select meta_value from wp_postmeta where meta_key = 'Sun' and post_id = $postID) as Sun, "
                . " DATE_FORMAT(FROM_UNIXTIME((select meta_value from wp_postmeta where meta_key = 'vevent_dtstart' and post_id = $postID)+(3*3600) ), '%Y-%m-%d')as dtStart, "
                . " DATE_FORMAT(FROM_UNIXTIME((select meta_value from wp_postmeta where meta_key = 'vevent_dtend' and post_id = $postID)+(3*3600) ), '%Y-%m-%d')as dtEnd, "
                . " DATE_FORMAT(FROM_UNIXTIME((select meta_value from wp_postmeta where meta_key = 'vevent_dtstart' and post_id = $postID)+(3*3600) ), '%H:%i')as hrStart, "
                . " DATE_FORMAT(FROM_UNIXTIME((select meta_value from wp_postmeta where meta_key = 'vevent_dtend' and post_id = $postID)+(3*3600) ), '%H:%i')as hrEnd "
                . " from dual;";
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        //insert post evento
        $result = $app_db->get_results($query);
        $app_db->close();
        return $result;
    }

    /**
     * @Create campaign and Email Modelo from default description
     */
    public function createCampaign($request, $postID) {
        $campaign = array(
            'post_title' => sanitize_title($request['titEvent'] . "_" . $request['placeName']),
            'post_content' => '<img src="' . $request['content_url'] . '"><br>' . $request['txtDesc'],
            'post_status' => 'draft',
            'post_type' => 'campaign',
            'post_parent' => $postID, //Parent from remote wordpress....
            'post_author' => get_current_user_id()//Current User
        );
        // Insert the post into the database
        $campaignID = wp_insert_post($campaign);
        //Add meta info
        // add_post_meta($campaignID, "vevent_dtstart", $dtStart, true);
        // add_post_meta($campaignID, "vevent_dtend", $dtEnd, true);
        if (!empty($request['discount'])) {
            add_post_meta($campaignID, _DISCOUNT, $request['discountAmount'], true);
        }
        if (!empty($request[_LINKFACE])) {
            add_post_meta($campaignID, _LINKFACE, $request[_LINKFACE], true);
        }
        if (!empty($request['youtube'])) {
            add_post_meta($campaignID, "youtube", $request['youtube'], true);
        }
        if (!empty($request['ingresso'])) {
            add_post_meta($campaignID, "ticket", $request['ingresso'], true);
        }
        if (!empty($request['whats'])) {
            add_post_meta($campaignID, "whats", $request['whats'], true);
        }
        if (!empty($request['email'])) {
            add_post_meta($campaignID, "email", $request['email'], true);
        }
        $email = array(
            'post_title' => sanitize_title($request['titEvent'] . "_" . $request['placeName']),
            'post_content' => $request['txtDesc'],
            'post_status' => 'draft',
            'post_type' => 'email',
            'post_parent' => $campaignID,
            'post_author' => get_current_user_id()
        );
        $emailID = wp_insert_post($email);
    }

    public function loadMyCategories($request) {
        //select 
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        $query = "select term_id from wp_term_taxonomy as a left join wp_term_relationships as b on a.term_taxonomy_id = b.term_taxonomy_id where a.taxonomy = 'segmento' and b.object_id =" . $request['id'];
        $ret = $app_db->get_results($query);
        $app_db->close();
        return $ret;
    }

    public function removeCategories(&$conn, $postID, $categorie) {
        $query = "delete from wp_term_relationships where object_id =$postID and term_taxonomy_id in (select term_taxonomy_id from wp_term_taxonomy where term_id in ($categorie) and taxonomy='segmento')";
        return $conn->get_results($query);
    }

    public function insertCategory($postID, $catID) {
        return "insert into wp_term_relationships value($postID,(select term_taxonomy_id from wp_term_taxonomy where term_id=$catID and taxonomy='segmento'),0)";
    }

    public function insertMeta($idPost, $metaKey, $metaValue) {
        $query = "insert into wp_postmeta (post_id,meta_key,meta_value) values ($idPost,'$metaKey','$metaValue')";
        return $query;
    }

    //SELECT UNIX_TIMESTAMP('2017-12-31 19:25:00')  -(3600*3) as DT
    public function getTimeFromString($d, $h) {
        $str = $d . " " . $h . ":00";
        return "SELECT UNIX_TIMESTAMP('" . $str . "')  -(3600*3) as DT";
    }

    public function uploadImage($image) {
        $myFile = str_replace("https://app.guiafloripa.com.br/wp-content/uploads/", "/var/www/app.guiafloripa.com.br/wp-content/uploads/", $image);
        $fileName = basename($myFile); //Get file name
        $fileType = filetype($myFile); //Get file type
        $fh = fopen($myFile, 'r');
        $fs = filesize($myFile);
        $theData = fread($fh, $fs);
        fclose($fh);
        $client = new WP_HTTP_IXR_CLIENT(WP_GUIA_XMLR);
        $client->debug = false;
        $params = array('name' => $fileName, 'type' => 'image/png', 'bits' => new IXR_Base64($theData), 'overwrite' => true);
        $res = $client->query('wp.uploadFile', 1, WP_GUIA_USER, WP_GUIA_PASS, $params);
        $clientResponse = $client->getResponse();
        return $clientResponse;
    }

}

function GetImageFromUrl($link) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);

    curl_close($ch);
    $upload_dir = wp_upload_dir();
    $basedir = $upload_dir['basedir'] . '/' . date('Y') . "/" . date('m') . "/facebook_" . rand() . ".jpg";
    //echo $basedir;
    $savefile = fopen($basedir, 'w');
    fwrite($savefile, $result);
    fclose($savefile);
    createAttach($basedir);
    return $basedir;
}

function createAttach($filename) {
    // $filename should be the path to a file in the upload directory.
// Check the type of file. We'll use this as the 'post_mime_type'.
    $filetype = wp_check_filetype(basename($filename), null);

// Get the path to the upload directory.
    $wp_upload_dir = wp_upload_dir();

// Prepare an array of post data for the attachment.
    $attachment = array(
        'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
        'post_mime_type' => $filetype['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
        'post_content' => '',
        'post_status' => 'inherit'
    );

// Insert the attachment.
    $attach_id = wp_insert_attachment($attachment, $filename);

// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

// Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
    wp_update_attachment_metadata($attach_id, $attach_data);
}
