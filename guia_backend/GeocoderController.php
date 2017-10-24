<?php

use Geocoder\Query\GeocodeQuery;
use Http\Adapter\Guzzle6\Client;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Provider\ArcGISOnline\ArcGISOnline;
use Geocoder\Provider\Geonames\Geonames;
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
        if (strlen($address) < 5) {
            return false;
        }
        $secs = intval(date("s"));
        $provider = null;
        $adapter = new Client();

        /*if (($secs % 4) < 1) {//If mod 4 = 0 Geoname
            $provider = new Geonames($adapter,'username');
            echo 'geo';
        } else*/
        if (($secs % 3) < 1) {//If mode 3 = 0 Google Maps
            $provider = new GoogleMaps($adapter);
            echo 'goo';
        } else {//Argis
            $provider = new ArcGISOnline($adapter);
            echo 'arc';
        }
        //var_dump($provider);

        $geocoder = new StatefulGeocoder($provider, 'pt-BR');
        $result = $geocoder->geocodeQuery(GeocodeQuery::create($address));
        //Return object
        $geo = new stdClass();

        try {
            $obj = $result->first();
            $geo->formatted_address = $obj->getStreetName()
                    . ", " . $obj->getPostalCode()
                    . ", " . $obj->getSubLocality()
                    . ", " . $obj->getAdminLevels()->get(2)->getName()
                    . ", " . $obj->getAdminLevels()->first()->getName();
        } catch (Geocoder\Exception\CollectionIsEmpty $e) {
            return null;
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
