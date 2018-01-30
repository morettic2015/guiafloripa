<?php
global $wpdb;
$query = "SELECT * FROM wp_posts WHERE post_author = " . get_current_user_id() . " and post_type = 'email'  and post_status = 'draft';";
$emails = $wpdb->get_results($query);
$query = "SELECT * FROM wp_posts WHERE post_author = " . get_current_user_id() . " and post_type = 'notification' and post_status = 'draft'";
$noifications = $wpdb->get_results($query);
$query = "SELECT meta_value FROM app_guiafloripa_com_br.wp_usermeta where meta_key = '_term_twitter' and user_id = " . get_current_user_id();
$hashTags = $wpdb->get_results($query);
//var_dump($hashTags);
$wpdb->close();
//var_dump($emails);
?>
<a name="top"/>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="notice notice-info" id="msg"> 
        <p>Construa sua campanha adicionando os canais desejados</p>
    </div>
    <hr/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .draggable { width: 90px; height: 120px; padding: 5px; float: left; margin: 0 10px 10px 0; font-size: .9em; }
        .ui-widget-header p, .ui-widget-content p { margin: 0; }
        #snaptarget { height: 100vh; margin-top: 0px; top: 0px;position: inherit }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var counter = 0;
        jQuery(function ($) {
            $("#snaptarget").droppable({
                drop: function (ev, ui) {
                    if (ui.helper.attr('id').search(/draggable[0-9]/) != -1) {
                        counter++;
                        var element = $(ui.draggable).clone();
                        element.addClass("tempclass");
                        $(this).append(element);
                        $(".tempclass").attr("id", "clonediv" + counter);
                        $("#draggable1" + counter).removeClass("tempclass");
                        //Get the dynamically item id
                        draggedNumber = ui.helper.attr('id').search(/drag([0-9])/)
                        itemDragged = "dragged" + RegExp.$1
                        console.log(itemDragged)
                        $("#clonediv" + counter).addClass(itemDragged);
                    }
                }
            });
<?php foreach ($emails as $m1) { ?>
                $("#email_<?php echo $m1->ID; ?>").draggable({grid: [20, 20], containment: 'snaptarget'})
    <?php
} foreach ($noifications as $m1) {
    ?>
                $("#noti_<?php echo $m1->ID; ?>").draggable({grid: [20, 20], containment: 'snaptarget'})
    <?php
}
$c1 = 0;
foreach ($hashTags as $m1) {
    $hash = json_decode($m1->meta_value);
    ?>
                $("#hash_<?php echo $c1++; ?>").draggable({grid: [20, 20], containment: 'snaptarget'})
<?php } ?>

            // $("#draggable2").draggable({grid: [20, 20], containment: 'snaptarget'});
            // $("#draggable3").draggable({grid: [20, 20], containment: 'snaptarget'});


        });
    </script>
    <div id="namediv" class="stuffbox">
        <div class="inside">
            <table class="form-table editcomment">
                <tbody>

                    <tr>
                        <td class="first" style="text-align: right"><label for="name">Nome da sua campanha</label></td>
                        <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">
                            <input type="hidden" name="id" id="id" value="<?php echo empty($post) ? "" : $post->post->ID; ?>">
                            <input type="text" name="title" value="" placeholder="Nome da Campanha de Marketing Digital"/>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="form-table editcomment">
                <tbody>

                    <tr>
                        <td style="width: 30%">
                           
                            <?php foreach ($emails as $m1) { ?>
                                <div id="email_<?php echo $m1->ID; ?>" class="draggable ui-widget-content dashicons dashicons-email container" >
                                    <p><?php echo substr($m1->post_title, 0, 30); ?></p>
                                    <span class="dashicons dashicons-admin-generic"></span>
                                </div>
                                <?php
                            }
                            foreach ($noifications as $m1) {
                                ?>
                                <div id="noti_<?php echo $m1->ID; ?>" class="draggable ui-widget-content dashicons dashicons-megaphone container" >
                                    <p><?php echo substr($m1->post_title, 0, 30); ?></p>
                                    <span class="dashicons dashicons-admin-generic"></span>
                                </div>
                                <?php
                            }

                            $c1 = 0;
                            foreach ($hashTags as $m1) {
                                $hash = json_decode($m1->meta_value);
                                ?>
                                <div id="hash_<?php echo $c1++; ?>" class="draggable ui-widget-content dashicons dashicons-twitter container" >
                                    <p><?php echo $hash->hashtag; ?></p>
                                    <span class="dashicons dashicons-admin-generic"></span>
                                </div>
                            <?php } ?>
                        </td>
                        <td style="align-content: flex-end">
                           
                            <div id="snaptarget" class="ui-widget-header">
                                <p></p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



</div>