<?php

const DISK_QUOTE = "_disk_quota";

class MediaController {

    public function get_attachment_id($url) {
        $attachment_id = 0;
        $dir = wp_upload_dir();
        if (false !== strpos($url, $dir['baseurl'] . '/')) { // Is URL in uploads directory?
            $file = basename($url);
            $query_args = array(
                'post_type' => 'attachment',
                'post_status' => 'inherit',
                'fields' => 'ids',
                'meta_query' => array(
                    array(
                        'value' => $file,
                        'compare' => 'LIKE',
                        'key' => '_wp_attachment_metadata',
                    ),
                )
            );
            $query = new WP_Query($query_args);
            if ($query->have_posts()) {
                foreach ($query->posts as $post_id) {
                    $meta = wp_get_attachment_metadata($post_id);
                    $original_file = basename($meta['file']);
                    $cropped_image_files = wp_list_pluck($meta['sizes'], 'file');
                    if ($original_file === $file || in_array($file, $cropped_image_files)) {
                        $attachment_id = $post_id;
                        break;
                    }
                }
            }
        }
        return $attachment_id;
    }

    public function removeMedia($request) {
        global $wpdb;
        if (isset($request['mediaId'])) {

            $query = "select post_id as pid, meta_id, meta_value, 'POST' as tp from wp_postmeta where meta_key in ('_url_logo1','_url_logo','content_url','content_url1') and meta_value like '%" . $request['mediaName'] . "'
                            union
                         select user_id as pid, umeta_id as meta_id, meta_value, 'USER' as tp from wp_usermeta where meta_key in ('content_url','content_url1') and meta_value like '%" . $request['mediaName'] . "'";
           // echo $query;
            $cp = $wpdb->get_results($query);
            
            var_dump($cp);
            if (count($cp) > 0) {
                echo '<div class="notice notice-error"><p><strong>A mídia selecionada está vinculada e não pode ser removida.</strong></p></div>';
            } else {
                $ret = wp_delete_attachment($request['mediaId']);
                var_dump($ret);
                if (isset($ret->ID)) {
                    echo '<div class="notice notice-success"><p><strong>Media removida com sucesso.</strong></p></div>';
                } else {
                    echo '<div class="notice notice-error"><p><strong>Um erro ocorreu ao tentar remover a sua mídia.</strong></p></div>';
                }
            }
        }
    }

    public function loadMedias() {

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
        $usage = round($diskQuote / 1000000, 2);
        update_user_meta(get_current_user_id(), DISK_QUOTE, $usage);
        echo '<div class="notice notice-warning"> 
                    <p><strong>Total de disco utilizado ' . $usage . 'MB.</strong></p>
                 </div>';

        $total = count($images);
        $limit = $total / 3;
        $images = array_map("wp_get_attachment_url", $image_ids);
        return $images;
    }

}
