<?php
/**
 * Notifications systems
 *
 * @package  Notifications
 * @author   Marc Bou Sleiman
 */
if (!defined('ABSPATH')) {
    exit;
}

function oss_send_notifications() {
    $nonce = wp_create_nonce("oss_sending_the_msg");
    $link = admin_url('admin-ajax.php?action=oss_sending_the_msg');
    $OneSignalWPSetting = get_option('OneSignalWPSetting');
    $OneSignalWPSetting_app_id = $OneSignalWPSetting['app_id'];
    $OneSignalWPSetting_rest_api_key = $OneSignalWPSetting['app_rest_api_key'];
    $pluginList = get_option('active_plugins');
    $plugin = 'onesignal-free-web-push-notifications/onesignal.php';
    if (in_array($plugin, $pluginList) && $OneSignalWPSetting_app_id && $OneSignalWPSetting_rest_api_key) {
        ?>
        <div class="bread_crumbs">
            <a href="<?php echo admin_url('admin.php?page=oss_general_overview'); ?>">Overview</a>
            <a href="<?php echo admin_url('admin.php?page=oss_send_notifications'); ?>" class="active_bread">Send Notification</a>
            <a href="<?php echo admin_url('admin.php?page=oss_all_notifications'); ?>">Scheduled Notifications</a>
            <a href="<?php echo admin_url('admin.php?page=oss_sent_notifications'); ?>">Sent Notifications</a>
        </div>
        <div class="wrap">
            <div class="icon32" id="icon-options-general">
                <br/>
            </div>
            <div class="header">
                <div class="elt">
                    <h2>New Notification Message</h2>
                </div>
                <div class="elt srch">
                    <div class="general_notice">
                        <h4>BE AWARE! This message will be sent to all subscribed users immediately
                            <img alt="close" class="close_notice_button" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'images/close_button.png' ?>" /></h4>
                    </div>
                    <form method="get" action="#">
                        <input type="hidden" name="page" value="property_info"/>
                        <div class="datepicker-type-wrapper">
                            <span class="section_title">SCHEDULE:</span>
                            <span class="radio-wrapper">
                                <input class="radio_selector" type="radio" name="send-time" id="send-immediately" value="send-immediately">
                                <label for="send-immediately">Send immediately</label>
                            </span>
                            <span class="radio-wrapper">
                                <input class="radio_selector" type="radio" name="send-time" id="send-scheduled" value="send-scheduled">
                                <label for="send-scheduled">Schedule Message</label>
                            </span>
                        </div>
                        <div class="schedule_date_section">
                            <span class="section_title">DATE:</span>
                            <input type="text" name="timepicker" class="timepicker"/>
        <!--                        <input id="time_picker_field" type="text" size="35" value="<?php // echo $_GET['src_date'];                                                             ?>"
                                   name="src_date" placeholder="Enter username to search"/>-->
                        </div>
                        <span class="section_title">TITLE:</span>
                        <input type="text" name="notification-title" id="notification-title" />
                        <span class="section_title">MESSAGE:</span>
                        <textarea rows="4" cols="50" name="notification-message" id="notification-message"></textarea>
                        <span class="section_title">URL: <h6>(When user clicks on the notification, he will be redirected to this URL.)</h6></span>
                        <input type="text" placeholder="(Optional)" name="notification-url" id="notification-url" />
                        <input id="send_notification" data-link="<?php echo $link; ?>" data-nonce="<?php echo $nonce; ?>" type="submit" value="Submit" name="submit"/>
                        <img alt="loader" class="loader_image" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'images/loader.gif' ?>" />
                        <div class="ajax_result"></div>
                    </form>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <h4 class="the_right_path">For any inquiry or concern feel free to <a href="http://marcbousleiman.com/#contact_me">CONTACT ME</a></h4>
    <?php } else { ?>
        <div class="bread_crumbs">
            <a href="<?php echo admin_url('admin.php?page=oss_general_overview'); ?>">Overview</a>
            <a href="<?php echo admin_url('admin.php?page=oss_send_notifications'); ?>" class="active_bread">Send Notification</a>
            <a href="<?php echo admin_url('admin.php?page=oss_all_notifications'); ?>">Scheduled Notifications</a>
            <a href="<?php echo admin_url('admin.php?page=oss_sent_notifications'); ?>">Sent Notifications</a>
        </div>
        <div class="wrap">
            <div class="icon32" id="icon-options-general">
                <br/>
            </div>
            <div class="header">
                <div class="elt">
                    <h2>New Notification Message</h2>
                </div>
                <div class="elt srch">
                    <h3 class="error_notice">Please complete the OneSignal – Free Web Push Notifications setup before using this plugin.</h3>
                    <div class="notice_hr"></div>
                    <h3 class="error_notice">To do so :</h3>
                    <ul class="todo_list">
                        <li>Download <a href="https://wordpress.org/plugins/onesignal-free-web-push-notifications/">OneSignal – Free Web Push Notifications</a></li>
                        <li>Activate OneSignal – Free Web Push Notifications plugin</li>
                        <li>Go to OneSignal – Free Web Push Notifications settings page</li>
                        <li>Provide the App ID and the REST API key as mentioned</li>
                        <li>Save and get back here...</li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <h4 class="the_right_path">For any inquiry or concern feel free to <a href="http://marcbousleiman.com/#contact_me">CONTACT ME</a></h4>
    <?php } ?>
    <style type="text/css">
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

        .general_notice h4 {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #e50000;
            background-color: #ffcccc;
            font-style: italic;
            border-image: none;
            border-style: solid;
            border-width: 1px 1px 5px;
            font-size: 16px;
            margin: 0;
            padding: 10px;
            color: #e50000;
        }

        .close_notice_button {
            float: right;
            cursor: pointer;
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
            background-color: rgba(0,0,0,0.15);
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
        .loader_image {
            margin: 0 0 3px 15px;
            vertical-align: bottom;
            display: none;
        }

        .schedule_date_section{
            display: none;
            position: relative;
        }

        .wrap {
            background-color: #fff;
            margin: 40px 20px 0 0;
            border: 1px solid #182b49;
            box-shadow: 0 0 3px 0 grey;
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
            background-color: #fff;
            color: #611341;
            font-weight: bold;
            margin: 25px 0 0 0;
            cursor: pointer;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        .header .elt.srch form input[name="submit"]:hover{
            background-color: #182b49;
            color: #fff;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        .header .elt.srch form input#notification-title,
        .header .elt.srch form input#notification-url,
        .header .elt.srch form textarea{
            width: 100%;
        }

        .header .elt.srch form input[name="submit"],
        .header .elt.srch form textarea,
        .header .elt.srch form input{
            border: 1px solid #929497;
            padding: 7px;
            font-weight: 600;
            border-radius: 0;
            background-color: #fff;
            color: #929497;
        }

        .header .elt.srch a {
            -webkit-box-shadow: 1.7px 1.7px 1px #787878;
            -moz-box-shadow: 1.7px 1.7px 1px #787878;
            box-shadow: 1.7px 1.7px 1px #787878;
            padding: 5px;
            text-decoration: none;
            border: 1px solid #611431;
            background-color: #fff;
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
    </style>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            //            jQuery('#time_picker_field').Zebra_DatePicker();
            jQuery(function ($) {
                $('.timepicker').intimidatetime({
                    format: 'yyyy-MM-dd hh:mm:00tt',
                    previewFormat: 'yyyy-MM-dd hh:mmtt'
                });
            });
            //if schedule clicked open date field
            jQuery('.close_notice_button').on('click', function () {
                jQuery('.general_notice').slideUp(500);
            });
            //if clicked close general notice
            jQuery('.radio_selector').on('click', function () {
                var selected_method = jQuery(this).val();
                if (selected_method == "send-scheduled") {
                    jQuery('.schedule_date_section').slideDown();
                } else {
                    jQuery('.schedule_date_section').slideUp();
                }
            });
            //submit button notification
            jQuery('#send_notification').on('click', function (e) {
                e.preventDefault();
                var selected_method = jQuery('input[name=send-time]:checked').val();
                var notify_title = jQuery('#notification-title').val();
                var notify_message = jQuery('#notification-message').val();
                var notify_time = jQuery('.timepicker').val();
                var notify_url = jQuery('#notification-url').val();
                var nonce = jQuery(this).attr("data-nonce");
                var ajax_url = jQuery(this).attr("data-link");
                var loader = jQuery('.loader_image');
                //                    alert(selected_method);
                if (selected_method && notify_title && notify_message) {
                    if (selected_method == 'send-immediately') {
                        if (notify_title && notify_message) {
                            loader.fadeIn();
                            jQuery.ajax({
                                type: "post",
                                dataType: "json",
                                url: ajax_url,
                                data: {action: "oss_sending_the_msg", nonce: nonce, selected_method: selected_method,
                                    notify_title: notify_title, notify_message: notify_message, notify_time: notify_time, notify_url: notify_url},
                                success: function (response) {
                                    loader.fadeOut();
                                    if (response.type == "success") {
                                        jQuery('.ajax_result').html('<h5 style="color : green ">Message Sent. Refreshing...</h5>');
                                        function reload() {
                                            location.reload(true);
                                        }
                                        setTimeout(reload, 1000);
                                    } else {
                                        jQuery('.ajax_result').html('<h5 style="color : red ">There was an error! Please try again.</h5>');
                                    }
                                }
                            });
                        }
                    }
                    if (selected_method == 'send-scheduled') {
                        if (notify_title && notify_message && notify_time) {
                            loader.fadeIn();
                            jQuery.ajax({
                                type: "post",
                                dataType: "json",
                                url: ajax_url,
                                data: {action: "oss_sending_the_msg", nonce: nonce, selected_method: selected_method,
                                    notify_title: notify_title, notify_message: notify_message, notify_time: notify_time, notify_url: notify_url},
                                success: function (response) {
                                    loader.fadeOut();
                                    if (response.type == "success") {
                                        jQuery('.ajax_result').html('<h5 style="color : green ">Message ' + response.msgstatus + '. Refreshing...</h5>');
                                        function reload() {
                                            location.reload(true);
                                        }
                                        setTimeout(reload, 1000);
                                    } else {
                                        jQuery('.ajax_result').html('<h5 style="color : red ">There was an error! Please try again.</h5>');
                                    }
                                }
                            });
                        } else {
                            jQuery('.ajax_result').html('<h5 style="color : red ">Please Select the schedule, fill the Date, Title and Message.</h5>');
                        }
                    }
                } else {
                    jQuery('.ajax_result').html('<h5 style="color : red ">Please Select the schedule, fill the Title and Message.</h5>');
                }
            });
        }
        );
    </script>
    <?php
}
