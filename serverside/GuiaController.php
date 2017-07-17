<?php

//Database configuration
DB::$user = 'guia';
DB::$password = 'Gu14Fl0r1p@';
DB::$dbName = 'guiafloripa_app';
DB::$host = 'localhost';
DB::$port = '3306';
DB::$error_handler = 'my_error_handler';

class GuiaController extends stdClass{

    public static function getEventosDeHoje($object){
        //@todo
        //DB::query("SELECT * FROM Profile"); // misspelled SELECT

        return null;
    }  

}








/******
 *    Database Handlers
 */

function my_error_handler($params) {
  echo "Error: " . $params['error'] . "<br>\n";
  echo "Query: " . $params['query'] . "<br>\n";
  die; // don't want to keep going if a query broke
}