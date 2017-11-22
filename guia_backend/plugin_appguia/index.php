<?php

/**
 * @Plugin Name: Guiafloripa APP REDIRECT
 * @Description: <p>PLUGIN REDIRECT DO APP GUIA - <b>www.experienciasdigitais.com.br</b>. <br>Utilize o Shorcode [guia_app]</p>
 * @author Luis Augusto Machado Moretto <projetos@morettic.com.br>
 * */
/* Start Adding Functions Below this Line */
define('PLUGIN_ROOT_DIR', plugin_dir_path(__FILE__));
const DEFAULT_VIEW_URL = "htps://app.guiafloripa.com.br";
const DEFAULT_REST_URL = "https://guiafloripa.morettic.com.br/busca/";
const DEFAULT_REST_PLACE = "https://guiafloripa.morettic.com.br/place/";
const DEFAULT_REST_ISSUE = "https://guiafloripa.morettic.com.br/issues/";
const DEFAULT_REST_STATS = "https://guiafloripa.morettic.com.br/sync_stats/";
const CACHE_FILE = "guia_cache.json";

/**
 * @Redirect URL using Javascript Script
 */
function guia_app_redirect() {
    $_key = $_GET['key'];
    $permaLink = get_permalink($_key);
    if (empty($permaLink)) {
        $permaLink = DEFAULT_VIEW_URL;
    }
    echo "<h1>Redirecionando</h1>";
    echo "<h4>Caso a página não redirecione clique no link abaixo</h4>";
    echo "<small><a href='$permaLink' target='_blank'>#$permaLink#</a></small>";
    //sleep(0.1);
    echo "<script>this.location.href='" . $permaLink . "';</script>";

    exit;
}

//Register Shortcode on Wordpress


/* Stop Adding Functions Below this Line */

function get_content() {
    //vars
    $current_time = time();
    $expire_time = 24 * 60 * 60;
    $file_time = filemtime(CACHE_FILE);
    //echo $file_time;
    //decisions, decisions
    if (file_exists(CACHE_FILE) && ($current_time - $expire_time < $file_time)) {
        return file_get_contents(CACHE_FILE);
    } else {
        $content = get_url(DEFAULT_REST_URL);

        //echo mb_detect_encoding($content);

        file_put_contents(CACHE_FILE, ($content));
        return ($content);
    }
}

function get_stats() {
    //vars
    $current_time = time();
    $expire_time = 24 * 60 * 60 * 3;
    $file_time = filemtime("stas_" . CACHE_FILE);
    //echo $file_time;
    //decisions, decisions
    if (file_exists("stas_" . CACHE_FILE) && ($current_time - $expire_time < $file_time)) {
        return file_get_contents("stas_" . CACHE_FILE);
    } else {
        $content = get_url(DEFAULT_REST_STATS);

        //echo mb_detect_encoding($content);

        file_put_contents("stas_" . CACHE_FILE, ($content));
        return ($content);
    }
}

function get_bugs() {
    //vars
    $current_time = time();
    $expire_time = 24 * 60 * 60;
    $file_time = filemtime("BUG_" . CACHE_FILE);
    //echo $file_time;
    //decisions, decisions
    if (file_exists("BUG_" . CACHE_FILE) && ($current_time - $expire_time < $file_time)) {
        return file_get_contents("BUG_" . CACHE_FILE);
    } else {
        $content = get_url(DEFAULT_REST_ISSUE);

        //echo mb_detect_encoding($content);

        file_put_contents("BUG_" . CACHE_FILE, ($content));
        return ($content);
    }
}

