<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include dirname(dirname(__FILE__)) . '/MantisPhpClient.php';

use MantisHub\MantisPhpClient;
//use SoapClient;

const MANTIS_REST = "https://bugtracker.morettic.com.br";
const MANTIS_USER = 'mobilebot';
const MANTIS_PASS = 'm0b1l3b0t';
const MANTIS_PROJECT = 'guiafloripa app';
const BACKEND = "BACKEND";
const GEOCODER_E = "GEOCODER";
const QUERY = "QUERY";


class BugTracker extends stdClass {

    public static function addIssueBugTracker($projectID, $category, $summary, $desc) {

        $mantis = new MantisPhpClient(MANTIS_REST, MANTIS_USER, MANTIS_PASS, 'GuiaFloripaBugTracker');

        //var_dump($mantis);

        $issue = array(
            'project' => array(
                'name' => MANTIS_PROJECT,
                'id' => $projectID
            ),
            'category' => $category,
            'summary' => ($summary),
            'description' => ($desc),
        );
        $return = $mantis->addIssue($issue);
        
        return $return;
    }

}
