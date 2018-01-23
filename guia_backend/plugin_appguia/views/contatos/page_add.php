<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<?php
include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
$ec = new ContatosController();
$profileId = $ec->saveUpdateProfile($_POST);
// echo "<pre>";
$lead = $ec->getLead($_GET);
//var_dump($lead);
?>
<a name="top"/>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><?php echo (empty($pId) ? "" : '<a target="_target" href="admin-ajax.php?action=email_template&pid=' . $pId . '" class="page-title-action">Visualizar</a>'); ?></h1>
    <div class="notice notice-info" id="msg"> 
        <p>Gerencie seus contatos</p>
    </div>
    <hr/>
    <form onsubmit="return validateLead()" id="terms-crud" onsubmit="return validate()" name="terms" action="admin.php?page=app_guiafloripa_leads_add&pid=<?php echo $_GET['pid'] ?>" method="post">


        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td colspan="5" >
                                    <h1>
                                        Informações do Contato
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><label for="name">Nome</label></td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="hidden" name="id" id="id" value="<?php echo empty($post) ? "" : $post->post->ID; ?>">
                                    <input type="text" name="firstName" id="firstName" spellcheck="true"  size="30"  placeholder="Nome" value="<?php echo $lead->first_name; ?>">

                                </td>
                                <td class="first" style="text-align: right"><label for="name">Sobrenome</label></td>
                                <td >
                                    <input type="text" name="lastName" id="lastName" spellcheck="true"  size="30"  placeholder="Sobrenome" value="<?php echo $lead->last_name; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right"><label for="name">Apelido</label></td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" maxlength="40" name="nick" id="nick" spellcheck="true"  size="30"  placeholder="Apelido" value="<?php echo $lead->info->nickname; ?>">
                                </td>
                                <td class="first" style="text-align: right"><label for="name">Pessoa Jurídica?</label></td>
                                <td >
                                    <input style="width: 50px" type="checkbox" name="pj" id="pj" spellcheck="true"  size="30" <?php echo $lead->pj > 0 ? "checked" : ""; ?> >
                                    <br><span class="description">Se o contato pertence a uma empresa marque esta opção</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="first dashicons-before dashicons-email" style="text-align: right">Email</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="email" name="email" id="email" spellcheck="true"  size="30"  placeholder="mail@mail.com" value="<?php echo $lead->info->user_email; ?>">
                                </td>


                                <td class="first" style="text-align: right">cpf/cnpj</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="pfpj" id="pfpj" spellcheck="true"  placeholder="Ex: 000.000.000-00" value="<?php echo $lead->pfpj; ?>" size="18" OnKeyUp="cnpj_cpf(this.name, this.value, 'terms', this.form)" onKeypress="campo_numerico()" maxlength="18">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Empresa</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="organization" id="organization" spellcheck="true"  size="30"  placeholder=" Empresa Ltda"  value="<?php echo $lead->organization; ?>">
                                </td>
                                <td class="first" style="text-align: right">Setor</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="actor" id="actor" spellcheck="true"  size="30"  placeholder="Engenharia"  value="<?php echo $lead->actor; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="first dashicons-before dashicons-admin-site" style="text-align: right">Website</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="website" id="website" spellcheck="true"  size="30"  placeholder="http://..." value="<?php echo $lead->info->user_url; ?>">
                                </td>
                                <td class="first dashicons-before dashicons-phone" style="text-align: right">Whatsapp</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="whats" id="whats" spellcheck="true"  size="30"  placeholder="(48) 996004929" value="<?php echo $lead->whatsapp; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="first dashicons-before dashicons-phone" style="text-align: right">Fixo</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="phone1" id="phone1" spellcheck="true"  size="30"  placeholder="(48) 32224929" value="<?php echo $lead->fixo; ?>">
                                </td>
                                <td class="first dashicons-before dashicons-phone" style="text-align: right">Comercial</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="phone2" id="phone2" spellcheck="true"  size="30"  placeholder="(48) 996004929" value="<?php echo $lead->comercial; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Endereço</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="address" id="address" spellcheck="true"  size="30"  placeholder="Ex: Rua General Vieia da Rosa"  value="<?php echo $lead->address; ?>">
                                </td>
                                <td class="first" style="text-align: right">Complemento</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="comp" id="comp" spellcheck="true"  size="30"  placeholder="Apto 321"  value="<?php echo $lead->comp; ?>">
                                </td>
                            </tr>
                            <?php
                            if (get_user_meta(get_current_user_id(), "_plano_type", true)) {
                                ?>
                                <tr>
                                    <td class="first dashicons-before dashicons-admin-media" style="text-align: right"> 
                                        Imagem de Perfil
                                    </td>
                                    <td colspan="3" style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input id="content_url" value="<?php echo $lead->content_url; ?>" name="content_url" type="hidden" readonly="readonly"/>
                                        <input type="button" value="Selecione" class="button button-primary" style="width: 25%" onclick="upload_new_img(this)"/>   
                                        <a href="javascript:void(0);" onclick="remove_image(this);" style="width: 25%" class="button button-primary">Remover</a>
                                        <div id="imgPreview" style="margin-top: 20px"><img src="<?php echo $lead->content_url; ?>" style="max-width: 200px"/></div>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                            <tr>
                                <td colspan="5">
                                    <hr>
                                    <h1>
                                        Redes Sociais
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td class="first dashicons-before dashicons-facebook" style="text-align: right">Facebook</td>
                                <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input  type="text" name="facebook" id="facebook" spellcheck="true"  size="30"  placeholder="http://..." value="<?php echo $lead->facebook; ?>">
                                </td>
                                <td class="first dashicons-before dashicons-admin-links" style="text-align: right">Skype</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Skype" id="Skype" spellcheck="true"  size="30"  placeholder="" value="<?php echo $lead->Skype; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="first dashicons-before dashicons-admin-links" style="text-align: right">LinkedIn</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="LinkedIn" id="LinkedIn" spellcheck="true"  size="30"  placeholder="http://..." value="<?php echo $lead->LinkedIn; ?>">
                                </td>
                                <td class="first dashicons-before dashicons-twitter" style="text-align: right">Twitter</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Twitter" id="Twitter" spellcheck="true"  size="30"  placeholder="" value="<?php echo $lead->Twitter; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="first dashicons-before dashicons-admin-links" style="text-align: right">Instagram</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Instagram" id="Instagram" spellcheck="true"  size="30"  placeholder="http://..." value="<?php echo $lead->Instagram; ?>">
                                </td>
                                <td class="first dashicons-before dashicons-googleplus" style="text-align: right">Google</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="Google" id="Google" spellcheck="true"  size="30"  placeholder="" value="<?php echo $lead->Google; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <a name="groups"/>
                                    <hr>
                                    <h1>
                                        Grupos
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Adicionar grupo</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" style="width: 150px" name="groupName" id="groupName" placeholder="Nome do Grupo"/>
                                    <input type="button" id="plus" name="plus" value="+" class="button button-primary" style="width: 50px">

                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Seus grupos</td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="hidden" name="vlGroups" id="vlGroups"/>
                                    <select name="myGroups" id="myGroups" style="width: 80%;height: 120px;margin-top: 10px" size="7">
                                        <?php
                                        $_myGroups = $ec->getUserGroups();
                                        foreach ($_myGroups as $opt) {
                                            ?>
                                            <option value="<?php echo $opt; ?>">
                                                <?php echo strtoupper($opt); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <br>
                                    <input onclick="addToUser()" type="button" id="addGroup"  name="addGroup" value="Adicionar" class="button button-primary" style="width: 90px">
                                    <input type="hidden" id="myGroupsVal" name="myGroupsVal"/>
                                </td>
                                <td class="first" style="text-align: right">
                                    Grupos do usuário
                                    <br><span class="description">Para remover clique no nome</span>

                                </td>
                                <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px;vertical-align:middle;">
                                    <div id="userGroups" style="max-width: 300px">
                                        <?php
                                        //var_dump($lead->groupList);
                                        $disableds = "";
                                        foreach ($lead->groupList as $lGroup) {
                                            echo "<input onclick='removeGroupByClick(this)' type='button' name='$lGroup->groupName' value='$lGroup->groupName' class='button button-primary' style='max-width:90px;min-width:20px;margin:5px;font-size:8px'/>";
                                            $disableds .= "disableOneGroup('$lGroup->groupName');\n";
                                        }
                                        ?>
                                    </div>

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
    function campo_numerico() {

        if (event.keyCode < 45 || event.keyCode > 57)
            event.returnValue = false;

    }

// Função verifica qual das funções tem que chamar cpf ou cnpj
    function cnpj_cpf(campo, documento, f, formi) {

        if (document.getElementById('pj').checked) {
            mascara_cnpj(campo, documento, f);
        } else {
            mascara_cpf(campo, documento, f);
        }
    }

// Mascara para o CNPJ
    function mascara_cnpj(campo, documento, f) {
        var mydata = '';
        mydata = mydata + documento;

        if (mydata.length == 2) {
            mydata = mydata + '.';

            ct_campo = eval("document." + f + "." + campo + ".value = mydata");
            ct_campo;
        }

        if (mydata.length == 6) {
            mydata = mydata + '.';

            ct_campo = eval("document." + f + "." + campo + ".value = mydata");
            ct_campo;
        }

        if (mydata.length == 10) {
            mydata = mydata + '/';

            ct_campo1 = eval("document." + f + "." + campo + ".value = mydata");
            ct_campo1;
        }

        if (mydata.length == 15) {
            mydata = mydata + '-';

            ct_campo1 = eval("document." + f + "." + campo + ".value = mydata");
            ct_campo1;
        }

        if (mydata.length == 18) {

            valida_cnpj(f, campo);
        }
    }

// Mascara para o CPF
    function mascara_cpf(campo, documento, f) {
        var mydata = '';
        mydata = mydata + documento;

        if (mydata.length == 3) {
            mydata = mydata + '.';

            ct_campo = eval("document." + f + "." + campo + ".value = mydata");
            ct_campo;
        }

        if (mydata.length == 7) {
            mydata = mydata + '.';

            ct_campo = eval("document." + f + "." + campo + ".value = mydata");
            ct_campo;
        }

        if (mydata.length == 11) {
            mydata = mydata + '-';

            ct_campo1 = eval("document." + f + "." + campo + ".value = mydata");
            ct_campo1;
        }

        if (mydata.length == 14) {

            valida_cpf(f, campo);
        }

    }

// Função para validar o CNPJ
    function valida_cnpj(f, campo) {

        pri = eval("document." + f + "." + campo + ".value.substring(0,2)");
        seg = eval("document." + f + "." + campo + ".value.substring(3,6)");
        ter = eval("document." + f + "." + campo + ".value.substring(7,10)");
        qua = eval("document." + f + "." + campo + ".value.substring(11,15)");
        qui = eval("document." + f + "." + campo + ".value.substring(16,18)");

        var i;
        var numero;
        var situacao = '';

        numero = (pri + seg + ter + qua + qui);

        s = numero;


        c = s.substr(0, 12);
        var dv = s.substr(12, 2);
        var d1 = 0;

        for (i = 0; i < 12; i++) {
            d1 += c.charAt(11 - i) * (2 + (i % 8));
        }

        if (d1 == 0) {
            var result = "falso";
        }
        d1 = 11 - (d1 % 11);

        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(0) != d1) {
            var result = "falso";
        }

        d1 *= 2;
        for (i = 0; i < 12; i++) {
            d1 += c.charAt(11 - i) * (2 + ((i + 1) % 8));
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(1) != d1) {
            var result = "falso";
        }


        if (result == "falso") {
            jQuery('#msg').removeClass("notice-info");
            jQuery("#msg").addClass("notice-error");
            jQuery("#msg").html("O CNPJ informado é inválido");
            document.location.href = "#top";
            aux1 = eval("document." + f + "." + campo + ".focus");
            //aux2 = eval("document." + f + "." + campo + ".value = ''");
            errorField(jQuery("#pfpj"));
        } else {
            defaultField(jQuery("#pfpj"))
        }
    }

// Função valida o CPF
    function valida_cpf(f, campo) {

        pri = eval("document." + f + "." + campo + ".value.substring(0,3)");
        seg = eval("document." + f + "." + campo + ".value.substring(4,7)");
        ter = eval("document." + f + "." + campo + ".value.substring(8,11)");
        qua = eval("document." + f + "." + campo + ".value.substring(12,14)");

        var i;
        var numero;

        numero = (pri + seg + ter + qua);

        s = numero;
        c = s.substr(0, 9);
        var dv = s.substr(9, 2);
        var d1 = 0;

        for (i = 0; i < 9; i++) {
            d1 += c.charAt(i) * (10 - i);
        }

        if (d1 == 0) {
            var result = "falso";
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(0) != d1) {
            var result = "falso";
        }

        d1 *= 2;
        for (i = 0; i < 9; i++) {
            d1 += c.charAt(i) * (11 - i);
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(1) != d1) {
            var result = "falso";
        }

        // Condição falsa
        if (result == "falso") {
            jQuery('#msg').removeClass("notice-info");
            jQuery("#msg").addClass("notice-error");
            jQuery("#msg").html("O CPF informado é inválido");
            document.location.href = "#top";
            aux1 = eval("document." + f + "." + campo + ".focus");
            //aux2 = eval("document." + f + "." + campo + ".value = ''");
            errorField(jQuery("#pfpj"));
        } else {
            defaultField(jQuery("#pfpj"))
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
    function validateLead() {
        var noError = true;
        if (jQuery("#firstName").val() === "") {
            errorField(jQuery("#firstName"));
            noError = false;
        } else {
            defaultField(jQuery("#firstName"));
        }
        if (jQuery("#lastName").val() === "") {
            errorField(jQuery("#lastName"));
            noError = false;
        } else {
            defaultField(jQuery("#lastName"));
        }
        if (jQuery("#nick").val() === "") {
            errorField(jQuery("#nick"));
            noError = false;
        } else {
            defaultField(jQuery("#nick"));
        }
        if (jQuery("#email").val() === "") {
            errorField(jQuery("#email"));
            noError = false;
        } else {
            defaultField(jQuery("#email"));
        }
        //vlGroups  myGroups
        var groups = document.getElementById('myGroups');
        var groupsList = new Array();
        for (i = 0; i < groups.length; i++) {
            if (groups[i].disabled) {
                groupsList.push(groups[i].text)
            }
        }
        document.getElementById('vlGroups').value = encodeURI(JSON.stringify(groupsList));

        if (!noError) {
            jQuery('#msg').removeClass("notice-info");
            jQuery("#msg").addClass("notice-error");
            jQuery("#msg").html("Verifique os campos marcados em vermelho e tente outra vez</b>");
            document.location.href = "#top";
        }

        return noError;
    }

    function disableOneGroup(nmGroup) {
        sel = document.getElementById("myGroups");
        for (i = 0; i < sel.length; i++) {
            if (sel[i].text === nmGroup) {
                sel[i].disabled = true;
                break;
            }
        }
    }

    function removeGroupByClick(element) {
        if (confirm("Deseja remover o usuário do grupo:" + element.value + "?")) {
            element.remove();
            sel = document.getElementById("myGroups");
            for (i = 0; i < sel.length; i++) {
                if (sel[i].text === this.value) {
                    sel[i].disabled = false;
                    break;
                }
            }
        }
    }

    function addToUser() {
        var sel = document.getElementById("myGroups");
        var dest = document.getElementById("userGroups");
        var opt1 = document.createElement("button");
        opt1.setAttribute("id", sel.value);
        opt1.setAttribute("value", sel.value);
        opt1.setAttribute("class", "button button-primary");
        opt1.setAttribute("style", "margin:5px;font-size:8px");
        opt1.setAttribute("name", sel.value);
        opt1.onclick = function () {
            // alert(this.innerHTML);
            removeGroupByClick(this);
        }
        opt1.appendChild(document.createTextNode(sel.value));
        dest.appendChild(opt1);

        for (var i = 0, iLen = sel.length; i < iLen; i++) {
            if (sel[i].value === sel.value) {
                sel[i].disabled = true;
                break;
            }
        }
    }
    document.getElementById('plus').onclick = function () {
        jQuery.ajax({
            url: "admin-ajax.php?action=insert_groups_profile",
            type: 'post',
            data: {
                groupName: document.getElementById('groupName').value
            },
            success: function (response) {
                var optionOne = response.split(",");
                if (optionOne[1] === undefined)
                    return;

                var x = document.getElementById("myGroups");
                var option = document.createElement("option");
                option.text = optionOne[1];
                option.value = optionOne[1];
                x.add(option);
            },
            error: function (e) {
                alert(e);
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
    jQuery(document).ready(function ($) {
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };

        $('#whats').mask(SPMaskBehavior, spOptions);
        $('#phone1').mask(SPMaskBehavior, spOptions);
        $('#phone2').mask(SPMaskBehavior, spOptions);
    });

<?php echo $disableds; ?>
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
