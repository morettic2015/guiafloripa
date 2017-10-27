<link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
<link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsen-css-components.min.css">
<script src="https://unpkg.com/onsenui/js/onsenui.min.js"></script>
<script src="https://unpkg.com/jquery/dist/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBszRC_PVudlS_S_O_ejw00pZ_fJFU3Q0o"></script>
<ons-page>
    <ons-toolbar>
        <div class="left"><img src="https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png" width="32"/></div>

        <div class="center">
            <h3 class="alert-success">
                Sua Conta
            </h3>
        </div>
    </ons-toolbar>




    <?php
    @session_start();
    var_dump($_SESSION);
    if (isset($_POST['mail'])) {
        var_dump($_POST);
    } else if (isset($_POST['username'])) {
        //echo "<pre>";
        $user = wp_login($_POST['username'], $_POST['password']);


        if (!empty($user->user_login)) {
            $_SESSION['user'] = $user;

       //      global $current_user;

    //echo 'The current logged in user ID is: ' . $current_user->ID;die;
            include PLUGIN_ROOT_DIR . 'views/menu.php';
        } else if (isset($_SESSION['user'])) {
            include PLUGIN_ROOT_DIR . 'views/menu.php';
        } else {
            echo '<ons-icon icon="ion-close-circled">Falha na autenticação</ons-icon>';
            include PLUGIN_ROOT_DIR . 'views/login.php';
        }
    }
    ?>


    <ons-fab position="bottom right" onclick="showPopover(this)">
        <ons-icon icon="ion-android-add"></ons-icon>
    </ons-fab>
    <ons-bottom-toolbar>
        <ons-row>

            <ons-col vertical-align="center">
                <center>
                    <a href="https://citywatch.com.br" target="_BLANK">
                        <img src=" https://app.guiafloripa.com.br/wp-content/uploads/2017/08/logo_guiafloripa_roda.png" width="90">
                    </a>
                </center>
            </ons-col>

            <ons-col vertical-align="center">
                <center>
                    <a href="https://citywatch.com.br" target="_BLANK">
                        <img src="https://app.guiafloripa.com.br/wp-content/uploads/2017/08/logo-CW.png" width="90">
                    </a>
                </center>
            </ons-col>
            <ons-col  vertical-align="center">
                <center>
                    <a href="https://experienciasdigitais.com.br" target="_BLANK">
                        <img src="https://app.guiafloripa.com.br/wp-content/uploads/2017/08/logo_morettic_roda.png" width="90">
                    </a>
                </center>
            </ons-col>
        </ons-row>

    </ons-bottom-toolbar>
</ons-page>

<ons-popover direction="up" id="popover">
    <div class="center">
        <ons-icon onclick="hidePopover()" icon="ion-close">  
            cancelar
        </ons-icon>
    </div>
    <div style="padding: 10px; text-align: center;">
        <h1>Quero Criar uma conta</h1>
        <p>
            Utilize sua conta no Facebook cadastrar-se!
        </p>
        <div id="status"></div>

        <!-- Display user profile data -->
        <div id="userData"></div>
        <ons-button  onclick="fbLogin()" >
            <ons-icon icon="ion-social-facebook-outline">
                Criar conta
            </ons-icon>
        </ons-button>
    </div>

</ons-popover>

<template id="tab1.html">
    <ons-page id="Tab1">
        <p style="text-align: center;">
            This is the first page.
        </p>
    </ons-page>
</template>

<template id="tab2.html">
    <ons-page id="Tab2">
        <p style="text-align: center;">
            This is the second page.
        </p>
    </ons-page>
</template>


<form name="facebook" method="post">
    <input type="hidden" name="mail" id="mail"/>
    <input type="hidden" name="name" id="name"/>
</form>
<script>
    var showPopover = function (target) {
        document
                .getElementById('popover')
                .show(target);
    };

    var hidePopover = function () {
        document
                .getElementById('popover')
                .hide();
    };


    window.fbAsyncInit = function () {
        // FB JavaScript SDK configuration and setup
        FB.init({
            appId: '1405126029586258', // FB App ID
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true, // parse social plugins on this page
            version: 'v2.8' // use graph api version 2.8
        });

        // Check whether the user already logged in
        /* FB.getLoginStatus(function (response) {
         if (response.status === 'connected') {
         //display user data
         getFbUserData();
         }
         });*/
    };

// Load the JavaScript SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
    function fbLogin() {
        FB.login(function (response) {
            if (response.authResponse) {
                // Get and display the user profile data
                getFbUserData();
            } else {
                document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
            }
        }, {scope: 'email'});
    }

// Fetch the user profile data from facebook
    function getFbUserData() {///profile/{email}/{name}/{userId}/{pushToken} //
        FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
                function (response) {
                    var url = "https://guiafloripa.morettic.com.br/profile/" + escape(response.email) + "/" + escape(response.first_name) + "/null/null"
                    $.get(url, function (data) {
                        //alert("Data Loaded: " + data);
                        ons.notification.alert('Sucesso. Redirecionando...');
                    });
                    document.facebook.mail.value = response.email;
                    document.facebook.name.value = response.first_name;
                    //document.facebook.submit();
                    //document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.first_name + '!';
                    //document.getElementById('userData').innerHTML = '<p><b>FB ID:</b> ' + response.id + '</p><p><b>Name:</b> ' + response.first_name + ' ' + response.last_name + '</p><p><b>Email:</b> ' + response.email + '</p><p><b>Gender:</b> ' + response.gender + '</p><p><b>Locale:</b> ' + response.locale + '</p><p><b>Picture:</b> <img src="' + response.picture.data.url + '"/></p><p><b>FB Profile:</b> <a target="_blank" href="' + response.link + '">click to view profile</a></p>';
                });
    }

// Logout from facebook
    function fbLogout() {
        FB.logout(function () {
            document.getElementById('fbLink').setAttribute("onclick", "fbLogin()");
            document.getElementById('fbLink').innerHTML = '<img src="fblogin.png"/>';
            document.getElementById('userData').innerHTML = '';
            document.getElementById('status').innerHTML = 'You have successfully logout from Facebook.';
        });
    }
</script>
<?php
//Makes LOGIN
?>