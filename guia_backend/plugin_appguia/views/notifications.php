<?php

/**
 * checking general overview for users
 *
 * @package  Guia Floripa APP
 * @author   Morettic.com.br
 */
const FREEGEOIP = "https://freegeoip.net/json/";


$OneSignalWPSetting = get_option('OneSignalWPSetting');
$OneSignalWPSetting_app_id = $OneSignalWPSetting['app_id'];
$OneSignalWPSetting_rest_api_key = $OneSignalWPSetting['app_rest_api_key'];
$pluginList = get_option('active_plugins');
$plugin = 'onesignal-free-web-push-notifications/onesignal.php';
if (in_array($plugin, $pluginList) && $OneSignalWPSetting_app_id && $OneSignalWPSetting_rest_api_key) {
    ?>

    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <?PHP
        $OneSignalWPSetting = get_option('OneSignalWPSetting');
        $OneSignalWPSetting_app_id = $OneSignalWPSetting['app_id'];
        $OneSignalWPSetting_rest_api_key = $OneSignalWPSetting['app_rest_api_key'];
        $onesignal_extra_info = get_option('oss_settings_page');
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . $OneSignalWPSetting_rest_api_key,
                'Cache-Control' => 'max-age=31536000'
            )
        );
        $url = "https://onesignal.com/api/v1/players?app_id=" . $OneSignalWPSetting_app_id . "&limit=500&offset=0";
        $response = wp_remote_get($url, $args);
        $response_to_arrays = json_decode(wp_remote_retrieve_body($response), true);
        ?>
        <div class="notice notice-info"> 
            <p><code><?php echo count($response_to_arrays['players']); ?> Leads</code> em potêncial no seu segmento no canal de <code>Notificações</code>.</p>
        </div>

        <table id="notifications" class="table table-striped">
            <thead>
                <tr>
                   <!-- <th colspan="1">Opçao</th> -->
                    <th colspan="2">Primeira sessão</th>
                    <th colspan="2">Última sessão</th>
                    <th colspan="2">Dispositivo</th>
                    <th colspan="1">Total de Sessões</th>
                    <th colspan="2">Linguagem</th>
                    <th colspan="2">IP</th>
                    <th colspan="2">Cidade</th>
                    <th colspan="2">UF</th>
                    <th colspan="2">Pais</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $response_counter = 0;
                foreach (array_reverse($response_to_arrays['players']) as $response_array) {
                    $ip = $response_array['ip'];
                    $user_sessions = $response_array['session_count'];
                    $user_language = $response_array['language'];
                    $user_device = $response_array['device_model'];
                    $user_status = $response_array['invalid_identifier'];
                    $final_readable_last_active = date('d/m/y h:i:s', $response_array['last_active']);
                    $final_readable_first_session = date('d/m/y h:i:s', $response_array['created_at']);

                    $geo = get_option($ip);

                    if ($geo === false) {
                        $urlFreeGeoIp = FREEGEOIP . $ip;
                        $args = array('headers' => array(
                                'If-Modified-Since: Sat, 29 Oct 1994 19:43:31 GMT',
                                'Cache-Control: max-age=31536000',
                            ),
                        );
                        $r1 = wp_remote_get($urlFreeGeoIp, $args);
                        $jsGeo = json_decode(wp_remote_retrieve_body($r1), true);
                        //Save IP to Wp_options //lesss io resource...faster from database
                        add_option($ip, json_encode($jsGeo), '', false);
                        //var_dump($jsGeo);
                    } else {
                        $jsGeo = get_object_vars(json_decode($geo));
                    }
                    ?>
                    <tr class="notification-entry">
                       <!-- <td colspan="1" class="notification-content">
                            <input type="checkbox">
                        </td> -->
                        <td colspan="2" class="submitted date">
                            <small><?php echo $final_readable_first_session; ?></small>
                        </td>
                        <td colspan="2" class="notification-content">
                            <small><?php echo $final_readable_last_active; ?></small>
                        </td>
                        <td colspan="2" class="notification-content">
                            <?php echo $user_device; ?>
                        </td>
                        <td colspan="1" class="notification-content">
                            <?php echo $user_sessions; ?>
                        </td>
                        <td colspan="2" class="notification-content">
                            <?php echo $user_language; ?>
                        </td>
                        <td colspan="2" class="notification-content">
                            <small><?php echo $ip; ?></small>
                        </td>
                        <td colspan="2" class="notification-content">
                            <?php echo $jsGeo['city']; ?>
                        </td>
                        <td colspan="2" class="notification-content">
                            <?php echo $jsGeo['region_name']; ?>
                        </td>
                        <td colspan="2" class="notification-content">
                            <?php echo $jsGeo['country_code']; ?>
                        </td>
                    </tr>
                    <?php
                    //die;
                    //}
                    $response_counter++;
                }
                if ($response_counter == 0) {
                    ?>
                    <tr class="notification-entry">
                        <td colspan="13" class="one action text-center no_notifications">
                            Nenhum Lead em potencial neste canal.
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>

    </div>
<?php } ?>
<style type="text/css">
    .used_logo {
        max-width: 20%;
    }

    .provide_user_key {
        padding: 0 20px;
    }

    .provide_user_key #submit{
        border: 1px solid #929497;
        border-radius: 0;
        box-shadow: none;
        color: #929497;
        font-weight: 600;
        height: 40px;
        text-shadow: none;
    }

    .bread_crumbs{
        text-align: center;
        margin: 40px 0 0 0;
    }

    .the_right_path{
        color: #182b49;
        font-size: 20px;
        margin: 10px 22px 0 0;
        text-align: right;
    }

    .the_right_path a{
        color: #028482;
        text-decoration: underline;
    }

    .error_notice{
        text-align: center;
        color: #182b49;
    }

    .error_notice:nth-child(3){
        text-align: left;
        margin: 0;
    }

    ul.todo_list{
        list-style: upper-greek;
        text-align: left;
        padding: 0 17px;
    }

    ul.todo_list li{
        color: #182b49;
        font-size: 17px;
    }

    .notice_hr{
        height: 1px;
        width: 200px;
        margin: 32px auto;
    }

    ul.todo_list li a{
        background-color: transparent;
        text-decoration: underline !important;
        color: #000;
        border: none !important;
        box-shadow: none !important;
    }

    .bread_crumbs a {
        color: #182b49 !important;
        border: 2px solid #182b49;
        display: inline-block;
        font-size: 16px;
        min-width: 200px;
        padding: 7px 25px;
        text-decoration: none;
        margin: 0 25px 0 0;
    }

    .bread_crumbs a.active_bread{
        text-decoration: underline;
        color: #929497;
        font-weight: bold;
    }

    .schedule_date_section{
        display: none;
        position: relative;
    }

    .wrap {
        border: 0px !important;
        background: transparent !important;
    }
    .status{
        text-align:center;
    }
    .status .loader{
        display:none;
        margin:0 auto;
    }
    .status p{
        font-weight: bold;
        font-size:16px;
    }
    .loader {
        display: none;
    }

    .widefat tbody th {
        color: #000;
    }

    .widefat tbody th a {
        color: #000;
        font-weight: bold;
    }

    .widefat tbody tr td{
        color: #000;
    }

    .clear {
        clear: both;
    }

    .header .elt {
        display: block;
    }

    .header .elt h2 {
        background: #182b49; /* For browsers that do not support gradients */
        background: -webkit-linear-gradient(left, #182b49 , #028482); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(right, #182b49, #028482); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(right, #182b49, #028482); /* For Firefox 3.6 to 15 */
        background: linear-gradient(to right, #182b49 , #028482); /* Standard syntax */
        color: #fff;
        font-size: 25px;
        margin: 0;
        padding: 30px 0;
        text-align: center;
    }

    .header .elt.srch {
        display: block;
        text-align: left;
        padding: 30px;
    }

    .header .elt.srch form input[name="submit"]{
        color: #611341;
        font-weight: bold;
        margin: 25px 0 0 0;
    }

    .header .elt.srch form input[name="submit"]:hover{
    }

    .header .elt.srch form input#notification-title,
    .header .elt.srch form input#notification-url,
    .header .elt.srch form textarea{
        width: 100%;
    }

    .header .elt.srch form input[name="submit"],
    .header .elt.srch form textarea,
    .header .elt.srch form input{
        padding: 7px;
        font-weight: 600;
        border-radius: 0;
        color: #929497;
    }

    .header .elt.srch a {
        -webkit-box-shadow: 1.7px 1.7px 1px #787878;
        -moz-box-shadow: 1.7px 1.7px 1px #787878;
        box-shadow: 1.7px 1.7px 1px #787878;
        padding: 5px;
        text-decoration: none;
        color: #611431;
    }
    .Zebra_DatePicker{
        top: 14% !important;
    }

    .datepicker-type-wrapper{
        margin: 0 0 20px 0;
    }

    .datepicker-type-wrapper .radio-wrapper{
        display: block;
        margin: 10px 30px;
    }

    .section_title{
        color: #929497;
        font-size: 17px;
        font-weight: bold;
        line-height: normal;
        margin: 10px 0;
        display: block;
    }

    .section_title h6{
        display: inline-block;
        margin: 0;
    }

    .datepicker-type-wrapper .radio-wrapper label{
        vertical-align: top;
        min-height: 18px;
        color: #505050;
        font-size: 16px;
    }

    .ajax_result h5{
        background-color: rgba(146, 148, 151, 0.30);
        display: inline-block;
        font-size: 20px;
        font-weight: bold;
        margin: 20px 0 0;
        padding: 17px 25px;
    }

    .wppb-serial-notification{
        display: none;
    }

    .panel {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    }

    .panel > .table:last-child, .panel > .table-responsive:last-child > .table:last-child {
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
        max-width: 100%;
        width: 100%;
        margin-bottom: 0;
    }

    .table thead tr, .fc-border-separate thead tr {
        background-color: #eeeeee;
        font-size: 12px;
    }

    .table > thead > tr > th {
        border-bottom: 2px solid #ddd;
    }

    .table > thead > tr > th, 
    .table > thead > tr > td, 
    .table > tbody > tr > th, 
    .table > tbody > tr > td, 
    .table > tfoot > tr > th, 
    .table > tfoot > tr > td {
        line-height: 1.42857;
        padding: 8px;
        text-align: center;
        font-weight: bold;
    }

    .table-striped > tbody > tr:nth-child(2n+1) {
        background-color: #f9f9f9;
    }

    .text-center{
        text-align: center;
    }

    .dashboard-button, .dropdown-button {
        background-color: #dedede;
        border: 1px solid #d9d9d9;
        border-radius: 3px;
        transition: none 0s ease 0s ;
        padding: 0.7em 1.1em;
        box-shadow: 0 -2px 0 rgba(0, 0, 0, 0.05) inset;
        color: #333;
        cursor: pointer;
    }

    .status-label.scheduled {
        background-color: #a082bf;
        border: 1px solid #9675b8;
        border-radius: 4px;
        color: white;
        display: inline-block;
        font-size: 12px;
        font-weight: 400;
        letter-spacing: 0.07em;
        line-height: 1;
        margin: 10px 5px;
        padding: 11px 8px;
        text-align: center;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        text-decoration: none;
        min-width: 70px;
    }

    .status-label.canceled{
        background-color: #caa36e;
        border: 1px solid #caa36e;
        border-radius: 4px;
        color: white;
        display: inline-block;
        font-size: 12px;
        font-weight: 400;
        letter-spacing: 0.07em;
        line-height: 1;
        margin: 10px 5px;
        padding: 11px 8px;
        text-align: center;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        text-decoration: none;
        min-width: 70px;
    }

    .no_notifications{
        color: #b2b2b2;
        font-size: 1.35em;
        font-weight: 300 !important;
    }

    .panel .users_title{
        font-weight: bold;
        margin: 20px 0 35px;
        text-align: center;
    }

    .panel .users_title span{
        font-size: 0.8em;
        color: #a1a1a1;
        font-weight: normal;
    }
    input[type="checkbox"]{
        appearance:none;
        width:40px;
        height:16px;
        border:1px solid #aaa;
        border-radius:2px;
        background:#ebebeb;
        position:relative;
        display:inline-block;
        overflow:hidden;
        vertical-align:middle;
        transition: background 0.3s;
        box-sizing:border-box;
    }
    input[type="checkbox"]:after{
        content:'';
        position:absolute;
        top:-1px;
        left:-1px;
        width:14px;
        height:14px;
        background:white;
        border:1px solid #aaa;
        border-radius:2px;
        transition: left 0.1s cubic-bezier(0.785, 0.135, 0.15, 0.86);
    }
    input[type="checkbox"]:checked{
        background:#a6c7ff;
        border-color:#8daee5;
    }
    input[type="checkbox"]:checked:after{
        left:23px;
        border-color:#8daee5;
    }

    input[type="checkbox"]:hover:not(:checked):not(:disabled):after,
    input[type="checkbox"]:focus:not(:checked):not(:disabled):after{
        left:0px;
    }

    input[type="checkbox"]:hover:checked:not(:disabled):after,
    input[type="checkbox"]:focus:checked:not(:disabled):after{
        left:22px;
    }

    input[type="checkbox"]:disabled{
        opacity:0.5;
    }
</style>
<?php
wp_die();
?>
