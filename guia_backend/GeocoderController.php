<?php

use Geocoder\Query\GeocodeQuery;
use Http\Adapter\Guzzle6\Client;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\StatefulGeocoder;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeocoderController
 *
 * @author Morettic LTDA
 */
class GeocoderController extends stdClass {

    /**
      @API Geocode Google
     * @todo implement cache
     *      */
    public static final function geocodeQuery($address) {
        $adapter = new Client();
        $provider = new GoogleMaps($adapter);
        $geocoder = new StatefulGeocoder($provider, 'pt-BR');
        $result = $geocoder->geocodeQuery(GeocodeQuery::create($address));
        //Return object
        $geo = new stdClass();
        $obj = $result->first();
        $geo->formatted_address = $obj->getStreetName()
                . ", " . $obj->getPostalCode()
                . ", " . $obj->getSubLocality()
                . ", " . $obj->getAdminLevels()->get(2)->getName()
                . ", " . $obj->getAdminLevels()->first()->getName();
        $geo->lat = $obj->getCoordinates()->getLatitude();
        $geo->lng = $obj->getCoordinates()->getLongitude();
        $geo->cep = $obj->getPostalCode();
        //var_dump($geo);
        return $geo;
    }
}
