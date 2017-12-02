<?php
include_once '/var/www/guiafloripa.morettic.com.br/vendor/autoload.php';
/**
 * @Plugin Name: Guiafloripa APP REDIRECT
 * @Description: <p>PLUGIN REDIRECT DO APP GUIA - <b>www.experienciasdigitais.com.br</b>. 
 * <br>Utilize o Shorcode [guia_app]</p>
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
const APP_USER = 'guia';
const APP_PASS = 'Gu14Fl0r1p@';
const APP_DBNM = 'guiafloripa_app';
const APP_HOST = 'localhost';
const APP_PORT = '3306';
const GUIA_host = "guiafloripa.com.br"; // Nome ou IP do Servidor
const GUIA_user = "appguia"; // Usuário do Servidor MySQL
const GUIA_senha = "#4ppgu14Fl0r1p4!"; // Senha do Usuário MySQL
const GUIA_dbase = "guiafloripa"; // Nome do seu Banco de Dados

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

/**
 * Ajax request
 */
function findPlacesAjax() {
    @session_start();
    $app_db = new wpdb(APP_USER, APP_PASS, APP_DBNM, APP_HOST);
    //var_dump($app_db);die;
    $query = "SELECT idPlace as placeID, upper(nmPlace) as placeName FROM guiafloripa_app.Place Where nmPlace like '%" . $_GET['q'] . "%'";
    $data = $app_db->get_results($query);
    // var_dump($data);
    // $results = array();
    $_SESSION['place'] = json_encode($data);
    foreach ($data as $r1) {
        echo $r1->placeName;
        echo "\n";
    }
    //  }
    die();
}

/**
 * @ajax for beach names
 * @Query = select id,post_title from wp_posts where id in (select post_id from wp_postmeta where meta_key = '_wp_page_template' and meta_value='praias-comerciais.php');
 */
function findBeachsAjax() {
    @session_start();
    $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
    // var_dump($app_db);
    $query = "select id,post_title from wp_posts where id in (select post_id from wp_postmeta where meta_key = '_wp_page_template' and meta_value='praias-comerciais.php') and post_title like '%" . $_GET['q'] . "%';";
    $data = $app_db->get_results($query);
    $_SESSION['findBeachsAjax'] = json_encode($data);
    foreach ($data as $r1) {
        echo $r1->post_title;
        echo "\n";
    }
    //  }
    die();
}

/**
 * Ajax request
 */
