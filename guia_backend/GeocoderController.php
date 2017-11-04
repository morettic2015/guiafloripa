<?php

use Geocoder\Query\GeocodeQuery;
use Http\Adapter\Guzzle6\Client;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Provider\ArcGISOnline\ArcGISOnline;
use Geocoder\Provider\BingMaps\BingMaps;
use Geocoder\Provider\LocationIQ\LocationIQ;
//use Geocoder\Provider\Geonames\Geonames;
use Geocoder\StatefulGeocoder;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
const BING_KEY = "890Qc3i1ozx24NzBIVqb~_rQckxzVlKYKLkNyEhjlcA~Apy5uU2wxXOal0ax-_XB20zMhSaNqQdI07gK5vq2D-Pedil14SRuV7qQYXKrQ0QK";
const GOOG_KEY = "AIzaSyAloOipSzJQrHYmhsBJ9asnw0tp4FnYw8E";
const LOCA_KEY = "9cf4ad45b4a768";

/**
 * Description of GeocoderController
 * $_SERVER['GOOGLE_GEOCODING_KEY']
 * @author Morettic LTDA
 */
class GeocoderController extends stdClass {

    /**
      @API Geocode Google
     * @todo implement cache
     *      */
    public static final function geocodeQuery($address) {
        //$_SERVER['GOOGLE_GEOCODING_KEY'] = GOOG_KEY;
        $address = str_replace("-", ",", $address);
        if (strlen($address) < 5) {
            return false;
        }
        $secs = intval(date("s"));
        $provider = null;
        $adapter = new Client();
        $geo = new stdClass();
        if (($secs % 3) === 0) {//If mod 4 = 0 Geoname
            $provider = new BingMaps($adapter, BING_KEY);
            $geo->proviver = "BIN";
        } else if (($secs % 5) === 0) {//If mode 3 = 0 Google Maps
            $provider = new GoogleMaps($adapter);
            $geo->proviver = "GOO";
        } else {//Argis
            /*$provider = new BingMaps($adapter, BING_KEY);
            $geo->proviver = "BIN";*/
            $provider = new ArcGISOnline($adapter, "BR");
            $geo->proviver = "ARC";
        }/* else {
          $provider = new LocationIQ($adapter, LOCA_KEY);
          $geo->proviver = "LOC";
          } */
        $geo->secs = $secs;
        ;
        // var_dump($geo);die;
        $geocoder = new StatefulGeocoder($provider, 'pt_BR');

        $result = $geocoder->geocodeQuery(GeocodeQuery::create($address));

        try {

            //var_dump($result);die;

            $obj = $result->first();

            //var_dump($obj);die;

            $geo->formatted_address = $obj->getStreetName()
                    . ", " . $obj->getPostalCode()
                    . ", " . $obj->getSubLocality()
                    . ", " . $obj->getAdminLevels()->get(0)->getName()
                    . ", " . $obj->getAdminLevels()->first()->getName();
        } catch (Geocoder\Exception\CollectionIsEmpty $e) {
            var_dump($e);
            //GeocoderController::geocodeQuery($address);
            return $geo;
        } catch (Exception $e) {
            //echo "\n";
            //echo $address;
            //echo "\n";
            $geo->formatted_address = $obj->getStreetName()
                    . ", " . $obj->getPostalCode()
                    . ", " . $obj->getSubLocality()
                    . ", " . $obj->getAdminLevels()->first()->getName();
        }
        $geo->lat = $obj->getCoordinates()->getLatitude();
        $geo->lng = $obj->getCoordinates()->getLongitude();
        $geo->cep = $obj->getPostalCode();
        //var_dump($geo);
        return $geo;
    }

}
