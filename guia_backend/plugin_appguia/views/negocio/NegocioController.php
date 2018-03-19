<?php

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
            update_post_meta($post_id, 'businessTypeGuia', $request['businessTypeGuia']);//Guia category
            update_post_meta($post_id, 'chkSyncGuia', $request['chkSyncGuia']);
            update_post_meta($post_id, 'chkSyncGuiaAPP', $request['chkSyncGuiaAPP']);
            update_post_meta($post_id, 'chkGoogle', $request['chkGoogle']);
            update_post_meta($post_id, '_google_token_', $request['google_token']);
            update_post_meta($post_id, '_chkFace', $request['chkFace']);
            update_post_meta($post_id, '_face_appid_', $request['face_appid']);
            update_post_meta($post_id, '_face_appsecret_', $request['face_appsecret']);
            update_post_meta($post_id, '_sub_category_', $request['businessTypeGuia1']);//Sub category
            update_post_meta($post_id, '_region_coor_', $request['region']);//City region
             update_post_meta($post_id, '_beach_nearby_', $request['beach']);//Beacj region

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
                $query = "select term_id,name from wp_terms where term_id =".$std->meta['_sub_category_'][0];
                //echo $query;
                $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
                $std->sub= $app_db->get_results($query);
                
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

}
