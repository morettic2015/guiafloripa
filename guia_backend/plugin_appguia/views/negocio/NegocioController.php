<?php

require_once( ABSPATH . 'wp-admin/includes/file.php' );
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NegocioController
 *
 * @author Morettic LTDA
 */
const BUSINESS_TYPE = "business_type";
const _BYTE = 1;
const _MEGA = 5;
const _GIGA = 10;
const _TERA = 50;

class NegocioController extends stdClass {

    public function getMaxBusiness() {
        global $wpdb;
        $myPlan = get_user_meta(get_current_user_id(), "_plano_type", true);
        //echo $myPlan;
        $tot_plan;
        switch ($myPlan) {
            case 1:
                $tot_plan = _MEGA;
                break;
            case 2:
                $tot_plan = _GIGA;
                break;
            case 3:
                $tot_plan = _TERA;
                break;
            default :
                $tot_plan = _BYTE;
                break;
        }

        $query = "select count(ID) as total from wp_posts where post_author = " . get_current_user_id() . " and post_type = 'business'";
        $business = $wpdb->get_results($query);
        $rest = $tot_plan - $business[0]->total;
        if ($rest > 0) {
            echo ' <div class="notice notice-warning"><p>Seu plano permite gerenciar mais ' . $rest . ' negócios</p></div>';
        } else {
            echo ' <div class="notice notice-error"><p>Limite de negócios atingido. Faça upgrade de seu <a href="admin.php?page=app_guiafloripa_money">plano</a></p></div>';
        }
        return $rest;
    }

    public function getCategoriasGuia($request = NULL) {
        if (is_null($request)) {
            $query = "select term_id,name from wp_terms where term_id in (select term_id from wp_term_taxonomy where taxonomy = 'hierarquia' and parent = 0)";
        } else {
            $query = "select term_id,name from wp_terms where term_id in (select term_id from wp_term_taxonomy where taxonomy = 'hierarquia' and parent = $request)";
        }
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        $ret = $app_db->get_results($query);
        return $ret;
    }

    public function logMail($negocio) {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
        $headers[] = 'To: Comercial Guia Floripa <comercial@guiafloripa.com.br>';
        $headers[] = 'From: Guia Floripa APP <contatos@app.guiafloripa.com.br>';
        $headers[] = 'Cc: cesar_floripa@hotmail.com';
        $headers[] = 'Bcc: malacma@gmail.com';
// Mail it
        mail("comercial@guiafloripa.com.br", "Atualização de negócio:" . $negocio, "Negócio atualizado na base do Guiafloripa. Aguardando publicação....", implode("\r\n", $headers));
    }

