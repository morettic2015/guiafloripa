<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<form>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
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
                    <b>Dados do seu negócio.</b>
                </p>
                <p>
                <table class="form-table editcomment" style="max-width: 100%">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right">Nome da Empresa</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="nmNegocio" id="nmNegocio" placeholder="Nome do meu negócio" />
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Tipo do Negócio</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <?php
                                $terms = get_terms(array('taxonomy' => 'business_type', 'hide_empty' => false));
                                //  var_dump($terms);
                                ?>
                                <select>
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
                                <input type="text" name="cnpjNegocio" placeholder="19.611.312/00001-18" />
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Webite</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="urlNegocio" id="urlNegocio" placeholder="http" />
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Whatsapp</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="whatsNegocio" placeholder="http" />
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Fone Comercial</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="foneNegocio" id="foneNegocio" placeholder="http" />
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Página do Facebook</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" name="faceNegocio" placeholder="http" /><a href="javascript:loadFacebook()" class="page-title-action">Sincronizar</a>
                                <div id="facePages" style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 5px;"></div>

                            </td>

                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Google Business</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" placeholder="http" /><a href="#" class="page-title-action">Sincronizar</a>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Cartões de crédito</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="checkbox"/>American
                                <input type="checkbox"/>Amex
                                <input type="checkbox"/>Credicard
                                <input type="checkbox"/>Discover
                                <input type="checkbox"/>Master
                                <input type="checkbox"/>Visa
                            </td>

                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Descrição do negócio</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <?php
                                $content = "";
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
                            <td><input type="checkbox"/> </td>
                            <td><input type="time"/> </td>
                            <td><input type="time"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Segunda</td>
                            <td><input type="checkbox"/> </td>
                            <td><input type="time"/> </td>
                            <td><input type="time"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Terça</td>
                            <td><input type="checkbox"/> </td>
                            <td><input type="time"/> </td>
                            <td><input type="time"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Quarta</td>
                            <td><input type="checkbox"/> </td>
                            <td><input type="time"/> </td>
                            <td><input type="time"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Quinta</td>
                            <td><input type="checkbox"/> </td>
                            <td><input type="time"/> </td>
                            <td><input type="time"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Sexta</td>
                            <td><input type="checkbox"/> </td>
                            <td><input type="time"/> </td>
                            <td><input type="time"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Sabado</td>
                            <td><input type="checkbox"/> </td>
                            <td><input type="time"/> </td>
                            <td><input type="time"/> </td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-4">
                <p>

                </p>
            </div>
            <div id="tabs-5">
                <p>

                </p>
            </div>
            <div id="tabs-6">
                <p>

                </p>
            </div>
            <input type="button" onclick="saveCampaign()" name="btSaveCampaign" style="width: 99%" value="Salvar" class="page-title-action"/>
        </div>
        <hr/>
    </div>
</form>
<script>
    jQuery(function ($) {
        $("#tabs").tabs();
    });


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
                            jQuery('#facePages').append('<input onclick="loadPageById(this)" type="radio" name="facePage" id="facePage" value="' + pages[i].id + '" /> ' + pages[i].name + '<br />');
                        }
                    }
            );
        }, {scope: 'manage_pages'});

    }

    function loadPageById(element) {
        var pageSelected = "/" + element.value;
        //FB.login(function () {
        FB.api(
                pageSelected,
                'GET',
                {"fields": "about,location,picture{url},hours,emails,cover,phone,website,whatsapp_number,category,category_list,company_overview,contact_address,name,payment_options,general_info"},
                function (response) {
                    // alert(JSON.stringify(response));
                    jQuery("#nmNegocio").val(response.name);
                    jQuery("#foneNegocio").val(response.phone);
                    jQuery("#urlNegocio").val(response.website);
                    tinyMCE.get("txtDesc").setContent(response.about);
                    //jQuery("#").val();
                    console.log(response);
                }
        );
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
</script>