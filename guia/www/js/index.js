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
var app = {
    // Application Constructor
    initialize: function () {
        document.addEventListener('deviceready', this.onDeviceReady.bind(this), false);
    },

    // deviceready Event Handler
    //
    // Bind any cordova events here. Common events are:
    // 'pause', 'resume', etc.
    onDeviceReady: function () {
        this.receivedEvent('deviceready');

        //Init Map Utils
        mapUtils = new MapUtils();


        navigator.geolocation.getCurrentPosition(function (position) {

            //Init Show info;
            mapUtils.showWelcome();

            //Loads Map
            mapUtils.sucessLoad(position);
        }, function (e) {
            //No GPS or WIFI!
            mapUtils.showNoGPS();
        }, { timeout: 5000 })


    },

    // Update DOM on a Received Event
    receivedEvent: function (id) {
        var parentElement = document.getElementById(id);


        console.log('Received Event: ' + id);
    }

};

app.initialize();

/**
 * @Classe Utilitiaria do APP
 * @Morettic.com.br
*/
var MapUtils = function () {
    this.sucessLoad = function (position) {
        lat = position.coords.latitude;
        lng = position.coords.longitude;
        //alert(lat);
        var mapUtils = new MapUtils();

        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = { zoom: 14, center: myLatlng, styles: mapUtils.getMapStyle(), mapTypeControl: false }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    }


    this.getMapStyle = function () {
        return [{ "featureType": "all", "elementType": "all", "stylers": [{ "saturation": -100 }, { "lightness": -30 }, { "hue": "#ff0000" }] }, { "featureType": "all", "elementType": "labels.text.fill", "stylers": [{ "color": "#ffffff" }] }, { "featureType": "all", "elementType": "labels.text.stroke", "stylers": [{ "color": "#353535" }] }, { "featureType": "landscape", "elementType": "geometry", "stylers": [{ "color": "#656565" }] }, { "featureType": "poi", "elementType": "geometry.fill", "stylers": [{ "color": "#505050" }] }, { "featureType": "poi", "elementType": "geometry.stroke", "stylers": [{ "color": "#808080" }] }, { "featureType": "road", "elementType": "geometry", "stylers": [{ "color": "#454545" }] }, { "featureType": "transit", "elementType": "labels", "stylers": [{ "hue": "#007bff" }, { "saturation": 100 }, { "lightness": -40 }, { "invert_lightness": true }, { "gamma": 1.5 }] }, { "featureType": "water", "elementType": "geometry.fill", "stylers": [{ "color": "#647f9c" }] }];
    }
    this.showWelcome = function () {
        this.showMessage("Bem vindo ao APP do Guiafloripa. Pesquise os eventos perto de você!", "#454545");
    }

    this.showNoGPS = function () {
        this.showMessage("Por favor ative sua WIFI/4G e GPS para visualizar o mapa!", "#FF00FF");
        setTimeout(cordova.plugins.diagnostic.switchToLocationSettings(),3000);
    }


    this.showMessage = function (msg, corDialog) {
        window.plugins.toast.showWithOptions({
            message: msg,
            duration: 6000, // 2000 ms
            position: "center",
            styling: {
                opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
                backgroundColor: corDialog, // make sure you use #RRGGBB. Default #333333
                textColor: '#FFFF00', // Ditto. Default #FFFFFF
                textSize: 20.5, // Default is approx. 13.
                cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
                horizontalPadding: 20, // iOS default 16, Android default 50
                verticalPadding: 16 // iOS default 12, Android default 30
            }
        });
    }
}
