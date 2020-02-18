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
const GUIA_host = "149.56.231.243"; // Nome ou IP do Servidor
const GUIA_user = "appguia"; // Usuário do Servidor MySQL
const GUIA_senha = "#4ppgu14Fl0r1p4!"; // Senha do Usuário MySQL
const GUIA_dbase = "guiafloripa"; // Nome do seu Banco de Dados
/**
 * downloadFiles
 */

function downloadFileFromUrl() {
    $filepath = "/var/www/app.guiafloripa.com.br/wp-content/uploads/" . $_GET['file'];

    // Process download
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;
    }
}

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
 * @Wordpress user save custom fields
 */
function save_extra_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, '_ck', $_POST['_ck']);
    update_user_meta($user_id, '_cs', $_POST['_cs']);
    update_user_meta($user_id, '_at', $_POST['_at']);
    update_user_meta($user_id, '_ac', $_POST['_ac']);
    update_user_meta($user_id, '_onesignal_rest_api_key', $_POST['_onesignal_rest_api_key']);
    update_user_meta($user_id, '_onesignal_app_id', $_POST['_onesignal_app_id']);
    update_user_meta($user_id, '_whatsapp', $_POST['_whatsapp']);
    update_user_meta($user_id, '_fixo', $_POST['_fixo']);
    update_user_meta($user_id, '_comercial', $_POST['_comercial']);
}

/**
 * @Wordpress Profile custom fields
 */
function extra_user_profile_fields($user) {
    ?>
    <a name="m_phones"/>
    <h2><?php _e("Telefones para Contatos", "blank"); ?><p><span class="description">Informe seus números para contatos **Opcional**</span></p></h2>

    <table class="form-table">
        <tr>
            <th><label for="_whatsapp"><?php _e("Número do whatsapp"); ?></label></th>
            <td>
                <input type="text" name="_whatsapp" id="_whatsapp" value="<?php echo esc_attr(get_the_author_meta('_whatsapp', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Número do seu Whatsapp com DDD. Ex: +55 48 999996064"); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="_fixo"><?php _e("Telefone Fixo"); ?></label></th>
            <td>
                <input type="text" name="_fixo" id="_fixo" value="<?php echo esc_attr(get_the_author_meta('_fixo', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Número do seu telefone fixo com DDD. Ex: +55 48 32220617"); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="_comercial"><?php _e("Telefone Comercial"); ?></label></th>
            <td>
                <input type="text" name="_comercial" id="_comercial" value="<?php echo esc_attr(get_the_author_meta('_comercial', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Número do seu telefone comercial DDD. Ex: +55 48 32220617"); ?></span>
            </td>
        </tr>
    </table>
    <!-- <a name="twitter"/>
     <h2><?php _e("Configurações do twitter", "blank"); ?><p><span class="description">Serviço integração com o Twitter **Opcional**</span></p></h2>

     <ul>
         <li>1) No <a href="https://apps.twitter.com/" target="_blank">Gerenciador de aplicativos do Twitter</a>, clique em 'Criar nova aplicação' e preencha todos os campos.</LI>
         <li>2) Na guia 'Permissões', selecione 'Ler, Escrever e acessar mensagens diretas' na área 'Acesso' e clique em 'Configurações de atualização'.</LI>
         <li>3) Na guia 'Chave e toques de acesso', clique no botão 'Criar meu token de acesso'.</LI>
         <li>4) Digite o nome de usuário do botão no respectivo campo abaixo.</LI>
         <li>5) Na guia 'Chave e Acesso Tokens', copie a Chave do Consumidor, o Segredo do Consumidor, o Token de Acesso e o Token de Acesso segure e cole nos respectivos campos abaixo.</LI>
     </ul>


     <table class="form-table">
         <tr>
             <th><label for="_ck"><?php _e("Twitter API KEY"); ?></label></th>
             <td>
                 <input type="text" name="_ck" id="_ck" value="<?php echo esc_attr(get_the_author_meta('_ck', $user->ID)); ?>" class="regular-text" /><br />
                 <span class="description"><?php _e("Esta chave de acesso pode ser usada para fazer chamadas da API em sua conta."); ?></span>
             </td>
         </tr>
         <tr>
             <th><label for="_cs"><?php _e("Twitter API Secret"); ?></label></th>
             <td>
                 <input placeholder="" type="text" name="_cs" id="_cs" value="<?php echo esc_attr(get_the_author_meta('_cs', $user->ID)); ?>" class="regular-text" /><br />
                 <span class="description"><?php _e("Esta senha de acesso pode ser usada para fazer chamadas da API em sua conta."); ?></span>
             </td>
         </tr>
         <tr>
             <th><label for="_at"><?php _e("Access Token"); ?></label></th>
             <td>
                 <input type="text" name="_at" id="_at" value="<?php echo esc_attr(get_the_author_meta('_at', $user->ID)); ?>" class="regular-text" /><br />
                 <span class="description"><?php _e("Este Token de acesso pode ser usada para fazer chamadas da API em sua conta."); ?></span>
             </td>
         </tr>
         <tr>
             <th><label for="_ac"><?php _e("Access Token Secret"); ?></label></th>
             <td>
                 <input type="text" name="_ac" id="_ac" value="<?php echo esc_attr(get_the_author_meta('_ac', $user->ID)); ?>" class="regular-text" /><br />
                 <span class="description"><?php _e("Este token pode ser usada para fazer chamadas da API em sua conta."); ?></span>
             </td>
         </tr>
     </table>
     <h2><?php _e("Configurações do OneSignal", "blank"); ?><p><span class="description">Serviço de notificações **Opcional**</span></p></h2>

     <table class="form-table">
         <tr>
             <th><label for="_onesignal_app_id"><?php _e("OneSignal APP ID"); ?></label></th>
             <td>
                 <input placeholder="c452ff74-3bc4-44ca-a015-bfdaf0812313" type="text" name="_onesignal_app_id" id="_onesignal_app_id" value="<?php echo esc_attr(get_the_author_meta('_onesignal_app_id', $user->ID)); ?>" class="regular-text" /><br />
                 <span class="description"><?php _e("Sua chave de identificação do app ID com 36 caracteres. Localize em sua conta OneSignal em Setup > OneSignal Keys > Step 2."); ?></span>
             </td>
         </tr>
         <tr>
             <th><label for="_onesignal_rest_api_key"><?php _e("Access Token"); ?></label></th>
             <td>
                 <input type="text" name="_onesignal_rest_api_key" id="_onesignal_rest_api_key" value="<?php echo esc_attr(get_the_author_meta('_onesignal_rest_api_key', $user->ID)); ?>" class="regular-text" /><br />
                 <span class="description"><?php _e("Sua chave REST com 48 caracteres. Localize em sua conta OneSignal em Setup > OneSignal Keys > Step 2."); ?></span>
             </td>
         </tr>
     </table>-->
    <?php
}

