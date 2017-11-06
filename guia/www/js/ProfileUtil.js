/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 *
 *
 *
 * https://guiafloripa.morettic.com.br/profile/malacma@2gmail.com/pedro/katia%20fire/345234524352435sssss
 * and open the template in the editor.
 */


var ProfileUtil = function () {
    this.nome = null;
    this.email = null;
    this.token = null;
    this.userId = null;
    this.url = null;
    this.distance = null;
    this.pushOn = null;


    this.initProfile = function () {
        if (localStorage.getItem("pushOn") !== undefined) {
            $('#checkPushOn').prop('checked', localStorage.getItem("pushOn")).trigger('click').trigger('change');
            $("#txtNomeProfile").val(localStorage.getItem("nome"));
            $("#txtEmailProfile").val(localStorage.getItem("email"));
            $("#slider-1").val(localStorage.getItem("distance"))
        }
        if (localStorage.getItem("pushOn") !== null) {
            var avatar = localStorage.getItem("avatar");
            $("#imgAvatar").attr("src", avatar);
            $("#imgAvatar").attr("style", "border-radius: 50%;")
        }



    }

    this.saveProfile = function () {
        this.nome = $("#txtNomeProfile").val();
        this.email = $("#txtEmailProfile").val();
        this.token = localStorage.getItem("pushToken");
        this.userId = localStorage.getItem("userId");
        this.distance = $("#slider-1").val();
        //this.pushOn = $("#checkPushOn").prop("checked");

        if (this.nome === "") {
            mapUtils.showMessage("Informe seu nome", "#f1f1f1");
            $("#txtNomeProfile").focus();
            return;
        }
        //Mail validation
        var regularExpression = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))){2,6}$/i;
        if (this.email === "" || !regularExpression.test(this.email)) {
            mapUtils.showMessage("Informe um email valido", "#f1f1f1");
            $("#txtEmailProfile").focus();
            return;
        }
        ///set local storage
        localStorage.setItem("nome", this.nome);
        localStorage.setItem("email", this.email);
        localStorage.setItem("distance", this.distance);
        localStorage.setItem("pushOn", this.pushOn);
        //this.mauticData();
        this.url = "https://guiafloripa.morettic.com.br/profile/" + this.email + "/" + this.nome + "/" + this.userId + "/" + this.token;
        console.log(this.url);
        $.get(this.url, function (data, status) {
            console.log(data);
            console.log(status);
            mapUtils.showMessage("Perfil atualizado", "#000000");
        });
        this.sendMauticData();
    }

    /**
     * @Send Lead to Mautic Inbound Marketing tool
     * */
    this.sendMauticData = function () {
        (function (w, d, t, u, n, a, m) {
            w['MauticTrackingObject'] = n;
            w[n] = w[n] || function () {
                (w[n].q = w[n].q || []).push(arguments)
            }, a = d.createElement(t),
                    m = d.getElementsByTagName(t)[0];
            a.async = 1;
            a.src = u;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://inbound.citywatch.com.br/mtc.js', 'mt');
        mt('send', 'pageview', {email: this.email, firstname: this.nome});

    }

    /**
     * @Todo Implement a service that serialize response from facebook on Server Side. 
     * @Post method to submit data
     * @Submits also email and name
     * @Create a Config instance with all metadatah
     * @Origin need to be from Facebook
     * */
    this.facebookLogin = function () {
        facebookConnectPlugin.login(["public_profile"],
                function (userData) {
                    console.log("UserInfo: ", userData);
                    //Get Data From User
                    facebookConnectPlugin.api(
                            "me/?fields=id,name,email,picture", // graph path
                            [], // array of additional permissions
                            function (response) {
                                localStorage.setItem("facebook", JSON.stringify(response));
                                console.log("Response: ", response);
                                $("#txtNomeProfile").val(response.name);
                                $("#txtEmailProfile").val(response.email);
                                $("#imgAvatar").attr("src", response.picture.data.url);
                                $("#imgAvatar").attr("style", "border-radius: 50%;")
                                localStorage.setItem("nome", response.name);
                                localStorage.setItem("email", response.email);
                                localStorage.setItem("avatar", response.picture.data.url);
                            }
                    )
                },
                function (error) {
                    console.error(error);
                    exceptHandler = new ExceptionHandler();
                    exceptHandler.report(device.model, error.filename, error.code, "119", "error.crash", error.crash)
                }
        );
    }
}


var profileUtil = new ProfileUtil();