    //put your code here
    public function insertUpdateNegocio($request) {
        global $wpdb;
        /* echo "<pre>";
          var_dump($request);
          echo "</pre>"; */
        if (count($request) > 0) {
            //echo "<pre>";

            $post_data = array(
                'post_title' => $request['nmNegocio'],
                'post_content' => $request['txtDesc'],
                'post_type' => 'business',
                'post_author' => get_current_user_id()
            );

            $this->logMail($request['nmNegocio']);

            if (!empty($request['idNegocio'])) {//Update post
                //var_dump($business);die;
                $post_data['ID'] = $request['idNegocio'];
            }
            $post_id = wp_insert_post($post_data);
            update_post_meta($post_id, 'facePage', empty($request['facePage']) ? $request['facePage1'] : $request['facePage']);
            update_post_meta($post_id, 'foneNegocio', $request['foneNegocio']);
            update_post_meta($post_id, 'whatsNegocio', $request['whatsNegocio']);
            update_post_meta($post_id, 'urlNegocio', $request['urlNegocio']);
            update_post_meta($post_id, 'emailNegocio', $request['emailNegocio']);
            update_post_meta($post_id, 'cnpjNegocio', $request['cnpjNegocio']);
            update_post_meta($post_id, 'faceNegocio', $request['faceNegocio']);
            update_post_meta($post_id, 'googleNegocio', $request['googleNegocio']);
            update_post_meta($post_id, 'american', $request['american']);
            update_post_meta($post_id, 'amex', $request['amex']);
            update_post_meta($post_id, 'credicard', $request['credicard']);
            update_post_meta($post_id, 'discover', $request['discover']);
            update_post_meta($post_id, 'master', $request['master']);
            update_post_meta($post_id, 'visa', $request['visa']);
            update_post_meta($post_id, 'i_domingo', $request['i_domingo']);
            update_post_meta($post_id, 'f_domingo', $request['f_domingo']);
            update_post_meta($post_id, 'i_segunda', $request['i_segunda']);
            update_post_meta($post_id, 'f_segunda', $request['f_segunda']);
            update_post_meta($post_id, 'i_terca', $request['i_terca']);
            update_post_meta($post_id, 'f_terca', $request['f_terca']);
            update_post_meta($post_id, 'i_quarta', $request['i_quarta']);
            update_post_meta($post_id, 'f_quarta', $request['f_quarta']);
            update_post_meta($post_id, 'i_quinta', $request['i_quinta']);
            update_post_meta($post_id, 'f_quinta', $request['f_quinta']);
            update_post_meta($post_id, 'i_sexta', $request['i_sexta']);
            update_post_meta($post_id, 'f_sexta', $request['f_sexta']);
            update_post_meta($post_id, 'i_sabado', $request['i_sabado']);
            update_post_meta($post_id, 'f_sabado', $request['f_sabado']);
            update_post_meta($post_id, 'zip', $request['zip']);
            update_post_meta($post_id, 'street', $request['street']);
            update_post_meta($post_id, 'neigh', $request['neigh']);
            update_post_meta($post_id, 'city', $request['city']);
            update_post_meta($post_id, 'state', $request['state']);
            update_post_meta($post_id, 'country', $request['country']);
            update_post_meta($post_id, 'lat', $request['lat']);
            update_post_meta($post_id, 'lon', $request['lon']);
            update_post_meta($post_id, 'picLogoURL', $request['picLogoURL']);
            update_post_meta($post_id, 'picCapaURL', $request['picCapaURL']);
            update_post_meta($post_id, 'neigh', $request['neigh']);
            update_post_meta($post_id, 'businessTypeGuia', $request['businessTypeGuia']); //Guia category
            update_post_meta($post_id, 'chkSyncGuia', $request['chkSyncGuia']);
            update_post_meta($post_id, 'chkSyncGuiaAPP', $request['chkSyncGuiaAPP']);
            update_post_meta($post_id, 'chkGoogle', $request['chkGoogle']);
            update_post_meta($post_id, '_google_token_', $request['google_token']);
            update_post_meta($post_id, '_chkFace', $request['chkFace']);
            update_post_meta($post_id, '_face_appid_', $request['face_appid']);
            update_post_meta($post_id, '_face_appsecret_', $request['face_appsecret']);
            update_post_meta($post_id, '_sub_category_', $request['businessTypeGuia1']); //Sub category
            update_post_meta($post_id, '_region_coor_', $request['region']); //City region
            update_post_meta($post_id, '_beach_nearby_', $request['beach']); //Beacj region
            update_post_meta($post_id, '_ac', $request['_ac']); //Beacj region
            update_post_meta($post_id, '_at', $request['_at']); //Beacj region
            update_post_meta($post_id, '_cs', $request['_cs']); //Beacj region
            update_post_meta($post_id, '_ck', $request['_ck']); //Beacj region
            update_post_meta($post_id, '_onesignal_rest_api_key', $request['_onesignal_rest_api_key']); //Beacj region
            update_post_meta($post_id, '_onesignal_app_id', $request['_onesignal_app_id']); //Beacj region

            $this->updateTerms($request, $post_id);

            echo '<div class="notice notice-success"> 
                    <p><strong>Negócio atualizado com sucesso</strong></p>
                 </div>';
            //$std->terms = wp_get_object_terms($post_id, BUSINESS_TYPE);
            return $this->findNegocioById($post_id);
        } else {
            $query = "select ID from wp_posts where post_author = " . get_current_user_id() . " and post_type = 'business'";
            //echo $query;
            $business = $wpdb->get_results($query);
            //var_dump($business);
            if (!empty($business)) {
                return $this->findNegocioById($business[0]->ID);
            }
            return null;
        }
    }

