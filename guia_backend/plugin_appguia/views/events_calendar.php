<?php ?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Exportar</a></h1>

    <div class="notice notice-info"> 
        <p>Calendário de <code>Eventos</code> vinculados ao seu perfil.</p>
    </div>
    <div id="calendar" > </div>
</div>
<?php
include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
$ec = new EventControl();
$lDates = $ec->loadMyDates();
$dates = "";
foreach ($lDates as $dt) {
    //var_dump($dt);
    $color = "#c31d52";
    if($dt->post_status==="draft"){
        $color = "#f2bb15";
    }else if($dt->post_status==="publish"){
        $color = "#3098c3";
    }
    $dates.= "{
        title: '" . $dt->post_title . "',
        start: '" . gmdate("Y-m-d", $dt->dtStart) . "',
        end: '" . gmdate("Y-m-d", $dt->dtEnd) . "',
        color  : '".$color."'    
    },";
}
?>

<script>


    jQuery(document).ready(function () {

        jQuery('#calendar').fullCalendar({
            editable: false,
            height: 650,
            eventLimit: true, // allow "more" link when too many events
            events: [
                <?php echo $dates ;?>
                {
                    title: 'Hi How Are u? www.morettic.com.br',
                    start: '1999-11-11',
                    end: '1999-11-13'
                }
            ]

        });
    });
</script>