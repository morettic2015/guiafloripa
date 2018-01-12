<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailController
 *
 * @author Morettic LTDA
 */
const COLOR_PICKER = "_color_picker";
const LOGO_URL = "_url_logo";
const LOGO_URL1 = "_url_logo1";
const FACE = _LINKFACE;
const TWITTER = 'linkTwitter';
const M_LINK = 'link';
const TXT_BT = "txtBt";

class EmailController {

    //put your code here

    public function getEmail($id) {
        // $id = isset($_POST['id'])?$_POST['id']:empty($_GET['pid'])?0:$_GET['pid'];
        $std = new stdClass();
        $std->meta = get_post_meta($id);
        $std->post = get_post($id);
        return $std;
    }

    public function saveUpdateEmail($request) {

        if (!isset($request['subject']))
            return false;
        // Create post object
        //var_dump($request);
        $email = array(
            'ID' => $request['id'],
            'post_title' => wp_strip_all_tags($request['subject']),
            'post_content' => $request['txtDesc'],
            'post_status' => 'draft',
            'post_type' => 'email',
            'post_author' => get_current_user_id()
        );
        // Insert the post into the database
        $emailId = wp_insert_post($email);
        //var_dump($emailId);
        if (!add_post_meta($emailId, COLOR_PICKER, $request['colorpicker'], true)) {
            update_post_meta($emailId, COLOR_PICKER, $request['colorpicker']);
        }
        if (!add_post_meta($emailId, LOGO_URL, $request['content_url'], true)) {
            update_post_meta($emailId, LOGO_URL, $request['content_url']);
        }
        if (!add_post_meta($emailId, LOGO_URL1, $request['content_url1'], true)) {
            update_post_meta($emailId, LOGO_URL1, $request['content_url1']);
        }
        if (!add_post_meta($emailId, FACE, $request['linkFacebook'], true)) {
            update_post_meta($emailId, FACE, $request['linkFacebook']);
        }
        if (!add_post_meta($emailId, TWITTER, $request[TWITTER], true)) {
            update_post_meta($emailId, TWITTER, $request[TWITTER]);
        }
        if (!add_post_meta($emailId, TXT_BT, $request[TXT_BT], true)) {
            update_post_meta($emailId, TXT_BT, $request[TXT_BT]);
        }
        if (!add_post_meta($emailId, M_LINK, $request[M_LINK], true)) {
            update_post_meta($emailId, M_LINK, $request[M_LINK]);
        }

        echo '<div class="notice notice-success is-dismissible"> 
                    <p><strong><code>Email marketing</code> salvo com sucesso</strong></p>
                 </div>';

        return $emailId;
    }

