<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />
<link href="<?php echo plugins_url('css/gijgo.css', __FILE__); ?>" rel="stylesheet" type="text/css" />
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="<?php echo plugins_url('js/gijgo.js', __FILE__); ?>" type="text/javascript"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $title;
$user = wp_get_current_user();
print "<h1>$title</h1>";
print "<p> Registro de ações em nome de <b>(" . $user->user_login . ")</b></p>";
include PLUGIN_ROOT_DIR . 'views/admin_functions.php';
?>
<form name="report" method="post">
    <table style="width: 99%" class="morris-default-style">
        <tr>
            <th colspan="2">
                <h2>Relatar Requisito ou Problema</h2>
            </th>
            <th>
                <h2>Estatísticas</h2>
            </th>
        </tr>
        <tr>
            <td class="post-state"><b>Título da ocorrência</b></td>
            <td class="post-state"> <input type="text" name="titBug" size="50"  class="pressthis-bookmarklet" /></td>
            <td rowspan="2" style="width: 300px"><div id="graph"></div></td>
        </tr>
        <tr class="">
            <td class="post-state"> <b>Descrição da ocorrência</b></td>
            <td class="post-state"> <textarea name='descBug' rows="20" style="width: 100%"  class="pressthis-bookmarklet" ></textarea></td>
        </tr>
    </table>
</form>

<hr>
<table id="grid"></table>
<hr>
<!-- End tabs -->
<footer>
    Copyright 2017@<br>
    <a href="https://morettic.com.br" target="_BLank">
        <img src="https://morettic.com.br/wp2/wp-content/uploads/2017/06/morettic2.png" width="80"/>
    </a>
</footer>

<script>
    $('#grid').grid({
        dataSource: 'https://guiafloripa.morettic.com.br/issues/',
        columns: [
            {field: 'id', width: 80, title: 'Codigo'},
            {field: 'category', sortable: true, width: 90, title: 'Categoria'},
            {field: 'summary', sortable: true, width: 120, title: 'Sumário'}
        ]
    });
    Morris.Donut({
        element: 'graph',
        data: [
            {value: 70, label: 'foo'},
            {value: 15, label: 'bar'},
            {value: 10, label: 'baz'},
            {value: 5, label: 'A really really long label'}
        ],
        backgroundColor: '#ccc',
        labelColor: '#060',
        colors: [
            '#0BA462',
            '#39B580',
            '#67C69D',
            '#95D7BB'
        ],
        formatter: function (x) {
            return x + "%"
        }
    });
</script>