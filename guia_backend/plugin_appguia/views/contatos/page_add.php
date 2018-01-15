<?php
/* include_once PLUGIN_ROOT_DIR . 'views/email/EmailController.php';
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
  } */
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><?php echo (empty($pId) ? "" : '<a target="_target" href="admin-ajax.php?action=email_template&pid=' . $pId . '" class="page-title-action">Visualizar</a>'); ?></h1>
    <div class="notice notice-info"> 
        <p>Gerencie seus contatos</p>
    </div>
    <hr/>
    <form id="terms-crud" onsubmit="return validate()" name="terms" action="admin.php?page=app_guiafloripa_mail_add&pid=<?php echo $_GET['pid'] ?>" method="post">


        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    <h1>
                                        Informações do Contato
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><label for="name">Nome</label></td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="hidden" name="id" id="id" value="<?php echo empty($post) ? "" : $post->post->ID; ?>">
                                    <input type="text" name="firstName" id="firstName" spellcheck="true"  size="30"  placeholder="Nome">

                                </td>
                                <td class="first" style="text-align: right"><label for="name">Sobrenome</label></td>
                                <td >
                                    <input type="text" name="lastName" id="lastName" spellcheck="true"  size="30"  placeholder="Sobrenome">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><label for="name">Apelido</label></td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="nick" id="nick" spellcheck="true"  size="30"  placeholder="Apelido">
                                </td>
                                <td class="first" style="text-align: right"><label for="name">Pessoa Jurídica?</label></td>
                                <td >
                                    <input style="width: 50px" type="checkbox" name="pj" id="pj" spellcheck="true"  size="30" >
                                    <br><span class="description">Se o contato pertence a uma empresa marque esta opção</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Email</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="email" name="email" id="email" spellcheck="true"  size="30"  placeholder="mail@mail.com">
                                </td>


                                <td class="first" style="text-align: right">cpf/cnpj</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="pfpj" id="actor" spellcheck="true"  size="30"  placeholder="Ex: 000.000.000-00">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Empresa</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="organization" id="organization" spellcheck="true"  size="30"  placeholder=" Empresa Ltda">
                                </td>
                                <td class="first" style="text-align: right">Setor</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="actor" id="actor" spellcheck="true"  size="30"  placeholder="Engenharia">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Website</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="website" id="website" spellcheck="true"  size="30"  placeholder="http://...">
                                </td>
                                <td class="first" style="text-align: right">Whatsapp</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="whats" id="whats" spellcheck="true"  size="30"  placeholder="+55 48 996004929">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Telefone fixo</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="phone1" id="phone1" spellcheck="true"  size="30"  placeholder="+55 48 32224929">
                                </td>
                                <td class="first" style="text-align: right">Telefone Comercial</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="phone2" id="phone2" spellcheck="true"  size="30"  placeholder="+55 48 996004929">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Endereço</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="address" id="address" spellcheck="true"  size="30"  placeholder="Ex: Rua General Vieia da Rosa">
                                </td>
                                <td class="first" style="text-align: right">Complemento</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="comp" id="comp" spellcheck="true"  size="30"  placeholder="Apto 321">
                                </td>
                            </tr>
                            <?php
                            if (get_user_meta(get_current_user_id(), "_plano_type", true)) {
                                ?>
                                <tr>
                                    <td class="first" style="text-align: right"> 
                                        Imagem de Perfil
                                    </td>
                                    <td colspan="3" style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input id="content_url" value="<?php echo $post->meta[LOGO_URL][0]; ?>" name="content_url" type="hidden" readonly="readonly"/>
                                        <input type="button" value="Selecione" class="button button-primary" style="width: 25%" onclick="upload_new_img(this)"/>   
                                        <a href="javascript:void(0);" onclick="remove_image(this);" style="width: 25%" class="button button-primary">Remover</a>
                                        <div id="imgPreview"><img src="<?php echo $post->meta[LOGO_URL][0]; ?>"/></div>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                            <tr>
                                <td colspan="5">
                                    <h1>
                                        Redes Sociais
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Facebook</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="facebook" id="facebook" spellcheck="true"  size="30"  placeholder="http://...">
                                </td>
                                <td class="first" style="text-align: right">Skype</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Skype" id="Skype" spellcheck="true"  size="30"  placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">LinkedIn</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="LinkedIn" id="LinkedIn" spellcheck="true"  size="30"  placeholder="http://...">
                                </td>
                                <td class="first" style="text-align: right">Twitter</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Twitter" id="Twitter" spellcheck="true"  size="30"  placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Instagram</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Instagram" id="Instagram" spellcheck="true"  size="30"  placeholder="http://...">
                                </td>
                                <td class="first" style="text-align: right">Google</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Twitter" id="Google" spellcheck="true"  size="30"  placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <h1>
                                        Grupos
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Seus grupos</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <select multiple="5" style="width: 80%;">
                                        <option>
                                            Selecione
                                        </option>
                                    </select>
                                </td>
                                <td class="first" style="text-align: right">
                                    Grupos do usuário
                                </td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <select multiple="5" style="width: 80%;">
                                        <option>
                                            Selecione
                                        </option>
                                    </select>

                                </td>
                            </tr>

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
