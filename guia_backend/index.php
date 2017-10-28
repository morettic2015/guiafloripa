<?php

/**
 * App de eventos Geolocalizados em Floripa.
 * 
 * www.guiafloripa.com.br
 * 
 * @Site https://app.guiafloripa.com.br
 * @Eventos e Estabelecimentos de Floripa
 * @DEV by Morettic.com.br
 * @Copyright (c) 2017, Morettic - Experiências Digitais
 * @Since Beta 1.2.5 2017-10-18
 * @Tutorial https://github.com/morettic2015/guiafloripa
 * @Partner http://www.experienciasdigitais.com.br
 * @Partner http://www.citywatch.com.br
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
require 'BugTracker.php';


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
 * @get A Place by id
 */
$app->get('/place/{id}', function (Request $request, Response $response) use ($app) {
    //Content Type JSON Cross Domain JSON
    //Cache 100 days
    $newResponse = $this->cache
            ->withExpires($response, time() + 3600 * 24 * 100)
            ->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //Return Eventos for today
    $data = new stdClass();
    $data->id = $request->getAttribute('id');
    $data = GuiaController::getPlaceById($data->id);
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
 * @Stats From Origin Destiny
 */
$app->get('/sync_stats/', function (Request $request, Response $response) use ($app) {
    $resWithExpires = $this->cache->withExpires($response, time() + 3600 * 24 *3);
    $newResponse = $resWithExpires->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $data = GuiaController::statsFromOriginDestiny();
    logActions("'/sync_stats/'");
    return $newResponse->withJson($data, 201);
});
/**
 * @Cron Run Once a Day 13:00 o Clock
 * @Push Send daily push by onesignal PushNotifications
 */
$app->get('/push/', function (Request $request, Response $response) use ($app) {
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $data = PushController::dailyNotification();
    logActions("PUSH");
    return $newResponse->withJson($data, 201);
});
/**
 * @Send anunciantes for integration
 * @Copy Lead to Mautic with a Specific Segment
 * * */
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
 * @Send issues to bugtracker webservice
 * @Endpoint for Mobile Issues!
 * * */
$app->post('/report/', function (Request $request, Response $response) use ($app) {
    $newResponse = $response->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'POST,GET');
    $dt = $request->getParsedBody();

    //var_dump($dt);die;

    $data = new stdClass();
    $data->title = filter_var($dt['title'], FILTER_SANITIZE_STRING);
    $data->desc = filter_var($dt['desc'], FILTER_SANITIZE_STRING);
    $data->desc .= " IP:" . get_client_ip();
    $data->id = BugTracker::addIssueBugTracker(10, 'Mobile', $data->title, $data->desc);

    logActions("BUG TRACKER");
    return $newResponse->withJson($data, 201);
});
/**
 * GET issues from Soap bugtracker webservice
 * @Endpoint for Mobile Issues!
 * * */
$app->get('/issues/', function (Request $request, Response $response) use ($app) {
    $resWithExpires = $this->cache->withExpires($response, time() + 3600 * 24);
    $newResponse = $resWithExpires->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'POST,GET');

    $data = BugTracker::getIssueBugTracker(10);
    logActions("/issues/");
    return $newResponse->withJson($data, 201);
});
//////////////////////////////////////////////////////////////////////////////
/**
 * @see /sync_* Only for integration purpouse 
 * @copyright (c) 2017, Moretto, LAMM <projetos@morettic.com.br>
 */
//////////////////////////////////////////////////////////////////////////////
/**
 * @Cron Service runs every 3 days only
 * @Sync Comer & Beber
 * */
$app->get('/sync_places_food/', function (Request $request, Response $response) use ($app) {
    GuiaController::updatePlacesByCategory("view_comer_beber", 1);
    logActions("SYNC PLACES FOOD");
    die();
});
/**
 * @Cron Service runs every 3 days only
 * @Sync Hospedagem
 * */
$app->get('/sync_places_hostage/', function (Request $request, Response $response) use ($app) {
    GuiaController::updatePlacesByCategory("view_hospedagem", 8);
    logActions("SYNC PLACES HOTEL");
    die();
});
/**
  @Cron Service runs every 3 days only
 * Sync Serviços Turísticos
 * */
$app->get('/sync_places_tourism/', function (Request $request, Response $response) use ($app) {
    GuiaController::updatePlacesByCategory("view_servico_turistico", 5);
    logActions("SYNC PLACES TOURISM");
    die();
});
/**
 * @Cron Service once a week on tuesday 9 o clock
 * @Sync service URLS
 */
