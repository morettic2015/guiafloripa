<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include dirname(dirname(__FILE__)) . '/MantisPhpClient.php';

use MantisHub\MantisPhpClient;
use SoapClient;

const BUGTRACKER_REST = "https://bugtracker.morettic.com.br";
const USER = 'mobilebot';
const PASS = 'm0b1l3b0t';
const MANTIS_PROJECT = 'GuiaFloripa App';

class BugTracker extends stdClass {

    public static function addIssueBugTracker($projectID, $category, $summary, $desc) {

        $mantis = new MantisPhpClient(BUGTRACKER_REST, USER, PASS, 'GuiaFloripaBugTracker');

        //var_dump($mantis);

        $issue = array(
            'project' => array(
                'name' => 'guiafloripa app',
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
