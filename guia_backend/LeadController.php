<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//const MAUTIC_PUBLIC_KEY = "545h4a5zslc0404cs0c08sw0w8oowokgs4gg8k8kgccs4wcgwg";
const MAUTIC_SEGMENT_ID = 23;
const MAUTIC_ANUNCUANTES_ID = 37;
const MAUTIC_INSTANCE_URL = "https://inbound.citywatch.com.br";
const MAUTIC_INSTANCE_API = "https://inbound.citywatch.com.br/api/";
const MAUTIC_USER = "leadmobi";
const MAUTIC_PASS = "leadmobi";

use \Mautic\Auth\ApiAuth;
use Mautic\MauticApi;

/**
 * Description of LeadController
 *
 * @author Morettic LTDA
 */
$auth = null;

class LeadController extends stdClass {

    public static function addAnunciante($contactId) {
        $con = LeadController::connectMautic();
        $segmentApi = $con->api->newApi("segments", $con->auth, MAUTIC_INSTANCE_API);
        $response = $segmentApi->addContact(MAUTIC_ANUNCUANTES_ID, $contactId);
        return $response;
    }

    /**
     * @Cria um template te de email para enviar .
     */
    public static function createEmailTemplate($id, $titulo, $name, $fromName, $subject, $customHtml, $description, $plainText, $reply) {
        $data = array(
            'title' => $titulo,
            'name' => $name,
            'fromName' => $fromName,
            'subject' => $subject,
            'customHtml' => $customHtml,
            'description' => $description,
            'plainText' => $plainText,
            'replyToAddress' => $reply,
            'isPublished' => 0
        );
        $email = [];
        $con = LeadController::connectMautic();
        $emailApi = $con->api->newApi("emails", $con->auth, MAUTIC_INSTANCE_API);
        if (empty($id) || is_null($id)) {
            $email = $emailApi->create($data);
        } else {
            $email = $emailApi->edit($id, $data, true);
        }
        return $email;
    }

    public static function createEmail($titulo, $description, $subject, $fromName, $customHtml, $plainText, $list, $id = NULL) {
        $name = "Template_Guia_" . substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);
        $data = array(
            'title' => $titulo,
            'name' => $name,
            'fromName' => $fromName,
            'subject' => $subject,
            'customHtml' => $customHtml,
            'description' => $description,
            'plainText' => $plainText,
            'emailType' => 'list',
            'lists' => array($list),
            'replyToAddress' => 'contato@guiafloripa.com.br',
            'isPublished' => 1
        );
        $con = LeadController::connectMautic();
        $emailApi = $con->api->newApi("emails", $con->auth, MAUTIC_INSTANCE_API);
        if (empty($id) || is_null($id)) {
            $email = $emailApi->create($data);
        } else {
            $email = $emailApi->edit($id, $data, true);
        }

        return $email;
    }

    public static function sendEmail($emailID) {
        $con = LeadController::connectMautic();
        $emailApi = $con->api->newApi("emails", $con->auth, MAUTIC_INSTANCE_API);
        $email = $emailApi->send($emailID);
        return $email;
    }

    public static function createSegment($name, $alias, $desc) {
        $data = array(
            'name' => $name,
            'alias' => $alias,
            'description' => $desc,
            'isPublished' => 1
        );
        $con = LeadController::connectMautic();


        $segmentApi = $con->api->newApi("segments", $con->auth, MAUTIC_INSTANCE_API);

        //var_dump($segmentApi);die;
        $segment = $segmentApi->create($data);
        return $segment;
    }

    /**
     * @Add Lead To Segment
     */
    public static function addContactToSegment($contactId, $segmentID = MAUTIC_SEGMENT_ID) {
        $con = LeadController::connectMautic();
        $segmentApi = $con->api->newApi("segments", $con->auth, MAUTIC_INSTANCE_API);
        $response = $segmentApi->addContact($segmentID, $contactId);
        return $response;
    }

    /**
     * @Create Lead Contact on Mautic
     */
    public static function createContact($first, $last, $email) {
        $con = LeadController::connectMautic();
        //echo "<pre>";
        // var_dump($con);
        $contactApi = $con->api->newApi("contacts", $con->auth, MAUTIC_INSTANCE_API);
        $data = array(
            'firstname' => $first,
            'lastname' => $last,
            'email' => $email,
            'ipAddress' => get_client_ip()
        );
        //var_dump($data);

        $contact = $contactApi->create($data);
        //var_dump($contact);
        //Lead ID From Mautic
        return $contact['contact']['id'];
    }

    /**
     *  @Connect with Mautic 
     * */
    public static function connectMautic() {

        @session_start();

        // ApiAuth->newAuth() will accept an array of Auth settings
        $settings = array(
            'baseUrl' => MAUTIC_INSTANCE_URL, //Base Url Instance
            'userName' => MAUTIC_USER, // Create a new user       
            'password' => MAUTIC_PASS  // Make it a secure password
        );

        // Initiate the auth object specifying to use BasicAuth
        $ret = new stdClass();
        $initAuth = new ApiAuth();
        //Ret Object
        $ret->auth = $initAuth->newAuth($settings, 'BasicAuth');
        $ret->api = new MauticApi();
        //var_dump($api);
        return $ret;
    }

}
