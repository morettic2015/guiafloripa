<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />
<link href="<?php echo plugins_url('css/gijgo.css', __FILE__); ?>" rel="stylesheet" type="text/css" />
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="<?php echo plugins_url('js/gijgo.js', __FILE__); ?>" type="text/javascript"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIgd_8suqQ-mT29qyY2FqmllQMoNidK9A"></script>

<?php
include_once PLUGIN_ROOT_DIR . 'views/TwitterControl.php';
$tc = new TwitterControl();
$ret = $tc->getNotificationsPoints();
$OneSignalWPSetting = get_option('OneSignalWPSetting');
$OneSignalWPSetting_app_id = $OneSignalWPSetting['app_id'];
$OneSignalWPSetting_rest_api_key = $OneSignalWPSetting['app_rest_api_key'];
$board = $tc->getNotificationStatus($OneSignalWPSetting_app_id, $OneSignalWPSetting_rest_api_key);
//var_dump($board);
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?> </h1>
    <div class="notice notice-info"> 
        <p><strong>Visualize a <code>localização</code> dos <?php echo $ret->counter; ?> usuários e seus <code>dispositivos</code> no mapa</strong></p>
    </div>
    <table style="width: 100%" class="stuffbox">

        <tr>
            <td style="width: 70%"><div id="map"></div></td>
            <td style="width: 30%">
        <center>
            <div id="ctPushs"></div>
            <h3>Estatísticas de Envio</h3>
            <div id="graph" style="height: 180px"></div>   
            <h3>Estatísticas de Conversão</h3>
            <div id="graph1" style="height: 180px"></div>
        </center>
        </td>

        </td>

        </tr>
    </table>
</div>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 520px;
        width: 100%;
    }
    /* Optional: Makes the sample page fill the window. */

</style>
<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: <?php echo $ret->lac; ?>, lng: <?php echo $ret->loc; ?>},
            zoom: 3
        });
    }
    initMap();

<?php echo $ret->script; ?>
</script>
<?php

?>
<script>
    Morris.Donut({
        element: 'graph1',
        data: [
            {value: <?php echo 100 - ($board->decimal_converted / $board->response_counter); ?>, label: 'Não clicados'},
            {value: <?php echo $board->decimal_converted / $board->response_counter ?>, label: 'Clicados'},
        ],
        backgroundColor: '#ccc',
        labelColor: '#f79129',
        colors: [
            '#2499c8',
            '#f79129',
            '#a4ce3f',
            '#c0358a',
        ],
        formatter: function (x) {
            return x + "%"
        }
    });
    Morris.Donut({
        element: 'graph',
        data: [
            {value: <?php echo $board->decimal_delivered / $board->response_counter; ?>, label: 'Entregues'},
            {value: <?php echo $board->decimal_failed / $board->response_counter; ?>, label: 'Não entregues'},
        ],
        backgroundColor: '#ccc',
        labelColor: '#f79129',
        colors: [
            '#a4ce3f',
            '#c0358a',
            '#67C69D',
            '#95D7BB'
        ],
        formatter: function (x) {
            return x + "%"
        }
    });
    document.getElementById('ctPushs').innerHTML = '<b>Notificações analisadas:<?php echo $response_counter; ?></b>';
</script>
