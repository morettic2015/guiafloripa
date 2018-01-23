<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
const FREEGEOIP = "https://freegeoip.net/json/";
const ONESIGNAL = "https://onesignal.com/api/v1/";
const ONE_SIGNAL_REST_API = "_onesignal_rest_api_key";
const ONE_SIGNAL_APP_ID = "_onesignal_app_id";

/**
 * Description of TwitterControl
 *
 * @author Morettic LTDA
 */
const META_KEY = "_term_twitter";

const CK = "_ck";
const CS = "_cs";
const AT = "_at";
const AC = "_ac";
const IC = "_ic_twitter";

class TwitterControl {

    public function getNotificationStatus() {
        $OneSignalWPSetting = get_option('OneSignalWPSetting');
        $OneSignalWPSetting_app_id = $OneSignalWPSetting['app_id'];
        $OneSignalWPSetting_rest_api_key = $OneSignalWPSetting['app_rest_api_key'];
        $total_notification_stats = 0;
        $decimal_delivered = 0;
        $decimal_failed = 0;
        $decimal_pending = 0;
        $decimal_converted = 0;
        $decimal_not_converted = 0;
        $response_counter = 0;
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . $OneSignalWPSetting_rest_api_key
            )
        );
        $url = ONESIGNAL . "notifications?app_id=" . $OneSignalWPSetting_app_id . "&limit=500&offset=0";
        $response = wp_remote_get($url, $args);

        $response_to_arrays = json_decode(wp_remote_retrieve_body($response), true);

        $user_custom_api_key = get_user_meta(get_current_user_id(), ONE_SIGNAL_REST_API, true);
        $user_custom_app_id = get_user_meta(get_current_user_id(), ONE_SIGNAL_APP_ID, true);
        //Custom API
        if ($user_custom_api_key !== "") {
            $args = array(
                'headers' => array(
                    'Authorization' => 'Basic ' . $user_custom_api_key
                )
            );
            $url = ONESIGNAL . "notifications?app_id=" . $user_custom_app_id . "&limit=500&offset=0";
            $response = wp_remote_get($url, $args);

            $response_to_arrays1 = json_decode(wp_remote_retrieve_body($response), true);
            $response_to_arrays['notifications'] = array_merge($response_to_arrays['notifications'], $response_to_arrays1['notifications']);
        }

        if ($response_to_arrays['notifications']) {
            foreach ($response_to_arrays['notifications'] as $response_array) {
                $now_time = time();
                $notification_send_after = $response_array['send_after'];
                //$response_counter++;
                if ($now_time > $notification_send_after && is_numeric($response_array['remaining']) && is_numeric($response_array['converted']) && is_numeric($response_array['successful']) && is_numeric($response_array['failed'])) {
                    $response_counter++;
                    //var_dump($response_array);
                    $notification_converted = $response_array['converted'];
                    $notification_delivered = $response_array['successful'];
                    $notification_failed = $response_array['failed'];
                    $notification_pending = $response_array['remaining'];
                    $total_notification_stats = $notification_delivered + $notification_failed + $notification_pending;

                    if (is_nan($total_notification_stats) ||
                            is_nan(($notification_delivered / $total_notification_stats) * 100) ||
                            is_nan(($notification_failed / $total_notification_stats) * 100) ||
                            is_nan(($notification_pending / $total_notification_stats) * 100) ||
                            is_nan(($notification_converted / $total_notification_stats) * 100)
                    ) {
                        continue;
                    }


                    $decimal_delivered += ($notification_delivered / $total_notification_stats) * 100;
                    $decimal_failed += ($notification_failed / $total_notification_stats) * 100;
                    $decimal_pending += ($notification_pending / $total_notification_stats) * 100;
                    $decimal_converted += ($notification_converted / $total_notification_stats) * 100;
                    /* echo "<br>$decimal_converted";
                      echo "<br>$notification_converted";
                      echo "<br>$notification_delivered";
                      echo "<br>$notification_failed";
                      echo "<br>$notification_pending"; */
                }
            }
            ?>
            <script>
                Morris.Donut({
                    element: 'graph1',
                    data: [
                        {value: <?php echo 100 - ($decimal_converted / $response_counter); ?>, label: 'Não clicados'},
                        {value: <?php echo $decimal_converted / $response_counter ?>, label: 'Clicados'},
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
                        {value: <?php echo $decimal_delivered / $response_counter; ?>, label: 'Entregues'},
                        {value: <?php echo $decimal_failed / $response_counter; ?>, label: 'Não entregues'},
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
            <?php
        }
    }

    public function getActionsForBot() {
        global $wpdb;
// $twitterMeta = get_user_meta(get_current_user_id(), '_term_twitter', false);
        $query = "select 
                    ID as userID,user_nicename as nick,meta_key as property ,meta_value as value 
                    from wp_users as a
                    left join wp_usermeta on user_id = ID
                    where meta_key in ('_term_twitter','_cs','_ck','_at','_as','_ac')
                    order by user_id asc";

        $twitterMeta = $wpdb->get_results($query);
        $ret = [];
        foreach ($twitterMeta as $row) {
            $std = $row;
            if ($std->value === "") {
                $std->value = new stdClass();
            } else {
                $std->value = json_decode($std->value);
            }
            $ret[] = $std;
        }
// var_dump($ret);
//   die;
        return $ret;
    }

    public function verifyConfig() {
        $t_ck = get_user_meta(get_current_user_id(), CK, false);
        $t_cs = get_user_meta(get_current_user_id(), CS, false);
        $t_at = get_user_meta(get_current_user_id(), AT, false);
        $t_ac = get_user_meta(get_current_user_id(), AC, false);

        if (empty($t_ck[0]) || empty($t_cs[0]) || empty($t_at[0]) || empty($t_ac[0])) {
            echo '<div class="notice notice-error is-dismissible"> 
                    <p><strong>Verifique as credencias do<a href="profile.php#twitter"> twitter em seu perfil </a>para ativar o Twitter BOT</strong></p>
                 </div>';
            return false;
        }
        return true;
    }

    public function dashBoardInfo($isFine) {
        if ($isFine === true) {
            echo '<p><strong class="notice-info">Credenciais do twitter salvas com sucesso.</strong></p>';
        }
        $t_ac = get_user_meta(get_current_user_id(), IC, false);
        if (empty($t_ac[0])) {
            echo '<p><strong>Credenciais ainda nao verificadas. <a href="#">Testar conexão</a></strong></p>';
        } else {//Show Usage Chart
            ?>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />
            <link href="<?php echo plugins_url('css/gijgo.css', __FILE__); ?>" rel="stylesheet" type="text/css" />
            <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
            <script src="<?php echo plugins_url('js/gijgo.js', __FILE__); ?>" type="text/javascript"></script>
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
            <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
            <div id="graph"></div>
            <script>
                Morris.Bar({
                    element: 'graph',
                    data: [
                        {x: 'Mensagens enviadas', a: 100},
                        {x: 'Leads importados', a: 75},
                        {x: 'Tweets favoritados', a: 50},
                        {x: 'Retweets', a: 75},
                        {x: 'Seguidores', a: 50},
                        {x: 'Seguindo', a: 75}
                    ],
                    xkey: 'x',
                    ykeys: ['a'],
                    labels: ['Series A']
                });
            </script>
            <?php
        }
    }

    public function disableCheck($p) {
//var_dump($p);
        $follow = isset($p->follow) ? 'true;' : 'false;';
        $unfollow = isset($p->unfollow) ? 'true;' : 'false;';
        $retweet = isset($p->retweetar) ? 'true;' : 'false;';
        $unretweet = isset($p->unretweet) ? 'true;' : 'false;';
        $unfavorite = isset($p->unfavorite) ? 'true;' : 'false;';
        $favoritos = isset($p->favoritos) ? 'true;' : 'false;';
        echo 'document.terms.hashtag.value="' . $p->hashtag . '";';
        echo 'document.terms.quote.value="' . $p->quote . '";';
        echo 'document.terms.ignore.checked= false;';
        echo 'document.terms.follow.checked = ' . $follow;
        echo 'document.terms.unfollow.checked =' . $unfollow;
        echo 'document.terms.retweetar.checked = ' . $retweet;
        echo 'document.terms.unretweet.checked = ' . $unretweet;
        echo 'document.terms.unfavorite.checked = ' . $unfavorite;
        echo 'document.terms.favoritos.checked = ' . $favoritos;
        if (isset($p->ignore)) {
            echo 'document.terms.ignore.checked = true;';
            echo "disableChecks(document.terms.ignore)";
        }
    }

    public function loadByUmetaId($o) {

//var_dump($o);
        if (isset($o['term'])) {
            global $wpdb;
            $query = "select * FROM wp_usermeta where umeta_id = " . $o['term'] . " and user_id = " . get_current_user_id();
            $twitterMeta = $wpdb->get_results($query);
//var_dump($twitterMeta);
            return $twitterMeta[0];
        }
    }

//put your code here
    public function saveTerm($obj) {
//var_dump($obj);
        global $wpdb;
        if (isset($obj['btSaveTerm'])) {
// echo get_current_user_id();
            if (isset($obj['umeta_id'])) {
                $meta = $obj['umeta_id'];
                $query = "update wp_usermeta set meta_value = '" . json_encode($obj) . "' where umeta_id = $meta and user_id = " . get_current_user_id();
// echo $query;
                $twitterMeta = $wpdb->get_results($query);
//var_dump($twitterMeta);
            } else {
                $meta = add_user_meta(get_current_user_id(), META_KEY, json_encode($obj), false);
            }
            echo '<div class = "notice notice-success is-dismissible">
<p><strong>Termo de busca salvo com sucesso (ID:' . $meta . ').</strong></p>
</div>';
//var_dump($obj);
//var_dump($meta);
        }
    }

    public function getNotificationsPoints() {
        global $wpdb;
        $query = "SELECT option_value FROM app_guiafloripa_com_br.wp_options where option_value like '%latitude%';";
        $twitterMeta = $wpdb->get_results($query);
//echo "<pre>";
        $i = 0;
        $str = "";
        $cLat = 0;
        $cLon = 0;
        foreach ($twitterMeta as $loc) {
            $json = json_decode($loc->option_value);
            if (empty($json->latitude)) {
                continue;
            } else {
                $i++;
                $cLat = $cLat + $json->latitude;
                $cLon = $cLon + $json->longitude;
                $str .= "var marker" . $i . " = new google.maps.Marker({
                            position: new google.maps.LatLng(" . $json->latitude . "," . $json->longitude . "),
                            map: map,
                            title:'" . $json->ip . "'
                        });";
            }
        }
        $cLat = $cLat / $i;
        $cLon = $cLon / $i;
        $ret = new stdClass();
        $ret->counter = $i;
        $ret->script = $str;
        $ret->lac = $cLat;
        $ret->loc = $cLon;

        return $ret;
    }

    public function getTwitterTerms() {
        $twitterMeta = get_user_meta(get_current_user_id(), META_KEY, false);
//var_dump($twitterMeta);
        return $twitterMeta;
    }

}
