/* 
 * @Class to Social Share Functions
 * @Copyright Morettic.com.br
 * @URL https://experienciasdigitais.com.br
 *  
 */


var SocialShare = function () {
    this.options = null;
    this.url = "https://app.guiafloripa.com.br";
    this.setUrlShare = function (pUrl) {
        this.url = pUrl;
    }
    this.initShare = function (msg, subject) {
        this.options = {
            message: msg, // not supported on some apps (Facebook, Instagram)
            subject: subject, // fi. for email
            files: ['', ''], // an array of filenames either locally or remotely
            url: this.url,
            chooserTitle: 'GuiaFloripa APP Compartilhe com seus Amigos!' // Android only, you can override the default share sheet title
        }
        try {
            window.plugins.socialsharing.shareWithOptions(this.options, this.onSuccess, this.onError);
        } catch (e) {
            console.log(e);
            alert(e);
        }
    }
    this.initShareURL = function (msg, subject, URL) {
        this.options = {
            message: msg, // not supported on some apps (Facebook, Instagram)
            subject: subject, // fi. for email
            files: ['', ''], // an array of filenames either locally or remotely
            url: URL,
            chooserTitle: 'GuiaFloripa APP Compartilhe com seus Amigos!' // Android only, you can override the default share sheet title
        }
        window.plugins.socialsharing.shareWithOptions(this.options, this.onSuccess, this.onError);
    }

    this.onSuccess = function (result) {
        console.log("Share completed? " + result.completed); // On Android apps mostly return false even while it's true
        console.log("Shared to app: " + result.app); // On Android result.app is currently empty. On iOS it's empty when sharing is cancelled (result.completed=false)
    }

    this.onError = function (msg) {
        console.log("Sharing failed with message: " + msg);
    }
}

var shareObj = new SocialShare();