function wpse_91693_register() {
    add_menu_page(
            'Integração de dados APP', // page title
            'Sincronização', // menu title
            'manage_options', // capability
            'app_guiafloripa_manager_backend', // menu slug
            'wpse_91693_render', null, 6
    );
    /* add_menu_page(
      'Estabelecimento', // page title
      'Estabelecimento', // menu title
      'read', // capability
      'app_guiafloripa_empresa', // menu slug
      'asd', null, 6
      ); */
    add_menu_page(
            'Meus Eventos', // page title
            'Meus Eventos', // menu title
            'read', // capability
            'app_guiafloripa_eventos', // menu slug
            'wpse_91693_events', null, 6
    );
    add_menu_page(
            'Campanhas', // page title
            'Campanhas', // menu title
            'read', // capability
            'app_guiafloripa_campaigns', // menu slug
            'wpse_91693_campaign', null, 6
    );
    add_menu_page(
            'Leads', // page title
            'Leads', // menu title
            'read', // capability
            'app_guiafloripa_leads', // menu slug
            'asd', null, 6
    );
    add_menu_page(
            'Mensagens', // page title
            'Mensagens', // menu title
            'read', // capability
            'app_guiafloripa_msg', // menu slug
            'asd', null, 6
    );
    add_menu_page(
            'Notificações', // page title
            'Notificações', // menu title
            'read', // capability
            'app_guiafloripa_push', // menu slug
            'wpse_91693_push', null, 6
    );
    add_menu_page(
            'Emails', // page title
            'Emails', // menu title
            'read', // capability
            'app_guiafloripa_mail', // menu slug
            'asd', null, 6
    );
    add_menu_page(
            'Chatbot', // page title
            'Chatbot', // menu title
            'read', // capability
            'app_guiafloripa_chatbot', // menu slug
            'asd', null, 6
    );
    add_menu_page(
            'Plano', // page title
            'Plano', // menu title
            'read', // capability
            'app_guiafloripa_money', // menu slug
            'asd', null, 6
    );
    add_menu_page(
            'Twitter bot', // page title
            'Twitter bot', // menu title
            'read', // capability
            'app_guiafloripa_twitter', // menu slug
            'wpse_91693_twitter', null, 6
    );
    add_submenu_page('app_guiafloripa_twitter', 'Hashtags', 'Adicionar Hashtag', 'read', 'app_guiafloripa_twitter_add_term', 'app_guiafloripa_twitter_add_term');
   // add_submenu_page('app_guiafloripa_twitter', 'Nuvem de Hashtags', 'Nuvem de Hashtags', 'read', 'app_guiafloripa_twitter_cloud_tag', 'app_guiafloripa_twitter_cloud_tag');

    //add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Sincronizar', 'manage_options', 'app_guiafloripa_manager_stats', 'wpse_91693_render');
    add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Estatisticas', 'manage_options', 'app_guiafloripa_manager_stats', 'wpse_91693_stats');
    add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Bug Report', 'manage_options', 'app_guiafloripa_manager_bug', 'wpse_91693_bug');
}

function wpse_91693_push() {
    include_once 'views/notifications.php';
}

function app_guiafloripa_twitter_cloud_tag() {
    include_once PLUGIN_ROOT_DIR . 'views/tpage_cloud.php';
}

function app_guiafloripa_twitter_add_term() {
    include_once PLUGIN_ROOT_DIR . 'views/tpage_add.php';
}

function wpse_91693_stats() {
    include PLUGIN_ROOT_DIR . 'views/stats.php';
}

function wpse_91693_bug() {
    include PLUGIN_ROOT_DIR . 'views/bug.php';
}

function wpse_91693_render() {
    include PLUGIN_ROOT_DIR . 'views/admin.php';
}

function wpse_91693_events() {
    include PLUGIN_ROOT_DIR . 'views/events.php';
}

function wpse_91693_twitter() {
    include PLUGIN_ROOT_DIR . 'views/twitter.php';
}

/**
 * @Show Slider with today events
 *  */
function fguia_panel() {
    include PLUGIN_ROOT_DIR . 'views/panel.php';
}

/**
 * @Show Slider with today events
 *  */
function fguia_event() {
    include PLUGIN_ROOT_DIR . 'views/event.php';
}

/* gets content from a URL via curl */

function get_url($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $content = curl_exec($ch);
    curl_close($ch);
    $result = iconv("Windows-1251", "UTF-8", $content);
    return $result;
}

function post_url($url, $fields) {


//url-ify the data for the POST
    foreach ($fields as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }
    rtrim($fields_string, '&');

//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

//execute post
    $result = curl_exec($ch);

//close connection
    curl_close($ch);

    return $result;
}

function wp_login($login, $pass) {
    $creds = array(
        'user_login' => $login,
        'user_password' => $pass,
        'remember' => true
    );

    $user = wp_signon($creds, false);
    //var_dump($user);

    return $user;
}

/**
 * Custom Widgets
 */
