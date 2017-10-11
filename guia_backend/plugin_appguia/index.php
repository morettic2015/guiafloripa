<?php

/**
 * @Plugin Name: Guiafloripa APP REDIRECT 
 * @Description: <p>PLUGIN REDIRECT DO APP GUIA - <b>www.experienciasdigitais.com.br</b>. <br>Utilize o Shorcode [guia_app]</p>
 * @author Luis Augusto Machado Moretto <projetos@morettic.com.br>

 * */
/* Start Adding Functions Below this Line */
const DEFAULT_VIEW_URL = "htps://app.guiafloripa.com.br";
/**
 * @Redirect URL using Javascript Script
 */
function guia_app_redirect() {
    $_key = $_GET['key'];
    $permaLink = get_permalink($_key);
    if(empty($permaLink)){
       $permaLink = DEFAULT_VIEW_URL; 
    }
    echo "<h1>Redirecionando</h1>";
    echo "<h4>Caso a página não redirecione clique no link abaixo</h4>";
    echo "<small><a href='$permaLink' target='_blank'>$permaLink</a></small>";
    //sleep(0.1);
    echo "<script>this.location.href='" . $permaLink . "';</script>";
    exit;
}

add_shortcode('guia_app', 'guia_app_redirect');

/* Stop Adding Functions Below this Line */
?>