    public function showModel($pid) {
        $post = $this->getEmail($pid);
        //var_dump($post);
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" style="" class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions   js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js csstransforms csstransforms3d csstransitions responsejs "><head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <title><?php echo $post->post->post_title; ?></title>
                <style type="text/css">
                    @import url(https://fonts.googleapis.com/css?family=Lato:400);

                    /* Take care of image borders and formatting */

                    img {
                        max-width: 600px;
                        outline: none;
                        text-decoration: none;
                        -ms-interpolation-mode: bicubic;
                    }

                    a {
                        text-decoration: none;
                        border: 0;
                        outline: none;
                    }

                    a img {
                        border: none;
                    }

                    /* General styling */

                    td, h1, h2, h3  {
                        font-family: Helvetica, Arial, sans-serif;
                        font-weight: 400;
                        color: black;
                    }

                    body {
                        -webkit-font-smoothing:antialiased;
                        -webkit-text-size-adjust:none;
                        width: 100%;
                        height: 100%;
                       
                        background: #ffffff;
                    }

                    h1, h2, h3 {
                        padding: 0;
                        margin: 0;
                        color: black;
                        font-weight: 400;
                    }

                    h3 {
                        color: #2969b0;
                        font-size: 24px;
                    }
                </style>

                <style type="text/css" media="screen">
                    @media screen {
                        /* Thanks Outlook 2013! http://goo.gl/XLxpyl*/
                        td, h1, h2, h3 {
                            font-family: 'Lato', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
                        }
                    }
                </style>

                <style type="text/css" media="only screen and (max-width: 480px)">
                    /* Mobile styles */
                    @media only screen and (max-width: 480px) {

                        table[class="w320"] {
                            width: 320px !important;
                        }

                        table[class="w300"] {
                            width: 300px !important;
                        }

                        table[class="w290"] {
                            width: 290px !important;
                        }

                        td[class="w320"] {
                            width: 320px !important;
                        }

                        td[class="mobile-center"] {
                            text-align: center !important;
                        }

                        td[class="mobile-padding"] {
                            padding-left: 20px !important;
                            padding-right: 20px !important;
                            padding-bottom: 20px !important;
                        }

                        [class="mobile-block"] {
                            width: 100% !important;
                            display: block !important;
                        }
                    }
                </style>
            </head>
            <body class="body ui-sortable" style="padding: 0px; margin: 0px; display: block; background: rgb(255, 255, 255); text-size-adjust: none; cursor: auto; overflow: visible;" bgcolor="#ffffff">
                <div data-section-wrapper="1" style="border-bottom: 3px solid <?php echo $post->meta[COLOR_PICKER][0] ?>;">
                    <center>
                        <table data-section="1" cellspacing="0" cellpadding="0" width="530" class="w320">
                            <tbody><tr>
                                    <td valign="top" style="text-align:left;" class="mobile-center ui-sortable" data-slot-container="1">

                                    </td>
                                </tr>
                            </tbody></table>
                    </center>
                </div>
                <?php if(!empty($post->meta[LOGO_URL][0])){ ?>
                <div data-section-wrapper="one-column">
                    <div data-section-wrapper="1">
                        <center>
                            <table data-section="1" style="margin: 0 auto;border-collapse: collapse !important;width: 600px;" class="w320" cellpadding="0" cellspacing="0" width="600">
                                <tbody><tr>
                                        <td data-slot-container="1" valign="top" class="mobile-block ui-sortable" style="padding-left: 5px; padding-right: 5px;">
                                            <div data-slot="image" data-param-align="1" style="text-align: center;">

                                                <img src="<?php echo $post->meta[LOGO_URL][0] ?>" alt="An image" class="fr-view"/><br />
                                                <div style="clear:both"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody></table>
                        </center>
                    </div>
                </div>
                <?php }if(!empty($post->meta[LOGO_URL1][0])){ ?>
                <div data-section-wrapper="1" background="<?php echo $post->meta[LOGO_URL1][0] ?>" bgcolor="black" valign="top" style="background: url(<?php echo $post->meta[LOGO_URL1][0] ?>) no-repeat center; background-color:<?php echo $post->meta[COLOR_PICKER][0] ?>; background-position: center;">
                    <center>
                        <table data-section="1" cellspacing="0" cellpadding="0" width="530" height="303" class="w320">
                            <tbody><tr>
                                    <td valign="middle" style="vertical-align:middle; padding-right: 15px; padding-left: 15px; text-align:left;" class="mobile-center ui-sortable" height="303" data-slot-container="1">

                                    </td>
                                </tr>
                            </tbody></table>
                    </center>
                </div>
                <?php } ?>
                <div data-section-wrapper="1">
                    <center>

                        <table data-section="1" cellspacing="0" cellpadding="8" width="530" class="w320">
                            <tbody><tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="100%">
                                            <tbody><tr>
                                                    <td class="mobile-padding ui-sortable" style="text-align:left;" data-slot-container="1">
                                                        <div data-slot="separator"></div>
                                                        <div data-slot="text">
                                                            <div style="text-align: center;">
                                                                <?php echo str_replace("&nbsp;","<br>",$post->post->post_content); ?>
                                                            </div>
                                                            <div data-empty="true"><br /></div>
                                                        </div>
                                                        <div data-slot="button" class="" style="position: relative; left: 0px; top: 0px; padding-top: 30px;" data-param-float="1" align="center" data-param-button-size="0" data-param-href="<?php echo $post->meta[M_LINK][0] ?>" data-param-link-text="<?php echo $post->meta[TXT_BT][0] ?>" data-param-padding-top="30">

                                                            <a href="<?php echo $post->meta[M_LINK][0] ?>" class="button" target="_blank" style="border-color: <?php echo $post->meta[COLOR_PICKER][0] ?>; border-width: 10px 20px; border-style: solid; text-decoration: none; border-radius: 3px; background-color: <?php echo $post->meta[COLOR_PICKER][0] ?>; display: inline-block; font-size: 14px; color: rgb(255, 255, 255); padding: 0px;"><?php echo $post->meta[TXT_BT][0] ?></a>
                                                            <div style="clear:both"></div>                                </div>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                               

                            </tbody></table>
                    </center>
                </div>
                <div data-section-wrapper="1" style="background-color:#c2c2c2;">
                    <center>
                        <table data-section="1" cellspacing="0" cellpadding="0" width="530" class="w320">
                            <tbody><tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="30" width="100%">
                                            <tbody><tr>
                                                    <td style="text-align:center;" data-slot-container="1" class="ui-sortable">
                                                        <div data-slot="text"><a href="http://twitter.com/<?php echo $post->meta[TWITTER][0] ?>" rel="noopener noreferrer" target="_blank"><img width="61" height="51" src="https://inbound.citywatch.com.br/themes/skyline/img/twitter.gif" alt="twitter" class="fr-fic fr-dii" /></a>

                                                            <a href="<?php echo $post->meta[FACE][0] ?>" rel="noopener noreferrer" target="_blank"><img width="61" height="51" src="https://inbound.citywatch.com.br/themes/skyline/img/facebook.gif" alt="facebook" class="fr-fic fr-dii" /></a></div>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <center>
                                            <table style="margin:0 auto;" cellspacing="0" cellpadding="5" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align:center; margin:0 auto;" width="100%" data-slot-container="1" class="ui-sortable">
                                                            <small>{unsubscribe_text} | {webview_text}</small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </div>

            </body>
        </html>
        <?php
    }

    public function duplicatePost($id) {
        $title = get_the_title($id);
        $oldpost = get_post($id);
        $oldpost->ID = "";
        // var_dump($oldpost);

        $new_post_id = wp_insert_post($oldpost);
        // Copy post metadata
        $data = get_post_custom($id);
        foreach ($data as $key => $values) {
            foreach ($values as $value) {
                add_post_meta($new_post_id, $key, $value);
            }
        }
        return $new_post_id;
    }

}
