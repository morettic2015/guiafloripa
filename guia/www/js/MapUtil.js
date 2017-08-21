
/**
 * @Classe Utilitiaria do APP
 * @Morettic.com.br
 * @DEV: por Luis Augusto Machado Moretto
 * @EMAIL: projetos@morettic.com.br
 * @UIX: João GUilherme de Oliveira
 * @EMAIL: jgoliveira78@hotmail.com
 */

var map;
var lat;
var lng;
var mapUtils;
var lEventos;
var directionsService;
var directionsDisplay;
var markers = new Array();
var notificationOpenedCallback;
var watcherPosition = null;

var MapUtils = function() {
    //Get Pin Type Based on TYPE from Marker
    this.getIcon = function(id) {
        icon = null;
        mId = parseInt(id);
        switch (mId) {
            case 1:
                icon = "./img/pin_5.png";
                break;
            case 2:
                icon = "./img/pin_7.png";
                break;
            case 3:
                icon = "./img/pin_3.png";
                break;
            case 4:
                icon = "./img/pin_2.png";
                break;
            case 5:
                icon = "./img/pin_8.png";
                break;
            case 6:
                icon = "./img/pin_4.png";
                break;
            case 7:
                icon = "./img/pin_1.png";
                break;
            case 8:
                icon = "./img/pin_6.png";
                break;
            case 9:
                icon = "./img/pin_9.png";
                break;
        }
        return icon;
    }
    /**
     * Remove all markers from map
     */
    this.clearAllPinsFromMap = function() {
        for (i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        //Init markers
        markers = new Array();
        //Clear path
        if (directionsDisplay != null)
            directionsDisplay.setMap(null);
    }


    this.createInfoWindowDef = function() {
        return new google.maps.InfoWindow({
            content: "holding...",
            maxHeight: 200,
            maxWidth: 220
        });
    }

    this.requestPin = function(pinType, dtInit, dtFim) {
        //Requisição ao server side
        mapUtils.clearAllPinsFromMap();
        var url1 = "https://guiafloripa.morettic.com.br/filtro/" + pinType + "/" + dtInit + "/" + dtFim;
        $.get(url1, function(data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            //Lista de eventos
            lEventos = data.e;

            mapUtils.showMessage("Total de resultados:" + lEventos.length, "#454545");

            infowindow = mapUtils.createInfoWindowDef();

            for (i = 0; i < lEventos.length; i++) {
                icon = null;

                markers[i] = new google.maps.Marker({
                    //alert()
                    position: new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                    map: map,
                    title: lEventos[i].idType,
                    indice: i,
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                        url: mapUtils.getIcon(lEventos[i].idType),
                        //size: new google.maps.Size(24, 13), // size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    },
                });
                /*lEventos[i].distance = google.maps.geometry.spherical.computeDistanceBetween(
                 new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                 new google.maps.LatLng(lat, lng));*/
                google.maps.event.addListener(markers[i], 'click', function() {
                    // this.setMap(null);
                    this.animation = null;
                    this.setMap(map);
                    var dist = mapUtils.calculateDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                    var content = '<h1>' + lEventos[this.indice].deEvent + '</h1><br>';

                    if (lEventos[this.indice].deLogo !== "default") {
                        content += '<center><img src="' + lEventos[this.indice].deLogo
                                + '" width="60"></center>'
                    }
                    content += '<p>'
                            + lEventos[this.indice].deDetail
                            + '<br><b>Distância:</b>'
                            + dist;
                    +'</p> </a></li>';

                    /* infowindow.setContent("<img width='60' src='"
                     + lEventos[this.indice].deLogo
                     + "'/>"
                     + lEventos[this.indice].deDetail
                     + "<br>"
                     + dist);*/
                    infowindow.setContent(content);
                    infowindow.open(map, this);
                    mapUtils.showDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                });

            }

            posFinal = markers.length;
            markers[posFinal] = new google.maps.Marker({
                //alert()
                position: new google.maps.LatLng(lat, lng),
                map: map,
                title: "Você",
                indice: posFinal,
                animation: google.maps.Animation.BOUNCE,
            });
            // mapUtils.clusterOption(map, markers);
        });
    }



    /**
     * @ Call to show only today events
     */
    this.showWhatsGoingOn = function() {
        this.clearAllPinsFromMap();
        $.get("https://guiafloripa.morettic.com.br/busca/", function(data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            //Lista de eventos
            lEventos = data.e;

            infowindow = mapUtils.createInfoWindowDef();

            for (i = 0; i < lEventos.length; i++) {
                icon = null;

                markers[i] = new google.maps.Marker({
                    //alert()
                    position: new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                    map: map,
                    title: lEventos[i].idType,
                    indice: i,
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                        url: mapUtils.getIcon(lEventos[i].idType),
                        //size: new google.maps.Size(24, 13), // size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    },
                });
                /*lEventos[i].distance = google.maps.geometry.spherical.computeDistanceBetween(
                 new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                 new google.maps.LatLng(lat, lng));*/
                google.maps.event.addListener(markers[i], 'click', function() {
                    // this.setMap(null);
                    this.animation = null;
                    this.setMap(map);
                    var dist = mapUtils.calculateDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                    var content = '<h1>' + lEventos[this.indice].deEvent + '</h1><br>';

                    if (lEventos[this.indice].deLogo !== "default") {
                        content += '<center><img src="' + lEventos[this.indice].deLogo
                                + '" width="60"></center>'
                    }
                    content += '<p>'
                            + lEventos[this.indice].deDetail
                            + '<br><b>Distância:</b>'
                            + dist;
                    +'</p> </a></li>';

                    /* infowindow.setContent("<img width='60' src='"
                     + lEventos[this.indice].deLogo
                     + "'/>"
                     + lEventos[this.indice].deDetail
                     + "<br>"
                     + dist);*/
                    infowindow.setContent(content);
                    infowindow.open(map, this);
                    mapUtils.showDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                });

            }

            posFinal = markers.length;
            markers[posFinal] = new google.maps.Marker({
                //alert()
                position: new google.maps.LatLng(lat, lng),
                map: map,
                title: "Você",
                indice: posFinal,
                animation: google.maps.Animation.BOUNCE,
            });
            //mapUtils.clusterOption(map, markers);
        });
    }
    /**
     * @Called on load to show today events
     */
    this.sucessLoad = function(position) {
        //Init directions service
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        //Set Coordinates
        lat = position.coords.latitude;
        lng = position.coords.longitude;
        //Init map at floripa center of it
        var myLatlng = new google.maps.LatLng(-27.59226, -48.54902);
        //Set map options
        var mapOptions = {
            zoom: 14,
            center: myLatlng,
            styles: this.getMapStyle(),
            mapTypeControl: false,
            gestureHandling: "greedy",
            streetViewControl: false,
            disableDefaultUI: false
        }
        //Init Map from HTML Canvas
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        directionsDisplay.setMap(map);
        //Hide A- B Markers from directions
        directionsDisplay.setOptions({suppressMarkers: true});

        //Requisição ao server side
        $.get("https://guiafloripa.morettic.com.br/busca/", function(data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            //Lista de eventos
            lEventos = data.e;

            infowindow = mapUtils.createInfoWindowDef();

            for (i = 0; i < lEventos.length; i++) {
                icon = null;

                markers[i] = new google.maps.Marker({
                    //alert()
                    position: new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                    map: map,
                    title: lEventos[i].idType,
                    indice: i,
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                        url: mapUtils.getIcon(lEventos[i].idType),
                        //size: new google.maps.Size(24, 13), // size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    },
                });
                /*lEventos[i].distance = google.maps.geometry.spherical.computeDistanceBetween(
                 new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                 new google.maps.LatLng(lat, lng));*/
                google.maps.event.addListener(markers[i], 'click', function() {
                    // this.setMap(null);
                    this.animation = null;
                    this.setMap(map);
                    var dist = mapUtils.calculateDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                    var content = '<h1>' + lEventos[this.indice].deEvent + '</h1><br>';

                    if (lEventos[this.indice].deLogo !== "default") {
                        content += '<center><img src="' + lEventos[this.indice].deLogo
                                + '" width="60"></center>'
                    }
                    content += '<p>'
                            + lEventos[this.indice].deDetail
                            + '<br><b>Distância:</b>'
                            + dist;
                    +'</p> </a></li>';

                    /* infowindow.setContent("<img width='60' src='"
                     + lEventos[this.indice].deLogo
                     + "'/>"
                     + lEventos[this.indice].deDetail
                     + "<br>"
                     + dist);*/
                    infowindow.setContent(content);
                    infowindow.open(map, this);
                    mapUtils.showDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                });

            }

            posFinal = markers.length;
            markers[posFinal] = new google.maps.Marker({
                //alert()
                position: new google.maps.LatLng(lat, lng),
                map: map,
                title: "Você",
                indice: posFinal,
                animation: google.maps.Animation.BOUNCE,
            });
            //mapUtils.clusterOption(map, markers);
        });
    }
    /**
     * @Calculate distance from two diferent coordinates in KM
     * */
    this.calculateDistance = function(lat1, long1, lat2, long2) {

        //radians
        lat1 = (lat1 * 2.0 * Math.PI) / 60.0 / 360.0;
        long1 = (long1 * 2.0 * Math.PI) / 60.0 / 360.0;
        lat2 = (lat2 * 2.0 * Math.PI) / 60.0 / 360.0;
        long2 = (long2 * 2.0 * Math.PI) / 60.0 / 360.0;


        // use to different earth axis length
        var a = 6378137.0;        // Earth Major Axis (WGS84)
        var b = 6356752.3142;     // Minor Axis
        var f = (a - b) / a;        // "Flattening"
        var e = 2.0 * f - f * f;      // "Eccentricity"

        var beta = (a / Math.sqrt(1.0 - e * Math.sin(lat1) * Math.sin(lat1)));
        var cos = Math.cos(lat1);
        var x = beta * cos * Math.cos(long1);
        var y = beta * cos * Math.sin(long1);
        var z = beta * (1 - e) * Math.sin(lat1);

        beta = (a / Math.sqrt(1.0 - e * Math.sin(lat2) * Math.sin(lat2)));
        cos = Math.cos(lat2);
        x -= (beta * cos * Math.cos(long2));
        y -= (beta * cos * Math.sin(long2));
        z -= (beta * (1 - e) * Math.sin(lat2));

        return (Math.sqrt((x * x) + (y * y) + (z * z)) / 10) + " KM";
    }
    /**
     * @ Map Style
     * */
    this.getMapStyle = function() {
        return [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    },
                    {
                        "visibility": "on"
                    },
                    {
                        "hue": "#ff0000"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#b4d4e1"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    }
    /**
     * @Welcome message
     * */
    this.showWelcome = function() {
        this.showMessage("Bem vindo ao APP do Guiafloripa. Pesquise os eventos perto de você!", "#454545");
    }
    /**
     * @GPS Exception
     * */
    this.showNoGPS = function() {
        window.location.href = "gps.html";
        setTimeout(cordova.plugins.diagnostic.switchToLocationSettings(), 3000);
    }

    /**
     * @Messagem Manager method
     * */
    this.showMessage = function(msg, corDialog) {
        window.plugins.toast.showWithOptions({
            message: msg,
            duration: 6000, // 2000 ms
            position: "top",
            styling: {
                opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
                backgroundColor: corDialog, // make sure you use #RRGGBB. Default #333333
                textColor: '#ffffff', // Ditto. Default #FFFFFF
                textSize: 20.5, // Default is approx. 13.
                cornerRadius: 5, // minimum is 0 (square). iOS default 20, Android default 100
                horizontalPadding: 20, // iOS default 16, Android default 50
                verticalPadding: 16 // iOS default 12, Android default 30
            }
        });
    }
    this.initSliderMenu = function() {
        $("#flexiselDemo1").flexisel({
            visibleItems: 3,
            clone: false,
        });
    }

    this.setBorderStyle = function(element, name, id) {
        res = element.src.split("_");
        pos = res.length - 1;
        element.src = res[pos] == "on.png" ? "./img/" + name + "_off.png" : "./img/" + name + "_on.png";
        //alert($('#dtinicio').val());
        pdtInit = $('#dtinicio').val() == "" ? "-1" : $('#dtinicio').val();
        pdtFim = $('#dtfim').val() == "" ? "-1" : $('#dtfim').val();
        //alert(pdtInit);
        //alert(pdtFim);
        this.requestPin(id, pdtInit, pdtFim);
    }
    /**
     * Init Push Notifications
     */
    this.initPush = function() {
        notificationOpenedCallback = function(jsonData) {
            console.log('notificationOpenedCallback: ' + JSON.stringify(jsonData));
        };

        window.plugins.OneSignal
                .startInit("c452ff74-3bc4-44ca-a015-bfdaf0779354")
                .handleNotificationOpened(notificationOpenedCallback)
                .endInit();
        //Save userId and pushToken on Database (localstorage)
        window.plugins.OneSignal.getIds(function(ids) {
            console.log('getIds: ' + JSON.stringify(ids));
            //alert("userId = " + ids.userId + ", pushToken = " + ids.pushToken);
            localStorage.setItem("pushToken", ids.pushToken);
            localStorage.setItem("userId", ids.userId);
        });
    }
    /**
     * @ Calculate Distance from two points
     * **/
    this.showDistance = function(pLat, pLng, oLat, oLng) {
        var start = new google.maps.LatLng(oLat, oLng);
        //var end = new google.maps.LatLng(38.334818, -181.884886);
        var end = new google.maps.LatLng(pLat, pLng);

        var bounds = new google.maps.LatLngBounds();
        bounds.extend(start);
        bounds.extend(end);
        map.fitBounds(bounds);
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
            } else {
                console.log("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
            }
        });
    }
    this.initAds = function() {
        if (window.plugins && window.plugins.AdMob) {
            var ad_units = {
                ios: {
                    banner: 'ca-app-pub-5450650045028162/7776401911', //PUT ADMOB ADCODE HERE
                    interstitial: 'ca-app-pub-5450650045028162/2653913659'	//PUT ADMOB ADCODE HERE
                },
                android: {
                    banner: 'ca-app-pub-5450650045028162/7776401911', //PUT ADMOB ADCODE HERE
                    interstitial: 'ca-app-pub-5450650045028162/2653913659'	//PUT ADMOB ADCODE HERE
                }
            };
            var admobid = (/(android)/i.test(navigator.userAgent)) ? ad_units.android : ad_units.ios;

            window.plugins.AdMob.setOptions({
                publisherId: admobid.banner,
                interstitialAdId: admobid.interstitial,
                adSize: window.plugins.AdMob.AD_SIZE.SMART_BANNER, //use SMART_BANNER, BANNER, LARGE_BANNER, IAB_MRECT, IAB_BANNER, IAB_LEADERBOARD
                bannerAtTop: false, // set to true, to put banner at top
                overlap: true, // banner will overlap webview
                offsetTopBar: false, // set to true to avoid ios7 status bar overlap
                isTesting: false, // receiving test ad
                autoShow: false // auto show interstitial ad when loaded
            });

            //registerAdEvents();
            //window.plugins.AdMob.createInterstitialView();	//get the interstitials ready to be shown
            //window.plugins.AdMob.requestInterstitialAd();
            window.plugins.AdMob.createBannerView();

            setInterval(window.plugins.AdMob.requestInterstitialAd(), 10000);
        } else {
            //alert( 'admob plugin not ready' );
        }
    }

    this.finishGPSTimer = function() {
        try {
            navigator.geolocation.clearWatch(watcherPosition);
        } catch (e) {
            console.log(e)
        }
    }
    //
    this.initGPSTimer = function() {
        watcherPosition = navigator.geolocation.watchPosition(
                function(pos) {
                    alert(pos.coords.latitude);
                },
                function(error) {
                    alert('code: ' + error.code + '\n' +
                            'message: ' + error.message + '\n');
                },
                {
                    timeout: 30000,
                    enableHighAccuracy: true
                });
    }

    this.clusterOption = function(map, markers) {
        var voptions = {
            imagePath: 'img/m'
        };

        var markerCluster = new MarkerClusterer(map, markers, voptions);
    }
}

