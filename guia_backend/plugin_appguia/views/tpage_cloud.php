<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?> <a href="admin.php?page=app_guiafloripa_twitter_add_term" class="page-title-action">Adicionar hashtag</a></h1>
    <?php
    include_once PLUGIN_ROOT_DIR . 'views/TwitterControl.php';
    $tc = new TwitterControl();
    // $tc->saveTerm($_POST);
    $tc->verifyConfig();
    ?>
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->

    <h2>Popular Tags</h2>
    <ul>
        <li><?php
            /* $args = array(
              'taxonomy' => array('post_tag', 'category'),
              );

              wp_tag_cloud($args); */
            ?></li>
    </ul>

</div>