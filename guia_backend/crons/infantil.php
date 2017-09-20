<?php

//header("Access-Control-Allow-Origin: *");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Import Libs
require '../vendor/autoload.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 *
 */
include '../GuiaController.php';
include '../GeocoderController.php';

GuiaController::cronEventCategory("view_infantil_ids", 2);


//7 lazer