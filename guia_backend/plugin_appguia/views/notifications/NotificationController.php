<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationController
 *
 * @author Morettic LTDA
 */
const NOTIFICATION_LINK = "_note_link";

class NotificationController {

    //put your code here
    public function updateNotification($request) {
        //
        if (isset($request['subject'])) {
            //var_dump($request);die;
            $email = array(
                'ID' => $request['id'],
                'post_title' => wp_strip_all_tags($request['subject']),
                'post_content' => $request['description'],
                'post_status' => 'draft',
                'post_type' => 'notification',
                'post_author' => get_current_user_id()
            );
            // Insert the post into the database
            $postId = wp_insert_post($email);
            //var_dump($emailId);
            if (!add_post_meta($postId, NOTIFICATION_LINK, $request['link'], true)) {
                update_post_meta($postId, NOTIFICATION_LINK, $request['link']);
            }
            echo '<div class="notice notice-success is-dismissible"> 
                    <p><strong><code>Notificação ' . $postId . '</code> salva com sucesso</strong></p>
                 </div>';
        }else if(isset($_GET['id'])){
            $postId = $_GET['id'];
        }
        $not = new stdClass();
        $not->post = get_post($postId);
        $not->url = get_post_meta($postId, NOTIFICATION_LINK, true);
        return $not;
    }

}
