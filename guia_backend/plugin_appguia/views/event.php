<link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
<link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsen-css-components.min.css">
<script src="https://unpkg.com/onsenui/js/onsenui.min.js"></script>
<script src="https://unpkg.com/jquery/dist/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBszRC_PVudlS_S_O_ejw00pZ_fJFU3Q0o"></script>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 240px;

    }
</style>
<?php
$id = $_GET['placeID'];

$url = DEFAULT_REST_PLACE . $id;
echo $url;

$json = file_get_contents($url);
// Decode the JSON string into an object
$obj = json_decode($json);
var_dump($obj);
?>
<ons-page>
    <ons-toolbar>
        <div class="left"><img src="https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png" width="32"/></div>

        <div class="center">
            <h3 class="alert-success">
                <?php echo $obj[0]->nmPlace; ?>
            </h3>
        </div>
    </ons-toolbar>
    <ons-card>
        <ons-list>
            <img src="<?php echo $obj[0]->deLogo; ?>" alt="<?php echo $obj[0]->nmPlace; ?>" class="center">
            <ons-list-item>
                <ons-icon icon="ion-android-list">  
                    Sobre a gente
                </ons-icon>
            </ons-list-item>
            <ons-list-item>
                <?php echo $obj[0]->dePlace; ?>
            </ons-list-item>
            <ons-list-item>
                <ons-icon icon="ion-android-globe">
                    <a href="<?php echo $obj[0]->deWebsite; ?>" target="_BLANK"> Visite o Website</a>
                </ons-icon>
            </ons-list-item>

            <?php if (!empty($obj[0]->deEmail)) { ?>
                <ons-list-item>
                    <ons-icon icon="ion-android-mail">
                        <?php echo $obj[0]->deEmail; ?>
                    </ons-icon>
                </ons-list-item>
            <?php } ?>

        </ons-list>
        <ons-list-item>
            <ons-icon icon="ion-android-compass">            
                <?php echo $obj[0]->deAddress; ?>
            </ons-icon>
        </ons-list-item>
        <div id="map"></div>

    </ons-card>
    <ons-fab position="bottom right" onclick="showPopover(this)">
        <ons-icon icon="ion-android-hangout"></ons-icon>
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
        <h1>Faça Contato</h1>
        <p>
            Utilize sua conta no Facebook para falar com nosso atendente virtual!
        </p>
        <ons-button>
            <ons-icon icon="ion-social-facebook-outline">
                Entrar em contato
            </ons-icon>
        </ons-button>
    </div>

</ons-popover>
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
    function initMap() {
        var myLatLng = {lat: <?php echo $obj[0]->nrLat; ?>, lng: <?php echo $obj[0]->nrLng; ?>};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: '<?php echo $obj[0]->nmPlace; ?>'
        });
    }
    window.onload = initMap();
    //  }
</script>