function loadPermalink() {
    // echo "SE FUDER";;;;
    $wpdb = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
    //var_dump($_GET);
    $id = $_GET['postID'];

    $post = get_post($id);
    var_dump($post);
    //echo $id;
    //echo get_the_permalink($id);
    exit;
}

/**
 * @ajax upload image
 * @PhpxmlRpc
 */
function mediaXmlRPCAjax() {
    
}

/**
 * @Update Groups from user
 * */
function insert_groups_profile() {
    //header("Content-type:application/json");
    include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
    $ec = new ContatosController();
    $data = $ec->getUpdateGroups($_POST);
    // echo $data;
    // var_dump($data);
    //var_dump($_POST);
    die;
}

/**
 * @Update Event by fragments
 * */
function update_evento_data() {
    header("Content-type:application/json");
    include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
    $ec = new EventControl();
    $data = $ec->updateEventInfo($_POST);
    echo $data;
    die;
}

function findPlacesEdit() {
    //  echo "Shit";
    header("Content-type:application/json");
    include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
    $ec = new EventControl();
    $data = $ec->loadPlacesByName($_GET);
    echo $data;
    die;
}

function emailTemplate1() {
    //echo "1";
    include_once PLUGIN_ROOT_DIR . 'views/email/EmailController.php';
    $ec = new EmailController();
    $ec->showModel($_GET['pid']);
    die();
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
    $app_db->close();
    //  }
    die();
}

/**
 * @Create Attach for Dropzone
 */
function createPostAttachment() {
    include_once PLUGIN_ROOT_DIR . 'views/contatos/Csv.php';

    if (!session_id()) {
        session_start();
    }

    $id = Csv::createAttachment($_SESSION['uploaded_file']);
    echo $_SESSION['uploaded_url'];
    die();
}

function importGmail() {
    include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
    $ec = new ContatosController();
    $ec->importGmail($_POST);
    die();
}

function importOutlook() {
    include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
    $ec = new ContatosController();
    $ec->importOutlook($_POST);
    die();
}

/**
 * @ajax for beach names
 * @Query = select id,post_title from wp_posts where id in (select post_id from wp_postmeta where meta_key = '_wp_page_template' and meta_value='praias-comerciais.php');
 */
function findNickName() {
    include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
    $ec = new ContatosController();
    echo $ec->getNickName($_GET['nick']);
    die();
}

