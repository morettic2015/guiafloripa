<?php

//PortalController::inserPost();
// var_dump($json);
/**
 * @Load categories from GuiaFloripa Website
 */
function updateEvent($p) {
    if (isset($_POST['placeName'])) {
        @session_start();
        echo "<pre>";
        var_dump($_POST);
        var_dump($_SESSION);


        $query = "INSERT INTO `guiafloripa`.`wp_posts`
                        (
                        `post_author`,
                        `post_date`,
                        `post_date_gmt`,
                        `post_content`,
                        `post_title`,
                        `post_excerpt`,
                        `post_status`,
                        `comment_status`,
                        `ping_status`,
                        `post_name`,
                        `to_ping`,
                        `pinged`,
                        `post_modified`,
                        `post_modified_gmt`,
                        `post_content_filtered`,
                        `post_parent`,
                        `guid`,
                        `menu_order`,
                        `post_type`,
                        `post_mime_type`,
                        `comment_count`)
                        VALUES
                        (
                        NULL,
                        57,
                        now(),
                        now(),
                        'CONTEUDO DO POST',
                        'TITULO DO POST',
                        'EXCREPCT DO POST',
                        'draft',
                        'closed',
                        'closed',
                        'Conteudo do post teste 1',
                        0,
                        0,
                        now(),
                        now(),
                        'TESTE DE PAMONHA',
                        NULL,
                        'TESTE_DE_PAMINHA',
                        0,
                        'teste',
                        'post',
                        0);";
        $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
        // var_dump($app_db);
        $data = $app_db->get_results($query);

        var_dump($app_db);
        echo "</pre>";

        die;
        return true;
    }
    return false;
}

function loadCategories() {

    $args = array(
        'user-agent' => 'GuiaFloripaAPP',
        'headers' => array(),
    );
    $response = wp_remote_get("https://guiafloripa.morettic.com.br/portal_categorias/");
    // echo "<pre>";
    // var_dump($response['body']);
    // echo "</pre>";
    return json_decode($response['body']);
}

