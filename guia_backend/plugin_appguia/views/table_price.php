<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="notice notice-info"> 
        <p><code>Planos</code> disponíveis.</p>
    </div>
    <ul class="products">
        <?php
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 12
        );
        $loop = new WP_Query($args);
                var_dump($loop);
        if ($loop->have_posts()) {
            while ($loop->have_posts()) : $loop->the_post();
            endwhile;
        } else {
            echo __('No products found');
        }
        wp_reset_postdata();
        ?>
    </ul><!--/.products-->
</div>