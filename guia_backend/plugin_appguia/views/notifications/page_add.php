<?php
include_once PLUGIN_ROOT_DIR . 'views/notifications/NotificationController.php';
$ec = new NotificationController();
$notification = $ec->updateNotification($_POST);

//var_dump($notification);
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="notice notice-info"> 
        <p>Crie um notificação para enviar em sua campanha</p>
    </div>
    <hr/>
    <form id="terms-crud" onsubmit="return imOk()" name="notification" action="admin.php?page=app_guiafloripa_push_add" method="post">


        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td class="first" style="text-align: right"><label for="name">Título</label></td>
                                <td>
                                    <input type="hidden" name="id" id="id" value="<?php echo empty($notification) ? "" : $notification->post->ID; ?>">
                                    <input type="text" value="<?php echo $notification->post->post_title; ?>" name="subject" id="subject" spellcheck="true"  size="30" maxlength="50"  placeholder="Título da Notificação">
                                </td>
                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Mensagem</td>
                                <td>
                                    <textarea name="description" id="description" style="width: 100%;height: 60px" maxlength="100"><?php echo $notification->post->post_content; ?></textarea>
                                </td>

                            </tr>
                            <tr>
                                <td class="first" style="text-align: right">Link</td>
                                <td><input type="text" name="link" onblur="isValidURL(this)" id="link" value="<?php echo $notification->url; ?>"  spellcheck="true"  size="30"  placeholder="http://"></td>
                            </tr>                            
                        </tbody>
                    </table>
                    <br>
                    <input type="button" name="btSaveTerm" value="Salvar" class="page-title-action" onclick="imOk()"/>

                </fieldset>
            </div>
        </div>
    </form>
</div>
<script>
    function imOk() {
        var isOk = true;
        if (jQuery('#subject').val() === "") {
            errorField(jQuery("#subject"));
            isOk =  false;
        }
        if (jQuery('#description').val() === "") {
            errorField(jQuery("#description"));
            isOk =  false;
        }
        if (jQuery('#link').val() === "") {
            errorField(jQuery("#link"));
            isOk = false;
        }
        if(isOk){
            document.notification.submit();
        }
    }

    function errorField(field) {
        field.css('border-color', '#c89494');
        field.css('background-color', '#F9D3D3');
    }
    function isValidURL(str) {
        var pattern = new RegExp('^((https?:)?\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locater
        if (!pattern.test(str.value)) {
            errorField(jQuery("#link"));
            str.value = "";
            str.focus();
            return false;
        } else {
            return true;
        }
    }
</script>