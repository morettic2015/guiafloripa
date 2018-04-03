<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ScriptsController
 *
 * @author Morettic LTDA
 */
class ScriptsController {

    //put your code here
    public static function initHeaderScripts() {
        echo '<style type="text/css">#wpfooter {display:none;} </style>';
        wp_enqueue_script('form-contato', 'https://www.gstatic.com/charts/loader.js', false);
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
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('wp-color-picker');
    }

}
