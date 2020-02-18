<?php
//var_dump($_GET);
include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
$current_user = wp_get_current_user();
$ec = new EventControl();
?>
<form id="events_crud" name="events_crud" action="admin-ajax.php?action=load_event_edit">
    <input type="hidden" name="action" value="update_evento_data">
    <input type="hidden" name="eventID" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="section" value="<?php echo $_GET['page']; ?>">
    <?php
    if ($_GET['page'] === "place") {
        $mPlace = $ec->loadMyPlace($_GET);
        //var_dump($mPlace);
        ?>
        <label>
            <h3>Estabelecimento</h3>
            <input type="text" name="placeName" id="placeName" style="width: 60%"  placeholder="Digite o nome do estabelecimento" />
            <input class="button button-primary" type="button" value="Localizar" onclick="loadPlaces()"/>
            <a href="https://app.guiafloripa.com.br/wp-admin/admin.php?page=app_guiafloripa_negocio_add" class="button button-primary">Adicionar</a>
           
            <select size="12" id="pResult" name="pResult" style="width: 100%;height: 250px">
                <?php
                if (count($mPlace) > 0) {
                    echo "<option value='" . $mPlace[0]->id . "'>" . $mPlace[0]->post_title . "</option>";
                }
                ?>
            </select>
        </label>
        <script>
            function loadPlaces() {
                url = "admin-ajax.php?action=findPlacesEdit&name=" + $("#placeName").val();
                $.ajax({
                    url: url,
                    context: document.body
                }).done(function (data) {
                    $('#pResult').find('option').remove();
                    $.each(data, function (i, item) {
                        $('#pResult').append($('<option>', {
                            value: item.placeID,
                            text: item.placeName
                        }));
                    });
                });
            }
        </script>
        <!--<a href="javascript:addPlace()" class="button button-primary">Adicionar</a><br>-->
        <?php
    } else if ($_GET['page'] === "comp") {
        $data = $ec->loadComplemento($_GET);
        /*  echo "<pre>";
          var_dump($data);
          echo "</pre>"; */
        ?>
        <h3>Informações do ingresso</h3>
        <input style="width:100%" type="text" name="vevent_price" placeholder="Valores (pista, área vip, camarotes, etc)" value="<?php echo $data->event[0]->price; ?>" />
        <span class="description">Valor custo tipo do ingresso número de itens</span>
        <h3>Email para contato</h3>
        <input style="width:100%" type="email" id="email" name="email" placeholder="meuemail@guiafloripa.com.br" value="<?php echo $data->event[0]->email; ?>" /><br>
        <span class="description">Email para receber mensagens dos clientes</span>
        <h3>Whatsapp</h3>
        <input type="text"  style="width: 100%" id="whats" name="whats" value="<?php echo get_user_meta(get_current_user_id(), "_whatsapp", true); ?>" placeholder="Telefone para contato"/><br>
        <span class="description">Prencha no seu <a href="profile.php#m_phones" target="_blank">perfil</a> para carregar automaticamente</span>
        <h3>Website ou link para venda</h3>
        <input type="text" id="ingresso"  style="width: 100%"  name="ingresso"  placeholder="http://"/>
        <span class="description">URL do link para o ingresso ou site do evento **Apenas para assinantes</span>
        <h3>Youtube ou Vimeo</h3>
        <input type="text" name="youtube" id="youtube"  style="width: 100%"  id="youtube" placeholder="Vídeo promocional"/>
        <span class="description">Endereço do video começando com http **Apenas para assinantes</span>
        <h3>Facebook</h3>
        <input type="text" id="linkFace"  style="width: 100%"  name="linkFace"  placeholder="Endereço do Evento no Facebook"/>
        <span class="description">Endereço no face começando com http...**Apenas para assinantes</span>
        <h3>Desconto</h3>
        <span class="description">Desconto para ingresso ou promoção **Apenas para assinantes</span><br>
        Informe o desconto
        <input type="checkbox" id="discount" name="discount" value="SIM" style="width: 20px">
        <input type="number" name="discountAmount" id="discountAmount" style="width: 40px"/>%</label>

    <?php
    echo "<script>";
    echo "jQuery(function($){\n";
    foreach ($data->campaign as $c) {
        if ($c->meta_key === "discount") {
            echo "$('#discountAmount').val('" . $c->meta_value . "');\n";
            echo "$('#discount').prop('checked', true);\n";
        } else if ($c->meta_key === "linkFace") {
            echo "$('#linkFace').val('" . $c->meta_value . "');\n";
        } else if ($c->meta_key === "youtube") {
            echo "$('#youtube').val('" . $c->meta_value . "');\n";
        } else if ($c->meta_key === "whats") {
            echo "$('#whats').val('" . $c->meta_value . "');\n";
        } else if ($c->meta_key === "email") {
            echo "$('#email').val('" . $c->meta_value . "');\n";
        } else if ($c->meta_key === "ticket") {
            echo "$('#ingresso').val('" . $c->meta_value . "');\n";
        }
    }
    echo "\n});\n"
    . "</script>";
} else if ($_GET['page'] === "image") {
    $imge = $ec->loadImage($_GET['id']);
    ?>
    <table style = "width: 100%">
        <tr>
            <td >
                <h3>Foto Destaque</h3>
                <input id="content_url" name="content_url" type="hidden" readonly="read                    only"/>
                <input type="button" value="Selecione" class="button button-primary" style="width: 100%;margin-bottom: 10px" onclick="upload_new_img(this)"/>   
                <input type="button" onclick="remove_image(this);" style="width: 100%" value="Remover" class="button button-primary">
                <hr>
                <div id="imgPreview" style="width: 100%;margin-bottom: 10px">
                    <center>
                        <?php
                        if (!empty($imge[0]->img)) {
                            echo "<image style=\"width: 150px;margin-bottom: 10px\" src='" . $imge[0]->img . "'/>";
                        }
                        ?>
                    </center>
                </div>
            </td>
        </tr>
    </table>
    <?php
} else if ($_GET['page'] === "local") {
    $categories = $ec->loadRegions($_GET);
    //var_dump($categories);
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
        <option value="">Selecione</option>
        <?php
        $data = $categories->neigh;
        foreach ($data as $a) {
            echo "<option value='" . $a->postID . "'>" . $a->title . "</option>";
        }
        ?>
    </select>
    <span class="description">Informe o bairro</span>
    <h3>Praia</h3>
    <select id="beach" name="beach" style="width: 100%" placeholder="Praia do Evento">
        <option value="">Selecione</option>
        <?php
        // var_dump($app_db);
        $data1 = $categories->beach;

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
            $("#neigh").val('<?php echo $categories->bairros[0]->meta_value; ?>').prop('selected', true);
            $("#beach").val('<?php echo $categories->praias[0]->meta_value; ?>').prop('selected', true);
            $("input[value='<?php echo $categories->mRegion[0]->meta_key; ?>']").prop('checked', true);
        })
    </script>
    <?php
} else if ($_GET['page'] === "categ") {
    $myCategories = $ec->loadMyCategories($_GET);
    //var_dump($myCategories);
    ?>
    <div style="width: 100%;float: left; display: inline-block;" id="divCategories">
        <h3>Escolha as categorias /tags</h3>
        <span class="description"></span>Selecione as categorias / tags relacionadas com seu evento<br>
        <?php
        $mList = "-1";
        $categories = $ec->loadCategories();
        foreach ($categories->list as $cat) {
            //var_dump($cat);
            ?>
            <div style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                <input type="checkbox" id="categories" name="categories[]" value="<?php echo $cat->termID; ?>" style="height: 15px;width: 20px"><?php echo $cat->name; ?> 
            </div>
            <?php
            $mList.=",".$cat->termID;
        }
        ?>
        <input type="hidden" name="oldCategories" id="oldCategories" value="<?php echo $mList; ?>"/>
    </div>

    <script>
        var mArray = <?php echo json_encode($myCategories); ?>;
        //var arrayValues;
        for (i = 0; i < mArray.length; i++) {
            $("input[value='" + mArray[i].term_id + "']").prop('checked', true);
        }

    </script>
    <?php
} else if ($_GET['page'] === "dates") {
    $dates = $ec->loadDates($_GET['id']);
    //var_dump($dates);
    ?>
    <table style="width: 100%">
        <td>
            <h3>Inicio</h3>
            <input type="date" name="dtStart" id="dtStart" style="width:55%" value="<?php echo $dates[0]->dtStart; ?>"/>
            <input type="time" name="hrStart" id="hrStart" style="width:30%" value="<?php echo $dates[0]->hrStart; ?>"/>
            <h3>Fim</h3>
            <input type="date" name="dtEnd" id="dtEnd" style="width:55%" value="<?php echo $dates[0]->dtEnd; ?>"/>
            <input type="time" name="hrEnd" id="hrEnd" style="width:30%" value="<?php echo $dates[0]->hrEnd; ?>"/>
        </td>
        </tr>
        <tr>
            <td>
                <h3>Recorrência Semanal</h3>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek1" value="Mon" style="height: 15px;width: 20px">Segunda-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek2" value="Tue" style="height: 15px;width: 20px">Terça-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek3" value="Wed" style="height: 15px;width: 20px">Quarta-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek4" value="Thu" style="height: 15px;width: 20px">Quinta-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek5" value="Fri" style="height: 15px;width: 20px">Sexta-Feira
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek6" value="Sat" style="height: 15px;width: 20px">Sábado
                </div>
                <div style="width: 50%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                    <input type="checkbox" name="dayofweek[]" id="dayofweek7" value="Sun" style="height: 15px;width: 20px">Domingo
                </div>
                </div>
            </td>
        </tr>
    </table>
    <?php
    echo "<script>";
    echo 'function checkField(val,field){
            if(val==="on"){
                $(field)[0].checked = true;
            }
        }';
    echo "checkField('" . $dates[0]->Mon . "','#dayofweek1');";
    echo "checkField('" . $dates[0]->Tue . "','#dayofweek2');";
    echo "checkField('" . $dates[0]->Wed . "','#dayofweek3');";
    echo "checkField('" . $dates[0]->Thu . "','#dayofweek4');";
    echo "checkField('" . $dates[0]->Fri . "','#dayofweek5');";
    echo "checkField('" . $dates[0]->Sat . "','#dayofweek6');";
    echo "checkField('" . $dates[0]->Sun . "','#dayofweek7');";
    echo "</script>";
} else if ($_GET['page'] === "general") {
    $app_db = new wpdb(GUIA_user, GUIA_senha, GUIA_dbase, GUIA_host);

    $query = "select post_title,post_content, (select meta_value from wp_postmeta as b where post_id = " . $_GET['id'] . " and b.meta_key = 'vevent_moreinfo') as more_info from wp_posts as a where id = " . $_GET['id'];
    $data = $app_db->get_results($query);
    //var_dump($data);
    //;
    ?>
    <h3>Título</h3>
    <input type="text" id="titEvent" name="titEvent" value="<?php echo $data[0]->post_title; ?>" style="width:100%;"  placeholder="Titulo do Evento"/>
    <span class="description">Informe o título como vai aparecer no Site e no APP</span>
    <h3>Descrição</h3>
    <textarea id="txtDesc"  name="txtDesc" class="tinymce_data" style="width:100%;" rows="8"  placeholder="Descrição do seu evento com informações para o seu público"><?php echo $data[0]->post_content; ?></textarea>
    <span class="description">caracteres restantes<code id="counterChar"><?php echo 500-strlen($data[0]->post_content); ?></code></span>
    <h3>Mais informações</h3>
    <input type="text" id="more_info" name="more_info" maxlength="120" style="width:100%;" value="<?php echo $data[0]->more_info; ?>"  placeholder="Mais informações"/>
    <span class="description">Informações sobre locais paraa venda de ingressos e promoters</span>
    <script>

        var length = 0;
        // jQuery(function ($) {
        $('#txtDesc').keyup(function () {
            length = 500 - $('#txtDesc').val().length;
            $('#counterChar').text(length);
        });
        $('#txtDesc').keydown(function (e) {
            console.log(e.keyCode);
            var text = $(this).val();
            var chars = text.length;
            if (chars > 499) {
                switch (e.keyCode) {
                    case 46:
                        return true;
                        break;
                    case 8:
                        return true;
                        break;
                    case 88:
                        return true;
                        break;
                    default :
                        return false;
                        break;
                }
                return false;
            }
            return true;
        });
        //  });
    </script>
    <?php
}
?>

</form>

<?php
wp_die();
?>