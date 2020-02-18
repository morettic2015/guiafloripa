/* 
 *@ExceptionHandler sends exceptions to Mantis Bug Tracker Resolver
 *@author Lamm,<projetos@morettic.com.br>
 *
 *<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><title>Slim Application Error</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana,sans-serif;}h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}strong{display:inline-block;width:65px;}</style></head><body><h1>Slim Application Error</h1><p>A website error has occurred. Sorry for the temporary inconvenience.</p></body></html>
 */


var ExceptionHandler = function () {
    this.url = "https://guiafloripa.morettic.com.br/report/";
    this.report = function (device, msg, url, lineNo, columnNo, error) {
      var manufac = device.manufacturer === undefined ? "" : device.manufacturer;
        var title = device.model + "-" + manufac + "-" + device.version;
        var desc = (msg + " " + url + " " + lineNo + " " + columnNo + " " + error);

        //window.cordova.plugins.firebase.crash.report("Exception Error");
        $.ajax({
            type: 'POST',
            url: this.url,
            data: {title: (title), desc: desc},
            success: function (data) {
                console.log(data);
                console.log(status);
                mapUtils.showMessage("Ocorreu um problema...", "#000000");
                //window.location.reload();
            }
        });
    };
};