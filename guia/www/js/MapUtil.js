
/**
 * @Classe Utilitiaria do APP
 * @Morettic.com.br
 * @DEV: por Luis Augusto Machado Moretto
 * @EMAIL: projetos@morettic.com.br
 * @UIX: João GUilherme de Oliveira
 * @EMAIL: jgoliveira78@hotmail.com
 */
var zoom = 10;
var map;
var lat, latZ;
var lng, lngZ;
var mapUtils;
var lEventos;
var directionsService;
var directionsDisplay;
var markers = new Array();
var notificationOpenedCallback;
var watcherPosition = null;
var markerCluster = null;
//var myLoader;

var MapUtils = function () {
    //Get Pin Type Based on TYPE from Marker
    this.getIcon = function (id) {
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
    this.clearAllPinsFromMap = function () {
        for (i = 0; i < lEventos.length; i++) {//Release memory...
            lEventos[i] = null;
        }
        lEventos.length = 0;//release memory
        //lEventos = null;//release memory
        for (i = 0; i < markers.length; i++) {
            markers[i].setMap(null); //Release from map
            markers[i] = null; //Release from memory
        }
        //Init markers
        markers = [];
        //Clear path
        if (directionsDisplay != null) {
            directionsDisplay.setMap(null);
        }
    }


    this.createInfoWindowDef = function () {
        return new google.maps.InfoWindow({
            content: "holding...",
            maxHeight: 200,
            maxWidth: 220
        });
    }

    this.requestPin = function (pinType, dtInit, dtFim) {
        //myLoader.show();
        //Requisição ao server side
        mapUtils.clearAllPinsFromMap();
        var url1 = "https://guiafloripa.morettic.com.br/filtro/" + pinType + "/" + dtInit + "/" + dtFim;
        $.get(url1, function (data, status) {
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
                    title: lEventos[i].deEvent,
                    indice: i,
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                        url: mapUtils.getIcon(lEventos[i].idType),
                        size: new google.maps.Size(32, 51), // size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 51) // anchor
                    },
                });
                /*lEventos[i].distance = google.maps.geometry.spherical.computeDistanceBetween(
                 new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                 new google.maps.LatLng(lat, lng));*/
                google.maps.event.addListener(markers[i], 'click', function () {
                    // this.setMap(null);
                    this.animation = null;
                    this.setMap(map);
                    //                    var dist = mapUtils.calculateDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                    //                    var img = (lEventos[this.indice].deLogo === "default" || lEventos[this.indice].deLogo === "") ? lEventos[this.indice].deImg : lEventos[this.indice].deLogo;

                    InfoWindowT(lEventos[this.indice], lat, lng);
                    //                    mapUtils.showDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
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
            mapUtils.clusterOption(map, markers);
            //myLoader.hide();
        });
    }

    this.requestPlaces = function (pinType) {
        //Requisição ao server side
        mapUtils.clearAllPinsFromMap();
        var url1 = "https://guiafloripa.morettic.com.br/estabelecimentos/" + pinType;
        var lcache = localStorage.getItem("estabelecimentos/" + pinType);
        var lEventos;
        if (lcache !== null) {
            lEventos = JSON.parse(lcache);
            mapUtils.makeMarkersFromPlaces(lEventos);
        } else {
            $.get(url1, function (data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                //Lista de eventos
                lEventos = data.e;
                localStorage.setItem("estabelecimentos/" + pinType, JSON.stringify(lEventos));
                mapUtils.makeMarkersFromPlaces(lEventos);
            });
        }
    }

    this.makeMarkersFromPlaces = function (lEventos) {
        for (i = 0; i < lEventos.length; i++) {
            icon = null;

            markers[i] = new google.maps.Marker({
                //alert()
                position: new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                map: map,
                title: lEventos[i].nmPlace,
                indice: i,
                animation: google.maps.Animation.DROP,
                icon: {
                    url: mapUtils.getIcon(lEventos[i].idType),
                    size: new google.maps.Size(32, 51), // size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(0, 51) // anchor
                },
            });
            /*lEventos[i].distance = google.maps.geometry.spherical.computeDistanceBetween(
             new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
             new google.maps.LatLng(lat, lng));*/
            google.maps.event.addListener(markers[i], 'click', function () {
                // this.setMap(null);
                this.animation = null;
                this.setMap(map);
                //var dist = mapUtils.calculateDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
                //var img = lEventos[this.indice].deLogo;
                InfoWindowT(lEventos[this.indice], lat, lng);
                //mapUtils.showDistance(lEventos[this.indice].nrLat, lEventos[this.indice].nrLng, lat, lng);
            });

        }
        mapUtils.showMessage("Total de resultados:" + lEventos.length, "#454545");

        infowindow = mapUtils.createInfoWindowDef();

        posFinal = markers.length;
        markers[posFinal] = new google.maps.Marker({
            //alert()
            position: new google.maps.LatLng(lat, lng),
            map: map,
            title: "Você",
            indice: posFinal,
            animation: google.maps.Animation.BOUNCE,
        });
        mapUtils.clusterOption(map, markers);
    }
    /**
     * @ Call to show only today events
     */
    this.showWhatsGoingOn = function () {
        this.clearAllPinsFromMap();
        $.get("https://guiafloripa.morettic.com.br/busca/", function (data, status) {
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
                    title: lEventos[i].deEvent,
                    indice: i,
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                        url: mapUtils.getIcon(lEventos[i].idType),
                        size: new google.maps.Size(32, 51), // size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 51) // anchor
                    },
                });
                google.maps.event.addListener(markers[i], 'click', function () {
                    // this.setMap(null);
                    this.animation = null;
                    this.setMap(map);
                    InfoWindowT(lEventos[this.indice], lat, lng);
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
            mapUtils.clusterOption(map, markers);
        });
    }
    /**
     * @Focus map again after close Detail Window.
     * */
    this.focusMap = function () {
        //navigator.splashscreen.show();
        setTimeout(function () {
            try {
                map.setCenter({lat: parseFloat(latZ), lng: parseFloat(lngZ)});
                //map.setCenter(new google.maps.LatLng(lat, lng));
                map.setZoom(zoom);
                mapUtils.initSliderMenu();
            } catch (e) {//Capture error from ZOOM
                exceptHandler.report(device, e.toString(), e.fileName, e.lineNumber, e.columnNumber, e.description);
            } finally {
                //navigator.splashscreen.hide();
            }
        }, 100);
    }

    this.showList = function () {
        this.showList1(null);
    }
    this.showList1 = function (o) {
        var jsonStr = localStorage.getItem("todayEvents");
        $("#titFav").html("O que há pra hoje?");
        if (o !== null) {
            $("#titFav").html("Meus favoritos");
            jsonStr = localStorage.getItem("fav");
        }
        var lEventos = JSON.parse(jsonStr);
        var contentList = '<div style="width: 300px">';

        for (i = 0; i < lEventos.length; i++) {
            var image = lEventos[i].deLogo === "default" ? "img/icone.png" : lEventos[i].deLogo;
            var deEvent = lEventos[i].deEvent === undefined ? "" : lEventos[i].deEvent;
            var printDate = (lEventos[i].printDate === undefined) ? "" : lEventos[i].printDate;
            var nrPhone = (lEventos[i].nrPhone===null)?"":lEventos[i].nrPhone;
            contentList += '<fieldset class="ui-grid-a">'
                    + '<div class="ui-block-a" style="width: 35% !important;"><img width="96" height="96" src="' + image + '"></div>'
                    + '<div class="ui-block-b" style="width: 64% !important;"><h3>' + lEventos[i].nmPlace + '</h3><p><small>' + deEvent + '</small></p></div>'
                    + '</fieldset><p><center class="smallTxt">'
                    + lEventos[i].deAddress
                    + "<br><br><b>"
                    + printDate
                    + '</b><br><br>'
                    + nrPhone
                    + '<br><br>'
                    + mapUtils.calculateDistance(lat,lng,lEventos[i].nrLat,lEventos[i].nrLng)
                    + '<fieldset class="ui-grid-c">'
                    + '<div class="ui-block-a">'
                    + '<a href="javascript:myFavorites.linkFavorite('+i+')" style="margin:0.5em 10px;" class="ui-btn ui-corner-all ui-icon-star ui-btn-icon-notext">Favoritos</a>'
                    + '</div><div class="ui-block-b">'
                    + '<a href="#" style="margin:0.5em 10px;" class="ui-btn ui-corner-all ui-icon-action ui-btn-icon-notext">Compartilhar</a></div>'
                    + '<div class="ui-block-c">'
                    + '<a target="_blank" href="'+lEventos[i].deWebsite+'" style="margin:0.5em 10px;" class="ui-btn ui-corner-all ui-icon-navigation ui-btn-icon-notext">Website</a>'
                    + '</div>'
                    + '<div class="ui-block-d">'
                    + '<a href="javascript:alert(\"Aguarde...\")" style="margin:0.5em 10px;" class="ui-btn ui-corner-all ui-icon-comment ui-btn-icon-notext">Mensagem</a>'
                    + '</div>'
                    + '</fieldset></center></p><hr>';
        }

        contentList += "</div>";
        $("#listViewTodayEvents").html(contentList);

        //$("#listViewTodayEvents").html(contentList);
    }
    /**
     * @Called on load to show today events
     */
    this.sucessLoad = function (position) {

        //Init directions service
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        //Set Coordinates
        lat = position.coords.latitude;
        lng = position.coords.longitude;

        localStorage.setItem("lat", lat);
        localStorage.setItem("lon", lng);

        //Init map at floripa center of it
        var myLatlng = new google.maps.LatLng(-27.59226, -48.54902);
        //Set map options
        var mapOptions = {
            zoom: 16,
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
        $.get("https://guiafloripa.morettic.com.br/busca/", function (data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            //Lista de eventos
            lEventos = data.e;
            //Save list to show on
            localStorage.setItem("todayEvents", JSON.stringify(data.e));

            infowindow = mapUtils.createInfoWindowDef();

            for (i = 0; i < lEventos.length; i++) {
                icon = null;

                markers[i] = new google.maps.Marker({
                    //alert()
                    position: new google.maps.LatLng(lEventos[i].nrLat, lEventos[i].nrLng),
                    map: map,
                    title: lEventos[i].deEvent,
                    indice: i,
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                        url: mapUtils.getIcon(lEventos[i].idType),
                        size: new google.maps.Size(32, 51), // size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 51) // anchor
                    },
                });
                google.maps.event.addListener(markers[i], 'click', function () {
                    // this.setMap(null);
                    this.animation = null;
                    this.setMap(map);
                    InfoWindowT(lEventos[this.indice], lat, lng);
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
            mapUtils.clusterOption(map, markers);
            navigator.splashscreen.hide();//hide splash after map load
        });
    }
    /**
     * @Calculate distance from two diferent coordinates in KM
     * */
    this.calculateDistance = function (lat1, long1, lat2, long2) {

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

        return Math.round((Math.sqrt((x * x) + (y * y) + (z * z)) / 10)) + " KM";
    }
    /**
     * @ Map Style
     * */
    this.getMapStyle = function () {
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
    this.showWelcome = function () {
        this.showMessage("Bem vindo ao APP do Guia Floripa. Pesquise os eventos perto de você!", "#454545");
    }
    /**
     * @GPS Exception
     * */
    this.showNoGPS = function () {
        window.location.href = "gps.html";
        setTimeout(cordova.plugins.diagnostic.switchToLocationSettings(), 3000);
    }

    /**
     * @Messagem Manager method
     * */
    this.showMessage = function (msg, corDialog) {
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
    this.initSliderMenu = function () {
        var dvjQuery = $("#flexiselDemo1").detach();
        $("#flexiselOwner").html(dvjQuery);

        $("#flexiselDemo1").flexisel({
            visibleItems: 4,
            clone: false,
        });
    }

    this.setBorderStyle = function (element, name, id) {
        //zoom = zoom == undefined ? 10 : zoom;
        // map.setZoom(10);
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
    this.setBorderStyle1 = function (element, name, id) {
        // zoom = map.getZoom();
        // map.setZoom(zoom);
        res = element.src.split("_");
        pos = res.length - 1;
        element.src = res[pos] == "on.png" ? "./img/" + name + "_off.png" : "./img/" + name + "_on.png";
        //alert(pdtFim);
        this.requestPlaces(id);
    }
    /**
     * Init Push Notifications
     */
    this.initPush = function () {
        notificationOpenedCallback = function (jsonData) {
            console.log('notificationOpenedCallback: ' + JSON.stringify(jsonData));
        };

        window.plugins.OneSignal
                .startInit("c452ff74-3bc4-44ca-a015-bfdaf0779354")
                .handleNotificationOpened(notificationOpenedCallback)
                .endInit();
        //Save userId and pushToken on Database (localstorage)
        window.plugins.OneSignal.getIds(function (ids) {
            console.log('getIds: ' + JSON.stringify(ids));
            //alert("userId = " + ids.userId + ", pushToken = " + ids.pushToken);
            localStorage.setItem("pushToken", ids.pushToken);
            localStorage.setItem("userId", ids.userId);
        });
    }
    /**
     * @ Calculate Distance from two points
     * **/
    this.showDistance = function (pLat, pLng, oLat, oLng) {
        /* var iStr = pLat + pLng + oLat + oLng;
         iStr+= "_";
         var item = localStorage.getItem(iStr);
         if (item === null) {*/

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
        directionsService.route(request, function (response, status) {
            //localStorage.setItem(iStr, JSON.stringify(response));
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
            } else {
                console.log("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
            }
        });
        /* }else{//Load response from local storage...less IO from Internet
         vresponse = JSON.parse(item);
         directionsDisplay.setDirections(vresponse);
         directionsDisplay.setMap(map);
         }*/
    }
    this.initAds = function () {
        try {
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
        } catch (e) {//Send Exception to Firebase
            exceptHandler.report(device, e.toString(), e.fileName, e.lineNumber, e.columnNumber, e.description);
        }
    }

    this.finishGPSTimer = function () {
        try {
            navigator.geolocation.clearWatch(watcherPosition);
        } catch (e) {
            window.cordova.plugins.firebase.crash.report(e.toString());
            console.log(e)
        }
    }
    //
    this.initGPSTimer = function () {
        watcherPosition = navigator.geolocation.watchPosition(
                function (pos) {
                    alert(pos.coords.latitude);
                },
                function (error) {
                    alert('code: ' + error.code + '\n' +
                            'message: ' + error.message + '\n');
                },
                {
                    timeout: 30000,
                    enableHighAccuracy: true
                });
    }

    this.clusterOption = function (map, markers) {
        /* if (markerCluster !== null) {
         //markerCluster.clearMarkers();
         markerCluster.setMap(null);
         }
         var voptions = {
         imagePath: 'img/m',
         maxZoom: 15,
         zoomOnClick: false
         };
         
         markerCluster = new MarkerClusterer(map, markers, voptions);*/
    }

}
/**
 * 
 *  
 *  @Function to open InfoWindow from Map on POPUP format
 *  @Obj from response
 *  @lat user lat
 *  @lng user lon
 * */
function InfoWindowT(obj, plat, plng) {
    zoom = map.getZoom();

    latZ = obj.nrLat;
    lngZ = obj.nrLng;
    document.getElementById('pageBt').click();
    var dist = mapUtils.calculateDistance(obj.nrLat, obj.nrLng, plat, plng);
    var img = (obj.deLogo === "default" || obj.deLogo === "") ? obj.deImg : obj.deLogo;

    $("#txtTitT").text(obj.deEvent);
    //$("#txtTitT").text(obj.deEvent);
    $("#txtDescT").html(obj.deDetail);
    $("#txtPlaT").text(obj.nmPlace);
    var tit = (obj.deEvent === null || obj.deEvent === undefined) ? obj.nmPlace : obj.deEvent;
    $("#txtTitT").text(tit);
    $("#txtAddrT").text(obj.deAddress);
    var txtTmpData = obj.printDate;//obj.dtUntil == obj.dtFrom ? obj.dtUntil : obj.dtFrom + "-" + obj.dtUntil;
    $("#txtDateT").text(txtTmpData);
    $("#txtDistT").text(dist);
    shareObj.setUrlShare("https://app.guiafloripa.com.br");

    if (obj.deWebsite === null || obj.deWebsite === undefined || obj.deWebsite === "N/A") {
        hideIt('txtURLT');
    } else {
        showIt('txtURLT');
        $("#txtURLT").attr("href", obj.deWebsite);
    }

    //ate Null Hide IT
    if (obj.dtUntil === null || obj.dtUntil === undefined) {
        shareObj.setMessage("Venha conhecer " + obj.nmPlace + "! Quer mais opções? Guia Floripa App.");
        hideIt('txtDateT');
        hideIt('txtDateT1');
    } else {
        shareObj.setMessage("Que tal " + obj.deEvent + " no dia " + obj.printDate + "? Quer mais opções? Guia Floripa App.");
        showIt('txtDateT');
        showIt('txtDateT1');
    }
    //If phone is not null not undefined and not avaliable show it else hide
    if (obj.nrPhone === null || obj.nrPhone === undefined || obj.nrPhone === "N/A") {
        hideIt('txtPhonT');
        hideIt('txtPhonT1');
    } else {
        showIt('txtPhonT1');
        showIt('txtPhonT');
        $("#txtPhonT").text(obj.nrPhone);
    }
    //Description null hide it
    if (obj.nmPlace === null || obj.idType === "1" || obj.idType === "3" || obj.idType === "5" || obj.idType === "8") {
        hideIt('txtPlaT')
    } else {
        showIt('txtPlaT');
    }
    //
    if (obj.deDetail === null || obj.deDetail === undefined) {
        if (obj.dePlace === null || obj.dePlace === undefined) {
            hideIt('txtDescT');
            hideIt('txtDescT1');
        } else {
            showIt('txtDescT');
            showIt('txtDescT1');
            $("#txtDescT").html(obj.dePlace);
        }
    } else {
        showIt('txtDescT');
        showIt('txtDescT1');
    }

    if (img === "default" || img === "" || img === undefined || img === null) {
        hideIt('deLogoPromo');
        hideIt('divImagem');
        shareObj.setVet([]);
    } else {
        showIt('divImagem');
        showIt('deLogoPromo');
        shareObj.setVet([img]);
        document.getElementById('deLogoPromo').src = img;
    }
    //Cinema
    if (obj.idType === "3") {
        document.getElementById('txtDescT').style.visibility = 'visible';
        document.getElementById('txtDescT').style.display = 'block';
        // var content = '<fieldset style="background: transparent;border: none"><ul id="flexiselCinema"  style="background: transparent;border: none">';
        var content = '';
        for (i = 0; i < obj.movies.length; i++) {
            mP = obj.movies[i];
            var id = 'txtId' + i;
            content += '<h1 class="txtTitT">' + mP.deEvent + '</h1>'
                    + '<div class="containerImagem" id="divImagem">'
                    + '<center><img src="' + mP.deImg
                    + '" style="max-height: 150px;align-content: center" class="imgPopUp">'
                    + '</center></div>'
                    + '<a class="ui-btn ui-mini ui-icon-calendar ui-mini ui-btn-inline ui-btn-icon-left blankButtons">' + mP.dtFrom + ' - ' + mP.dtUntil + '</a>'
                    + '<div id=' + id + ' class="txtCinema" readonly>'
                    + mP.deDetail
                    + '</div>';
        }
        //  content += "</ul>"
        content += "<br><br><br><br>";
        $("#txtDescT").html(content);
    }
    myFavorites.setCurrentF(obj);
    mapUtils.showDistance(obj.nrLat, obj.nrLng, plat, plng);
}


function hideIt(e) {
    document.getElementById(e).style.visibility = 'hidden';
    document.getElementById(e).style.display = 'none';
}

function showIt(e) {
    document.getElementById(e).style.visibility = 'visible';
    document.getElementById(e).style.display = 'block';
}

function formatDate(data) {
    var formattedDate = new Date(data);
    var d = formattedDate.getDate();
    var m = formattedDate.getMonth();
    m += 1;  // JavaScript months are 0-11
    var y = formattedDate.getFullYear();

    return d + "/" + m + "/" + y + " " + formattedDate.getHours() + ":" + formattedDate.getMinutes();
}