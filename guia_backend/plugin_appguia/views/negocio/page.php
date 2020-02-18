<?php
include_once PLUGIN_ROOT_DIR . 'views/negocio/NegocioController.php';
include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
$ec = new EventControl();
$categories = $ec->loadCategories();
$nc = new NegocioController();
$rest = $nc->getMaxBusiness();
if (isset($_POST['nmNegocio'])) {
    $business = $nc->insertUpdateNegocio($_POST);
} else {
    $business = $nc->findNegocioById($_GET['id']);
}
if (isset($_GET['eventID'])) {
    echo ' <div class="notice notice-warning" > 
            <p><span class="dashicons dashicons-warning"></span>&nbsp;Após cadastrar o negócio lembre-se de associar com o evento!</p>
        </div>';
}

/* echo isset($business->id) ? $business->id:(isset($_GET['id'])?$_GET['id']:"");
 *//* echo "<pre>"; 
  var_dump($business);
  /* var_dump($_POST);
 */ /* echo "</pre>"; */
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<form name="frm_negocio" method="post" onsubmit="setImages()">
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?><a href="javascript:loadFacebook()" class="page-title-action">Importar página do Facebook</a></h1>
        <div class="notice notice-info" id="msg"> 
            <p>Configure o seu negócio</p>
        </div>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-2">Dados Gerais</a></li>
                <li><a href="#tabs-3">Horários</a></li>
                <li><a href="#tabs-4">Endereço</a></li>
                <?php if (!empty(get_user_meta(get_current_user_id(), "_plano_type", true))) { ?>
                    <li><a href="#tabs-5">Fotos</a></li>
                <?php } ?>
                <li><a href="#tabs-6">Configurações</a></li>
            </ul>
            <div id="tabs-2">
                <p>
                    <span class="dashicons dashicons-feedback"></span> <b>Dados do meu negócio.</b>
                    <br>
                </p>
                <p>
                <table class="form-table editcomment" style="max-width: 800px">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right;;max-width: 300px" id="titPgFace"></td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px" id="facePages"></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-sticky"></span> Nome do negócio*</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="nmNegocio" id="nmNegocio" placeholder="Nome do meu negócio" style="width: 100%" value="<?php echo isset($business->post) ? $business->post->post_title : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-category"></span> Categorias do Facebook</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <?php
                                $terms = get_terms(array('taxonomy' => 'business_type', 'hide_empty' => false));
                                //  var_dump($terms);
                                ?>
                                <select name="businessType" id="businessType">
                                    <?php
                                    echo '<optgroup label="Categorias do Facebook">';
                                    foreach ($terms as $t) {
                                        echo "<option value='" . $t->term_id . "'>" . $t->name . "</option>";
                                    }
                                    echo '</optgroup>';
                                    ?>

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-category"></span> Categoria*</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <select name="businessTypeGuia" id="businessTypeGuia" onchange="loadSubCategory(this)">
                                    <?php
                                    $mc = $nc->getCategoriasGuia(NULL);
                                    echo '<optgroup label="Categorias do Guiafloripa">';
                                    foreach ($mc as $t) {
                                        echo "<option value='" . $t->term_id . "'>" . $t->name . "</option>";
                                    }
                                    echo '</optgroup>';
                                    ?>

                                </select>
                                <br>
                                <span class="description">Selecione a categoria de atuação do seu negócio</span>

                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-category"></span> Sub Categoria</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <select name="businessTypeGuia1" id="businessTypeGuia1">
                                    <?php
                                    if (isset($business->sub[0])) {
                                        echo "<option value='" . $business->sub[0]->term_id . "' selected>" . $business->sub[0]->name . "</option>";
                                    }
                                    ?>
                                </select>
                                <br>
                                <span class="description">Selecione a subcategoria de atuação do seu negócio</span>

                            </td>
                        </tr>

                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-id"></span> CPF / CNPJ</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="text" name="cnpjNegocio" placeholder="19.611.312/00001-18" value="<?php echo isset($business->meta['cnpjNegocio']) ? $business->meta['cnpjNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-email"></span> Email</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="email" name="emailNegocio" id="emailNegocio" placeholder="Email de contato do negócio" value="<?php echo isset($business->meta['emailNegocio']) ? $business->meta['emailNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-admin-links"></span> Webite</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" name="urlNegocio" id="urlNegocio" placeholder="http"  style="width: 100%" value="<?php echo isset($business->meta['urlNegocio']) ? $business->meta['urlNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-phone"></span> Whatsapp</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="tel" name="whatsNegocio" placeholder="+55 48 996004929" value="<?php echo isset($business->meta['whatsNegocio']) ? $business->meta['whatsNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-phone"></span> Fone Comercial*</td>
                            <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="tel" name="foneNegocio" id="foneNegocio" placeholder="+5548 32220617" value="<?php echo isset($business->meta['foneNegocio']) ? $business->meta['foneNegocio'][0] : ""; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-facebook-alt"></span> Página do Facebook</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" name="faceNegocio" id="faceNegocio" placeholder="http" style="width: 100%"  value="<?php echo isset($business->meta['faceNegocio']) ? $business->meta['faceNegocio'][0] : ""; ?>"/>
                            </td>

                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-googleplus"></span> Google Business</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="url" id="googleNegocio" name="googleNegocio" placeholder="http" style="width: 100%" value="<?php echo isset($business->meta['googleNegocio']) ? $business->meta['googleNegocio'][0] : ""; ?>"/>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-money"></span> Cartões de crédito</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="checkbox" name="american" value="american" <?php echo empty($business->meta['american'][0]) ? "  " : "  checked  "; ?>/>American
                                <input type="checkbox" name="amex" value="amex" <?php echo empty($business->meta['amex'][0]) ? "  " : "  checked  "; ?>/>Amex
                                <input type="checkbox" name="credicard" value="credicard" <?php echo empty($business->meta['credicard'][0]) ? "  " : "  checked  "; ?>/>Credicard
                                <input type="checkbox" name="discover" value="discover" <?php echo empty($business->meta['discover'][0]) ? "  " : "  checked  "; ?>/>Discover
                                <input type="checkbox" name="master" value="master" <?php echo empty($business->meta['master'][0]) ? "  " : "  checked  "; ?>/>Master
                                <input type="checkbox" name="visa" value="visa" <?php echo empty($business->meta['visa'][0]) ? "  " : "  checked  "; ?>/>Visa
                            </td>

                        </tr>
                        <tr>
                            <td class="first" style="text-align: right;max-width: 300px"><span class="dashicons dashicons-info"></span> Descrição do negócio</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <?php
                                $content = isset($business->post) ? $business->post->post_content : "";
                                $editor_id = 'txtDesc';

                                wp_editor($content, $editor_id, array('media_buttons' => false, 'quicktags' => false, 'textarea_rows' => 3));
                                ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-3">
                <p>
                    <span class="dashicons dashicons-calendar-alt"></span> <b>Selecione o horário de funcionamento de seu negócio.</b>
                </p>
                <p>
                <table class="form-table editcomment" style="max-width: 400px">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right">Domingo</td>
                            <td><input type="checkbox" name="chk_domingo" id="chk_domingo" <?php echo empty($business->meta['i_domingo'][0]) ? "" : " checked "; ?>/> </td>
                            <td><input type="time"  name="i_domingo" id="i_domingo"  value="<?php echo isset($business->meta['i_domingo']) ? $business->meta['i_domingo'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_domingo" id="f_domingo" value="<?php echo isset($business->meta['f_domingo']) ? $business->meta['f_domingo'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Segunda</td>
                            <td><input type="checkbox" name="chk_segunda" id="chk_segunda" <?php echo empty($business->meta['i_segunda'][0]) ? " " : " checked "; ?>/> </td>
                            <td><input type="time"  name="i_segunda" id="i_segunda"  value="<?php echo isset($business->meta['i_segunda']) ? $business->meta['i_segunda'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_segunda" id="f_segunda"  value="<?php echo isset($business->meta['f_segunda']) ? $business->meta['f_segunda'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Terça</td>
                            <td><input type="checkbox" name="chk_terca" id="chk_terca" <?php echo empty($business->meta['i_terca'][0]) ? "  " : " checked "; ?>/> </td>
                            <td><input type="time"  name="i_terca" id="i_terca"  value="<?php echo isset($business->meta['i_terca']) ? $business->meta['i_terca'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_terca" id="f_terca"  value="<?php echo isset($business->meta['f_terca']) ? $business->meta['f_terca'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Quarta</td>
                            <td><input type="checkbox" name="chk_quarta" id="chk_quarta" <?php echo empty($business->meta['i_quarta'][0]) ? "  " : "  checked "; ?>/> </td>
                            <td><input type="time"  name="i_quarta" id="i_quarta"  value="<?php echo isset($business->meta['i_quarta']) ? $business->meta['i_quarta'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_quarta" id="f_quarta"  value="<?php echo isset($business->meta['f_quarta']) ? $business->meta['f_quarta'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Quinta</td>
                            <td><input type="checkbox" name="chk_quinta" id="chk_quinta" <?php echo empty($business->meta['i_quinta'][0]) ? " checked " : "  checked  "; ?>/> </td>
                            <td><input type="time"  name="i_quinta" id="i_quinta"  value="<?php echo isset($business->meta['i_quinta']) ? $business->meta['i_quinta'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_quinta" id="f_quinta"  value="<?php echo isset($business->meta['f_quinta']) ? $business->meta['f_quinta'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Sexta</td>
                            <td><input type="checkbox" name="chk_sexta" id="chk_sexta" <?php echo empty($business->meta['i_sexta'][0]) ? "  " : "  checked "; ?>/> </td>
                            <td><input type="time"  name="i_sexta" id="i_sexta"  value="<?php echo isset($business->meta['i_sexta']) ? $business->meta['i_sexta'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_sexta" id="f_sexta"  value="<?php echo isset($business->meta['f_sexta']) ? $business->meta['f_sexta'][0] : ""; ?>"/> </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Sabado</td>
                            <td><input type="checkbox" name="chk_sabado" id="chk_sabado" <?php echo empty($business->meta['i_sabado'][0]) ? "  " : "  checked  "; ?>/> </td>
                            <td><input type="time"  name="i_sabado" id="i_sabado"  value="<?php echo isset($business->meta['i_sabado']) ? $business->meta['i_sabado'][0] : ""; ?>"/> </td>
                            <td><input type="time"  name="f_sabado" id="f_sabado"  value="<?php echo isset($business->meta['f_sabado']) ? $business->meta['f_sabado'][0] : ""; ?>"/> </td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-4">
                <p>
                    <span class="dashicons dashicons-location"></span> <b>Localização do meu negócio.</b>
                </p>
                <p>
                <table class="form-table editcomment" style="max-width: 600px">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right">Cep</td>
                            <td><input type="number"  name="zip" id="zip" onblur="loadPlaces(this)" value="<?php echo isset($business->meta['zip']) ? $business->meta['zip'][0] : ""; ?>"/>
                                <br><span class="description">Apenas números</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Rua</td>
                            <td><input type="text"  name="street" id="street" style="width: 100%" value="<?php echo isset($business->meta['street']) ? $business->meta['street'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Bairro</td>
                            <td><input type="text"  name="neigh" id="neigh" style="width: 100%" value="<?php echo isset($business->meta['neigh']) ? $business->meta['neigh'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Praia</td>
                            <td>
                                <input type="text" id="beach" name="beach" style="width: 200px" placeholder="Praia proxima" value="<?php echo isset($business->meta['_beach_nearby_']) ? $business->meta['_beach_nearby_'][0] : ""; ?>" />
                                <br><span class="description">Informe a praia proxima (se houver) e selecione o resultado</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Região</td>
                            <td>
                                <div style="width: 100%">

                                    <?php
                                    $i = 1;
                                    foreach ($categories->regions as $cat) {
                                        //var_dump($cat);
                                        ?>
                                        <input class="singleOne" type="radio" name="region" id="region" value="<?php echo $cat->meta_key; ?>" style="height: 10px;width: 10px"><?php echo $cat->meta_key; ?> 
                                        <br>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Cidade</td>
                            <td><input type="text"  name="city" id="city" value="<?php echo isset($business->meta['city']) ? $business->meta['city'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td  class="first" style="text-align: right">Estado</td>
                            <td><input type="text"  name="state" id="state" value="<?php echo isset($business->meta['state']) ? $business->meta['state'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">País</td>
                            <td><input type="text"  name="country" id="country" value="<?php echo isset($business->meta['country']) ? $business->meta['country'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Latitude</td>
                            <td><input type="text"  name="lat" id="lat" readonly="" value="<?php echo isset($business->meta['lat']) ? $business->meta['lat'][0] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td  class="first" style="text-align: right">Longitude</td>
                            <td><input type="text"  name="lon" id="lon" readonly="" value="<?php echo isset($business->meta['lon']) ? $business->meta['lon'][0] : ""; ?>"/></td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <?php if (!empty(get_user_meta(get_current_user_id(), "_plano_type", true))) { ?>
                <div id="tabs-5">
                    <p>
                        <span class="dashicons dashicons-format-gallery"></span> <b>Fotos do meu negócio.</b>
                    </p>
                    <p>
                        <input type="hidden" name="idNegocio" id="facePage1" value="<?php echo isset($business->id) ? $business->id : (isset($_GET['id']) ? $_GET['id'] : ""); ?>"/>
                        <input type="hidden" name="facePage1" id="facePage1" value="<?php echo isset($business->meta['facePage']) ? $business->meta['facePage'][0] : ""; ?>"/>
                        <input type="hidden" name="picLogoURL" id="picLogoURL" value="<?php echo isset($business->meta['picLogoURL']) ? $business->meta['picLogoURL'][0] : ""; ?>"/>
                        <input type="hidden" name="picCapaURL" id="picCapaURL" value="<?php echo isset($business->meta['picCapaURL']) ? $business->meta['picCapaURL'][0] : ""; ?>"/>
                        <input type="hidden" name="picDropzone" id="picCapaURL" value="<?php echo isset($business->meta['picDropzone']) ? $business->meta['picDropzone'][0] : ""; ?>"/>
                        <span class="dashicons dashicons-format-image"></span> Logotipo ou foto 100x100 px<br>
                        <a href="javascript:upload_new_img(this,'single')" class="button button-primary" style="margin: 15px">Anexar</a><br>
                    <div id="logoPreview" onclick="upload_new_img(this, 'single')" name="logoPreview" class="gallery page-title-action"><img style="max-width: 100px" src="<?php echo isset($business->meta['picLogoURL']) ? $business->meta['picLogoURL'][0] : ""; ?>"></div>
                    <span class="dashicons dashicons-images-alt2"></span> Galeria <br><br>
                    <a href="javascript:upload_new_img(this,'multiple')" class="button button-primary" style="margin: 15px">Anexar</a>
                  <!--  <span class="description">Total de até 10 imagens podem ser anexadas na galeria</span> -->

                    <div id="gallPreview" onclick="upload_new_img(this, 'multiple')" name="gallPreview" class="gallery page-title-action" ></div>

                    </p>
                </div>
            <?php } ?>
            <div id="tabs-6">


                <p style="height: auto"> 
                    <span class="dashicons dashicons-admin-generic"></span><b>Preferências</b>
                <h2>Configurações do Guia Floripa</h2>
                <label><input type="checkbox" name="chkSyncGuia" id="chkSyncGuia" value="chk_guia">Enviar para publicação no Guia Floripa ao salvar</label><br>
                <label><input type="checkbox" name="chkSyncGuiaAPP" id="chkSyncGuiaAPP" value="chk_app">Enviar para publicação no App Guia Floripa</label><br>
                <h2>Configurações do Google</h2>
                <ul>
                    <li>1) No <a href="#" target="_blank">Google</a>, clique em 'Criar nova aplicação' e preencha todos os campos.</LI>
                    <li>2) Copie e cole o token de autenticação de seu APP.</LI>
                </ul>
                <label><input type="checkbox" name="chkGoogle" id="chkGoogle" value="chk_app">Atualizar página do Google Business ao salvar</label><br>
                <label>Chave do Google APP<br><input <?php echo!is_null($business->meta['chkGoogle'][0]) ? "checked=''" : ""; ?> type="text" id="google_token"  name="google_token" value="<?php echo isset($business->meta['_google_token_']) ? $business->meta['_google_token_'][0] : ""; ?>" style="width: 300px"></label><br>
                <h2>Configurações do Facebook</h2>
                <ul>
                    <li>1) No <a href="https://developers.facebook.com/" target="_blank">Facebook developers</a> crie um aplicativo</LI>
                    <li>2) Vincule o seu novo APP com a pagina do Facebook desejada.</LI>
                    <li>3) <a href="#">Autorize seu APP</a> para gerenciar sua página do Facebook.</LI>
                </ul>
                <label><input type="checkbox" name="chkFace" id="chkFace" value="chk_app_face">Atualizar página do Facebook ao salvar</label><br>
                <label>Facebook APP ID<br><input <?php echo!is_null($business->meta['chkFace'][0]) ? "checked=''" : ""; ?> type="text" name="face_appid" id="face_appid" value="<?php echo isset($business->meta['_face_appid_']) ? $business->meta['_face_appid_'][0] : ""; ?>"  style="width: 300px"></label><br>
                <label>Facebook APP SECRET<br><input <?php echo!is_null($business->meta['chkFace'][0]) ? "checked=''" : ""; ?> type="text" name="face_appsecret" id="face_appsecret" value="<?php echo isset($business->meta['_face_appsecret_']) ? $business->meta['_face_appsecret_'][0] : ""; ?>" style="width: 300px"></label><br>
                <h2>Configurações do Twitter</h2>
                <ul>
                    <li>1) No <a href="https://apps.twitter.com/" target="_blank">Gerenciador de aplicativos do Twitter</a>, clique em 'Criar nova aplicação' e preencha todos os campos.</LI>
                    <li>2) Na guia 'Permissões', selecione 'Ler, Escrever e acessar mensagens diretas' na área 'Acesso' e clique em 'Configurações de atualização'.</LI>
                    <li>3) Na guia 'Chave e toques de acesso', clique no botão 'Criar meu token de acesso'.</LI>
                    <li>4) Digite o nome de usuário do botão no respectivo campo abaixo.</LI>
                    <li>5) Na guia 'Chave e Acesso Tokens', copie a Chave do Consumidor, o Segredo do Consumidor, o Token de Acesso e o Token de Acesso segure e cole nos respectivos campos abaixo.</LI>
                </ul>
                <label for="_ck"><?php _e("Twitter API KEY"); ?></label><br>
                <input type="text" value="<?php echo isset($business->meta['_ck']) ? $business->meta['_ck'][0] : ""; ?>" name="_ck" id="_ck" value="<?php echo esc_attr(get_the_author_meta('_ck', $user->ID)); ?>" class="regular-text" /><br />
                <label for="_cs"><?php _e("Twitter API Secret"); ?></label>
                <br>
                <input value="<?php echo isset($business->meta['_cs']) ? $business->meta['_cs'][0] : ""; ?>" placeholder="" type="text" name="_cs" id="_cs" value="<?php echo esc_attr(get_the_author_meta('_cs', $user->ID)); ?>" class="regular-text" /><br />
                <label for="_at"><?php _e("Access Token"); ?></label>
                <br>
                <input value="<?php echo isset($business->meta['_at']) ? $business->meta['_at'][0] : ""; ?>" type="text" name="_at" id="_at" value="<?php echo esc_attr(get_the_author_meta('_at', $user->ID)); ?>" class="regular-text" /><br />
                <label for="_ac"><?php _e("Access Token Secret"); ?></label>
                <br>
                <input value="<?php echo isset($business->meta['_ac']) ? $business->meta['_ac'][0] : ""; ?>" type="text" name="_ac" id="_ac" value="<?php echo esc_attr(get_the_author_meta('_ac', $user->ID)); ?>" class="regular-text" /><br />
                <h2>Configurações do Onesignal (Notificações)</h2>
                <p>
                    Localize em sua conta OneSignal em Setup > OneSignal Keys > Step 2.
                </p>
                <label for="_onesignal_app_id"><?php _e("OneSignal APP ID"); ?></label><br>
                <input value="<?php echo isset($business->meta['_onesignal_app_id']) ? $business->meta['_onesignal_app_id'][0] : ""; ?>" placeholder="c452ff74-3bc4-44ca-a015-bfdaf0812313" type="text" name="_onesignal_app_id" id="_onesignal_app_id" value="<?php echo esc_attr(get_the_author_meta('_onesignal_app_id', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Sua chave de identificação do app ID com 36 caracteres. "); ?></span>

                <br>
                <label for="_onesignal_rest_api_key"><?php _e("Access Token"); ?></label><br>
                <input value="<?php echo isset($business->meta['_onesignal_rest_api_key']) ? $business->meta['_onesignal_rest_api_key'][0] : ""; ?>" type="text" name="_onesignal_rest_api_key" id="_onesignal_rest_api_key" value="<?php echo esc_attr(get_the_author_meta('_onesignal_rest_api_key', $user->ID)); ?>" class="regular-text" />
                <br>
                <span class="description"><?php _e("Sua chave REST com 48 caracteres."); ?></span>

                </p>
            </div>
            <input type="button" onclick="submitNegocio()" name="btSaveCampaign" style="width: 99%" value="Salvar" class="page-title-action"/>
        </div>
        <hr/>
    </div>
