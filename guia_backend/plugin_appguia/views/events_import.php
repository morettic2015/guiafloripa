<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php
    include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
    $current_user = wp_get_current_user();
    $ec = new EventControl();
    if (isset($_POST['facebook_place_id'])) {//Import place
        var_dump($_POST);
        wp_die();
    } else if(isset($_POST['facebook_event_ids'])){//Import event
        $facebook = $ec->importEvents($_POST);
        //wp_die();
    }

    /* echo "<pre>";
      var_dump($facebook);
      echo "</pre>"; */
    ?>
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <div class="notice notice-info" id="alertMessage"> 
        <p>1) Importe seu <code>Evento</code><br>2) Vincule ou cadastre um <code>estabelecimento</code><br>3) Envie para publicação</p>
    </div>
    <div id="message-term"></div>
    <hr/>
    <form id="events_crud" name="terms" action="admin.php?page=app_guiafloripa_eventos_imp" method="post" >
        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td class="first" style="text-align: right">ID do Evento Público no Facebook</td>
                                <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                    <input type="text" name="facebook_event_ids" <?php echo empty($_POST['facebook_event_ids']) ? "" : "readonly"; ?> class="facebook_event_ids" style="min-width: 200px;max-width: 400px" value="<?php echo $_POST['facebook_event_ids']; ?>">
                                    <br><span class="description">ID do Evento para https://www.facebook.com/events/123456789/ é "123456789"</span>
                                </td>
                            </tr>
                            <?php
                            if ($facebook !== NULL) {
                                if (count($facebook->placeGuia) > 0) {
                                    ?>

                                    <tr>
                                        <td class="first" style="text-align: right">Estabelecimento localizado</td>
                                        <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">

                                            <?php
                                            foreach ($facebook->placeGuia as $pId) {
                                                echo $pId->post_title;
                                            }
                                            echo '<div class="notice notice-warning"> 
                                                    <p><strong>Evento importado com sucesso. Verifique as informações antes de publicar no Guia Floripa!</strong></p>
                                                  </div>';
                                            ?>

                                            <br>
                                        </td>
                                    </tr>
                                    <?php
                                } else {//Need to add place
                                    ?>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Endereço</td>
                                        <td  style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                            <?php echo $facebook->place->location->street . ',' . $facebook->place->location->city . ',' . $facebook->place->location->country; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first" style="text-align: right">Categorias</td>
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
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php if (!count($facebook->placeGuia) > 0) { ?>
                        <input type="submit" name="btImportEvent" value="Importar" class="page-title-action"/>
                    <?php } ?>
                </fieldset>
            </div>
        </div>
    </form>
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