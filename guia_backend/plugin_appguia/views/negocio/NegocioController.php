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

class NegocioController extends stdClass {

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

            $this->updateTerms($request, $post_id);

            $std = new stdClass();
            $std->id = $post_id;
            $std->post = get_post($post_id);
            $std->meta = get_post_meta($post_id);

            //$wpdb->close();
            //$this->updateTerms($request, $post_id);

            echo '<div class="notice notice-success"> 
                    <p><strong>Negócio atualizado com sucesso</strong></p>
                 </div>';
            //$std->terms = wp_get_object_terms($post_id, BUSINESS_TYPE);
            return $std;
        } else {
            $query = "select ID from wp_posts where post_author = " . get_current_user_id() . " and post_type = 'business'";
            //echo $query;
            $business = $wpdb->get_results($query);
            //var_dump($business);
            if (!empty($business)) {
                $std = new stdClass();
                $std->id = $business[0]->ID;
                $std->post = get_post($business[0]->ID);
                $std->meta = get_post_meta($business[0]->ID);
                //$std->terms = wp_get_object_terms($business[0]->ID, BUSINESS_TYPE);
                // $wpdb->close();

                return $std;
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
