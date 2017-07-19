/*
 @ APP GUIAFLORIPA CITYWATCH
 @ Copyright Morettic.com.br
 @ Citywatch.com.br
 @ Guiafloripa.com.br
 @ Genimo.com.br
 */
var map;
var lat;
var lng;
var mapUtils;
var lEventos;
var markers = new Array();
var app = {
    // Application Constructor
    initialize: function() {
        document.addEventListener('deviceready', this.onDeviceReady.bind(this), false);
    },
    // deviceready Event Handler
    //
    // Bind any cordova events here. Common events are:
    // 'pause', 'resume', etc.
    onDeviceReady: function() {
        this.receivedEvent('deviceready');

        //Init Map Utils
        mapUtils = new MapUtils();
        //INit map Slider
        mapUtils.initSliderMenu();

        navigator.geolocation.getCurrentPosition(function(position) {

            //Init Show info;
            mapUtils.showWelcome();

            //Loads Map
            mapUtils.sucessLoad(position);
        }, function(e) {
            //No GPS or WIFI!
            mapUtils.showNoGPS();
        }, {timeout: 5000})


    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
        var parentElement = document.getElementById(id);


        console.log('Received Event: ' + id);
    }

};

app.initialize();

/**
 * @Classe Utilitiaria do APP
 * @Morettic.com.br
 */
var MapUtils = function() {

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
        }
        return icon;
    }

    this.sucessLoad = function(position) {

        lat = position.coords.latitude;
        lng = position.coords.longitude;
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 14,
            center: myLatlng,
            styles: this.getMapStyle(),
            mapTypeControl: false,
            disableDefaultUI: true
        }
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        //Requisição ao server side
        $.get("https://guiafloripa.morettic.com.br/busca/", function(data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            //Lista de eventos
            lEventos = data.e;

            infowindow = new google.maps.InfoWindow({
                content: "holding..."
            });
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
                    infowindow.setContent("<img width='60' src='"
                            + lEventos[this.indice].deLogo
                            + "'/>"
                            + lEventos[this.indice].deDetail
                            + "<br>"
                            + dist);
                    infowindow.open(map, this);
                });

            }

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
        this.showMessage("Por favor ative sua WIFI/4G e GPS para visualizar o mapa!", "#FF00FF");
        setTimeout(cordova.plugins.diagnostic.switchToLocationSettings(), 3000);
    }

    /**
     * @Messagem Manager method
     * */
    this.showMessage = function(msg, corDialog) {
        window.plugins.toast.showWithOptions({
            message: msg,
            duration: 6000, // 2000 ms
            position: "center",
            styling: {
                opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
                backgroundColor: corDialog, // make sure you use #RRGGBB. Default #333333
                textColor: '#FFFF00', // Ditto. Default #FFFFFF
                textSize: 20.5, // Default is approx. 13.
                cornerRadius: 5, // minimum is 0 (square). iOS default 20, Android default 100
                horizontalPadding: 20, // iOS default 16, Android default 50
                verticalPadding: 16 // iOS default 12, Android default 30
            }
        });
    }
    this.initSliderMenu = function() {
        $("#flexiselDemo1").flexisel({
            visibleItems: 1,
            clone: false,
        });
    }

    this.setBorderStyle = function(element) {
        element.style.border = "thick solid black";
    }
}