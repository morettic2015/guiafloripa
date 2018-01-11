<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><a href="#" class="page-title-action">Visualizar</a></h1>
    <div class="notice notice-info"> 
        <p>Crie seu email marketing para enviar em sua campanha</p>
    </div>
    <hr/>
    <form id="terms-crud" onsubmit="return validate()" name="terms" action="admin.php?page=app_guiafloripa_mail_add" method="post">
        <?php 
        var_dump($_POST);
        ?>

        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td class="first" style="text-align: right">Nome interno</td>
                                <td>
                                    <input type="text" name="nmInterno" id="nmInterno" value="" spellcheck="true"  size="30" placeholder="nome-interno-da-mensagem_123">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><label for="name">Assunto</label></td>
                                <td><input type="text" name="subject" id="subject" value="" spellcheck="true"  size="30"  placeholder="Assunto da mensagem"></td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Cabeçalho</td>
                                <td><input type="text" name="header" id="header" value="" spellcheck="true"  size="30"  placeholder="Cabeçalho da mensagem"></td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Mensagem</td>
                                <td>
                                    <?php
                                    $content = '';
                                    $editor_id = 'txtDesc';

                                    wp_editor($content, $editor_id, array('media_buttons' => false, 'quicktags' => false));
                                    ?>
                                </td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Link</td>
                                <td><input type="text" name="link" id="link" value="" spellcheck="true"  size="30"  placeholder="http://"></td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Titulo do botão</td>
                                <td><input type="text" name="txtBt" id="txtBt" value="" spellcheck="true"  size="30"  placeholder="Compre seu ticket!"></td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Cor do botão</td>
                                <td><input type="text" name="colorpicker" id="colorpicker" value="" spellcheck="true"  size="30"  placeholder="Compre seu ticket!"></td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Link Facebook</td>
                                <td><input type="text" name="linkFacebook" id="linkFacebook" value="" spellcheck="true"  size="30"  placeholder="https://facebook.com/minhapagina"></td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Link Twitter</td>
                                <td><input type="text" name="linkTwitter" id="linkTwitter" value="" spellcheck="true"  size="30"  placeholder="@meuperfil"></td>

                            </tr>
                            <?php
                            if (get_user_meta(get_current_user_id(), "_plano_type", true)) {
                                ?>
                                <tr>
                                    <td class="first" style="text-align: right"> 
                                        Logotipo
                                    </td>
                                    <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input id="content_url" name="content_url" type="hidden" readonly="readonly"/>
                                        <input type="button" value="Selecione" class="button button-primary" style="width: 25%" onclick="upload_new_img(this)"/>   
                                        <a href="javascript:void(0);" onclick="remove_image(this);" style="width: 25%" class="button button-primary">Remover</a>
                                        <div id="imgPreview"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right"> 
                                        Imagem publicitária
                                    </td>
                                    <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input id="content_url1" name="content_url1" type="hidden" readonly="readonly"/>
                                        <input type="button" value="Selecione" class="button button-primary" style="width: 25%" onclick="upload_new_img1(this)"/>   
                                        <a href="javascript:void(0);" onclick="remove_image1(this);" style="width: 25%" class="button button-primary">Remover</a>
                                        <div id="imgPreview1"></div>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <input type="submit" name="btSaveTerm" value="Salvar" class="page-title-action"/>

                </fieldset>
            </div>
        </div>
    </form>

</div>
<script>
    jQuery(function ($) {

        $("#colorpicker").wpColorPicker({
            // you can declare a default color here,
            // or in the data-default-color attribute on the input
            //defaultColor: false,

            // a callback to fire whenever the color changes to a valid color
            change: function (event, ui) {},
            // a callback to fire when the input is emptied or an invalid color
            clear: function () {},
            // hide the color picker controls on load
            hide: true,
            // set  total width
            width: 200,
            // show a group of common colors beneath the square
            // or, supply an array of colors to customize further
            palettes: ['#444444', '#ff2255', '#559999', '#99CCFF', '#00c1e8', '#F9DE0E', '#111111', '#EEEEDD']
        });


    });
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
                    title: 'Logotipo',
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
    function upload_new_img1(obj)
    {
        var file_frame;
        var img_name = jQuery(obj).closest('p').find('.upload_image');
        if (file_frame) {
            file_frame.open();
            return;
        }

        file_frame = wp.media.frames.file_frame = wp.media(
                {
                    title: 'Imagem publicitária',
                    button: {
                        text: jQuery(this).data('uploader_button_text')
                    },
                    multiple: false
                }
        );
        file_frame.on('select', function () {
            attachment = file_frame.state().get('selection').first().toJSON();
            document.getElementById('content_url1').value = attachment.url;
            document.getElementById("imgPreview1").innerHTML = '<br><img style="max-width:200px;border:1px" src="' + attachment.url + '"/>'
            file_frame.close();
        });
        file_frame.open();
    }

    function remove_image1(obj) {
        document.getElementById("imgPreview1").innerHTML = "";
        document.getElementById('content_url1').value = "";
    }
</script>
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
