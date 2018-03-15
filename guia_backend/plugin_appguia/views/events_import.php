<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php
    include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
    $current_user = wp_get_current_user();
    $ec = new EventControl();
    if (isset($_POST['facebook_place_id'])) {//Import place
        var_dump($_POST);
        wp_die();
    } else if (isset($_POST['facebook_event_ids'])) {//Import event
        $facebook = $ec->importEvents($_POST);
        //wp_die();
    }

    /* echo "<pre>";
      var_dump($facebook);
      echo "</pre>"; */
    ?>
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <div class="notice notice-info" id="alertMessage"> 
        <p>1) Informe o código do seu <code>Evento</code> no Facebook<br>2) Vincule ou cadastre um <code>estabelecimento</code><br>3) Envie para publicação</p>
    </div>
    <div id="message-term"></div>
    <hr/>
    <form id="events_crud1" name="terms1" action="admin.php?page=app_guiafloripa_eventos_imp" method="post" >
        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <?php if (empty($_POST['facebook_event_ids'])) { ?>
                                <tr>
                                    <td class="first" colspan="2"><h3 style="margin: 0px;">Passo 1: Informe o código do evento no Facebook</h3></td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">ID do Evento Público no Facebook</td>
                                    <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input type="text" name="facebook_event_ids" <?php echo empty($_POST['facebook_event_ids']) ? "" : "readonly"; ?> class="facebook_event_ids" style="min-width: 200px;max-width: 400px" value="<?php echo $_POST['facebook_event_ids']; ?>">
                                        <br>
                                        <span class="description">ID do Evento para https://www.facebook.com/events/123456789/ é "123456789"</span>
                                    </td>
                                </tr>
                                <?php
                            }
                            if ($facebook !== NULL) {
                                ?>
                                <tr>
                                    <td class="first" colspan="2">
                                        <h3>
                                            Passo 1: Selecione as categorias do seu evento
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">Nome do Evento</td>
                                    <td><?php echo $facebook->name; ?></td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right">
                                        Informações seu evento
                                    </td>
                                    <td>
                                        <div  colspan="2" style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                            <input type="button" value="Geral" class="button button-primary" style="width: 100px;margin-bottom: 10px" onclick="showPop('general',<?php echo $facebook->postID; ?>);"/>   
                                            <input type="button" value="Datas" class="button button-primary" style="width: 80px;margin-bottom: 10px" onclick="showPop('dates',<?php echo $facebook->postID; ?>);"/>   
                                            <input type="button" value="Categorias" class="button button-primary" style="width: 120px;margin-bottom: 10px;border: 1px;border-color: red;border-style: dotted;background-color: orange" onclick="showPop('categ',<?php echo $facebook->postID; ?>);"/>   
                                            <input type="button" value="Imagem" class="button button-primary" style="width: 70px;margin-bottom: 10px" onclick="showPop('image',<?php echo $facebook->postID; ?>);"/>   
                                            <input type="button" value="Complemento" class="button button-primary" style="width: 150px;margin-bottom: 10px" onclick="showPop('comp',<?php echo $facebook->postID; ?>);"/>   
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                if (count($facebook->placeGuia) > 0) {
                                    ?>

                                    <tr>
                                        <td class="first" style="text-align: right">Estabelecimento localizado</td>
                                        <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">

                                            <?php
                                            foreach ($facebook->placeGuia as $pId) {
                                                echo $pId->post_title;
                                            }
                                            echo '<div class="notice notice-error"> 
                                                    <p><strong>Evento importado com sucesso. Verifique as informações antes de publicar no Guia Floripa!<br>Por favor selecione as categorias que se aplicam ao seu evento no botao laranja</strong></p>
                                                  </div>';
                                            ?>

                                            <br>
                                        </td>
                                    </tr>
                                    <?php
                                } else {//Need to add place
                                    ?>
                                    <tr>
                                        <td class="first" colspan="2">
                                            <hr>
                                            <h3>
                                                Passo 2: Informe o estabelecimento de realização do evento
                                            </h3>
                                            <p>
                                                Localize o estabelecimento e associe com o evento
                                                <input type="text" id="srcPlace" name="srcPlace" placeholder="Ex: Fields" style="max-width: 300px"/>
                                                <input style="max-width: 90px" onclick="associatePlaceEvent('admin-ajax.php?action=save_event_place&eventID=<?php echo $facebook->postID; ?>&eventName=')" type="button" name="slv" value="Associar" class="page-title-action"/>
                                            </p>
                                            <p>
                                                Caso o estabelecimento não seja localizado cadastre <a href="admin.php?page=app_guiafloripa_negocio_add&source=event&eventID=<?php echo $facebook->postID; ?>" class="page-title-action"/>Cadastre aqui</a>
                                            </p>
                                        </td>
                                    </tr>
                                <script>
                                    jQuery(function ($) {
                                        $("#srcPlace").suggest(ajaxurl + "?action=wpwines-dist-regions", {delay: 400, minchars: 4});
                                        $("#srcPlace").change(function (e) {
                                            placeIsSelected = true;
                                        });
                                    })
                                </script>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php if (!count($facebook->placeGuia) > 0) { ?>
                        <input type="submit" name="btImportEvent" value="Importar" class="page-title-action"/>
                    <?php }
                    ?>


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
        width:20px;
        height:16px;
        border:1px solid #aaa;
        border-radius:2px;
        background:#ebebeb;
        position:relative;
        display:inline-block;
        overflow:hidden;
        vertical-align:middle;
        margin-right: 10px; 
        transition: background 0.3s;
        box-sizing:border-box;
    }
    input[type="checkbox"]:after{
        content:'';
        position:absolute;
        top:-1px;
        left:-1px;
        width:7px;
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
        left:13px;
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
</style>
<script>
    var mdialog;
    jQuery(function ($) {
        /*$("#placeName").suggest(ajaxurl + "?action=wpwines-dist-regions", {delay: 400, minchars: 4});
         $("#placeName").change(function (e) {
         placeIsSelected = true;
         });*/
        $("#beach").suggest(ajaxurl + "?action=findBeachsAjax", {delay: 400, minchars: 4});
        $("#beach").change(function (e) {
            bairroIsSelected = true;
        });
        $("#neigh").suggest(ajaxurl + "?action=findNeighoodAjax", {delay: 400, minchars: 4});
        $("#neigh").change(function (e) {
            praiaIsSelected = true;
        });
        mdialog = $("#dialog").dialog({
            autoOpen: false,
            resizable: false,
            height: "auto",
            position: "center",
            draggable: true,
            //dialogClass: "alertDialog",
            width: 300,
            modal: true,
            buttons: {
                "Atualizar": function () {
                    $.ajax({
                        url: $("#events_crud").attr('action'),
                        type: 'POST',
                        data: $("#events_crud").serialize(),
                        success: function (result) {
                            console.log(JSON.stringify(result));
                            mdialog.html('<div class="notice notice-info"><p>Evento atualizado com sucesso.</p></div>');
                        },
                        error: function (e) {
                            console.log(JSON.stringify(e));
                            mdialog.html('<div class="notice notice-error"><p>Ocorreu um erro ao atualizar o evento. Por favor tente mais tarde.</p></div>');
                        }
                    });
                }
            }
        });
    });
    function showPop(page, id) {
        mdialog.html("<center><br><br><br><img src='https://app.guiafloripa.com.br/wp-content/uploads/2017/12/SpecificCharmingLeafcutterant-max-1mb.gif'/></center>")
        loadDynamicContentModal(page, id);
    }
    function loadDynamicContentModal(page, id) {
        var titulo = "";
        if (page === "general") {
            titulo = "Informações";
        } else if (page === "image") {
            titulo = "Imagem do Evento";
        } else if (page === "comp") {
            titulo = "Complemento";
        } else if (page === "place") {
            titulo = "Estabelecimento";
        } else if (page === "dates") {
            titulo = "Datas do Evento";
        } else if (page === "categ") {
            titulo = "Categorias";
        } else if (page === "local") {
            titulo = "Localização";
        }
        /* var options = {
         autoOpen: false,
         draggable: false,
         resizable: false,
         //dialogClass: "alert",
         modal: true,
         title: titulo,
         position: 'center',
         height: 480
         };*/
        mdialog.load("admin-ajax.php?action=load_event_edit&page=" + page + "&id=" + id).dialog('open');
    }

    function associatePlaceEvent(url) {
        url += jQuery("#srcPlace").val();
        //alert(url);
        jQuery.get(url, function (data) {
            console.log(data);
            if (data.error === undefined) {
                alert('Localização do evento salva com sucesso!')
                window.location.href = "admin.php?page=app_guiafloripa_eventos";
            } else {
                alert(data.error);
            }
        });
    }
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
</script>