function findNeighoodAjax() {
    @session_start();
    $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
    // var_dump($app_db);
    $query = "select id as postID,post_title as title from wp_posts where post_type = 'cidade' and post_title like '%" . $_GET['q'] . "%' and id in (select post_id from wp_postmeta where meta_key = 'mf_page_type' and meta_value='Cidade') order by post_title asc;";
    $data = $app_db->get_results($query);
    //var_dump($data);die;
    // $results = array();
    $_SESSION['findNeighoodAjax'] = json_encode($data);
    foreach ($data as $r1) {
        echo $r1->title;
        echo "\n";
    }
    //  }
    die();
}

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
    add_submenu_page('app_guiafloripa_eventos', 'Seu calendário de Eventos', 'Calendário', 'read', 'app_guiafloripa_eventos_cal', 'app_guiafloripa_eventos_cal');
    add_submenu_page('app_guiafloripa_eventos', 'Adicione seu Evento', 'Adicionar', 'read', 'app_guiafloripa_eventos_add', 'app_guiafloripa_eventos_add');
    add_submenu_page('app_guiafloripa_eventos', 'Importar Eventos do Facebook', 'Importar', 'read', 'app_guiafloripa_eventos_imp', 'app_guiafloripa_eventos_imp');
    add_submenu_page('app_guiafloripa_eventos', 'Estabelecimentos cadastrados', 'Estabelecimentos', 'read', 'app_guiafloripa_eventos_place', 'app_guiafloripa_eventos_place');
    add_menu_page(
            'Campanhas', // page title
            'Campanhas', // menu title
            'read', // capability
            'app_guiafloripa_campaigns', // menu slug
            'wpse_91693_campaign', null, 6
    );
    add_submenu_page('app_guiafloripa_campaigns', 'Relatório das suas campanhas', 'Relatório', 'read', 'app_guiafloripa_campaigns_report', 'app_guiafloripa_push_map');
    add_submenu_page('app_guiafloripa_campaigns', 'Criar uma Campanha', 'Criar', 'read', 'app_guiafloripa_campaigns_add', 'app_guiafloripa_push_map');
    add_menu_page(
            'Leads', // page title
            'Leads', // menu title
            'read', // capability
            'app_guiafloripa_leads', // menu slug
            'asd', null, 6
    );
    add_submenu_page('app_guiafloripa_leads', 'Adicionar Lead', 'Adicionar', 'read', 'app_guiafloripa_leads_add', 'app_guiafloripa_push_map');
    add_submenu_page('app_guiafloripa_leads', 'Importar Leads', 'Importar', 'read', 'app_guiafloripa_leads_imp', 'app_guiafloripa_push_map');

    add_menu_page(
            'Mensagens', // page title
            'Mensagens', // menu title
            'read', // capability
            'app_guiafloripa_msg', // menu slug
            'asd', null, 6
    );
    add_menu_page(
            'Dispositivos Ativos', // page title
            'Dispositivos', // menu title
            'read', // capability
            'app_guiafloripa_push', // menu slug
            'wpse_91693_push', null, 6
    );
    add_submenu_page('app_guiafloripa_push', 'Acesso e Leitura das Notificações', 'Alcance', 'read', 'app_guiafloripa_push_map', 'app_guiafloripa_push_map');
    add_menu_page(
            'Emails', // page title
            'Emails', // menu title
            'read', // capability
            'app_guiafloripa_mail', // menu slug
            'asd', null, 6
    );
    add_submenu_page('app_guiafloripa_mail', 'Criar um Email Marketing', 'Criar', 'read', 'app_guiafloripa_mail_add', 'app_guiafloripa_push_map');

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
            'app_guiafloripa_money', null, 6
    );
    add_menu_page(
            'Minhas Hashtags', // page title
            'Twitter', // menu title
            'read', // capability
            'app_guiafloripa_twitter', // menu slug
            'wpse_91693_twitter', null, 6
    );
    add_submenu_page('app_guiafloripa_twitter', 'Adicionar Hashtag de Busca', 'Adicionar Hashtag', 'read', 'app_guiafloripa_twitter_add_term', 'app_guiafloripa_twitter_add_term');
    // add_submenu_page('app_guiafloripa_twitter', 'Nuvem de Hashtags', 'Nuvem de Hashtags', 'read', 'app_guiafloripa_twitter_cloud_tag', 'app_guiafloripa_twitter_cloud_tag');
    //add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Sincronizar', 'manage_options', 'app_guiafloripa_manager_stats', 'wpse_91693_render');
    add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Estatisticas', 'manage_options', 'app_guiafloripa_manager_stats', 'wpse_91693_stats');
    add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Bug Report', 'manage_options', 'app_guiafloripa_manager_bug', 'wpse_91693_bug');
}

function app_guiafloripa_eventos_cal() {
    include_once PLUGIN_ROOT_DIR . 'views/events_calendar.php';
}

function app_guiafloripa_eventos_add() {
    wp_enqueue_media('media-upload');
    wp_enqueue_media('thickbox');
    wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_media('my-upload');
    wp_enqueue_style('thickbox');
    include_once PLUGIN_ROOT_DIR . 'views/events_add.php';
}

function app_guiafloripa_money() {
    include_once PLUGIN_ROOT_DIR . 'views/table_price.php';
}

function wpse_91693_push() {
    include_once PLUGIN_ROOT_DIR . 'views/notific.php';
}

function app_guiafloripa_twitter_cloud_tag() {
    include_once PLUGIN_ROOT_DIR . 'views/tpage_cloud.php';
}

