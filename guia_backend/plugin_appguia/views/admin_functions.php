<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_POST['place'])) {
    echo $_POST['place'];
    echo "<iframe src=" . $_POST['place'] . " width='100%' height='300px' style='border:1px solid lightgrey;'>";
    echo "</iframe>";
}
if (isset($_POST['event'])) {
    echo $_POST['event'];
    echo "<iframe src=" . $_POST['event'] . " width='100%' height='300px' style='border:1px solid lightgrey;'>";
    echo "</iframe>";
}
if (isset($_POST['propriedade'])) {
    echo $_POST['propriedade'];
    echo "<iframe src=" . $_POST['propriedade'] . " width='100%' height='300px' style='border:1px solid lightgrey;'>";
    echo "</iframe>";
}
if (isset($_POST['thePlace'])) {
    echo $_POST['thePlace'] . $_POST['idPlace'];
    echo "<iframe src=" . $_POST['thePlace'] . $_POST['idPlace'] . " width='100%' height='300px' style='border:1px solid lightgrey;'>";
    echo "</iframe>";
}
if (isset($_POST['nrPlace'])) {
    //Read URL and get JSON
    echo "https://guiafloripa.morettic.com.br/place/" . $_POST['nrPlace'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://guiafloripa.morettic.com.br/place/" . $_POST['nrPlace']);
    $result = curl_exec($ch);
    curl_close($ch);

    $obj = json_decode($result);

   
    var_dump($obj);
  
}
global $wp;
if (isset($_POST['titBug'])) {
    //var_dump($wp->request);
    $user = wp_get_current_user();
    $tit = 'WP:' . $_POST['titBug'] . "(" . $user->user_login . ")";
    $des = "<p>" . $_POST['descBug'] . "</p><br>"; //.get_current_screen();
    $url = 'https://guiafloripa.morettic.com.br/report/';
    $fields = array(
        'title' => urlencode($tit),
        'desc' => urlencode($des)
    );
    if (!empty($_POST['titBug']) && (!empty($_POST['descBug']))) {
        $return = post_url($url, $fields);

       
        var_dump($return);
        // echo $user->user_login; 
        //var_dump($user);



   
    } else {
        echo "<h1>Não foi possivel relatar o bug</h1>";
        echo "<p>Por favor informe o titulo e o nome do bug</p>";
    }
}

// var_dump($_POST);
function activeTab($field) {
    if (isset($_POST[$field])) {
        echo 'class="wp-tab-active"';
    }
}

function defaultActiveTab() {
    if (!isset($_POST['place']) && !isset($_POST['nrPlace']) && !isset($_POST['thePlace']) && !isset($_POST['propriedade']) && !isset($_POST['event'])) {
        echo 'class="wp-tab-active"';
    }
}
?>