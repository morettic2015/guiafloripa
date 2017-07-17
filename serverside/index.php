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
$app->get('/busca/{lat}/{lon}/{types}', function (Request $request, Response $response) use ($app) {
    //Content Type JSONP Cross Domain JSON
    $newResponse = $response->withHeader('Content-type', 'application/json');
    //Get Parameters
    $data = new stdClass();
	$data->lat = $request->getAttribute('lat');
    $data->lon = $request->getAttribute('lon');
    $data->types = $request->getAttribute('types');
    //Return Eventos for today
    $data->eventos = GuiaController::getEventosDeHoje($data);
    //Response Busca Hoje
    //echo "buscaHoje({})";
   

    return $newResponse->withJson($data, 201);
});

//Busca eventos de uma determinada data
$app->get('/busca/{lat}/{lon}/{types}/{from}/{to}', function (Request $request, Response $response) use ($app){
    //Content Type JSONP Cross Domain JSON
    //$app->contentType('application/javascript');
    //Get Parameters
    $data = new stdClass();
	$data->lat = $request->getAttribute('lat');
    $data->lon = $request->getAttribute('lon');
    $data->types = $request->getAttribute('types');
    $data->from = $request->getAttribute('from');
    $data->to = $request->getAttribute('to');
    //Return Eventos by date interval
    $eventos = GuiaController::getEventosDeHoje($data);
    //Response Busca Data    
    echo "buscaData({})";
});
$app->run();


