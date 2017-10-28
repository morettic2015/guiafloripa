<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $title;
//$user = wp_get_current_user();
print "<h1>$title</h1>";
?>
<p>Dados no banco de dados x integração por categoria</b></p>
<div id="origin" style="height: 250px;"></div>


<footer>
    Copyright 2017@<br>
    <a href="https://morettic.com.br" target="_BLank">
        <img src="https://morettic.com.br/wp2/wp-content/uploads/2017/06/morettic2.png" width="80"/>
    </a>
</footer>



<script>



<?php
$state = get_stats();
//echo "123";
echo "var dataOrigin = " . $state;
?>

    Morris.Bar({
        element: 'origin',
        data: [
            {x: 'Comer e Beber', a: parseInt(dataOrigin.origin.eat), b: parseInt(eval(dataOrigin.destiny[0]).eat)},
            {x: 'Cultura', a: parseInt(dataOrigin.origin.cult), b: parseInt(eval(dataOrigin.destiny[0]).cult)},
            {x: 'Gratuito', a: parseInt(dataOrigin.origin.free), b: parseInt(eval(dataOrigin.destiny[0]).free)},
            {x: 'Hospedagem', a: parseInt(dataOrigin.origin.host), b: parseInt(eval(dataOrigin.destiny[0]).host)},
            {x: 'Infantil', a: parseInt(dataOrigin.origin.child), b: parseInt(eval(dataOrigin.destiny[0]).child)},
            {x: 'Lazer', a: parseInt(dataOrigin.origin.party), b: parseInt(eval(dataOrigin.destiny[0]).party)},
            {x: 'Eventos', a: parseInt(dataOrigin.origin.event), b: parseInt(eval(dataOrigin.destiny[0]).event)},
            {x: 'Cinema', a: parseInt(dataOrigin.origin.cine), b: parseInt(eval(dataOrigin.destiny[0]).cine)},
            {x: 'Turismo', a: parseInt(dataOrigin.origin.tourism), b: parseInt(eval(dataOrigin.destiny[0]).tourism)}
        ],
        xkey: 'x',
        ykeys: ['a', 'b'],
        labels: ['GUIA FLORIPA', 'APP']
    });

</script>