function app_guiafloripa_push_map() {
    include_once PLUGIN_ROOT_DIR . 'views/notifications_map.php';
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
            'Dispositivos', // Title.
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
 * @Show only current user Media on Wordpress
 */
function wpse_72278_current_author_media($query) {
    global $pagenow, $user_ID;


    $query->set('author', $user_ID);

    return $query;
}

function wpse_72278_custom_view_count($views) {
    global $user_ID, $wpdb;

    if (!current_user_can('editor'))
        return $views;

    $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts 
        WHERE post_author = '$user_ID'
        AND post_type = 'attachment' ");
    $image = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts 
        WHERE post_author = '$user_ID' 
        AND post_mime_type LIKE 'image/%' ");
    $video = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts 
        WHERE post_author = '$user_ID' 
        AND post_mime_type LIKE 'video/%' ");
    $detached = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts 
        WHERE post_author = '$user_ID' 
        AND post_type = 'attachment' AND post_parent = '0' ");

    $views['all'] = preg_replace('/\(.+\)/U', '(' . $total . ')', $views['all']);
    $views['image'] = preg_replace('/\(.+\)/U', '(' . $image . ')', $views['image']);
    $views['video'] = preg_replace('/\(.+\)/U', '(' . $video . ')', $views['video']);
    $views['detached'] = preg_replace('/\(.+\)/U', '(' . $detached . ')', $views['detached']);

    return $views;
}

/**
 * Remove WooCommerce Autommatic Redirect
 */
function wc_login_redirect($redirect_to) {
    $redirect_to = 'https://app.guiafloripa.com.br/wp-admin/admin.php';
    return $redirect_to;
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

function header_options_guia_app() {
    echo '<style type="text/css">#wpfooter {display:none;} </style>';
    wp_enqueue_style('full-css', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.3/fullcalendar.min.css');
    wp_register_script('js', 'https://code.jquery.com/jquery-1.7.min.js');
    wp_register_script('moment-js', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js');
    wp_register_script('ui-js', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"');
    wp_register_script('full-js', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.min.js');
    wp_enqueue_script('js');
    wp_enqueue_script('moment-js');
    wp_enqueue_script('ui-js');
    wp_enqueue_script('full-js');
    wp_enqueue_script('suggest');
    wp_enqueue_script('jquery-ui-dialog'); // jquery and jquery-ui should be dependencies, didn't check though...
    wp_enqueue_style('wp-jquery-ui-dialog');
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
 * Register the /wp-json/ route
 */
function appguia_register_routes() {
    register_rest_route('twitterbot/v1', 'list', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'twitter_bot_route',
    ));
    register_rest_route('places/v1', 'list', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'places_route',
    ));
    register_rest_route('event_type/v1', 'list', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'event_type_route',
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
 * Generate results for the /wp-json/places/v1/pid route.
 *
 * @param WP_REST_Request $request Full details about the request.
 *
 * @return WP_REST_Response|WP_Error The response for the request.
 */
function places_route(WP_REST_Request $request) {
    //var_dump($request);
    //die;
    $app_db = new wpdb(APP_USER, APP_PASS, APP_DBNM, APP_HOST);
    //var_dump($app_db);die;
    $query = "SELECT idPlace as placeID, upper(nmPlace) as placeName, nrLat as latitude, nrLng as longitude FROM guiafloripa_app.Place order by idPlace desc;";
    $data = $app_db->get_results($query);
    $response = new WP_REST_Response($data);
    $response->set_status(201);
    return $response;
}

/**
 * Generate results for the /wp-json/event_type/v1/eid route.
 *
 * @param WP_REST_Request $request Full details about the request.
 *
 * @return WP_REST_Response|WP_Error The response for the request.
 */
function event_type_route(WP_REST_Request $request) {
    //var_dump($request);
    //die;
    $app_db = new wpdb(APP_USER, APP_PASS, APP_DBNM, APP_HOST);
    //var_dump($app_db);die;
    $query = "SELECT idType as typeID , deType as typeName FROM guiafloripa_app.Type;";
    $data = $app_db->get_results($query);
    $response = new WP_REST_Response($data);
    $response->set_status(200);
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
add_action('rest_api_init', 'appguia_register_routes');
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');
add_action('wp_dashboard_setup', 'add_email_dashboard_widgets');
add_action('admin_menu', 'wpse_91693_register');
add_action('admin_head', 'header_options_guia_app');
add_shortcode('guia_app', 'guia_app_redirect');
add_shortcode('guia_event', 'fguia_event');
add_shortcode('guia_panel', 'fguia_panel');
add_action('wp_ajax_wpwines-dist-regions', 'findPlacesAjax');
add_action('wp_ajax_findNeighoodAjax', 'findNeighoodAjax');
add_action('wp_ajax_findBeachsAjax', 'findBeachsAjax');
add_filter('pre_get_posts', 'wpse_72278_current_author_media');
add_filter('views_upload', 'wpse_72278_custom_view_count', 10, 1);
add_filter('woocommerce_prevent_admin_access', '__return_false');
add_filter('woocommerce_login_redirect', 'wc_login_redirect');
?>
