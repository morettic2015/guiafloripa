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
add_shortcode('guia_app', 'guia_app_redirect');

/**
 * @Show Slider with today events
 *  */
function fguia_panel() {
    include PLUGIN_ROOT_DIR . 'views/panel.php';
}

add_shortcode('guia_panel', 'fguia_panel');

/**
 * @Show Slider with today events
 *  */
function fguia_event() {
    include PLUGIN_ROOT_DIR . 'views/event.php';
}

add_shortcode('guia_event', 'fguia_event');

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
    $expire_time = 24 * 60 * 60 *3;
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

add_action('admin_menu', 'wpse_91693_register');

function wpse_91693_register() {
    add_menu_page(
            'Sincronização', // page title
            'Guia APP Admin', // menu title
            'manage_options', // capability
            'app_guiafloripa_manager_backend', // menu slug
            'wpse_91693_render', null, 6
    );
    add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Estatisticas', 'manage_options', 'app_guiafloripa_manager_stats', 'wpse_91693_stats');
    add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Bug Report', 'manage_options', 'app_guiafloripa_manager_bug', 'wpse_91693_bug');
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

?>