<?php

//header("Access-Control-Allow-Origin: *");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Import Libs
require './vendor/autoload.php';
require 'GuiaController.php';


//Init Objects
$app = new \Slim\App;
//$app->view(new \JsonApiView());
//$app->add(new \JsonApiMiddleware());
//Define Routes
//Busca Eventos de Hoje
$app->get('/busca/', function (Request $request, Response $response) use ($app) {
    //Content Type JSON Cross Domain JSON
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //Return Eventos for today
    $data = GuiaController::getEventosDeHoje();
    //Response Busca Hoje
    return $newResponse->withJson($data, 201);
});

//Busca eventos de uma determinada data
$app->get('/filtro/{types}/{from}/{to}', function (Request $request, Response $response) use ($app) {
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //StdObject for return
    $data = new stdClass();
    $data->types = $request->getAttribute('types');
    $data->from = $request->getAttribute('from');
    $data->to = $request->getAttribute('to');
    //Return Eventos by date interval
    $data = GuiaController::findEventosByDateType($data->from,$data->to,$data->types) ;
    
    //Response Busca Data
    return $newResponse->withJson($data, 201);
});
//Busca eventos de uma determinada data
$app->get('/synchronize', function (Request $request, Response $response) use ($app) {
     $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    require 'GuiaSynchronize.php';
    $data = GuiaSynchronize::getCinemas();
    return $newResponse->withJson($data, 201);
    //Response Busca Data
    //echo "ISSA";
});
//Busca eventos de uma determinada data
$app->get('/synchronize_places', function (Request $request, Response $response) use ($app) {
     $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    require 'GuiaSynchronize.php';
    $data = GuiaSynchronize::getPlaces();
    return $newResponse->withJson($data, 201);
    //Response Busca Data
    //echo "ISSA";
});
$app->run();



