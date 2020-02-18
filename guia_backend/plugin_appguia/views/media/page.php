<div class="wrap">
    <h1><?php
        $plano = get_user_meta(get_current_user_id(), "_plano_type", true);
        //var_dump($plano);
        echo esc_html(get_admin_page_title());
        if ($plano) {
            ?><a href="javascript:upload_new_img(this)" class="page-title-action">Anexar</a><a href="javascript:downloadFiles()" title="Habilite os pop ups para fazer o download de imagens. Máximo 10 imagens por download" class="page-title-action">Download</a><a href="javascript:removeFiles()" class="page-title-action">Excluir</a><?php } ?></h1>



    <?php
    if (isset($_POST['selMedias'])) {
        $filesDownload = explode(",", $_POST['selMedias']);
        if ($_POST['selMediasAct'] === "download") {

            //var_dump($filesDownload);
            echo "<script>";
            foreach ($filesDownload as $d) {
                $path = str_replace("https://app.guiafloripa.com.br/wp-content/uploads", "https://app.guiafloripa.com.br/wp-admin/admin-ajax.php?action=downloadFileFromUrl&file=", $d);
                if ($path === "") {
                    continue;
                }
                echo "window.open('" . $path . "','_blank');\n";
            }
            echo "</script>";
            //https://app.guiafloripa.com.br/wp-admin/admin-ajax.php?action=downloadFileFromUrl&file=/2018/03/23-03-1815285020_207642943017773_4750800478043254071_n.png
        } else if ($_POST['selMediasAct'] === "remove") {
            //var_dump($_POST);
            global $wpdb;
            // echo "<pre>";
            $totalRemove = 0;
            foreach ($filesDownload as $d) {
                $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $d));
                $remove = wp_delete_attachment($attachment[0]);
                //var_dump($remove);
                $totalRemove++;
            }
            echo '<div class="notice notice-info"> 
                    <p>('.$totalRemove.') Imagens removidas com sucesso.</p>
                </div>';
            // echo "</pre>";
            //return $attachment[0];
        }
    }

    if (empty($plano)) {
        echo ' <div class="notice notice-warning"> 
        <p>Seu plano nao permite anexar imagens. Faça upgrade de seu <a href="admin.php?page=app_guiafloripa_money">plano</a></p>
    </div>';
    } else {
        echo ' <div class="notice notice-info"> 
        <p><label><input type="checkbox" id="checkAll" name="checkAll"/> Selecione todas a mídias </label></p>
    </div>';
    }


    include_once PLUGIN_ROOT_DIR . 'views/media/MediaController.php';
    $mc = new MediaController();
    $mc->removeMedia($_POST);
    $images = $mc->loadMedias();
    foreach ($images as $obj) {
        //echo $obj;die;
        $attach_id = $mc->get_attachment_id($obj);
        $type = explode(".", $obj);
        $ext = $type[count($type) - 1];
        //$path = str_replace("https://app.guiafloripa.com.br/wp-content/uploads/", "/var/www/app.guiafloripa.com.br/wp-content/uploads/", $obj);
        //wp_generate_attachment_metadata($attach_id, $path);
        ?>
        <form method="post" action="admin.php?page=app_guiafloripa_midia">
            <div class="gallery">
                <center>
                    <a href="<?php echo $obj; ?>" target="_BLANK">
                        <img src="<?php echo $ext === "csv" ? "https://app.guiafloripa.com.br/wp-content/uploads/2018/01/csv.png" : $obj; ?>" alt="<?php echo $obj; ?>" width="300" height="200">
                    </a>
                    <br>
                    <input type="checkbox" name="mediaId" class="theclass" value="<?php echo $obj; ?>"/>
                    <a class="button button-primary button_size" href="<?php echo $obj; ?>" target="_BLANK">Visualizar</a> 
                    <input type="hidden" name="mediaName" value="<?php echo $obj; ?>"/>
                    <input type="hidden" name="mediaId" value="<?php echo $attach_id; ?>"/>
                    <input type="submit" name="Excluir" value="Excluir" class="button button-primary button_size"/>
                   <!-- <a class="button button-primary button_size" href="<?php echo $obj; ?>" target="_BLANK">Info</a> -->
                </center>
            </div>
        </form>

        <?php
    }
    ?>
    <form method="post" name="act" action="admin.php?page=app_guiafloripa_midia">
        <input type="hidden" name="selMedias" id="selMedias"/>
        <input type="hidden" name="selMediasAct" id="selMediasAct"/>
    </form>
</div>
<style>
    .button_size{
        width: 120px;
    }
    div.gallery {
        margin: 8px;
        border: 1px dotted #ccc;
        float: left;
        width: 300px;
        height: 220px;

    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: auto;
        max-width: 300px;
        height: 180px;
    }

    div.desc {
        padding: 15px;
        text-align: center;
    }
    input[type="checkbox"]{
        appearance:none;
        width:36px;
        height:25px;
        border:1px solid #aaa;
        border-radius:2px;
        background:#ebebeb;
        position:relative;
        display:inline-block;
        overflow:hidden;
        vertical-align:middle;
        margin-top: 2px;
        margin-right: 0px; 
        transition: background 0.3s;
        box-sizing:border-box;
    }
    input[type="checkbox"]:after{
        content:'';
        position:absolute;
        top:-1px;
        left:-1px;
        width:7px;
        height:25px;
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
<script>
    /**
     * @Download images from URL
     * */
    function downloadFiles() {

        var total = 0;
        $('input.theclass[type=checkbox]').each(function () {
            var sThisVal = jQuery("#selMedias").val();
            if (this.checked) {
                sThisVal += "," + $(this).val();
                total++;
                jQuery("#selMedias").val(sThisVal);
                if (total > 9) {
                    jQuery("#selMediasAct").val("download");
                    document.act.submit();
                }
            }
        });
        jQuery("#selMediasAct").val("download");
        document.act.submit();
    }
    /**
     * @Download images from URL
     * */
    function removeFiles() {
        if (!confirm("Confirma a exclusão das mídias selecionadas?")) {
            return;
        }
        var total = 0;
        $('input.theclass[type=checkbox]').each(function () {
            var sThisVal = jQuery("#selMedias").val();
            if (this.checked) {
                sThisVal += "," + $(this).val();
                total++;
                jQuery("#selMedias").val(sThisVal);
                if (total > 9) {
                    jQuery("#selMediasAct").val("remove");
                    document.act.submit();
                }
            }
        });
        jQuery("#selMediasAct").val("remove");
        document.act.submit();
    }
    jQuery("#checkAll").click(function () {
        jQuery('input:checkbox').prop('checked', this.checked);
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
                    title: 'Biblioteca de Midias',
                    button: {
                        text: jQuery(this).data('uploader_button_text')
                    },
                    multiple: false
                }
        );
        file_frame.on('select', function () {
            attachment = file_frame.state().get('selection').first().toJSON();
            file_frame.close();
            window.location.href = "admin.php?page=app_guiafloripa_midia";
        });
        file_frame.open();
    }
</script>