/**
 * @Ajax to save groups
 */
function updateGroupsBatch() {
    include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
    $ec = new ContatosController();
    $ec->updateGroupsBatch($_GET);
    wp_die();
}

/**
 * @ajax for beach names
 * @Query = select id,post_title from wp_posts where id in (select post_id from wp_postmeta where meta_key = '_wp_page_template' and meta_value='praias-comerciais.php');
 */
function findBeachsAjax() {
    include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
    $ec = new EventControl();
    $data = $ec->loadSearchBeachs($_GET);
    foreach ($data as $r1) {
        echo $r1->post_title;
        echo "\n";
    }
    die();
}

/**
 * @Update
 */
function app_guiafloripa_eventos_imp() {
    wp_enqueue_media('media-upload');
    wp_enqueue_media('thickbox');
    wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_media('my-upload');
    wp_enqueue_style('thickbox');
    include_once PLUGIN_ROOT_DIR . 'views/events_import.php';
}

/**
 * @Ajax to load dinamyc content from forms
 */
function loadEventEdit() {
    include_once PLUGIN_ROOT_DIR . 'views/events_edit.php';
}

/**
 * Ajax request
 */
function findNeighoodAjax() {
    include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
    $ec = new EventControl();
    $data = $ec->loadSearchNeigh($_GET);

    foreach ($data as $r1) {
        echo $r1->title;
        echo "\n";
    }
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

function viewControllerMnu() {
    include_once PLUGIN_ROOT_DIR . 'views/ViewController.php';
    ViewController::initMenus();
}

/**
 * @Get Post from XML RPC
 */
function getPermalink() {
    header("Content-type:application/json");
    //echo "1";
    include_once PLUGIN_ROOT_DIR . 'views/negocio/NegocioController.php';
    $nc = new NegocioController();
    $permalink = $nc->getPermalinkFromPost($_GET['idPost']);
    echo json_encode($permalink);
    wp_die();
}

function loadSubCategoryGuiaApp() {
    header("Content-type:application/json");
    //echo "1";
    include_once PLUGIN_ROOT_DIR . 'views/negocio/NegocioController.php';
    $nc = new NegocioController();
    $cat = $nc->getCategoriasGuia($_GET['id']);
    echo json_encode($cat);
    wp_die();
    die();
}

function app_guiafloripa_negocio() {
    include_once PLUGIN_ROOT_DIR . 'views/negocio/negocio.php';
}

function app_guiafloripa_negocio_add() {
    /* define('DROPZONEJS_PLUGIN_URL', plugin_dir_url(__FILE__));
      define('DROPZONEJS_PLUGIN_VERSION', '0.0.1');
      wp_enqueue_script(
      'dropzonejs', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js', array(), DROPZONEJS_PLUGIN_VERSION
      );
      wp_enqueue_style(
      'dropzonecss', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css', array(), DROPZONEJS_PLUGIN_VERSION
      ); */
    wp_enqueue_media('media-upload');
    wp_enqueue_media('thickbox');
    wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_media('my-upload');
    wp_enqueue_style('thickbox');
    include_once PLUGIN_ROOT_DIR . 'views/negocio/page.php';
}

function app_guiafloripa_eventos_cal() {
    include_once PLUGIN_ROOT_DIR . 'views/events_calendar.php';
}

function app_guiafloripa_activity() {
    include_once PLUGIN_ROOT_DIR . 'views/negocio/dashboard.php';
}

function app_guiafloripa_midia() {
    wp_enqueue_media('media-upload');
    wp_enqueue_media('thickbox');
    wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_media('my-upload');
    wp_enqueue_style('thickbox');
    include_once PLUGIN_ROOT_DIR . 'views/media/page.php';
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

function app_guiafloripa_mail_add() {
    wp_enqueue_media('media-upload');
    wp_enqueue_media('thickbox');
    wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_media('my-upload');
    wp_enqueue_style('thickbox');
    include_once PLUGIN_ROOT_DIR . 'views/email/page_add.php';
}

function app_guiafloripa_push_list() {
    include_once PLUGIN_ROOT_DIR . 'views/notifications/note_grid.php';
}

function wpse_91693_push() {
    include_once PLUGIN_ROOT_DIR . 'views/notific.php';
}

function app_guiafloripa_twitter_followers() {
    include_once PLUGIN_ROOT_DIR . 'views/contatos/followers.php';
}

function app_guiafloripa_twitter_cloud_tag() {
    include_once PLUGIN_ROOT_DIR . 'views/tpage_cloud.php';
}

function app_guiafloripa_push_add() {
    include_once PLUGIN_ROOT_DIR . 'views/notifications/page_add.php';
}

function app_guiafloripa_leads_imp() {
    define('DROPZONEJS_PLUGIN_URL', plugin_dir_url(__FILE__));
    define('DROPZONEJS_PLUGIN_VERSION', '0.0.1');
    wp_enqueue_script(
            'dropzonejs', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js', array(), DROPZONEJS_PLUGIN_VERSION
    );
    wp_enqueue_style(
            'dropzonecss', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css', array(), DROPZONEJS_PLUGIN_VERSION
    );
    include PLUGIN_ROOT_DIR . 'views/contatos/page_imp.php';
}

function app_guiafloripa_campaigns_add() {
    include PLUGIN_ROOT_DIR . 'views/campaign/page_add.php';
}

function app_guiafloripa_leads_add() {
    wp_enqueue_media('media-upload');
    wp_enqueue_media('thickbox');
    wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_media('my-upload');
    include PLUGIN_ROOT_DIR . 'views/contatos/page_add.php';
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

function app_guiafloripa_mail() {
    include PLUGIN_ROOT_DIR . 'views/email/email.php';
}

function app_guiafloripa_leads() {
    include PLUGIN_ROOT_DIR . 'views/contatos/contatos.php';
}

function wpse_91693_campaign() {
    include PLUGIN_ROOT_DIR . 'views/campaign/campaign.php';
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
/*
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
*/
/**
 * Init DashBoard
 */
function dashboard_widgets() {
    include_once PLUGIN_ROOT_DIR . 'views/ViewController.php';
    ViewController::initDashboards();
}
/**
 * @Dashboard Plano
 */
function plano_dashboard_widget_content() {
    include_once PLUGIN_ROOT_DIR . 'views/ViewController.php';
    ViewController::dashboardPlano();
}
/**
 * @Dashboard Help
 */
function tips_dashboard_widget_content() {
    include_once PLUGIN_ROOT_DIR . 'views/ViewController.php';
    ViewController::dashboardTips();
}
/**
 * @Dashboard Recursos
 */
function cota_dashboard_widget_content() {
    include_once PLUGIN_ROOT_DIR . 'views/ViewController.php';
    ViewController::dashboardResources();
}
/**
 * @Dashboard Events
 */
function events_dashboard_widget_content() {
    include_once PLUGIN_ROOT_DIR . 'views/ViewController.php';
    ViewController::dashboardEvents();
}
/**
 * Contacts imported
 */
function leads_dashboard_widget_content() {
    include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
    $ec = new ContatosController();
    $data = $ec->getDashBoard();
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
/* function share_dashboard_widget_content() {
  // Display whatever it is you want to show.
  echo "Hello there, I'm a Dashboard Widget. Edit me!";
  } */

function wpb_sender_email($original_email_address) {
    return 'root@experienciasdigitais.com.br';
}

// Function to change sender name
function wpb_sender_name($original_email_from) {
    return 'Experiências Digitais';
}

function header_options_guia_app() {
    include_once PLUGIN_ROOT_DIR . 'views/ScriptsController.php';
    ScriptsController::initHeaderScripts();
}

//Remove visit site menu
function remove_admin_bar_links() {
    global $wp_admin_bar;
    //$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');
    $wp_admin_bar->remove_menu('view-store');
    $wp_admin_bar->remove_menu('new-content'); // Remove the view site link
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
    // Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

    $labels = array(
        'name' => _x('Tipo de Negócios', 'tipo de negócio do anunciante'),
        'singular_name' => _x('business_type', 'tipo de negócio do anunciante'),
        'search_items' => __('Buscar tipo de negóio'),
        'all_items' => __('Todos os tippos de negócio'),
        'parent_item' => __('Parent Topic'),
        'parent_item_colon' => __('Parent Topic:'),
        'edit_item' => __('Edit Topic'),
        'update_item' => __('Update Topic'),
        'add_new_item' => __('Add New Topic'),
        'new_item_name' => __('Novo Negógio'),
        'menu_name' => __('Tipo de negócio'),
    );

// Now register the taxonomy

    register_taxonomy('business_type', array('post'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => false,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'business_type'),
    ));
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
    $tweets = $tc->getTermsForTree();
    ?>
    <div id="wordtree_basic" style="width: 100%;max-width: 400px; height: 233px;"></div>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['wordtree']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([['HashTags'],
    <?php
    foreach ($tweets as $t12) {
        echo "['" . str_replace("#", "# ", $t12) . "'],";
    }
    ?>
            ]);

            var options = {
                wordtree: {
                    format: 'implicit',
                    word: '#'
                }
            };

            var chart = new google.visualization.WordTree(document.getElementById('wordtree_basic'));
            chart.draw(data, options);
        }
    </script>



    <?php
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
 * Associa o Estabelecimento com o Evento
 */
function saveEventPlace() {
    header("Content-type:application/json");
    include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
    $ec = new EventControl();
    $ec->savePlaceImport($_GET['eventID'], $_GET['eventName']);
    //echo $data;
    die;
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
add_filter('pre_get_posts', 'wpse_72278_current_author_media');
add_filter('views_upload', 'wpse_72278_custom_view_count', 10, 1);
add_filter('woocommerce_prevent_admin_access', '__return_false');
add_filter('woocommerce_login_redirect', 'wc_login_redirect');
add_action('init', 'create_event_post');
add_action('rest_api_init', 'appguia_register_routes');
//add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');
add_action('wp_dashboard_setup', 'dashboard_widgets');
add_action('admin_menu', 'viewControllerMnu');
add_action('admin_head', 'header_options_guia_app');
add_action('wp_ajax_mediaXmlRPCAjax', 'mediaXmlRPCAjax');
add_action('wp_ajax_wpwines-dist-regions', 'findPlacesAjax');
add_action('wp_ajax_email_template', 'emailTemplate1');
add_action('wp_ajax_findPlacesEdit', 'findPlacesEdit');
add_action('wp_ajax_findNeighoodAjax', 'findNeighoodAjax');
add_action('wp_ajax_update_evento_data', 'update_evento_data');
add_action('wp_ajax_insert_groups_profile', 'insert_groups_profile');
add_action('wp_ajax_findBeachsAjax', 'findBeachsAjax');
add_action('wp_ajax_updateGroupsBatch', 'updateGroupsBatch');
add_action('wp_ajax_findNickName', 'findNickName');
add_action('wp_ajax_importGmail', 'importGmail');
add_action("wp_ajax_createAttach ", "createPostAttachment");
add_action('wp_ajax_downloadFileFromUrl', 'downloadFileFromUrl');
add_action('wp_ajax_importOutlook', 'importOutlook');
add_action('wp_ajax_load_event_edit', 'loadEventEdit');
add_action('wp_ajax_save_event_place', 'saveEventPlace');
add_action('wp_ajax_get_permalink_post', 'getPermalink');
add_action('wp_ajax_sub_cat_guia', 'loadSubCategoryGuiaApp');
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');
add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');
add_shortcode('guia_app', 'guia_app_redirect');
add_shortcode('guia_event', 'fguia_event');
add_shortcode('guia_panel', 'fguia_panel');
add_action('wp_ajax_submit_dropzonejs', 'dropzonejs_upload');
add_action('wp_ajax_get_permalink', 'loadPermalink');

/**
 * dropzonejs_upload() handles the AJAX request, learn more about AJAX in Plugins at https://codex.wordpress.org/AJAX_in_Plugins
 * @return [type] [description]
 */
function dropzonejs_upload() {

    if (!empty($_FILES) && wp_verify_nonce($_REQUEST['my_nonce_field'], 'protect_content')) {

        $uploaded_bits = wp_upload_bits(
                $_FILES['file']['name'], null, //deprecated
                file_get_contents($_FILES['file']['tmp_name'])
        );

        if (false !== $uploaded_bits['error']) {
            $error = $uploaded_bits['error'];
            return add_action('admin_notices', function() use ( $error ) {
                $msg[] = '<div class="error"><p>';
                $msg[] = '<strong>DropzoneJS & WordPress</strong>: ';
                $msg[] = sprintf(__('wp_upload_bits failed,  error: "<strong>%s</strong>'), $error);
                $msg[] = '</p></div>';
                echo implode(PHP_EOL, $msg);
            });
        }
        $uploaded_file = $uploaded_bits['file'];
        $uploaded_url = $uploaded_bits['url'];
        $uploaded_filetype = wp_check_filetype(basename($uploaded_bits['file']), null);

        if (!session_id()) {
            session_start();
        }
        $_SESSION['uploaded_file'] = $uploaded_file;
        $_SESSION['uploaded_url'] = $uploaded_url;
        $_SESSION['uploaded_filetype'] = $uploaded_filetype;
    }
    die();
}

// Our custom post type function
function create_posttype_ajuda() {

    register_post_type('ajuda_faq',
            // CPT Options
            array(
        'labels' => array(
            'name' => __('Ajuda'),
            'singular_name' => __('Ajuda')
        ),
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => 'help'),
            )
    );
}

// Hooking up our function to theme setup
add_action('init', 'create_posttype_ajuda');
?>
