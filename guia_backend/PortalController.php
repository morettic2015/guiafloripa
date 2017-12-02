<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PortalController
 *
 * @author Morettic LTDA
 */
class PortalController extends GuiaController {

    public static final function inserPost() {
        
    }

    public static final function getCategoriasPortal() {
        define('CHARSET', 'ISO-8859-1');
        $conn = new MysqlDB();
        $query = "select term_id as termID, name, slug as token from wp_terms where term_id in (select term_id from wp_term_taxonomy where taxonomy = 'segmento') and slug not like 'Cine%' and name not like '%Especial%' and name not like '%Cine%' order by name asc;";
        $conn->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $conn->execute($query); // misspelled SELECT
        $i = 0;
        $ret = new stdClass();
        $ret->list = array();
        //while ($row = $conn->hasNext()) {
        while ($row = $conn->hasNext()) {
            $ret->list[] = $row;
        }
        $query = "select distinct meta_key from wp_postmeta where meta_key like 'regi%'";
        $conn->execute($query); // misspelled SELECT
        $i = 0;
        $ret->regions = array();
        //while ($row = $conn->hasNext()) {
        while ($row = $conn->hasNext()) {
            $ret->regions[] = $row;
        }
        $query = "select id as postID,post_title as title from wp_posts where post_type = 'cidade' and id in (select post_id from wp_postmeta where meta_key = 'mf_page_type' and meta_value='Cidade') order by post_title asc;";
        $conn->execute($query); // misspelled SELECT
        $i = 0;
        $ret->neighborhoods = array();
        //while ($row = $conn->hasNext()) {
        while ($row = $conn->hasNext()) {
            $ret->neighborhoods[] = $row;
        }

        $conn->closeConn();
        return $ret;
    }

    //put your code here
}
