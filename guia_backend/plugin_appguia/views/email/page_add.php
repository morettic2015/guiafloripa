<?php
include_once PLUGIN_ROOT_DIR . 'views/email/EmailController.php';
$ec = new EmailController();
$emailId = $ec->saveUpdateEmail($_POST);
// echo "<pre>";
$pId = "";
if ($_GET['pid'] !== "") {
    // echo "post";
    $pId = $_GET['pid'];
    $post = $ec->getEmail($_GET['pid']);
} else if ($emailId) {
    $pId = $emailId;
    $post = $ec->getEmail($emailId);
}
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><?php echo (empty($pId) ? "" : '<a target="_target" href="admin-ajax.php?action=email_template&pid=' . $pId . '" class="page-title-action">Visualizar</a>'); ?></h1>
    <div class="notice notice-info"> 
        <p>Crie seu email marketing para enviar em sua campanha</p>
    </div>
    <hr/>
    <form id="terms-crud" onsubmit="return validate()" name="terms" action="admin.php?page=app_guiafloripa_mail_add&pid=<?php echo $_GET['pid'] ?>" method="post">


        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td class="first" style="text-align: right"><span class="dashicons dashicons-sticky"></span> <label for="name"> Assunto</label></td>
                                <td>
                                    <input type="hidden" name="id" id="id" value="<?php echo empty($post) ? "" : $post->post->ID; ?>">
                                    <input type="text" value="<?php echo $post->post->post_title; ?>" name="subject" id="subject" spellcheck="true"  size="30"  placeholder="Assunto da mensagem">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><span class="dashicons dashicons-admin-comments"></span> Mensagem<br><span class="description">Conteúdo do seu email</span></td>
                                <td>
                                    <?php
                                    $content = $post->post->post_content;
                                    $editor_id = 'txtDesc';

                                    wp_editor($content, $editor_id, array('media_buttons' => false, 'quicktags' => false, 'textarea_rows' => 3));
                                    ?>
                                    

                                </td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><span class="dashicons dashicons-admin-links"></span> Link</td>
                                <td><input type="text" name="link" id="link" value="<?php echo $post->meta[M_LINK][0]; ?>"  spellcheck="true"  size="30"  placeholder="http://"></td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Titulo do botão</td>
                                <td><input type="text" name="txtBt" id="txtBt" value="<?php echo $post->meta[TXT_BT][0]; ?>" spellcheck="true"  size="30"  placeholder="Compre seu ticket!"></td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><span class="dashicons dashicons-editor-textcolor"></span> Cor do tema</td>
                                <td><input type="text" name="colorpicker" id="colorpicker" value="<?php echo $post->meta[COLOR_PICKER][0]; ?>" spellcheck="true"  size="30"  placeholder="Compre seu ticket!"></td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><span class="dashicons dashicons-facebook-alt"></span> Link Facebook</td>
                                <td><input type="text" name="linkFacebook" value="<?php echo $post->meta[FACE][0]; ?>" value="" spellcheck="true"  size="30"  placeholder="https://facebook.com/minhapagina"></td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><span class="dashicons dashicons-twitter"></span> Link Twitter</td>
                                <td><input type="text" name="linkTwitter" id="linkTwitter" value="<?php echo $post->meta[TWITTER][0]; ?>" spellcheck="true"  size="30"  placeholder="@meuperfil"></td>

                            </tr>
                            <?php
                            if (get_user_meta(get_current_user_id(), "_plano_type", true)) {
                                ?>
                                <tr>
                                    <td class="first" style="text-align: right"> 
                                        <span class="dashicons dashicons-format-image"></span> Logotipo
                                    </td>
                                    <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input id="content_url" value="<?php echo $post->meta[LOGO_URL][0]; ?>" name="content_url" type="hidden" readonly="readonly"/>
                                        <input type="button" value="Selecione" class="button button-primary" style="width: 25%" onclick="upload_new_img(this)"/>   
                                        <a href="javascript:void(0);" onclick="remove_image(this);" style="width: 25%" class="button button-primary">Remover</a>
                                        <div id="imgPreview"><img src="<?php echo $post->meta[LOGO_URL][0]; ?>"/></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first" style="text-align: right"> 
                                        <span class="dashicons dashicons-images-alt"></span> Imagem publicitária
                                    </td>
                                    <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input id="content_url1" value="<?php echo $post->meta[LOGO_URL1][0]; ?>" name="content_url1" type="hidden" readonly="readonly"/>
                                        <input type="button" value="Selecione" class="button button-primary" style="width: 25%" onclick="upload_new_img1(this)"/>   
                                        <a href="javascript:void(0);" onclick="remove_image1(this);" style="width: 25%" class="button button-primary">Remover</a>
                                        <div id="imgPreview1"><img src="<?php echo $post->meta[LOGO_URL1][0]; ?>"/></div>
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