$categories = loadCategories();
?>
<a name="top"/>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?> <a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Importar Evento</a></h1>
    <?php
    if (updateEvent($p)) {
        
    } else {
        ?>
        <div class="notice notice-info" id="alertMessage"> 
            <p>1) Cadastre seu <code>Evento</code><br>2) Vincule um <code>estabelecimento</code><br>3) Envie para publicação</p>
        </div>
        <div id="message-term"></div>
        <hr/>
        <form id="events_crud" name="terms" action="admin.php?page=app_guiafloripa_eventos_add" method="post" >
            <div id="namediv" class="stuffbox"><div id="message-term"></div>
                <div class="inside">
                    <fieldset>
                        <table class="form-table editcomment">
                            <tbody>
                                <tr>
                                    <td class="first" style="text-align: right">Estabelecimento</td>
                                    <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input type="text" name="placeName" id="placeName" style="width: 40%"  placeholder="Digite o nome do estabelecimento" onblur="validateOnBlur(jQuery('#placeName'))">
                                        <a href="javascript:addPlace()" class="button button-primary">Adicionar</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="first" style="text-align: right">Título</td>
                                    <td>
                                        <input type="text" id="titEvent" name="titEvent"  placeholder="Titulo do Evento"   onblur="validateOnBlur(jQuery('#titEvent'))"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">
                                        Descrição
                                    </td>
                                    <td>
                                        <textarea id="txtDesc"  name="txtDesc" class="tinymce_data" style="width:100%;" rows="8"  placeholder="Descrição do seu evento com informações para o seu público"  onblur="validateOnBlur(jQuery('#txtDesc'))"></textarea>
                                        <small>caracteres<code id="counterChar">500</code></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Datas (inicio e fim)</td>
                                    <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input type="datetime-local" name="dtStart" id="dtStart" style="width:30%"   onblur="validateOnBlur(jQuery('#dtStart'))"/>
                                        <input type="datetime-local" name="dtEnd" id="dtEnd" style="width:30%"  onblur="validateOnBlur(jQuery('#dtEnd'))"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right"> 
                                        Foto destaque
                                    </td>
                                    <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input id="content_url" name="content_url" type="hidden" readonly="readonly"/>
                                        <input type="button" value="Selecione" class="button button-primary" style="width: 25%" onclick="upload_new_img(this)"/>   
                                        <a href="javascript:void(0);" onclick="remove_image(this);" style="width: 25%" class="button button-primary">Remover</a>
                                        <div id="imgPreview"></div>
                                    </td>
                                </tr>
                                <tr >
                                    <td class="first" style="text-align: right">Categorias</td>
                                    <td>
                                        <div style="width: 100%" id="divCategories">

                                            <?php
                                            $i = 1;
                                            foreach ($categories->list as $cat) {
                                                //var_dump($cat);
                                                ?>
                                                <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                    <input type="checkbox" id="categories" name="categories[]" value="<?php echo $cat->termID; ?>" style="height: 15px;width: 20px"><?php echo $cat->name; ?> 
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Região da ilha</td>
                                    <td>
                                        <div style="width: 100%">

                                            <?php
                                            $i = 1;
                                            foreach ($categories->regions as $cat) {
                                                //var_dump($cat);
                                                ?>
                                                <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                    <input class="singleOne" type="checkbox" name="region" id="region" value="<?php echo $cat->meta_key; ?>" style="height: 15px;width: 20px"><?php echo $cat->meta_key; ?> 
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Bairro</td>
                                    <td>
                                        <input type="text" id="neigh" name="neigh" style="width: 200px" placeholder="Bairro do Evento"  onblur="validateOnBlur(jQuery('#neigh'))"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Praia</td>
                                    <td>
                                        <input type="text" id="beach" name="beach" style="width: 200px" placeholder="Praia do Evento" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Ingresso</td>
                                    <td style="width: 33%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input type="text"  placeholder="Ex: Convite, Promoção" style="width: 40%"/>
                                        <input type="text"  placeholder="Valor, free" style="width: 40%"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Whatsapp</td>
                                    <td>
                                        <input type="text" id="whats" name="whats" placeholder="Telefone para contato"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Link para ingressos</td>
                                    <td>
                                        <input type="text" id="ingresso" name="ingresso"  placeholder="Link para a compra de ingressos"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="first" style="text-align: right">Youtube / Vimeo</td>
                                    <td>
                                        <input type="text" name="youtube" id="youtube" placeholder="Vídeo promocional"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Facebook</td>
                                    <td>
                                        <input type="text" id="linkFace" name="linkFace"  placeholder="Endereço do Evento no Facebook"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Criar campanha para este evento?</td>
                                    <td>
                                        <input type="checkbox" name="createCampaign" value="SIM" style="width: 40px">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first"  style="text-align: right">Desconto por compartilhamento?</td>
                                    <td>
                                        <input type="checkbox" name="discount" value="SIM" style="width: 40px">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="first"  style="text-align: right">Publicado?</td>
                                    <td>
                                        <input type="checkbox" name="published" value="SIM" style="width: 40px">
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <br>
                        <input type="button" name="btSaveEvent" value="Salvar Evento" class="page-title-action" onclick="validation.isValid(); void(0)"/>
                    </fieldset>
                </div>
            </div>
        </form>

    </div>
    <div id="dialog" title="Atenção">
        <p id="dialog_content"></p>
    </div>

    <style>
        input[type="checkbox"]{
            appearance:none;
            width:40px;
            height:16px;
            border:1px solid #aaa;
            border-radius:2px;
            background:#ebebeb;
            position:relative;
            display:inline-block;
            overflow:hidden;
            vertical-align:middle;
            transition: background 0.3s;
            box-sizing:border-box;
        }
        input[type="checkbox"]:after{
            content:'';
            position:absolute;
            top:-1px;
            left:-1px;
            width:14px;
            height:14px;
            background:white;
            border:1px solid #aaa;
            border-radius:2px;
            transition: left 0.1s cubic-bezier(0.785, 0.135, 0.15, 0.86);
        }
        input[type="checkbox"]:checked{
            background:#a6c7ff;
            border-color:#8daee5;
        }
        input[type="checkbox"]:checked:after{
            left:23px;
            border-color:#8daee5;
        }

        input[type="checkbox"]:hover:not(:checked):not(:disabled):after,
        input[type="checkbox"]:focus:not(:checked):not(:disabled):after{
            left:0px;
        }

        input[type="checkbox"]:hover:checked:not(:disabled):after,
        input[type="checkbox"]:focus:checked:not(:disabled):after{
            left:22px;
        }

        input[type="checkbox"]:disabled{
            opacity:0.5;
        }
        .first{
            color: #122b40;
        }
    </style>

    <script>
        function upload_new_img(obj)
        {
            var file_frame;
            var img_name = jQuery(obj).closest('p').find('.upload_image');
            if (file_frame) {
                file_frame.open();
                return;
            }

            file_frame = wp.media.frames.file_frame = wp.media(
                    {
                        title: 'Imagens dos seus Eventos',
                        button: {
                            text: jQuery(this).data('uploader_button_text')
                        },
                        multiple: false
                    }
            );
            file_frame.on('select', function () {
                attachment = file_frame.state().get('selection').first().toJSON();
                document.getElementById('content_url').value = attachment.url;
                document.getElementById("imgPreview").innerHTML = '<br><img style="max-width:200px;border:1px" src="' + attachment.url + '"/>'
                file_frame.close();
            });
            file_frame.open();
        }

        function remove_image(obj) {
            document.getElementById("imgPreview").innerHTML = "";
            document.getElementById('content_url').value = "";
        }
        var mdialog;
        /**
         * @JQuery UI elements
         * */
        jQuery(function ($) {
            $("#placeName").suggest(ajaxurl + "?action=wpwines-dist-regions", {delay: 500, minchars: 3});
            $("#beach").suggest(ajaxurl + "?action=findBeachsAjax", {delay: 500, minchars: 3});
            $("#neigh").suggest(ajaxurl + "?action=findNeighoodAjax", {delay: 500, minchars: 2});
            mdialog = $("#dialog").dialog({
                autoOpen: false,
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Confirmar": function () {
                        $("#events_crud").submit()
                    },
                    Revisar: function () {
                        $(this).dialog("close");
                    }
                }
            });
            $('#txtDesc').html().trim();
            $('input.singleOne').on('change', function () {
                $('input.singleOne').not(this).prop('checked', false);
            });
            $('#txtDesc').keyup(function () {
                length = 500 - $('#txtDesc').val().length;
                $('#counterChar').text(length);
            });
            $('#txtDesc').keydown(function (e) {
                var text = $(this).val();
                var chars = text.length;
                if (chars > 499) {
                    if (e.keyCode == 46 || e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40) {
                        return true;
                    }
                    return false;
                }
                return true;
            });
        });
        function addPlace() {
            var show = mdialog.dialog("open", "true");
            //mdialog.dialog("open", "true", {effect: "blind", duration: 800});

        }
        var validateForm = function () {
            this.hasErrors = false;
            this.str = "<b>";
            this.isValid = function () {
                this.hasErrors = false;
                this.str = "";
                jQuery("#alertMessage").html("");
                if (jQuery('#placeName').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe o nome do estabelecimento<br>";
                    errorField(jQuery('#placeName'));
                } else {
                    defaultField(jQuery('#placeName'));
                }
                if (jQuery('#titEvent').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe o título do evento<br>";
                    errorField(jQuery('#titEvent'));
                } else {
                    defaultField(jQuery('#titEvent'));
                }
                if (jQuery('#txtDesc').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe a descrição do evento<br>";
                    errorField(jQuery('#txtDesc'));
                } else {
                    defaultField(jQuery('#txtDesc'));
                }
                if (jQuery('#neigh').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe o bairro do evento<br>";
                    errorField(jQuery('#neigh'));
                } else {
                    defaultField(jQuery('#neigh'));
                }
                /**if (jQuery('#content_url').val() === "") {
                 this.hasErrors = true;
                 this.str += " - Adicione uma imagem de destaque no evento<br>";
                 }*/
                if (jQuery('#dtStart').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe a data de inicio do evento<br>";
                    errorField(jQuery('#dtStart'));
                } else {
                    defaultField(jQuery('#dtStart'));
                }
                if (jQuery('#dtEnd').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe a data fim do evento<br>";
                    errorField(jQuery('#dtEnd'));
                } else {
                    defaultField(jQuery('#dtEnd'));
                }
                var hasChecked = false;
                jQuery('input:checkbox[id=categories]:checked').each(function () {
                    console.log($(this).val());
                    hasChecked = true;
                });
                if (!hasChecked) {
                    this.hasErrors = true;
                    this.str += " - Informe a categoria do evento<br>";
                }
                hasChecked = false;
                jQuery('input:checkbox[name=region]:checked').each(function () {
                    console.log($(this).val());
                    hasChecked = true;
                });
                if (!hasChecked) {
                    this.hasErrors = true;
                    this.str += " - Informe a região do evento<br>";
                }

                if (this.hasErrors) {
                    jQuery('#alertMessage').removeClass("notice-info");
                    jQuery("#alertMessage").addClass("notice-error");
                    jQuery("#alertMessage").html(this.str + "</b>");
                    document.location.href = "#top";
                } else {
                    jQuery('#alertMessage').removeClass("notice notice-info");
                    jQuery("#alertMessage").addClass("notice notice-success");
                    jQuery("#alertMessage").html("Sucesso salvando seu evento....");
                }

                console.log(jQuery('#dtEnd').val());
                //  mdialog.dialog("open", "true");
                if (!this.hasErrors) {
                    jQuery("#dialog_content").html("<p class='notice-info'>Falta um passo para salvar as alterações em seu evento. <br><code>Confirme</code> para prosseguir ou <code>Revise</code> seu evento</p>")
                    show = mdialog.dialog("open", "true");
                }
            }
        }

        function validateOnBlur(field) {
            if (field.val() === "") {
                errorField(field);
                // field.focus();
            } else {
                defaultField(field);
            }
        }

        function errorField(field) {
            field.css('border-color', '#c89494');
            field.css('background-color', '#F9D3D3');
        }
        function defaultField(field) {
            field.css('border-color', 'blue');
            field.css('background-color', 'white');
            field.parent().append('<span class="ui-icon ui-icon-clock" style="display:inline-block"></span>');
        }
        var validation = new validateForm();

    </script>
<?php } ?>
</div>