function add_email_dashboard_widgets() {
    wp_add_dashboard_widget(
            'wpemail_dashboard_widget', // Widget slug.
            'Emails', // Title.
            'email_dashboard_widget_content' // Display function.
    );
    wp_add_dashboard_widget(
            'wpquota_dashboard_widget', // Widget slug.
            'Estatísticas de uso', // Title.
            'cota_dashboard_widget_content' // Display function.
    );
    $my_widget = $wp_meta_boxes['dashboard']['normal']['core']['wpquota_dashboard_widget'];
    unset($wp_meta_boxes['dashboard']['normal']['core']['wpquota_dashboard_widget']);
    $wp_meta_boxes['dashboard']['side']['core']['wpquota_dashboard_widget'] = $my_widget;
    wp_add_dashboard_widget(
            'wpplano_dashboard_widget', // Widget slug.
            'Seu Plano', // Title.
            'plano_dashboard_widget_content' // Display function.
    );
    wp_add_dashboard_widget(
            'wppush_dashboard_widget', // Widget slug.
            'Notificações', // Title.
            'push_dashboard_widget_content' // Display function.
    );
    global $wp_meta_boxes;
    $my_widget = $wp_meta_boxes['dashboard']['normal']['core']['wppush_dashboard_widget'];
    unset($wp_meta_boxes['dashboard']['normal']['core']['wppush_dashboard_widget']);
    $wp_meta_boxes['dashboard']['side']['core']['wppush_dashboard_widget'] = $my_widget;
    wp_add_dashboard_widget(
            'wptwitter_dashboard_widget', // Widget slug.
            'Twitter BOT', // Title.
            'twitter_dashboard_widget_content' // Display function.
    );
    $my_widget = $wp_meta_boxes['dashboard']['normal']['core']['wptwitter_dashboard_widget'];
    unset($wp_meta_boxes['dashboard']['normal']['core']['wptwitter_dashboard_widget']);
    $wp_meta_boxes['dashboard']['side']['core']['wptwitter_dashboard_widget'] = $my_widget;
    wp_add_dashboard_widget(
            'wptips_dashboard_widget', // Widget slug.
            'Dicas e tutorias', // Title.
            'tips_dashboard_widget_content' // Display function.
    );
    $my_widget = $wp_meta_boxes['dashboard']['normal']['core']['wptips_dashboard_widget'];
    unset($wp_meta_boxes['dashboard']['normal']['core']['wptips_dashboard_widget']);
    $wp_meta_boxes['dashboard']['side']['core']['wptips_dashboard_widget'] = $my_widget;
    wp_add_dashboard_widget(
            'wpleads_dashboard_widget', // Widget slug.
            'Leads', // Title.
            'leads_dashboard_widget_content' // Display function.
    );
    wp_add_dashboard_widget(
            'wpeventos_dashboard_widget', // Widget slug.
            'Meus Eventos', // Title.
            'events_dashboard_widget_content' // Display function.
    );
}

/**
 * Create the function to output the contents of your Dashboard Widget.
 */
function share_dashboard_widget_content() {
    // Display whatever it is you want to show.
    echo "Hello there, I'm a Dashboard Widget. Edit me!";
}

function wpb_sender_email($original_email_address) {
    return 'comercial@guiafloripa.com.br';
}

// Function to change sender name
function wpb_sender_name($original_email_from) {
    return 'Comercial';
}

function remove_dashboard_widgets() {
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
}

function hid_wordpress_thankyou() {
    echo '<style type="text/css">#wpfooter {display:none;} </style>';
}

//Remove visit site menu
function remove_admin_bar_links() {
    global $wp_admin_bar;
    // $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
}

// Our custom post type function
function create_event_post() {
    register_post_type('_events',
            // CPT Options
            array(
        'labels' => array(
            'name' => __('Eventos'),
            'singular_name' => __('Eventos')
        ),
        'capability' => __('read'),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'eventos'),
            )
    );
}

function my_post_type_editor_settings($settings) {
    global $post_type;
    if ($post_type == '_events') {
        $settings['tinymce'] = false;
    }
    return $settings;
}

//
//$tc = new TwitterControl();

function twitter_dashboard_widget_content() {
    //echo "TESTE";
    include_once PLUGIN_ROOT_DIR . 'views/TwitterControl.php';
    $tc = new TwitterControl();
    $is = $tc->verifyConfig();
    $tc->dashBoardInfo($is);
}

/**
 * Register the /wp-json/twitterbot/v1/foo route
 */
function myplugin_register_routes() {
    register_rest_route('twitterbot/v1', 'bot', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'twitter_bot_route',
    ));
}

/**
 * Generate results for the /wp-json/twitterbot/v1/bot route.
 *
 * @param WP_REST_Request $request Full details about the request.
 *
 * @return WP_REST_Response|WP_Error The response for the request.
 */
function twitter_bot_route(WP_REST_Request $request) {
    include_once PLUGIN_ROOT_DIR . 'views/TwitterControl.php';
    // Do something with the $request
    // Return either a WP_REST_Response or WP_Error object
    $tc = new TwitterControl();
    $data = $tc->getActionsForBot();
    $response = new WP_REST_Response($data);
    $response->set_status(201);
    return $response;
}

/**
 * Custom Actions
 * @Shortcodes
 * @Filters
 * @Actions
 * @Remove
 */
remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
add_filter('wp_mail_from', 'wpb_sender_email');
add_filter('wp_mail_from_name', 'wpb_sender_name');
add_filter('wp_editor_settings', 'my_post_type_editor_settings');
add_action('init', 'create_event_post');
add_action('rest_api_init', 'myplugin_register_routes');
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');
add_action('wp_dashboard_setup', 'add_email_dashboard_widgets');
add_action('admin_menu', 'wpse_91693_register');
add_action('admin_head', 'hid_wordpress_thankyou');
add_shortcode('guia_app', 'guia_app_redirect');
add_shortcode('guia_event', 'fguia_event');
add_shortcode('guia_panel', 'fguia_panel');
// Hooking up our functions to WordPress filters 
?>
