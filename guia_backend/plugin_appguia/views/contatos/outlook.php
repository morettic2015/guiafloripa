<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// initiate cURL resource
$ch = curl_init();
// where you want to post data
$url = "https://login.microsoftonline.com/common/oauth2/v2.0/token";
curl_setopt($ch, CURLOPT_URL, $url);
// tell curl you want to post something
curl_setopt($ch, CURLOPT_POST, true);

// define what you want to post
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
    'grant_type' => 'authorization_code',
    'code' => urlencode($_GET['code']),
    'redirect_uri' => 'https://app.guiafloripa.com.br/wp-content/plugins/plugin_appguia/views/contatos/outlook.php',
    'client_id' => urlencode('000000004420117F'),
    'client_secret' => urlencode('wqbXXQAM828$eglbFT82:}|')
)));

// return the output in string format
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// execute post
$output = curl_exec($ch);
var_dump($output);

// close the connection
curl_close($ch);

// show output
$info = json_decode($output);

$curl_h = curl_init('https://graph.microsoft.com/v1.0/me/contacts');

curl_setopt($curl_h, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $info->access_token",
        )
);

# do not output, but store to variable
curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl_h);

print_r($response);