$app->get('/sync_urls/', function (Request $request, Response $response) use ($app) {
    GuiaController::updateURLS();
    logActions("URL UPDATE");
    die();
});
/**
 * @Cron Service once a week on tuesday 9 o clock
 * @Sync Images from Events & Places
 */
$app->get('/sync_images/', function (Request $request, Response $response) use ($app) {
    GuiaController::updateImages();
    logActions("Sync Images");
    die();
});
/**
 * @Cron Manual Sync. Not called by Crontab -e
 */
$app->get('/sync_cinemas/', function (Request $request, Response $response) use ($app) {
    //header("Content-type: text/html; charset=iso");
    GuiaController::cronCinemas();
    GuiaController::updateURLS();
    logActions("CRON CINEMA");
    die();
});
/**
 * @Cron Manual Sync. Not called by Crontab -e
 */
$app->get('/sync_free/', function (Request $request, Response $response) use ($app) {
    GuiaController::cronEventCategory("view_gratuitos_ids", 9);
    GuiaController::updateURLS();
    logActions("EVENTS - FREE");
    die();
});
/**
 * @Cron Manual Sync. Not called by Crontab -e
 */
$app->get('/sync_cultura/', function (Request $request, Response $response) use ($app) {
    GuiaController::cronEventCategory("view_cultura_ids", 4);
    GuiaController::updateURLS();
    logActions("EVENTS - CULT");
    die();
});
/**
 * @Cron Manual Sync. Not called by Crontab -e
 */
$app->get('/sync_lazer/', function (Request $request, Response $response) use ($app) {
    GuiaController::cronEventCategory("view_lazer_ids", 7);
    GuiaController::updateURLS();
    logActions("EVENTS - LAZER");
    die();
});
/**
 * @Cron Manual Sync. Not called by Crontab -e
 */
$app->get('/sync_eventos/', function (Request $request, Response $response) use ($app) {
    GuiaController::cronEventCategory("view_eventos_ids", 6);
    GuiaController::updateURLS();
    logActions("EVENTS - EVENTS");
    die();
});
/**
 * @Cron Manual Sync. Not called by Crontab -e
 */
$app->get('/sync_infantil/', function (Request $request, Response $response) use ($app) {
    GuiaController::cronEventCategory("view_infantil_ids", 2);
    GuiaController::updateURLS();
    logActions("EVENTS - CHILD");
    die();
});
/**
 * @Sync Point
 */
$app->get('/sync_tourism_manual/{id}', function (Request $request, Response $response) use ($app) {
    $id = $request->getAttribute('id');
    GuiaController::updatePlacesByCategoryID("view_servico_turistico", 5, $id);
    logActions("/sync_tourism_manual/{id}");
    die();
});
/**
 * @Sync Point
 */
$app->get('/sync_host_manual/{id}', function (Request $request, Response $response) use ($app) {
    $id = $request->getAttribute('id');
    GuiaController::updatePlacesByCategoryID("view_hospedagem", 8, $id);
    logActions("/sync_host_manual/{id}");
    die();
});
/**
 * @Sync Point
 */
$app->get('/sync_comer_manual/{id}', function (Request $request, Response $response) use ($app) {
    $id = $request->getAttribute('id');
    GuiaController::updatePlacesByCategoryID("view_comer_beber", 1, $id);
    logActions("/sync_comer_manual/{id}");
    die();
});
/**
 * @Sync Point
 */
$app->get('/sync_recorrencias/', function (Request $request, Response $response) use ($app) {
    GuiaController::updateReccuringDates();
    logActions("/sync_recorrencias/");
    die();
});



/**
 * @Test purpouse
 * @ignore it only for Test
 */
$app->get('/test_case/', function (Request $request, Response $response) use ($app) {
    //GuiaController::testCinemas();
    //GuiaController::reverseImagesFromWordress(8948);
    $addr = GeocoderController::geocodeQuery("Rua Major Costa, 66, Centro, Florianópolis");
    echo "<pre>";
    var_dump($addr);
}); //Run Slim Microservice
$app->run();

/**
 * @Global Util Functions for Log date format and others
 * */

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

function tirarAcentos($string) {
    return strtr(utf8_decode($string), utf8_decode(
                    'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'), 'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
}
