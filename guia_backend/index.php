<?php

/**
 * @App.Guiafloripa.com.br
 * @Eventos e Estabelecimentos de Floripa
 * @DEV by Morettic.com.br
 * @experienciasdigitais.com.br
 * @citywatch.com.br parceiro
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

//use Controller;
//Import Libs
require './vendor/autoload.php';
require 'GuiaController.php';
require 'ProfileController.php';
require 'PushController.php';
require 'LeadController.php';
require 'GeocoderController.php';
require 'CinemaController.php';


/**
 * @Create a Cache to improve perfomance on resquest response handler 24 hours cache
 * Register service provider with the container
 * Add middleware to the application
 * */
$container = new \Slim\Container;
$container['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};
$app = new \Slim\App($container);
$app->add(new \Slim\HttpCache\Cache('public', 86400));
/* $configuration = [
  'settings' => [
  'displayErrorDetails' => true,
  ],
  ];
  $c = new \Slim\Container($configuration);
  $app = new \Slim\App($c); */
/**
 * @Search //Define Routes //Busca Eventos de Hoje
 */
$app->get('/busca/', function (Request $request, Response $response) use ($app) {
    //Content Type JSON Cross Domain JSON
    //Cache 24 hours
    $resWithExpires = $this->cache->withExpires($response, time() + 3600 * 24);
    $newResponse = $resWithExpires->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //Return Eventos for today
    $data = GuiaController::getEventosDeHoje();
    logActions("BUSCA");
    //Response Busca Hoje
    return $newResponse->withJson($data, 201);
});
/**
 * @Search for Places
 */
$app->get('/estabelecimentos/{types}', function (Request $request, Response $response) use ($app) {
    //Content Type JSON Cross Domain JSON
    //Cache 24 hours
    $resWithExpires = $this->cache->withExpires($response, time() + 3600 * 24);
    $newResponse = $resWithExpires->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //Return Eventos for today
    $data = new stdClass();
    $data->types = $request->getAttribute('types');
    $data = GuiaController::getPlacesByType($data);
    logActions("estabelecimentos");
    //Response Busca Hoje
    return $newResponse->withJson($data, 201);
});
/**
 * @SEarch for events in a given date
 * Busca eventos de uma determinada data
 */
$app->get('/filtro/{types}/{from}/{to}', function (Request $request, Response $response) use ($app) {
    //Cache 24 hours
    $resWithExpires = $this->cache->withExpires($response, time() + 3600 * 24);
    $newResponse = $resWithExpires->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //StdObject for return
    $data = new stdClass();
    $data->types = $request->getAttribute('types');
    $data->from = $request->getAttribute('from');
    $data->to = $request->getAttribute('to');
    //Return Eventos by date interval
    if ($data->types == 3) {
        //$data = new stdClass();
        $data->e = CinemaController::loadCinemaPlaces($data->from, $data->to);
    } else {
        $data = GuiaController::findEventosByDateType($data->from, $data->to, $data->types);
    }
    logActions("FILTRO");
    //Response Busca Data
    return $newResponse->withJson($data, 201);
});
/**
  @Integration Atualiza o perfil e manda para a integração com Mautic e OneSignal Push Notifications
  @Connect to Mautic and OneSignal Push Notifications
 *  */
$app->get('/profile/{email}/{name}/{userId}/{pushToken}', function (Request $request, Response $response) use ($app) {
    $resWithExpires = $this->cache->withExpires($response, time() + 3600 * 24);
    $newResponse = $resWithExpires->withHeader('Content-type', 'application/json')
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
    logActions("PROFILE");
    //Response Busca Data
    return $newResponse->withJson($data, 201);
});

/**
 * @Cron Run Once a Day 13:00 o Clock
 */
//Send daily push by onesignal PushNotifications
$app->get('/push/', function (Request $request, Response $response) use ($app) {
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $data = PushController::dailyNotification();
    logActions("PUSH");
    return $newResponse->withJson($data, 201);
});
//Send anunciantes for integration
$app->get('/anunciantes/', function (Request $request, Response $response) use ($app) {
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $data = ProfileController::insertLeadAnunciantes();
    logActions("LEADS ANUNCIANTES");
    return $newResponse->withJson($data, 201);
});
/**
  @Cron Service runs every 3 days only
 * Sync Comer & Beber
 * */
$app->get('/sync_places_food/', function (Request $request, Response $response) use ($app) {
    GuiaController::updatePlacesByCategory("view_comer_beber", 1);
});
/**
  @Cron Service runs every 3 days only
 * Sync Hospedagem
 * */
$app->get('/sync_places_hostage/', function (Request $request, Response $response) use ($app) {
    GuiaController::updatePlacesByCategory("view_hospedagem", 8);
});
/**
  @Cron Service runs every 3 days only
 * Sync Serviços Turísticos
 * */
$app->get('/sync_places_tourism/', function (Request $request, Response $response) use ($app) {
    GuiaController::updatePlacesByCategory("view_servico_turistico", 5);
});
/**
 * @Cron Service once a week on tuesday 9 o clock
 * @Sync service URLS
 */
$app->get('/sync_urls/', function (Request $request, Response $response) use ($app) {
    GuiaController::updateURLS();
}); //Run Slim Microservice
$app->get('/test_cinema/', function (Request $request, Response $response) use ($app) {
    GuiaController::testCinemas();
}); //Run Slim Microservice
$app->run();

/**
 * @Monolog log actions from requests
 */
function logActions($action) {
    //Init log file
    $log = new Logger('MainLoger');
    $log->pushHandler(new StreamHandler(__DIR__ . '/request.log', Logger::INFO));
    $logMsg = $action;
    $logMsg .= " / ";
    $logMsg .= time();
    $logMsg .= " / ";
    $logMsg .= get_client_ip();
    $logMsg .= "/n";
    $log->info($logMsg);
}

/**
 * @Get IP from differente request and headers
 */
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if (getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if (getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if (getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}