    public function findNegocioById($id) {
        global $wpdb;
        $query = "select ID from wp_posts where post_author = " . get_current_user_id() . " and post_type = 'business' and ID = $id";
        //echo $query;
        $business = $wpdb->get_results($query);
        //var_dump($business);
        if (!empty($business)) {
            $std = new stdClass();
            $std->id = $business[0]->ID;
            $std->post = get_post($business[0]->ID);
            $std->meta = get_post_meta($business[0]->ID);

            if (isset($std->meta['_sub_category_'][0])) {
                $query = "select term_id,name from wp_terms where term_id =" . $std->meta['_sub_category_'][0];
                //echo $query;
                $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
                $std->sub = $app_db->get_results($query);
            }
            //$std->terms = wp_get_object_terms($business[0]->ID, BUSINESS_TYPE);
            // $wpdb->close();

            return $std;
        }
        return null;
    }

    private function updateTerms($request, $post_id) {
        $term = explode(":", $request['businessType']);
        if (count($term) > 1) {
            $term_id_wp = wp_insert_term($term[1], BUSINESS_TYPE);
            if (isset($term_id_wp->errors)) {
                $term = get_term_by('name', $term[1], BUSINESS_TYPE);
                $term_id = $term->term_id;
            } else {
                //echo "Novo";
                $term_id = $term_id_wp['term_id'];
            }
            update_post_meta($post_id, BUSINESS_TYPE, $term_id);
        } else {
            update_post_meta($post_id, BUSINESS_TYPE, $request['businessType']);
        }
    }

    public function insertOrUpdate($id) {
        @session_start();
        include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);

        // echo $id;
        $postID = null;
        $negocio = $this->findNegocioById($id);
        /* echo "<pre>";
          var_dump($negocio);
          echo "</pre>"; */
        if (empty($negocio->meta['_id_app_guia_'][0])) {
            //  echo "nobo";
            $query = $this->insertNegocioGuia($negocio);

            $result = $app_db->get_results($query);

            $query = "select ID from wp_posts where post_title = '" . $negocio->post->post_title . "' order by id DESC limit 1";
            $result = $app_db->get_results($query);
            $postID = $result[0]->ID;

            update_post_meta($id, "_id_app_guia_", $postID);
        } else {
            $postID = $negocio->meta['_id_app_guia_'][0];
            $query = "update wp_posts set post_excerpt='" . strip_tags(substr($negocio->post->post_content, 0, 449)) . "', post_title = '" . $negocio->post->post_title . "',post_content='" . $negocio->post->post_content . "' where id = " . $postID;
            // echo $query;
            $vet[] = $app_db->get_results($query);
        }
        $plano = empty(get_user_meta(get_current_user_id(), "_plano_type", true)) ? "1" : "0";

        $ec = new EventControl();

