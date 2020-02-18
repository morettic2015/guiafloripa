<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Adicionar</a><a href="admin.php?page=app_guiafloripa_eventos_imp" class="page-title-action">Importar do Facebook</a></h1>

    <div class="notice notice-info"> 
        <p>Lista de <code>Eventos</code> vinculados ao seu perfil.</p>
    </div>

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="movies-filter" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
        <?php $test_list_table->display() ?>
    </form>

</div>
<div id="dialog" title="Atenção">
    <p id="dialog_content"></p>
</div>
<script>
    var mdialog;
    jQuery(function ($) {
        mdialog = $("#dialog").dialog({
            autoOpen: false,
            resizable: false,
            height: "auto",
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
        //showPop(null,1);
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
    .alert{
        margin: 0 auto;
        margin-top: 50px;
        max-width: 640px;
        min-width: 250px;
        width: 80% !important;
        left: 0 !important;
        right: 0 !important;
        height: auto !important;
    }
</style>