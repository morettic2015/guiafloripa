<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="notice notice-info"> 
        <p>Biblioteca de mídias</p>
    </div>
    <?php
    $image_ids = get_posts(
            array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_author' => get_current_user_id(),
                'post_status' => 'inherit',
                'posts_per_page' => - 1,
                'fields' => 'ids',
    ));

    // var_dump($image_ids);

    $diskQuote = 0;
    foreach ($image_ids as $i) {
        // echo $i;
        $attachment_meta = wp_get_attachment_metadata($i);

        // echo $attachment_meta['filesizeHumanReadable'];
        $diskQuote += filesize(get_attached_file($i));

        // $metadata = wp_get_attachment_metadata($attachment_id);
        //  echo $metadata['filesize'];
    }

    echo '<div class="notice notice-warning"> 
                    <p><strong>Total de disco utilizado ' . round($diskQuote / 1000000, 2) . 'MB.</strong></p>
                 </div>';

    $total = count($images);
    $limit = $total / 3;
    $images = array_map("wp_get_attachment_url", $image_ids);
    foreach ($images as $obj) {
        ?>
        <div class="gallery">
            <a href="<?php echo $obj; ?>" target="_BLANK">
                <img src="<?php echo $obj; ?>" alt="<?php echo $obj; ?>" width="300" height="200">
            </a>
        </div>
        <?php
    }
    ?>

</div>



<style>
    div.gallery {
        margin: 8px;
        border: 1px solid #ccc;
        float: left;
        width: 300px;
        height: 180px;
       
    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: auto;
        max-width: 300px;
        height: 180px;
    }

    div.desc {
        padding: 15px;
        text-align: center;
    }
</style>