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

global $app_db;

class EventControl extends stdClass {

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

    public function loadMyEvents() {
        $lEvents = get_user_option(_MY_EVENTS, get_current_user_id());
        if (empty($lEvents)) {
            $lEvents = [];
        } else {
            $lEvents = unserialize($lEvents);
        }
        $myEvents = "";
        foreach ($lEvents as $e) {
            $myEvents .= $e . ",";
        }
        $myEvents .= "-1";
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
          '" . $request['txtDesc'] . "',
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

    public function insertEvent($request) {
        //var_dump($_SESSION);


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
            $app_db->get_results($this->insertMeta($postID, 'praias', $ne[0]->id));
        }
        //Place owner
        $ne = json_decode($_SESSION['place']);
        if (count($ne) > 0) {
            $app_db->get_results($this->insertMeta($postID, 'vevent_location', $ne[0]->placeID));
        }
        //Evento more info

        $app_db->get_results($this->insertMeta($postID, _MOREINFO, $request['more_info']));
        //Meta regiao_central
        $app_db->get_results($this->insertMeta($postID, $request['region'], '1'));
        //Meta Evento price & Info
        $app_db->get_results($this->insertMeta($postID, 'vevent_price', $request['vevent_price']));
        $app_db->get_results($this->insertMeta($postID, 'vevent_price_label', "Ingresso:"));
        //Meta email
        if (!empty($request['email'])) {
            $app_db->get_results($this->insertMeta($postID, 'vevent_email', $request['email']));
        }
        //Dates
        $qtinit = $this->getTimeFromString($request['dtStart'], $request['hrStart']);
        $qtfim = $this->getTimeFromString($request['dtEnd'], $request['hrEnd']);
        //Query timestamp from database
        $dtinit = $app_db->get_results($qtinit);
        $dtfim = $app_db->get_results($qtfim);
        //Insert new dates
        $app_db->get_results($this->insertMeta($postID, 'vevent_dtstart', $dtinit[0]->DT));
        $app_db->get_results($this->insertMeta($postID, 'vevent_dtend', $dtfim[0]->DT));
        //Insert event duration variable
        $timeAmnt = (double) ($dtfim[0]->DT + (3600 * 6)) - (double) $dtinit[0]->DT;
        $app_db->get_results($this->insertMeta($postID, _DURACAO, $timeAmnt));
        //Close connection
        $app_db->close();
        //If parameter is set create prebuild templates
        //Create Campaign
        $this->createCampaign($request, $postID, $dtinit[0]->DT, $dtfim[0]->DT);

        $lEvents = get_user_option(_MY_EVENTS, get_current_user_id());
        if (empty($lEvents)) {
            $lEvents = [];
        } else {
            $lEvents = unserialize($lEvents);
        }
        $lEvents[] = $postID;
        update_user_option(get_current_user_id(), _MY_EVENTS, serialize($lEvents));
        //Aviso guiafloripa
        wp_mail("comercialguiafloripa@gmail.com", "Novo evento:" . $request['titEvent'], "Novo evento cadastrado");
        // var_dump($mData);
        return $postID;
    }

    /**
     * @Create campaign and Email Modelo from default description
     */
    public function createCampaign($request, $postID, $dtStart, $dtEnd) {
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
        add_post_meta($campaignID, "vevent_dtstart", $dtStart, true);
        add_post_meta($campaignID, "vevent_dtend", $dtEnd, true);
        if (!empty($request['discount'])) {
            add_post_meta($campaignID, "discount", $request['discountAmount'], true);
        }
        if (!empty($request['linkFace'])) {
            add_post_meta($campaignID, "linkFace", $request['linkFace'], true);
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
