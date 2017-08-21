<?php

//header("Access-Control-Allow-Origin: *");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Import Libs
require './vendor/autoload.php';
require 'GuiaController.php';
require 'ProfileController.php';
require 'PushController.php';


/**
 *   @Services to supply mobile client
 *  */
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
    $data = GuiaController::findEventosByDateType($data->from, $data->to, $data->types);

    //Response Busca Data
    return $newResponse->withJson($data, 201);
});

//Busca eventos de uma determinada data
$app->get('/profile/{email}/{name}/{userId}/{pushToken}', function (Request $request, Response $response) use ($app) {
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //StdObject for return
    $data = new stdClass();
    $data->email = $request->getAttribute('email');
    $data->name = $request->getAttribute('name');
    $data->userId = $request->getAttribute('userId');
    $data->pushToken = $request->getAttribute('pushToken');
    //Return Eventos by date interval
    $data = ProfileController::insertUpdateProfile($data);

    //Response Busca Data
    return $newResponse->withJson($data, 201);
});

/**
 * @Sync Services
 */
$app->get('/sync', function (Request $request, Response $response) use ($app) {
    shell_exec("/var/www/guiafloripa.morettic.com.br/crons/cron_guia.sh");
});

$app->get('/push/', function (Request $request, Response $response) use ($app) {
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $data = PushController::dailyNotification();

    return $newResponse->withJson($data, 201);
});

$app->run();



