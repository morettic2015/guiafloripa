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

?>