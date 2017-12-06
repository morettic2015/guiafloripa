<?php
include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
$ec = new EventControl();

//PortalController::inserPost();
// var_dump($json);
/**
 * @Load categories from GuiaFloripa Website
 */
function updateEvent($p) {
    if (isset($_POST['placeName'])) {
        //echo "<pre>";
        //var_dump($_POST);
        //var_dump($_SESSION);

        $ec = new EventControl();
        $post1 = $ec->insertEvent($_POST);
        //var_dump($post1);
        ?>
        <div class="notice notice-info" > 
            <p>Seu evento foi criado com sucesso.</p>
            <p>Uma <a href="admin.php?page=app_guiafloripa_campaigns">campanha</a> modelo foi criada. Edite para promover seu evento</p>
        </div>
        <?php
        die;
        return true;
    }
    return false;
}

$categories = $ec->loadCategories();
?>
<a name="top"/>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?> <!--<a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Importar Evento</a>--></h1>
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
                                        <a href="javascript:addPlace()" class="button button-primary">Adicionar</a><br>
                                        <span class="description">Informe o nome do estabelecimento onde vai ocorrer o evento</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="first" style="text-align: right">Título</td>
                                    <td>
                                        <input type="text" id="titEvent" name="titEvent"  placeholder="Titulo do Evento"   onblur="validateOnBlur(jQuery('#titEvent'))"/>
                                        <span class="description">Informe o título como vai aparecer no Site e no APP</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">
                                        Descrição
                                    </td>
                                    <td>
                                        <textarea id="txtDesc"  name="txtDesc" class="tinymce_data" style="width:100%;" rows="8"  placeholder="Descrição do seu evento com informações para o seu público"  onblur="validateOnBlur(jQuery('#txtDesc'))"></textarea>
                                        <span class="description">caracteres restantes<code id="counterChar">500</code></span>
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
                                <tr>
                                    <td class="first" style="text-align: right">Data e hora (inicio e fim)</td>
                                    <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input type="date" name="dtStart" id="dtStart" style="width:25%"   onblur="validateOnBlur(jQuery('#dtStart'))"/>
                                        <input type="time" name="hrStart" id="hrStart" style="width:10%"   onblur="validateOnBlur(jQuery('#hrStart'))"/>
                                        <input type="date" name="dtEnd" id="dtEnd" style="width:25%"  onblur="validateOnBlur(jQuery('#dtEnd'))"/>
                                        <input type="time" name="hrEnd" id="hrEnd" style="width:10%"   onblur="validateOnBlur(jQuery('#hrEnd'))"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Recorrência semanal</td>
                                    <td>
                                        <div style="width: 100%">
                                            <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Mon" style="height: 15px;width: 20px">Segunda-Feira
                                            </div>
                                            <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Tue" style="height: 15px;width: 20px">Terça-Feira
                                            </div>
                                            <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Wed" style="height: 15px;width: 20px">Quarta-Feira
                                            </div>
                                            <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Thu" style="height: 15px;width: 20px">Quinta-Feira
                                            </div>
                                            <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Fri" style="height: 15px;width: 20px">Sexta-Feira
                                            </div>
                                            <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Sat" style="height: 15px;width: 20px">Sábado
                                            </div>
                                            <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Sun" style="height: 15px;width: 20px">Domingo
                                            </div>
                                        </div>
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
                                        <br><span class="description">Informe o bairro</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Praia</td>
                                    <td>
                                        <input type="text" id="beach" name="beach" style="width: 200px" placeholder="Praia do Evento" />
                                        <br><span class="description">Praia proxima</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Ingresso</td>
                                    <td style="width: 33%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input type="text" name="vevent_info"  placeholder="Ex: Convite, Promoção" style="width: 40%"/>
                                        <input type="text" name="vevent_price" placeholder="Valor, free" style="width: 40%"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Email de contato</td>
                                    <td>
                                        <input style="width: 50%" type="email" id="email" name="email" placeholder="meuemail@guiafloripa.com.br"  onblur="validateOnBlur(jQuery('#email'))"/><br>
                                        <span class="description">Email para receber mensagens dos clientes</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Whatsapp</td>
                                    <td>
                                        <input type="text"  style="width: 50%" id="whats" name="whats" placeholder="Telefone para contato"/><br>
                                        <span class="description">Whats ou celular de contato</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Link para ingressos</td>
                                    <td>
                                        <input type="text" id="ingresso" name="ingresso"  placeholder="Link para a compra de ingressos"/>
                                        <span class="description">URL do link para o ingresso</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="first" style="text-align: right">Youtube / Vimeo</td>
                                    <td>
                                        <input type="text" name="youtube" id="youtube" placeholder="Vídeo promocional"/>
                                        <span class="description">Endereço do video começando com http...</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Facebook</td>
                                    <td>
                                        <input type="text" id="linkFace" name="linkFace"  placeholder="Endereço do Evento no Facebook"/>
                                        <span class="description">Endereço no face começando com http...</span>
                                    </td>
                                </tr>
                               <!-- <tr>
                                    <td class="first" style="text-align: right">Criar campanha para este evento?</td>
                                    <td>
                                        <input type="checkbox" name="createCampaign" value="SIM" style="width: 40px">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td class="first"  style="text-align: right">Desconto promocional</td>
                                    <td  style="width: 33%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input type="checkbox" name="discount" value="SIM" style="width: 40px">
                                        <label>Percentual de desconto<input type="number" name="discountAmount" id="discountAmount" style="width: 50px"/>%</label>
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
            $("#placeName").suggest(ajaxurl + "?action=wpwines-dist-regions", {delay: 500, minchars: 4});
            $("#beach").suggest(ajaxurl + "?action=findBeachsAjax", {delay: 500, minchars: 4});
            $("#neigh").suggest(ajaxurl + "?action=findNeighoodAjax", {delay: 500, minchars: 4});
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

            $("#dtStart").datepicker("option", "dateFormat", "dd/mm/yy");

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
                if (jQuery('#vevent_info').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe o preço<br>";
                    errorField(jQuery('#vevent_info'));
                } else {
                    defaultField(jQuery('#vevent_info'));
                }
                if (jQuery('#vevent_price').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe o preço do evento<br>";
                    errorField(jQuery('#vevent_price'));
                } else {
                    defaultField(jQuery('#vevent_price'));
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
                if (jQuery('#email').val() === "") {
                    this.hasErrors = true;
                    this.str += " - Informe o email de contato<br>";
                    errorField(jQuery('#email'));
                } else {
                    defaultField(jQuery('#email'));
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
                    jQuery("#dialog_content").html("<p class='notice-info'>Falta um passo para você começar a divulgar oseu evento. <br><code>Confirme</code> para prosseguir ou <code>Revise</code>&nbsp;seu evento</p>")
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