<?php
wp_enqueue_media('media-upload');
wp_enqueue_media('thickbox');
wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
wp_enqueue_media('my-upload');
wp_enqueue_style('thickbox');
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Importar Evento</a></h1>

    <div class="notice notice-info"> 
        <p>1) Cadastre seu <code>Evento</code><br>2) Vincule um <code>estabelecimento</code><br>3) Envie para publicação</p>
    </div>
    <div id="message-term"></div>
    <hr/>
    <form id="terms-crud" name="terms" action="admin.php?page=app_guiafloripa_twitter_add_term" method="post">
        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td class="first" style="text-align: right">Título</td>
                                <td>
                                    <input type="text"  placeholder="Titulo do Evento"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Descrição</td>
                                <td>
                                    <textarea id="txtDesc" class="tinymce_data" style="width:100%;" rows="8"  placeholder="Descrição do seu evento com informações para o seu público">
                                        
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Início</td>
                                <td><input type="datetime-local" style="width:200px;max-width: 100%"/></td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Fim</td>
                                <td> <input type="datetime-local" style="width:200px;max-width: 100%"/></td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"> 
                                    Foto destaque
                                </td>
                                <td>
                                    <input id="content_url" name="content_url" type="hidden" readonly="readonly"/>
                                    <input type="button" value="Selecione" class="button button-primary button-primary" style="width: 150px" onclick="upload_new_img(this)"/>   
                                    <a href="javascript:void(0);" onclick="remove_image(this);" class="remove_image">Remove</a>
                                    <div id="imgPreview"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Categorias</td>
                                <td style="float: left">
                                    <label>Lazer <input type="radio" name="unfavorite" value="SIM" style="height: 15px;width: 20px"></label>
                                    <label>Cultura <input type="radio" name="unfavorite" value="SIM" style="height: 15px;width: 20px"></label>
                                    <label>Free <input type="radio" name="unfavorite" value="SIM" style="height: 15px;width: 20px"></label>
                                    <label>Evento <input type="radio" name="unfavorite" value="SIM" style="height: 15px;width: 20px"></label>
                                    <label>Infantil <input type="radio" name="unfavorite" value="SIM" style="height: 15px;width: 20px"></label>

                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Estabelecimento</td>
                                <td style="float: left">
                                    <a href="admin.php?page=app_guiafloripa_eventos_add">Adicionar</a>
                                    <input type="text" name="unfollow" width="200px"  placeholder="Digite o nome do estabelecimento">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Youtube</td>
                                <td>
                                    <input type="text" placeholder="Vídeo promocional"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Facebook</td>
                                <td>
                                    <input type="text"  placeholder="Endereço do Evento no Facebook"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Criar campanha para este evento?</td>
                                <td>
                                    <input type="checkbox" name="unfavorite" value="SIM" style="width: 40px">
                                </td>
                            </tr>

                            <tr>
                                <td class="first"  style="text-align: right">Publicado?</td>
                                <td>
                                    <input type="checkbox" name="unretweet" value="SIM" style="width: 40px">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <br>
                    <input type="submit" name="btSaveTerm" value="Prévia do Evento" class="page-title-action"/>
                </fieldset>
            </div>
        </div>
    </form>
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
</script>