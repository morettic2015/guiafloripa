<?php
include_once PLUGIN_ROOT_DIR . 'views/negocio/NegocioController.php';
$nc = new NegocioController();
if (isset($_POST['nmNegocio'])) {
    $business = $nc->insertUpdateNegocio($_POST);
} else {
    $business = $nc->findNegocioById($_GET['id']);
}
/*echo isset($business->id) ? $business->id:(isset($_GET['id'])?$_GET['id']:"");
echo "<pre>";
  var_dump($business);
  var_dump($_POST);
  echo "</pre>"; */
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<form name="frm_negocio" method="post">
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?><a href="javascript:loadFacebook()" class="page-title-action">Sincronizar com página do Facebook</a></h1>
        <div class="notice notice-info" id="msg"> 
            <p>Configure o seu negócio</p>
        </div>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-2">Dados Gerais</a></li>
                <li><a href="#tabs-3">Horários</a></li>
                <li><a href="#tabs-4">Endereço</a></li>
                <li><a href="#tabs-5">Fotos</a></li>
                <li><a href="#tabs-6">Configurações</a></li>
            </ul>
            <div id="tabs-2">
                <p>
                    <b>Dados do meu negócio.</b>
                </p>
                <p>
                <table class="form-table editcomment">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right;" id="titPgFace"></td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px" id="facePages"></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Nome da Empresa</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="nmNegocio" id="nmNegocio" placeholder="Nome do meu negócio" style="width: 100%" value="<?php echo isset($business->post) ? $business->post->post_title : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Tipo do Negócio</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <?php
                                $terms = get_terms(array('taxonomy' => 'business_type', 'hide_empty' => false));
                                //  var_dump($terms);
                                ?>
                                <select name="businessType" id="businessType">
                                    <option value="0" selected="true">Selecione</option> 
                                    <?php
                                    foreach ($terms as $t) {
                                        echo "<option value='" . $t->term_id . "'>" . $t->name . "</option>";
                                    }
                                    ?>

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Cnpj</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="cnpjNegocio" placeholder="19.611.312/00001-18" value="<?php echo isset($business->meta['cnpjNegocio']) ? $business->meta['cnpjNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Email</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="email" name="emailNegocio" id="emailNegocio" placeholder="Email de contato do negócio" value="<?php echo isset($business->meta['emailNegocio']) ? $business->meta['emailNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Webite</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" name="urlNegocio" id="urlNegocio" placeholder="http"  style="width: 100%" value="<?php echo isset($business->meta['urlNegocio']) ? $business->meta['urlNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Whatsapp</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="tel" name="whatsNegocio" placeholder="+55 48 996004929" value="<?php echo isset($business->meta['whatsNegocio']) ? $business->meta['whatsNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Fone Comercial</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="tel" name="foneNegocio" id="foneNegocio" placeholder="+5548 32220617" value="<?php echo isset($business->meta['foneNegocio']) ? $business->meta['foneNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Página do Facebook</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" name="faceNegocio" id="faceNegocio" placeholder="http" style="width: 100%"  value="<?php echo isset($business->meta['faceNegocio']) ? $business->meta['faceNegocio'][0] : ""; ?>"/>
                            </td>

                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Google Business</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" id="googleNegocio" name="googleNegocio" placeholder="http" style="width: 100%" value="<?php echo isset($business->meta['googleNegocio']) ? $business->meta['googleNegocio'][0] : ""; ?>"/>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Cartões de crédito</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="checkbox" name="american" value="american" <?php echo empty($business->meta['american'][0]) ? "  " : "  checked  "; ?>/>American
                                <input type="checkbox" name="amex" value="amex" <?php echo empty($business->meta['amex'][0]) ? "  " : "  checked  "; ?>/>Amex
                                <input type="checkbox" name="credicard" value="credicard" <?php echo empty($business->meta['credicard'][0]) ? "  " : "  checked  "; ?>/>Credicard
                                <input type="checkbox" name="discover" value="discover" <?php echo empty($business->meta['discover'][0]) ? "  " : "  checked  "; ?>/>Discover
                                <input type="checkbox" name="master" value="master" <?php echo empty($business->meta['master'][0]) ? "  " : "  checked  "; ?>/>Master
                                <input type="checkbox" name="visa" value="visa" <?php echo empty($business->meta['visa'][0]) ? "  " : "  checked  "; ?>/>Visa
                            </td>

                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Descrição do negócio</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <?php
                                $content = isset($business->post) ? $business->post->post_content : "";
                                $editor_id = 'txtDesc';

                                wp_editor($content, $editor_id, array('media_buttons' => false, 'quicktags' => false));
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-3">
                <p>
                    <b>Selecione o horário de funcionamento de seu negócio.</b>
                </p>
                <p>
                <table class="form-table editcomment" style="max-width: 400px">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right">Domingo</td>
                            <td><input type="checkbox" name="chk_domingo" id="chk_domingo" <?php echo empty($business->meta['i_domingo'][0]) ? "" : " checked "; ?>/> </td>
                            <td><input type="time"  name="i_domingo" id="i_domingo"  value="<?php echo isset($business->meta['i_domingo']) ? $business->meta['i_domingo'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_domingo" id="f_domingo" value="<?php echo isset($business->meta['f_domingo']) ? $business->meta['f_domingo'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Segunda</td>
                            <td><input type="checkbox" name="chk_segunda" id="chk_segunda" <?php echo empty($business->meta['i_segunda'][0]) ? " " : " checked "; ?>/> </td>
                            <td><input type="time"  name="i_segunda" id="i_segunda"  value="<?php echo isset($business->meta['i_segunda']) ? $business->meta['i_segunda'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_segunda" id="f_segunda"  value="<?php echo isset($business->meta['f_segunda']) ? $business->meta['f_segunda'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Terça</td>
                            <td><input type="checkbox" name="chk_terca" id="chk_terca" <?php echo empty($business->meta['i_terca'][0]) ? "  " : " checked "; ?>/> </td>
                            <td><input type="time"  name="i_terca" id="i_terca"  value="<?php echo isset($business->meta['i_terca']) ? $business->meta['i_terca'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_terca" id="f_terca"  value="<?php echo isset($business->meta['f_terca']) ? $business->meta['f_terca'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Quarta</td>
                            <td><input type="checkbox" name="chk_quarta" id="chk_quarta" <?php echo empty($business->meta['i_quarta'][0]) ? "  " : "  checked "; ?>/> </td>
                            <td><input type="time"  name="i_quarta" id="i_quarta"  value="<?php echo isset($business->meta['i_quarta']) ? $business->meta['i_quarta'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_quarta" id="f_quarta"  value="<?php echo isset($business->meta['f_quarta']) ? $business->meta['f_quarta'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Quinta</td>
                            <td><input type="checkbox" name="chk_quinta" id="chk_quinta" <?php echo empty($business->meta['i_quinta'][0]) ? " checked " : "  checked  "; ?>/> </td>
                            <td><input type="time"  name="i_quinta" id="i_quinta"  value="<?php echo isset($business->meta['i_quinta']) ? $business->meta['i_quinta'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_quinta" id="f_quinta"  value="<?php echo isset($business->meta['f_quinta']) ? $business->meta['f_quinta'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Sexta</td>
                            <td><input type="checkbox" name="chk_sexta" id="chk_sexta" <?php echo empty($business->meta['i_sexta'][0]) ? "  " : "  checked "; ?>/> </td>
                            <td><input type="time"  name="i_sexta" id="i_sexta"  value="<?php echo isset($business->meta['i_sexta']) ? $business->meta['i_sexta'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_sexta" id="f_sexta"  value="<?php echo isset($business->meta['f_sexta']) ? $business->meta['f_sexta'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Sabado</td>
                            <td><input type="checkbox" name="chk_sabado" id="chk_sabado" <?php echo empty($business->meta['i_sabado'][0]) ? "  " : "  checked  "; ?>/> </td>
                            <td><input type="time"  name="i_sabado" id="i_sabado"  value="<?php echo isset($business->meta['i_sabado']) ? $business->meta['i_sabado'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_sabado" id="f_sabado"  value="<?php echo isset($business->meta['f_sabado']) ? $business->meta['f_sabado'][0] : ""; ?>"/> </td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-4">
                <p>
                    <b>Localização do meu negócio.</b>
                </p>
                <p>
                <table class="form-table editcomment" style="max-width: 400px">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right">Cep</td>
                            <td><input type="number"  name="zip" id="zip" onblur="loadPlaces(this)" value="<?php echo isset($business->meta['zip']) ? $business->meta['zip'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Rua</td>
                            <td><input type="text"  name="street" id="street" style="width: 100%" value="<?php echo isset($business->meta['street']) ? $business->meta['street'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Bairro</td>
                            <td><input type="text"  name="neigh" id="neigh" style="width: 100%" value="<?php echo isset($business->meta['neigh']) ? $business->meta['neigh'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Cidade</td>
                            <td><input type="text"  name="city" id="city" value="<?php echo isset($business->meta['city']) ? $business->meta['city'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td  class="first" style="text-align: right">Estado</td>
                            <td><input type="text"  name="state" id="state" value="<?php echo isset($business->meta['state']) ? $business->meta['state'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">País</td>
                            <td><input type="text"  name="country" id="country" value="<?php echo isset($business->meta['country']) ? $business->meta['country'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Latitude</td>
                            <td><input type="text"  name="lat" id="lat" readonly="" value="<?php echo isset($business->meta['lat']) ? $business->meta['lat'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td  class="first" style="text-align: right">Longitude</td>
                            <td><input type="text"  name="lon" id="lon" readonly="" value="<?php echo isset($business->meta['lon']) ? $business->meta['lon'][0] : ""; ?>"/></td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-5">
                <p>
                    <b>Fotos do meu negócio.</b>
                </p>
                <p>
                    <input type="hidden" name="idNegocio" id="facePage1" value="<?php echo isset($business->id) ? $business->id:(isset($_GET['id'])?$_GET['id']:""); ?>"/>
                    <input type="hidden" name="facePage1" id="facePage1" value="<?php echo isset($business->meta['facePage']) ? $business->meta['facePage'][0] : ""; ?>"/>
                    <input type="hidden" name="picLogoURL" id="picLogoURL" value="<?php echo isset($business->meta['picLogoURL']) ? $business->meta['picLogoURL'][0] : ""; ?>"/>
                    <input type="hidden" name="picCapaURL" id="picCapaURL" value="<?php echo isset($business->meta['picCapaURL']) ? $business->meta['picCapaURL'][0] : ""; ?>"/>
                <table class="form-table editcomment" style="max-width: 600px">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right" id="titPgFace">Logotipo</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px" id="picLogo">
<?php echo!empty($business->meta['picLogoURL'][0]) ? "<a href='" . $business->meta['picLogoURL'][0] . "' target=_blank>Visualizar</a>" : ""; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right" id="titPgFace">Foto de capa</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px" id="picCapa">
<?php echo!empty($business->meta['picCapaURL'][0]) ? "<a href='" . $business->meta['picCapaURL'][0] . "' target=_blank>Visualizar</a>" : ""; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right" id="titPgFace">Galeria de imagens</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px"><a href="#">Editar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-6">
                <p>

                </p>
            </div>
            <input type="submit" name="btSaveCampaign" style="width: 99%" value="Salvar" class="page-title-action"/>
        </div>
        <hr/>
    </div>
</form>
<script>
    jQuery(function ($) {
        $("#tabs").tabs();

    });
    function loadPlaces(element) {
        var url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + element.value + "&key=AIzaSyDI-SU8nROAogbZWGveHUm3bT4FA5_Aujo"
        $.get(url,
                function (data) {
                    if (data.results.length > 0) {
                        jQuery('#street').val(data.results[0].formatted_address);
                        jQuery('#lat').val(data.results[0].geometry.location.lat);
                        jQuery('#lon').val(data.results[0].geometry.location.lng);
                        for (i = 0; i < data.results[0].address_components.length; i++) {
                            if (data.results[0].address_components[i].types.indexOf("postal_code") > -1) {
                                var cep = data.results[0].address_components[i].short_name;
                                var str = cep.match(/\d+/g, "") + '';
                                var s = str.split(',').join('');
                                jQuery('#zip').val(s);
                            }
                            if (data.results[0].address_components[i].types.indexOf("sublocality_level_1") > -1) {
                                jQuery('#neigh').val(data.results[0].address_components[i].short_name);
                            }
                            if (data.results[0].address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                                jQuery('#city').val(data.results[0].address_components[i].short_name);
                            }
                            if (data.results[0].address_components[i].types.indexOf("administrative_area_level_1") > -1) {
                                jQuery('#state').val(data.results[0].address_components[i].long_name);
                            }
                            if (data.results[0].address_components[i].types.indexOf("country") > -1) {
                                jQuery('#country').val(data.results[0].address_components[i].long_name);
                            }
                        }
                    }
                    console.log(data);
                }
        );
    }

    function loadFacebook() {
        FB.login(function () {
            FB.api(
                    '/me/accounts',
                    'GET',
                    {"type": "page"},
                    function (response) {
                        //facePages
                        //alert(JSON.stringify(response));
                        pages = response.data;
                        jQuery('#facePages').html("");
                        for (i = 0; i < pages.length; i++) {
                            jQuery('#facePages').append('<input onclick="loadPageById(this)" type="radio" name="facePage" id="facePage" value="' + pages[i].id + '" /> ' + pages[i].name + '<br/>');
                        }
                        jQuery("#titPgFace").html("Selecione a página do facebook");
                    }
            );
        }, {scope: 'pages_show_list'});

    }
    //function loadImagesFrom
    function loadPageById(element) {
        var pageSelected = "/" + element.value;
        //FB.login(function () {
        FB.api(
                pageSelected,
                'GET',
                {"fields": "username,about,location,picture{url},hours,emails,cover,phone,website,whatsapp_number,category,category_list,company_overview,contact_address,name,payment_options,general_info"},
                function (response) {
                    // alert(JSON.stringify(response));
                    if (response.username !== undefined)
                        jQuery("#faceNegocio").val("https://facebook.com/" + response.username);
                    jQuery("#nmNegocio").val(response.name);
                    if (response.phone !== undefined)
                        jQuery("#foneNegocio").val(response.phone);
                    jQuery("#urlNegocio").val(response.website);
                    if (response.emails !== undefined)
                        jQuery("#emailNegocio").val(response.emails[0]);
                    if (response.about !== undefined)
                        tinyMCE.get("txtDesc").setContent(response.about);
                    //jQuery("#").val();

                    if (response.hours !== undefined) {
                        if (response.hours.mon_1_close !== undefined) {
                            jQuery("#i_segunda").val(response.hours.mon_1_open);
                            jQuery("#f_segunda").val(response.hours.mon_1_close);
                            jQuery("#chk_segunda").prop('checked', true);
                        } else {
                            jQuery("#chk_segunda").prop('checked', false);
                            jQuery("#i_segunda").val("");
                            jQuery("#f_segunda").val("");
                        }
                        if (response.hours.tue_1_close !== undefined) {
                            jQuery("#i_terca").val(response.hours.tue_1_open);
                            jQuery("#f_terca").val(response.hours.tue_1_close);
                            jQuery("#chk_terca").prop('checked', true);
                        } else {
                            jQuery("#chk_terca").prop('checked', false);
                            jQuery("#i_terca").val("");
                            jQuery("#f_terca").val("");
                        }
                        if (response.hours.wed_1_close !== undefined) {
                            jQuery("#i_quarta").val(response.hours.wed_1_open);
                            jQuery("#f_quarta").val(response.hours.wed_1_close);
                            jQuery("#chk_quarta").prop('checked', true);
                        } else {
                            jQuery("#chk_quarta").prop('checked', false);
                            jQuery("#i_quarta").val("");
                            jQuery("#f_quarta").val("");
                        }
                        if (response.hours.thu_1_close !== undefined) {
                            jQuery("#i_quinta").val(response.hours.thu_1_open);
                            jQuery("#f_quinta").val(response.hours.thu_1_close);
                            jQuery("#chk_quinta").prop('checked', true);
                        } else {
                            jQuery("#chk_quinta").prop('checked', false);
                            jQuery("#i_quinta").val("");
                            jQuery("#f_quinta").val("");
                        }
                        if (response.hours.fri_1_close !== undefined) {
                            jQuery("#i_sexta").val(response.hours.fri_1_open);
                            jQuery("#f_sexta").val(response.hours.fri_1_close);
                            jQuery("#chk_sexta").prop('checked', true);
                        } else {
                            jQuery("#chk_sexta").prop('checked', false);
                            jQuery("#i_sexta").val("");
                            jQuery("#f_sexta").val("");
                        }
                        if (response.hours.sat_1_close !== undefined) {
                            jQuery("#i_sabado").val(response.hours.sat_1_open);
                            jQuery("#f_sabado").val(response.hours.sat_1_close);
                            jQuery("#chk_sabado").prop('checked', true);
                        } else {
                            jQuery("#chk_sabado").prop('checked', false);
                            jQuery("#i_sabado").val("");
                            jQuery("#f_sabado").val("");
                        }
                        if (response.hours.sun_1_close !== undefined) {
                            jQuery("#i_domingo").val(response.hours.sun_1_open);
                            jQuery("#f_domingo").val(response.hours.sun_1_close);
                            jQuery("#chk_domingo").prop('checked', true);
                        } else {
                            jQuery("#chk_domingo").prop('checked', false);
                            jQuery("#i_domingo").val("");
                            jQuery("#f_domingo").val("");
                        }
                        if (response.location !== undefined) {
                            jQuery("#city").val(response.location.city);
                            jQuery("#zip").val(response.location.zip);
                            jQuery("#lat").val(response.location.latitude);
                            jQuery("#lon").val(response.location.longitude);
                            jQuery("#street").val(response.location.street);
                            jQuery("#state").val(response.location.state);
                            jQuery("#country").val(response.location.country);
                        } else {
                            jQuery("#city").val("");
                            jQuery("#zip").val("");
                            jQuery("#lat").val("");
                            jQuery("#lon").val("");
                            jQuery("#street").val("");
                            jQuery("#state").val("");
                            jQuery("#country").val("");
                        }
                    }
                    if (response.category_list !== undefined) {
                        for (i = 0; i < response.category_list.length; i++) {
                            $("#businessType").append($("<option></option>").val(response.category_list[i].id + ":" + response.category_list[i].name).html(response.category_list[i].name));
                        }
                    }
                    if (response.picture !== undefined) {
                        jQuery("#picLogoURL").val(response.picture.data.url);
                        jQuery("#picLogo").html("<img src='" + response.picture.data.url + "' style='max-width:300px'/>");
                    } else {
                        jQuery("#picLogoURL").val("");
                        jQuery("#picLogo").html("");

                    }
                    if (response.cover !== undefined) {
                        jQuery("#picCapaURL").val(response.cover.source);
                        jQuery("#picCapa").html("<img src='" + response.cover.source + "' style='max-width:300px'/>");
                    } else {
                        jQuery("#picCapaURL").val("");
                        jQuery("#picCapa").html("");
                    }
                    console.log(response);
                }
        );
        //element.prop('checked', true);
        // });
    }

    window.fbAsyncInit = function () {
        FB.init({
            appId: '1405126029586258',
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v2.12'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    document.getElementById('businessType').value = '<?php echo isset($business->meta[BUSINESS_TYPE][0]) ? $business->meta[BUSINESS_TYPE][0] : ""; ?>';
</script>