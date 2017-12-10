<?php
//var_dump($_GET);
include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
$current_user = wp_get_current_user();
$ec = new EventControl();
?>
<form id="events_crud" name="terms">
    <input type="hidden" name="eventID" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="section" value="<?php echo $_GET['page']; ?>">
    <?php
    if ($_GET['page'] === "place") {
        ?>
        <label>
            <h3>Estabelecimento</h3>
            <input type="text" name="placeName" id="placeName" style="width: 60%"  placeholder="Digite o nome do estabelecimento" />
            <input class="button button-primary" type="button" value="Localizar"/>
            <select multiple="false" size="12" style="width: 100%">

            </select>
        </label>
        <!--<a href="javascript:addPlace()" class="button button-primary">Adicionar</a><br>-->
        <?php
    } else if ($_GET['page'] === "comp") {
        ?>
        <h3>Informações do ingresso</h3>
        <input style="width:100%" type="text" name="vevent_price" placeholder="Valores (pista, área vip, camarotes, etc)" />
        <span class="description">Valor custo tipo do ingresso número de itens</span>
        <h3>Email para contato</h3>
        <input style="width:100%" type="email" id="email" name="email" placeholder="meuemail@guiafloripa.com.br" value="<?php echo $current_user->user_email; ?>"  onblur="validateOnBlur(jQuery('#email'))"/><br>
        <span class="description">Email para receber mensagens dos clientes</span>
        <h3>Whatsapp</h3>
        <input type="text"  style="width: 100%" id="whats" name="whats" value="<?php echo get_user_meta(get_current_user_id(), "_whatsapp", true); ?>" placeholder="Telefone para contato"/><br>
        <span class="description">Prencha no seu <a href="profile.php#m_phones" target="_blank">perfil</a> para carregar automaticamente</span>
        <h3>Website ou link evento</h3>
        <input type="text" id="ingresso"  style="width: 100%"  name="ingresso"  placeholder="http://"/>
        <span class="description">URL do link para o ingresso ou site do evento</span>
        <h3>Youtube ou Vimeo</h3>
        <input type="text" name="youtube"  style="width: 100%"  id="youtube" placeholder="Vídeo promocional"/>
        <span class="description">Endereço do video começando com http...</span>
        <h3>Facebook</h3>
        <input type="text" id="linkFace"  style="width: 100%"  name="linkFace"  placeholder="Endereço do Evento no Facebook"/>
        <span class="description">Endereço no face começando com http...</span>
        <h3>Desconto</h3>
        <span class="description">Desconto para ingresso ou promoção</span><br>
        Informe o desconto
        <input type="checkbox" name="discount" value="SIM" style="width: 20px">
        <input type="number" name="discountAmount" id="discountAmount" style="width: 40px"/>%</label>

    <?php
} else if ($_GET['page'] === "image") {
    ?>
    <table style="width: 100%">
        <tr>
            <td >
                <h3>Foto Destaque</h3>
                <input id="content_url" name="content_url" type="hidden" readonly="readonly"/>
                <input type="button" value="Selecione" class="button button-primary" style="width: 100%;margin-bottom: 10px" onclick="upload_new_img(this)"/>   
                <input type="button" onclick="remove_image(this);" style="width: 100%" value="Remover" class="button button-primary">
                <div id="imgPreview" style="width: 100%;margin-bottom: 10px"></div>
            </td>
        </tr>
    </table>
    <?php
} else if ($_GET['page'] === "local") {
    $categories = $ec->loadCategories();
    ?>
    <h3>Região</h3>
    <?php
    foreach ($categories->regions as $cat) {
        //var_dump($cat);
        ?>

        <div style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
            <input class="singleOne" type="checkbox" name="region" id="region" value="<?php echo $cat->meta_key; ?>" style="height: 15px;width: 20px"><?php echo $cat->meta_key; ?> 
        </div>
        <?php
    }
    ?>
    <p>
    <h3>Bairro</h3>
    <select  type="text" id="neigh" name="neigh" style="width: 100%" placeholder="Bairro do Evento">
        <?php
        $data = wp_cache_get('neigh');
        if (false === $data) {
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            $query = "select id as postID,post_title as title from wp_posts where post_type = 'cidade' and id in (select post_id from wp_postmeta where meta_key = 'mf_page_type' and meta_value='Cidade') group by post_title order by post_title asc;";
            $data = $app_db->get_results($query);
            wp_cache_set('neigh', $data);
            $app_db->close();
        }
        foreach ($data as $a) {
            echo "<option value='" . $a->postID . "'>" . $a->title . "</option>";
        }
        ?>
    </select>
    <span class="description">Informe o bairro</span>
    <h3>Praia</h3>
    <select id="beach" name="beach" style="width: 100%" placeholder="Praia do Evento">
        <?php
        // var_dump($app_db);
        $data1 = wp_cache_get('beach');
        if (false === $data1) {
            $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);
            $query1 = "select id,post_title from wp_posts where id in (select post_id from wp_postmeta where meta_key = '_wp_page_template' and meta_value='praias-comerciais.php') and post_title like '%" . $_GET['q'] . "%' group by post_title order by post_title asc;";
            $data1 = $app_db->get_results($query1);
            wp_cache_set('beach', $data1);
            $app_db->close();
        }

        foreach ($data1 as $a1) {
            echo "<option value='" . $a1->id . "'>" . $a1->post_title . "</option>";
        }
        ?>

    </select>
    <span class="description">Selecione uma praia proxima</span>
    </p>
    <script>
        jQuery(function ($) {
            $('input.singleOne').on('change', function () {
                $('input.singleOne').not(this).prop('checked', false);
            });
        })
    </script>
    <?php
} else if ($_GET['page'] === "categ") {
    ?>
    <div style="width: 100%;float: left; display: inline-block;" id="divCategories">
        <h3>Escolha as categorias</h3>
        <span class="description">Categorias do Site e APP de seu evento / estabelecimento</span><br>
        <?php
        $categories = $ec->loadCategories();
        foreach ($categories->list as $cat) {
            //var_dump($cat);
            ?>
            <div style="width: 40%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                <input type="checkbox" id="categories" name="categories[]" value="<?php echo $cat->termID; ?>" style="height: 15px;width: 20px"><?php echo $cat->name; ?> 
            </div>
            <?php
        }
        ?>
    </div>
    <?php
} else if ($_GET['page'] === "dates") {
    ?>
    <table style="width: 100%">
        <td>
            <h3>Inicio</h3>
            <input type="date" name="dtStart" id="dtStart" style="width:66%" />
            <input type="time" name="hrStart" id="hrStart" style="width:25%"/>
            <h3>Fim</h3>
            <input type="date" name="dtEnd" id="dtEnd" style="width:66%"/>
            <input type="time" name="hrEnd" id="hrEnd" style="width:25%"/>
        </td>
        </tr>
        <tr>
            <td>
                <h3>Recorrência Semanal</h3>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Mon" style="height: 15px;width: 20px">Segunda-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Tue" style="height: 15px;width: 20px">Terça-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Wed" style="height: 15px;width: 20px">Quarta-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Thu" style="height: 15px;width: 20px">Quinta-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Fri" style="height: 15px;width: 20px">Sexta-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Sat" style="height: 15px;width: 20px">Sábado
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek" value="Sun" style="height: 15px;width: 20px">Domingo
                </div>
                </div>
            </td>
        </tr>
    </table>
    <?php
} else if ($_GET['page'] === "general") {
    ?>
    <h3>Título</h3>
    <input type="text" id="titEvent" name="titEvent" style="width:100%;"  placeholder="Titulo do Evento"/>
    <span class="description">Informe o título como vai aparecer no Site e no APP</span>
    <h3>Descrição</h3>
    <textarea id="txtDesc"  name="txtDesc" class="tinymce_data" style="width:100%;" rows="8"  placeholder="Descrição do seu evento com informações para o seu público"></textarea>
    <span class="description">caracteres restantes<code id="counterChar">500</code></span>
    <h3>Mais informações</h3>
    <input type="text" id="more_info" name="more_info" maxlength="120" style="width:100%;"  placeholder="Mais informações"/>
    <span class="description">Informações complementares sobre o evento</span>
    <script>
        jQuery(function ($) {
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
        });
    </script>
    <?php
}
?>

</form>


<?php
wp_die();
?>