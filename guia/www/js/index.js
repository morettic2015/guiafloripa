/*
 @ APP GUIAFLORIPA CITYWATCH
 @ Copyright Morettic.com.br
 @ Citywatch.com.br
 @ Guiafloripa.com.br
 @ Genimo.com.br
 */

var app = {
    // Application Constructor
    initialize: function () {
        document.addEventListener('deviceready', this.onDeviceReady.bind(this), false);

    },
    //OnDevice Offline
    isOffline: function () {
        //navigator.splashscreen.show();
        //alert('OFFLINE');
        var networkState = navigator.connection.type;
        //alert(networkState);
        if (networkState === Connection.NONE) {
            window.location.href = "offline.html";
        }
    },
    // deviceready Event Handler
    //
    // Bind any cordova events here. Common events are:
    // 'pause', 'resume', etc.
    onDeviceReady: function () {
        this.receivedEvent('deviceready');
        //document.addEventListener("offline", this.onOffline(), false);

        this.isOffline();
        //Init Map Utils
        mapUtils = new MapUtils();
        //INit map Slider
        mapUtils.initSliderMenu();
        //Init Ads
        mapUtils.initAds();
        //Init Geolocation
        navigator.geolocation.getCurrentPosition(function (position) {
            //Init Show info;
            mapUtils.showWelcome();
            //Loads Map
            mapUtils.sucessLoad(position);
            //Loader for Actions
            myLoader = new Loader();
        }, function (e) {
            navigator.splashscreen.hide();//Hide Splash
            //No GPS or WIFI!
            mapUtils.showNoGPS();
        }, {timeout: 5000});
        //Init Push
        mapUtils.initPush();
        //Init profile data
        profileUtil.initProfile();
    },
    // Update DOM on a Received Event
    receivedEvent: function (id) {
        var parentElement = document.getElementById(id);
        console.log('Received Event: ' + id);
    }

};

app.initialize();
var exceptHandler = new ExceptionHandler();
//Exception handler and report
window.onerror = function (msg, url, lineNo, columnNo, error) {
    exceptHandler.report(device, msg, url, lineNo, columnNo, error);
    //window.location.href = "erro.html";
}
/**
 * Window loader controller
 * */
