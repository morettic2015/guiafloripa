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
    <form id="events_crud" name="terms" action="admin.php?page=app_guiafloripa_eventos_imp" method="post" >
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
                                                Passo 2: Importe a localização do seu evento (estabelecimento)
                                            </h3>
                                            <h4>
                                                Importar Estabelecimento
                                            </h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Local do Evento</td>
                                        <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                            <?php echo $facebook->place->name ?>
                                            <input type="hidden" name="placeName" value="<?php echo $facebook->place->name; ?>"/>
                                            <input type="hidden" name="lat" value="<?php echo $facebook->place->location->latitude; ?>"/>
                                            <input type="hidden" name="lon" value="<?php echo $facebook->place->location->longitude; ?>"/>
                                            <input type="hidden" name="facebook_place_id" value="<?php echo $facebook->place->id; ?>"/>
                                            <input type="hidden" name="facebook_event_id" value="<?php echo $facebook->id; ?>"/>
                                            <input type="hidden" name="street" value="<?php echo $facebook->place->location->street . ',' . $facebook->place->location->city . ',' . $facebook->place->location->country; ?>"/>
                                            <input type="hidden" name="eventID" value="<?php echo $facebook->postID; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Endereço</td>
                                        <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                            <?php echo $facebook->place->location->street . ',' . $facebook->place->location->city . ',' . $facebook->place->location->country; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Categorias *</td>
                                        <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                            <?php
                                            $categories = $ec->loadCategories();
                                            foreach ($categories->list as $cat) {
                                                //var_dump($cat);
                                                ?>
                                                <div style="width: 30%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                    <input type="checkbox" id="categories" name="categories[]" value="<?php echo $cat->termID; ?>" style="height: 15px;width: 20px"><?php echo $cat->name; ?> 
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Região da ilha *</td>
                                        <td>


                                            <?php
                                            $i = 1;
                                            foreach ($categories->regions as $cat) {
                                                //var_dump($cat);
                                                ?>
                                                <div style="width: 30%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                                    <input class="singleOne" type="checkbox" name="region" id="region" value="<?php echo $cat->meta_key; ?>" style="height: 15px;width: 20px"><?php echo $cat->meta_key; ?> 
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Bairro *</td>
                                        <td>
                                            <input type="text" id="neigh" name="neigh" style="width: 200px" placeholder="Bairro do Evento" />
                                            <br><span class="description">Informe o bairro e selecione o resultado</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Praia *</td>
                                        <td>
                                            <input type="text" id="beach" name="beach" style="width: 200px" placeholder="Praia do Evento" />
                                            <br><span class="description">Informe a praia proxima e selecione o resultado</span>
                                        </td>
                                    </tr>
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
            position: 'center',
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
        var options = {
            autoOpen: false,
            draggable: false,
            resizable: false,
            dialogClass: "alert",
            modal: true,
            title: titulo,
            position: 'center',
            height: 480
        };
        mdialog.load("admin-ajax.php?action=load_event_edit&page=" + page + "&id=" + id).dialog(options).dialog('open');
    }
</script>