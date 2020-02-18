<?php
include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
$cc = new ContatosController();
$ec = new EventControl();
global $wpdb;
$query = "SELECT ID, post_title FROM wp_posts WHERE post_author = " . get_current_user_id() . " and post_type = 'email'  and post_status = 'draft';";
$emails = $wpdb->get_results($query);
$query = "SELECT ID, post_title FROM wp_posts WHERE post_author = " . get_current_user_id() . " and post_type = 'notification' and post_status = 'draft'";
$noifications = $wpdb->get_results($query);
$query = "SELECT meta_value,umeta_id FROM wp_usermeta where meta_key = '_term_twitter' and user_id = " . get_current_user_id() . " order by meta_value ASC";
$hashTags = $wpdb->get_results($query);
$grupos = $cc->getUserGroups();
$eventos = $ec->loadMyEvents();
//var_dump($eventos);die;
$wpdb->close();
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<a name="top"></a>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="notice notice-info" id="msg"> 
        <p>Construa sua campanha adicionando os canais desejados</p>
    </div>
    <hr/>
    <div id="namediv" class="stuffbox">
        <div class="inside">
            <form name="frmCampaign" id="frmCampaign" >
                <table class="form-table editcomment">
                    <tbody>
                        <tr>
                            <td class="first" style="text-align: right">Publicada</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input class="singleOne" type="checkbox" name="published" id="published" value="1" style="height: 15px;width: 20px">Ativar campanha ao salvar

                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Campanha</td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <input type="hidden" name="id" id="id" value="<?php echo empty($post) ? "" : $post->post->ID; ?>">
                                <input type="text" name="title" value="" placeholder="Nome da Campanha de Marketing Digital"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Evento relacionado</td>
                            <td style="width: 95%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                <select name="c_event" id="c_event" style="width: 100%;">
                                    <option value="" selected >Nenhum Evento Relacionado</option>
                                    <?php foreach ($eventos as $g) { ?>
                                        <option value="<?php echo $g['ID']; ?>"><?php echo strtoupper($g['title']) . " - " . strtoupper($g['rating']); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right">Grupos</td>
                            <td style="width: 95%; float: left; display: inline-block;font-size: 12px;margin: 2px">

                                <?php foreach ($grupos as $g) { ?>
                                    <div style="width: 20%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                                        <input class="singleOne" type="checkbox" name="c_groups" id="c_groups" value="<?php echo strtoupper($g); ?>" style="height: 15px;width: 20px"><?php echo strtoupper($g); ?>
                                    </div>

                                <?php } ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="first" style="text-align: right" >Canais</td>
                            <td>
                                <div id="email_1" class="iconBt draggable ui-widget-content dashicons dashicons-email container" style="background-color: #448aff">
                                    <p>Email</p>
                                </div>

                                <div id="noti_1" class="iconBt draggable ui-widget-content dashicons dashicons-megaphone container" style="background-color: #607d8b" >
                                    <p>Notificação</p>
                                </div>
                                <div id="hash_1" class="iconBt draggable ui-widget-content dashicons dashicons-twitter container" style="background-color: #37474f">
                                    <p>Twitter</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <!-- <td class="first" style="text-align: right" >Sua Campanha</td> -->
                            <td style="align-content: flex-end" colspan="2">
                                <h3>Sua campanha</h3>
                                <div id="snaptarget" class="ui-widget-header" style="width: 100%;">
                                    <p></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="button" onclick="saveCampaign()" name="btSaveCampaign" value="Salvar" class="page-title-action"/>
            </form>
        </div>
    </div>
    <div id="dialog-confirm" title="Email Marketing">
        <p>
            <label for="mEmk">Selecione um Email Marketing</label>
            <select name="mEmk" id="mEmk" style="width: 100%;height: 80px;margin-top: 10px" size="7">
                <?php foreach ($emails as $g) { ?>
                    <option value="<?php echo $g->ID; ?>"><?php echo $g->post_title; ?></option>
                <?php } ?>
            </select>
            <label for="mEmkDate">Data de envio</label>
            <input name="mEmkDate" id="mEmkDate" type="date" style="width: 100%;"/>
            <a href="javascript:saveTask()" style="width: 55px" class="button button-primary">Salvar</a>
        </p>
    </div>
    <div id="dialog-confirm1" title="Twitter Marketing">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-2">Retweet</a></li>
                <li><a href="#tabs-3">Enviar mensagem</a></li>
            </ul>
            <div id="tabs-2">
                <p>
                    <b>Selecione uma hashtag para retweetar ou envie uma mensagem para o seus seguidores.</b>
                <hr/>
                <label for="mTwitter">Selecione uma hashtag</label>
                <select name="mTwitter" id="mTwitter" style="width: 100%;height: 80px;margin-top: 10px" size="7">
                    <?php
                    foreach ($hashTags as $g) {
                        $hash = json_decode($g->meta_value);
                        //var_dump($g);
                        ?>
                        <option value="<?php echo $g->umeta_id; ?>"><?php echo $hash->hashtag; ?></option>
                    <?php } ?>
                </select>
                </p>
                <p>
                    <label for="mTwitterR">Número de retweets</label>
                    <input type="number" min="1" max="10" name="mTwitterR" id="mTwitterR"/>
                </p>

            </div>
            <div id="tabs-3">
                <p>
                    <label for="mTwitterMsg">Envie uma mensagem aos seguidores</label>
                    <textarea name="mTwitterMsg" id="mTwitterMsg" style="width: 100%;height: 80px" maxlength="200"></textarea>
                    <label for="mTwitterDate">Data de envio</label>
                    <input name="mTwitterDate" id="mTwitterDate" type="date" style="width: 100%;"/>
                    <a href="javascript:saveTask()" style="width: 55px" class="button button-primary">Salvar</a>
                </p>
            </div>
        </div>
        <hr>


    </div>
    <div id="dialog-confirm2" title="Notificações">
        <p>
            <label for="mNotification">Selecione uma notificação</label>
            <select name="mNotification" id="mNotification" style="width: 100%;height: 80px;margin-top: 10px" size="7">
                <?php foreach ($noifications as $g) { ?>
                    <option value="<?php echo $g->ID; ?>"><?php echo $g->post_title; ?></option>
                <?php } ?>
            </select>
            <label for="mNotiDate">Data de envio</label>
            <input name="mNotiDate" id="mNotiDate" type="date" style="width: 100%;"/>
            <a href="javascript:saveTask()" style="width: 55px" class="button button-primary">Salvar</a>
        </p>
    </div>
</div>
<script>
    function isDateOk(dt) {
        var myDate = new Date(dt);
        var today = new Date();
        if (myDate < today) {
            alert('Data nao pode ser inferior a hoje!')
            return false;
        } else {
            return true;
        }
    }
    function saveCampaign() {
        var submission = new Object();
        submission.fields = jQuery("#frmCampaign").serializeArray();
        submission.campaign = mTasks
        alert(JSON.stringify(submission));
    }
    function saveTask() {
        //alert(taskEdit.id);
        for (i = 0; i < mTasks.length; i++) {
            if (mTasks[i].id === taskEdit.id) {
                var p12 = "data_" + taskEdit.id;
                var lCt = taskEdit.id.split("_");
                var hasDate = false;
                if (lCt[0] === "email") {
                    mTasks[i].email = jQuery("#mEmk").val();
                    mTasks[i].date = jQuery("#mEmkDate").val();
                    mTasks[i].type = "email";
                    hasDate = mTasks[i].date === "" ? false : true;
                    document.getElementById(p12).innerHTML = jQuery("#mEmkDate").val();
                    mdialog.dialog('close');

                } else if (lCt[0] === "noti") {
                    mTasks[i].notification = jQuery("#mNotification").val();
                    mTasks[i].date = jQuery("#mNotiDate").val();
                    mTasks[i].type = "notification";
                    hasDate = mTasks[i].date === "" ? false : true;
                    document.getElementById(p12).innerHTML = jQuery("#mNotiDate").val();
                    mdialog2.dialog('close');

                } else if (lCt[0] === "hash") {
                    mTasks[i].hashTag = jQuery("#mTwitter").val();
                    mTasks[i].date = jQuery("#mTwitterDate").val();
                    mTasks[i].msg = jQuery("#mTwitterMsg").val();
                    mTasks[i].type = "twitter";
                    hasDate = mTasks[i].date === "" ? false : true;
                    document.getElementById(p12).innerHTML = jQuery("#mTwitterDate").val();
                    mdialog1.dialog('close');

                }

                var squarE = "#" + taskEdit.id;
                //jQuery(squarE).removeClass("");
                if (hasDate && isDateOk(mTasks[i].date)) {
                    jQuery(squarE).addClass("fixedNotification", 3000, "easeOutBounce");
                } else {
                    jQuery(squarE).addClass("fixedMail", 3000, "easeOutBounce");
                }
                break;
            }
        }
    }
    function removeTask(element) {
        if (confirm("Deseja remover este elemento de sua campanha?")) {
            element.parentElement.remove();
        }
        var mName = element.parentElement.id;
        for (i = 0; i < mTasks.length; i++) {
            if (mTasks[i].id === mName) {
                mTasks.splice(i, 1);
                break;
            }
        }
    }
    var taskEdit = new Object();
    function configTask(element) {
        //alert(element);
        jQuery("#mEmk").val("");
        jQuery("#mEmkDate").val("");
        jQuery("#mNotification").val("");
        jQuery("#mNotiDate").val("");
        jQuery("#mTwitterMsg").val("");
        jQuery("#mTwitter").val("");
        jQuery("#mTwitterDate").val("");
        var mId = element.parentElement.id;
        for (i = 0; i < mTasks.length; i++) {
            if (mTasks[i].id === mId) {
                //alert(JSON.stringify(mTasks[i]));
                var lCt = mId.split("_");
                if (lCt[0] === "email") {

                    if (mTasks[i].email !== undefined)
                        jQuery("#mEmk").val(mTasks[i].email);

                    if (mTasks[i].date !== undefined)
                        jQuery("#mEmkDate").val(mTasks[i].date);

                    mdialog.dialog('open');
                } else if (lCt[0] === "noti") {

                    if (mTasks[i].notification !== undefined)
                        jQuery("#mNotification").val(mTasks[i].notification);

                    if (mTasks[i].date !== undefined)
                        jQuery("#mNotiDate").val(mTasks[i].date);

                    mdialog2.dialog('open');
                } else if (lCt[0] === "hash") {

                    if (mTasks[i].hashTag !== undefined)
                        jQuery("#mTwitter").val(mTasks[i].hashTag);

                    if (mTasks[i].date !== undefined)
                        jQuery("#mTwitterDate").val(mTasks[i].date);

                    if (mTasks[i].msg !== undefined)
                        jQuery("#mTwitterMsg").val(mTasks[i].msg);

                    mdialog1.dialog('open');
                }
            }
        }
        taskEdit.id = mId;


    }
    var mTasks = [];
    var counter = 0;
    var mdialog;
    var mdialog1;
    var mdialog2;
    jQuery(function ($) {
        $("#tabs").tabs();
        $("#snaptarget").droppable({
            classes: {
                'ui-droppable-hover': 'page-title-action'
            },
            drop: function (ev, ui) {
                counter++;
                var divId = ui.draggable[0].id + "_" + counter;
                var oldId = ui.draggable[0].id;
                mTasks.push({"id": divId});
                ui.draggable[0].id = divId;
                ui.draggable[0].keyWork = ui.draggable[0].id;
                $(ui.draggable)
                        .clone()
                        .appendTo($(this))
                        .append("<span class=\"iconBt dashicons dashicons-admin-generic\" onclick=\"configTask(this)\"></span>")
                        .append("<span class=\"iconBt dashicons dashicons-no\" onclick=\"removeTask(this)\"></span>")
                        .append("<span id='data_" + divId + "'></span>")
                        .addClass("droppedOne", 1000, "easeOutBounce");
                ui.draggable[0].id = oldId;

            }
        });
        $("#email_1").draggable({grid: [20, 20], helper: "clone"})
        $("#noti_1").draggable({grid: [20, 20], helper: "clone"});
        $("#hash_1").draggable({grid: [20, 20], helper: "clone"});
        var winDialogConfig = {
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            draggable: false,
            autoOpen: false
        };
        mdialog = $("#dialog-confirm").dialog(winDialogConfig);
        mdialog1 = $("#dialog-confirm1").dialog(winDialogConfig);
        mdialog2 = $("#dialog-confirm2").dialog(winDialogConfig);
    });
</script>
<style>
    .droppedOne{
        background-color: #F06292 !important;
    }

    .fixedMail{
        background-color: #d50000 !important;
    }
    .fixedTwitter{
        background-color: #311b92 !important;
    }
    .fixedNotification{
        background-color: #311b92 !important;
    }
    option:hover {
        color:white !important;
        background-color: #311b92 !important;
        border: 8px;
        border-style: double;

    }
    #c_groups {border: 1px;width: 200px}
    .iconBt {margin: 3px; color: white}
    .draggable { width: 80px; min-height: 90px;max-height: 110px; padding: 5px; border: 1px;border-color: #263238; float: left; margin: 5 10px 10px 5; font-size: .9em; }
    .ui-widget-header p, .ui-widget-content p { margin: 0; }
    #snaptarget { height: 40vh; width: 60vh; margin: 0px; top: 0px;position: inherit; border: 1px;border-style: dotted }

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
<?php
//wp_die(); ?>