</form>
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
    .dz-image img{width: 100%;height: 100%;}
    div.gallery {
        margin: 8px;
        border: 1px dotted #ccc;
        float: left;
        width: 100%;
        min-height: 120px;
        max-height: 600px;

    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: auto;
        max-width: 60px;
        height: 60px;
    }

    div.desc {
        padding: 15px;
        text-align: center;
    }
</style>
<?php
$str1 = substr($business->meta['picCapaURL'][0], 0, 1);
$str1 = $str1 === "[" ? $business->meta['picCapaURL'][0] : "[]";
?>
<script>

    function upload_new_img(obj, origem)
    {
        var file_frame;
        var img_name = jQuery(obj).closest('p').find('.upload_image');
        if (file_frame) {
            file_frame.open();
            return;
        }
        isMulti = origem === "single" ? false : true;
        file_frame = wp.media.frames.file_frame = wp.media(
                {
                    title: 'Biblioteca de Midias',
                    button: {
                        text: jQuery(this).data('uploader_button_text')
                    },
                    multiple: isMulti
                }
        );
        file_frame.on('select', function () {
            if (origem === "single") {
                attachment = file_frame.state().get('selection').first().toJSON();
                $("#picLogoURL").val(attachment.url);
                file_frame.close();
                document.getElementById('logoPreview').innerHTML = "<img src='" + attachment.url + "' style='max-width:100px'>";
            } else {
                document.getElementById('gallPreview').innerHTML = "";
                arrayImages = [];
                var selection = file_frame.state().get('selection');
                selection.map(function (attachment) {
                    attachment.toJSON();

                    arrayImages.push(attachment.attributes.url);
                    document.getElementById('gallPreview').innerHTML += "<img src='" + attachment.attributes.url + "' style='max-width:100px'>";

                });
            }
        });
        file_frame.open();
    }

    var arrayImages;
    try {
        arrayImages = <?php echo $str1; ?>;
    } catch (e) {
        arrayImages = [];
        console.log(e);
    }
    function setImages() {
        var myImages = JSON.stringify(arrayImages);
        alert(myImages);
        jQuery("#picCapaURL").val(myImages);
    }


    function loadSubCategory(element) {
        jQuery.ajax({
            type: "GET",
            url: "admin-ajax.php?action=sub_cat_guia&id=" + element.value,
            success: function (data)
            {
                $('#businessTypeGuia1').empty()
                for (i = 0; i < data.length; i++) {
                    $('#businessTypeGuia1').append($('<option>',
                            {
                                value: data[i].term_id,
                                text: data[i].name
                            }));
                }
            }
        });
    }
    jQuery(function ($) {
        $("#tabs").tabs();
        $('#chkFace').click(function () {
            if ($(this).is(":checked")) {
                $("#face_appid").removeAttr("disabled");
                $("#face_appsecret").removeAttr("disabled");
            } else {
                $("#face_appid").prop("disabled", "disabled");
                $("#face_appsecret").prop("disabled", "disabled");
            }
        });
        $('#chkGoogle').click(function () {
            if ($(this).is(":checked")) {
                $("#google_token").removeAttr("disabled");
            } else {
                $("#google_token").prop("disabled", "disabled");
            }
        });
        for (i = 0; i < arrayImages.length; i++) {
            document.getElementById('gallPreview').innerHTML += "<img src='" + arrayImages[i] + "' style='max-width:100px'>";
        }
    });
    function loadPlaces(element) {
        var url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + element.value + "&key=AIzaSyDI-SU8nROAogbZWGveHUm3bT4FA5_Aujo"
        $.get(url,
                function (data) {
                    if (data.results.length > 0) {
                        jQuery('#street').val(data.results[0].formatted_address);
                        jQuery('#lat').val(data.results[0].geometry.location.lat);
                        jQuery('#lon').val(data.results[0].geometry.location.lng);
                        for (i = 0; i < data.results[0].address_components.length; i++) {
                            if (data.results[0].address_components[i].types.indexOf("postal_code") > -1) {
                                var cep = data.results[0].address_components[i].short_name;
                                var str = cep.match(/\d+/g, "") + '';
                                var s = str.split(',').join('');
                                jQuery('#zip').val(s);
                            }
                            if (data.results[0].address_components[i].types.indexOf("sublocality_level_1") > -1) {
                                jQuery('#neigh').val(data.results[0].address_components[i].short_name);
                            }
                            if (data.results[0].address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                                jQuery('#city').val(data.results[0].address_components[i].short_name);
                            }
                            if (data.results[0].address_components[i].types.indexOf("administrative_area_level_1") > -1) {
                                jQuery('#state').val(data.results[0].address_components[i].long_name);
                            }
                            if (data.results[0].address_components[i].types.indexOf("country") > -1) {
                                jQuery('#country').val(data.results[0].address_components[i].long_name);
                            }
                        }
                    }
                    console.log(data);
                }
        );
    }

    function loadFacebook() {
        FB.login(function () {
            FB.api(
                    '/me/accounts',
                    'GET',
                    {"type": "page"},
                    function (response) {
                        //facePages
                        //alert(JSON.stringify(response));
                        pages = response.data;
                        jQuery('#facePages').html("");
                        for (i = 0; i < pages.length; i++) {
                            jQuery('#facePages').append('<input onclick="loadPageById(this)" type="radio" name="facePage" id="facePage" value="' + pages[i].id + '" /> ' + pages[i].name + '<br/>');
                        }
                        jQuery("#titPgFace").html("Selecione a página do facebook");
                    }
            );
        }, {scope: 'pages_show_list'});

    }
    //function loadImagesFrom
    function loadPageById(element) {
        var pageSelected = "/" + element.value;
        //FB.login(function () {
        FB.api(
                pageSelected,
                'GET',
                {"fields": "username,about,location,picture{url},hours,emails,cover,phone,website,whatsapp_number,category,category_list,company_overview,contact_address,name,payment_options,general_info"},
                function (response) {
                    // alert(JSON.stringify(response));
                    if (response.username !== undefined)
                        jQuery("#faceNegocio").val("https://facebook.com/" + response.username);
                    jQuery("#nmNegocio").val(response.name);
                    if (response.phone !== undefined)
                        jQuery("#foneNegocio").val(response.phone);
                    jQuery("#urlNegocio").val(response.website);
                    if (response.emails !== undefined)
                        jQuery("#emailNegocio").val(response.emails[0]);
                    if (response.about !== undefined)
                        tinyMCE.get("txtDesc").setContent(response.about);
                    //jQuery("#").val();

                    if (response.hours !== undefined) {
                        if (response.hours.mon_1_close !== undefined) {
                            jQuery("#i_segunda").val(response.hours.mon_1_open);
                            jQuery("#f_segunda").val(response.hours.mon_1_close);
                            jQuery("#chk_segunda").prop('checked', true);
                        } else {
                            jQuery("#chk_segunda").prop('checked', false);
                            jQuery("#i_segunda").val("");
                            jQuery("#f_segunda").val("");
                        }
                        if (response.hours.tue_1_close !== undefined) {
                            jQuery("#i_terca").val(response.hours.tue_1_open);
                            jQuery("#f_terca").val(response.hours.tue_1_close);
                            jQuery("#chk_terca").prop('checked', true);
                        } else {
                            jQuery("#chk_terca").prop('checked', false);
                            jQuery("#i_terca").val("");
                            jQuery("#f_terca").val("");
                        }
                        if (response.hours.wed_1_close !== undefined) {
                            jQuery("#i_quarta").val(response.hours.wed_1_open);
                            jQuery("#f_quarta").val(response.hours.wed_1_close);
                            jQuery("#chk_quarta").prop('checked', true);
                        } else {
                            jQuery("#chk_quarta").prop('checked', false);
                            jQuery("#i_quarta").val("");
                            jQuery("#f_quarta").val("");
                        }
                        if (response.hours.thu_1_close !== undefined) {
                            jQuery("#i_quinta").val(response.hours.thu_1_open);
                            jQuery("#f_quinta").val(response.hours.thu_1_close);
                            jQuery("#chk_quinta").prop('checked', true);
                        } else {
                            jQuery("#chk_quinta").prop('checked', false);
                            jQuery("#i_quinta").val("");
                            jQuery("#f_quinta").val("");
                        }
                        if (response.hours.fri_1_close !== undefined) {
                            jQuery("#i_sexta").val(response.hours.fri_1_open);
                            jQuery("#f_sexta").val(response.hours.fri_1_close);
                            jQuery("#chk_sexta").prop('checked', true);
                        } else {
                            jQuery("#chk_sexta").prop('checked', false);
                            jQuery("#i_sexta").val("");
                            jQuery("#f_sexta").val("");
                        }
                        if (response.hours.sat_1_close !== undefined) {
                            jQuery("#i_sabado").val(response.hours.sat_1_open);
                            jQuery("#f_sabado").val(response.hours.sat_1_close);
                            jQuery("#chk_sabado").prop('checked', true);
                        } else {
                            jQuery("#chk_sabado").prop('checked', false);
                            jQuery("#i_sabado").val("");
                            jQuery("#f_sabado").val("");
                        }
                        if (response.hours.sun_1_close !== undefined) {
                            jQuery("#i_domingo").val(response.hours.sun_1_open);
                            jQuery("#f_domingo").val(response.hours.sun_1_close);
                            jQuery("#chk_domingo").prop('checked', true);
                        } else {
                            jQuery("#chk_domingo").prop('checked', false);
                            jQuery("#i_domingo").val("");
                            jQuery("#f_domingo").val("");
                        }
                        if (response.location !== undefined) {
                            jQuery("#city").val(response.location.city);
                            jQuery("#zip").val(response.location.zip);
                            jQuery("#lat").val(response.location.latitude);
                            jQuery("#lon").val(response.location.longitude);
                            jQuery("#street").val(response.location.street);
                            jQuery("#state").val(response.location.state);
                            jQuery("#country").val(response.location.country);
                        } else {
                            jQuery("#city").val("");
                            jQuery("#zip").val("");
                            jQuery("#lat").val("");
                            jQuery("#lon").val("");
                            jQuery("#street").val("");
                            jQuery("#state").val("");
                            jQuery("#country").val("");
                        }
                    }
                    if (response.category_list !== undefined) {
                        for (i = 0; i < response.category_list.length; i++) {
                            $("#businessType").append($("<option></option>").val(response.category_list[i].id + ":" + response.category_list[i].name).html(response.category_list[i].name));
                        }
                    }
                    if (response.picture !== undefined) {
                        jQuery("#picLogoURL").val(response.picture.data.url);
                        jQuery("#picLogo").html("<img src='" + response.picture.data.url + "' style='max-width:300px'/>");
                    } else {
                        jQuery("#picLogoURL").val("");
                        jQuery("#picLogo").html("");

                    }
                    if (response.cover !== undefined) {
                        jQuery("#picCapaURL").val(response.cover.source);
                        jQuery("#picCapa").html("<img src='" + response.cover.source + "' style='max-width:300px'/>");
                    } else {
                        jQuery("#picCapaURL").val("");
                        jQuery("#picCapa").html("");
                    }
                    console.log(response);
                }
        );
        //element.prop('checked', true);
        // });
    }

    window.fbAsyncInit = function () {
        FB.init({
            appId: '1405126029586258',
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v2.12'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    document.getElementById('businessType').value = '<?php echo isset($business->meta[BUSINESS_TYPE][0]) ? $business->meta[BUSINESS_TYPE][0] : ""; ?>';
    document.getElementById('businessTypeGuia').value = '<?php echo isset($business->meta['businessTypeGuia'][0]) ? $business->meta['businessTypeGuia'][0] : ""; ?>';
    document.getElementById('chkSyncGuia').checked = <?php echo!is_null($business->meta['chkSyncGuia'][0]) ? "true" : "false"; ?>;
    document.getElementById('chkSyncGuiaAPP').checked = <?php echo!is_null($business->meta['chkSyncGuiaAPP'][0]) ? "true" : "false"; ?>;
    document.getElementById('chkGoogle').checked = <?php echo!is_null($business->meta['chkGoogle'][0]) ? "true" : "false"; ?>;
    document.getElementById('chkFace').checked = <?php echo!is_null($business->meta['_chkFace'][0]) ? "true" : "false"; ?>;


    jQuery(function ($) {

        /*  Dropzone.options.dropZoneLogo = {
         acceptedFiles: "image/*", // all image mime types
         //acceptedFiles: ".csv", // only .jpg files
         maxFiles: 1,
         thumbnailWidth: 100,
         thumbnailHeight: 100,
         uploadMultiple: false,
         maxFilesize: 2, // 5 MB
         addRemoveLinks: true,
         dictRemoveFile: 'X (Remover)',
         init: function () {
<?php
if (isset($business->meta['picLogoURL'][0])) {
    echo 'var mock = {name: "' . $business->meta['picLogoURL'][0] . '", size: 12345};';
    echo 'this.options.addedfile.call(this, mock);';
    echo 'this.options.maxFiles = 0;';
    echo 'this.emit("complete", mock);';
    echo 'this.emit("thumbnail", mock, "' . $business->meta['picLogoURL'][0] . '");';
}
?>
         
         this.on("sending", function (file, xhr, formData) {
         console.log(formData);
         console.log(file);
         console.log(xhr)
         formData.append("name", "value"); // Append all the additional input data of your form here!
         //window.location.href = "admin.php?page=app_guiafloripa_leads_imp&source=csv";
         //alert('logo jjjjj');
         
         });
         this.on('removedfile', function (file) {
         file.previewElement.remove();
         this.options.maxFiles = 1;
         });
         
         
         },
         success: function () {
         createAttach("Logo");
         }
         };
         
         function createAttach(source) {
         localStorage.setItem("source", source);
         jQuery.get(ajaxurl + "?action=createAttach", function (data, source) {
         source = localStorage.getItem("source");
         if (source === "Logo") {
         jQuery("#picLogoURL").val(data);
         } else {
         arrayImages.push(data);
         }
         });
         }
         
         /*   Dropzone.options.dropZoneCapa = {
         
         acceptedFiles: "image/*", // all image mime types
         //acceptedFiles: ".csv", // only .jpg files
         maxFiles: 10,
         uploadMultiple: false,
         maxFilesize: 2, // 5 MB
         addRemoveLinks: true,
         dictRemoveFile: 'X (Remover)',
         init: function () {
         
         for (i = 0; i < arrayImages.length; i++) {
         if (arrayImages[i] === null)
         continue;
         
         var mock = {name: arrayImages[i], size: 12345};
         this.options.addedfile.call(this, mock);
         this.options.maxFiles = 0;
         this.emit("complete", mock);
         this.emit("thumbnail", mock, arrayImages[i]);
         this.maxFiles--;
         }
         this.on("drop", function (e) {
         var cpArrayImg = [];
         for (i = 0; i < arrayImages.length; i++) {
         if (arrayImages[i] !== null && arrayImages[i] !== undefined) {
         cpArrayImg.push(arrayImages[i]);
         }
         }
         this.options.maxFiles = 10 - cpArrayImg.length;
         });
         
         this.on("sending", function (file, xhr, formData) {
         console.log(formData);
         console.log(file);
         console.log(xhr)
         formData.append("name", "value"); // Append all the additional input data of your form here!
         //window.location.href = "admin.php?page=app_guiafloripa_leads_imp&source=csv";
         // alert('logo');
         // console.log(this.files);
         
         
         });
         this.on('removedfile', function (file) {
         file.previewElement.remove();
         for (i = 0; i < arrayImages.length; i++) {
         if (file.name === arrayImages[i]) {
         delete arrayImages[i];
         }
         }
         this.options.maxFiles++;
         });
         this.on("completemultiple", function () {
         alert(JSON.stringify(this.files));
         jQuery("#picDropzone").val(JSON.stringify(this.files));
         if (this.getQueuedFiles().length == 0 &&
         this.getUploadingFiles().length == 0) {
         process_responses(this.getAcceptedFiles());
         console.log(this.files);
         
         }
         });
         },
         success: function () {
         createAttach("Capa");
         
         /*   var fNames = "";
         for (i = 0; i < this.files.length; i++) {
         fNames += this.files[i].name;
         }
         // alert(JSON.stringify(this.files));
         jQuery("#picDropzone").val(fNames);*/
        /*  }
         };*/
        $("#beach").suggest(ajaxurl + "?action=findBeachsAjax", {delay: 400, minchars: 4});
        $("#beach").change(function (e) {
            bairroIsSelected = true;
        });
        $("INPUT[name=region]").val(['<?php echo $business->meta['_region_coor_'][0]; ?>']);
    })


    function submitNegocio() {
        finalArray = [];
        for (i = 0; i < arrayImages.length; i++) {
            if (arrayImages[i] !== null) {
                finalArray.push(arrayImages[i]);
            }
        }

        jQuery("#picCapaURL").val(JSON.stringify(finalArray));
        document.frm_negocio.submit();
    }
// dropzoneWordpressForm is the configuration for the element that has an id attribute
// with the value dropzone-wordpress-form (or dropzoneWordpressForm)

</script>