        $vet = array();

        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, "_category_permalink", $negocio->meta['_sub_category_'][0]));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, "vcard_address", $negocio->meta['street'][0]));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, "vcard_locality", $negocio->meta['city'][0]));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, "vcard_region", $negocio->meta['state'][0]));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, "vcard_tel", $negocio->meta['foneNegocio'][0]));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, "vcard_email", $negocio->meta['emailNegocio'][0]));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, "tipo_anuncio", $plano));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, $negocio->meta['_region_coor_'][0], '1'));
        $query = "select id as postID,post_title as title from wp_posts where post_parent = 2191 and post_title like '%" . $negocio->meta['neigh'][0] . "%' and post_title <> '' order by post_title asc;";
        $bairro = $app_db->get_results($query);
        $query = "select id,post_title from wp_posts where post_parent = 2311 and post_title like '%" . $negocio->meta['_beach_nearby_'][0] . "%';";
        $beach = $app_db->get_results($query);
        // var_dump($bairro);
        //  var_dump($beach);
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, _BAIRROS, $bairro[0]->postID));
        $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, _PRAIAS, $beach[0]->id));
        $vet[] = $app_db->get_results($ec->insertHierarquia($postID, $negocio->meta['_sub_category_'][0]));
        $vet[] = $app_db->get_results($ec->insertHierarquia($postID, $negocio->meta['businessTypeGuia'][0]));

        $logo = $negocio->meta['picLogoURL'][0];
        // echo $logo;
        $posStrFace = strpos($logo, "scontent.xx.fbcdn.net");
        //  echo "......................." . $posStrFace . "-----------------";

        if ($posStrFace > 0) {//imagem vem do facebook
            $urlImageNew = $this->copyImageFromFace($app_db, $logo, $postID);
            echo $urlImageNew;
            $infoPicture = $ec->uploadImage($urlImageNew);
            $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, _THUMB, $infoPicture['id']));
        } else {
            $infoPicture = $ec->uploadImage($logo);
            $vet[] = ($ec->insertOrUpdateMeta($app_db, $postID, _THUMB, $infoPicture['id']));
        }
        return $vet;
    }

    private function copyImageFromFace(&$app_db, $url, $postID) {


// URL to the WordPress logo

        $vet = explode("/", $url);
        $pos = count($vet) - 1;
        //echo $vet[$pos]."-------------";
        //var_dump($vet);die;
        $name = explode("?", $vet[$pos]);
        $dir = wp_upload_dir();
        // var_dump($dir);die;

        $img = $dir['path'] . "/" . date('d-m-y') . $name[0];

        echo "...." . $img;

        file_put_contents($img, file_get_contents($url));
        // $filename = $results['file']; // Full path to the file
        // $local_url = $results['url'];  // URL to the file in the uploads dir
        //$type = $results['type']; // MIME type of the file
        // Perform any actions here based in the above results
        $attachment = array(
            'post_mime_type' => filetype($img),
            'post_title' => $img,
            'post_content' => 'Anexo',
            'post_author' => get_current_user_id(),
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $img);


        return str_replace("/var/www/app.guiafloripa.com.br", "https://app.guiafloripa.com.br", $img);
    }

    public function insertNegocioGuia($obj) {
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
          '" . $obj->post->post_content . "<br><b>Autor:" . $current_user->user_firstname . "</b>',
          '" . $obj->post->post_title . "',
          '" . strip_tags($obj->post->post_content) . "',
          'draft',
          'closed',
          'closed',
          '" . $obj->post->post_title . "',
          0,
          0,
          NOW() + INTERVAL 5 HOUR,
          NOW() + INTERVAL 5 HOUR,
          '" . $obj->post->post_title . "',
          '',
          '" . sanitize_title($obj->post->post_title) . "',
          0,
          'anuncio',
          'post',
          0);";
        return $query;
    }

    public function loadStats() {
        global $wpdb;
        $std = new stdClass();
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

        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        $query = "
                SELECT count(*) as total
                FROM wp_posts as a 
                where 
                    id in ($myEvents)";
        //echo $myEvents;
        //echo $query;
        $std->events = $app_db->get_results($query);

        // $std->totalEvents = count($lEvents);
        $query = "select count(ID) as total from wp_posts where post_author = " . get_current_user_id() . " and post_type = 'business'";
        $std->business = $wpdb->get_results($query);

        //var_dump($_POST);
        $image_ids = get_posts(
                array(
                    'post_type' => 'attachment',
                    //'post_mime_type' => 'image',
                    'post_author' => get_current_user_id(),
                    //'post_status' => 'inherit',
                    'posts_per_page' => - 1,
                    'fields' => 'ids',
        ));

        // var_dump($image_ids);

        $diskQuote = 0;
        foreach ($image_ids as $i) {
            // echo $i;
            //$attachment_meta = wp_get_attachment_metadata($i);
            // echo $attachment_meta['filesizeHumanReadable'];
            $diskQuote += filesize(get_attached_file($i));

            // $metadata = wp_get_attachment_metadata($attachment_id);
            //  echo $metadata['filesize'];
        }
        $std->totalMedia = count($image_ids);
        $std->usage = round($diskQuote / 1000000, 2);
        //   $std->quote = get_user_meta(get_current_user_id(), DISK_QUOTE);

        return $std;
    }

}
