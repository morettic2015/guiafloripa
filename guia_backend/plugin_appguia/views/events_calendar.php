<?php ?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Exportar</a></h1>

    <div class="notice notice-info"> 
        <p>Calendário de <code>Eventos</code> vinculados ao seu perfil.</p>
    </div>
    <div id="calendar" > </div>
</div>
<script>
    jQuery(document).ready(function () {

        jQuery('#calendar').fullCalendar({
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2017-11-01'
                },
                {
                    title: 'Long Event',
                    start: '2017-11-07',
                    end: '2017-11-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-11-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-11-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2017-11-11',
                    end: '2017-11-13'
                },
                {
                    title: 'Meeting',
                    start: '2017-11-12T10:30:00',
                    end: '2017-11-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2017-11-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2017-11-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2017-11-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2017-11-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2017-11-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2017-11-28'
                }
            ]

        });
    });
</script>