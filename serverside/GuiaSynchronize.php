<?php

//Database configuration
DB::$user = 'appguia';
DB::$password = '#4ppgu14Fl0r1p4!';
DB::$dbName = 'guiafloripa';
DB::$host = 'guiafloripa.com.br';
DB::$port = '3306';
DB::$error_handler = array('Errors', 'static_error_handler'); 
// use an object method as an error handler
$my_object = new Errors();
DB::$error_handler = array($my_object, 'error_handler');

class Errors {
  public static function static_error_handler($params) {
    echo "Error: " . $params['error'] . "<br>\n";
    echo "Query: " . $params['query'] . "<br>\n";
    die; // don't want to keep going if a query broke
  }
   
  public function error_handler($params) {
    echo "Error: " . $params['error'] . "<br>\n";
    echo "Query: " . $params['query'] . "<br>\n";
    die; // don't want to keep going if a query broke
  }
}
class GuiaSynchronize extends stdClass{

    public static function getLatLonFromAddress($address){
        $content = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyBszRC_PVudlS_S_O_ejw00pZ_fJFU3Q0o');
        $json = json_decode($content);
        //echo "<pre>";
        $geo = new stdClass();
        $geo->formatted_address = $json->results[0]->formatted_address;
        $geo->lat = $json->results[0]->geometry->location->lat;
        $geo->lng = $json->results[0]->geometry->location->lng;


        return $geo;
    }

    public static function getPlaces(){
        echo "<pre>";
        $query = "show tables";

            $mdb = new MeekroDB();
        $mdb->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $eventos = $mdb->query($query); // misspelled SELECT
        foreach($eventos as $row){
            echo "\n".$row['Tables_in_guiafloripa'];
            $o = $mdb->query("desc ".$row['Tables_in_guiafloripa']);
           
            var_dump($row);
             var_dump($o);
        }
       /* echo "<pre>";
        var_dump($eventos);die;*/
          DB::disconnect();
          die();
    }

    public static function getCinemas(){
        $query = "SELECT 
    `dtstart`,`dtend`,
        `a1`.`id` AS `id_cn_filme_post`,
        `a2`.`id` AS `id_cn_filme`,
        `a3`.`ID` AS `id_wp_post`,
        `a3`.`post_title` AS `post_title`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_region'))) AS `state`,
		 (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `phone`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `city`,
		(SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_postalcode'))) AS `cep`,
		(SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `address`,
        `a3`.`post_content` AS `post_content`,
        `a3`.`ID` AS `ID_POST_`,
        `a1`.`outras_informacoes` AS `outras_informacoes`,
        `a1`.`salas_horarios` AS `salas_horarios`,
        `a2`.`titulo` AS `titulo`,
        `a2`.`titulo_original` AS `titulo_original`,
        `a2`.`ano_producao` AS `ano_producao`,
        `a2`.`duracao` AS `duracao`,
        `a2`.`pais_origem` AS `pais_origem`,
        `a2`.`diretor` AS `diretor`,
        `a2`.`elenco` AS `elenco`,
        `a2`.`sinopse` AS `sinopse`,
        `a2`.`imagem_full` AS `imagem_full`
    FROM
        ((`wp_cn_filme_post` `a1`
        LEFT JOIN `wp_cn_filme` `a2` ON ((`a1`.`id_wp_cn_filme` = `a2`.`id`)))
        LEFT JOIN `wp_posts` `a3` ON ((`a3`.`ID` = `a1`.`id_wp_posts`)))
        
        where a3.ID is not null and dtstart <> ''
        
        order by post_title ASC limit 100";
        $mdb = new MeekroDB();
        $mdb->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $eventos = $mdb->query($query); // misspelled SELECT

        /*echo "<pre>";
        var_dump($eventos);die;*/

        //https://maps.googleapis.com/maps/api/geocode/json?address=Rua%20Bocai%EF%BF%BDva,%202468%20-%20Centro&key=AIzaSyBszRC_PVudlS_S_O_ejw00pZ_fJFU3Q0o
        $cinemas = Array();

        foreach($eventos as $row){
            $cartaz = new stdClass();
    //var_dump($row);die;
            $cartaz->dtstart = $row['dtstart'];
            $cartaz->dtend = $row['dtend'];
            $cartaz->titulo = utf8_encode($row['titulo']);
            $cartaz->titulo_original = utf8_encode($row['titulo_original']);
            $cartaz->ano_producao = $row['ano_producao'];
            $cartaz->duracao = $row['duracao'];
            $cartaz->pais_origem = $row['pais_origem'];
            $cartaz->diretor = $row['diretor'];
            $cartaz->elenco = $row['elenco'];
            $cartaz->sinopse = $row['sinopse'];
            $cartaz->imagem_full = $row['imagem_full'];
            $cartaz->id_cn_filme_post = $row['id_cn_filme_post'];
            $cartaz->id_cn_filme = $row['id_cn_filme'];
            $cartaz->id_wp_post = $row['id_wp_post'];
            $cartaz->post_title = $row['post_title'];
            $cartaz->state = $row['state'];
            $cartaz->city = $row['city'];
            $cartaz->addressID = $row['address'];
            $cartaz->post_content = $row['post_content'];
            $cartaz->outras_informacoes_clean = strip_tags($row['outras_informacoes']);
            $cartaz->outras_informacoes_html = $row['outras_informacoes'];
            $cartaz->ID = $row['ID_POST_'];
            $cartaz->salas_horarios = $row['salas_horarios'];

            $cartaz->geo = GuiaSynchronize::getLatLonFromAddress($cartaz->addressID);

            $cinemas[] = $cartaz;
        }
        DB::disconnect();
        return $cinemas;
        //var_dump($eventos);
    }

     public static function getUpdateCinemas(){
        $query = "SELECT 
    `dtstart`,`dtend`,
        `a1`.`id` AS `id_cn_filme_post`,
        `a2`.`id` AS `id_cn_filme`,
        `a3`.`ID` AS `id_wp_post`,
        `a3`.`post_title` AS `post_title`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_region'))) AS `state`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `city`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `address`,
        `a3`.`post_content` AS `post_content`,
        `a3`.`ID` AS `ID_POST_`,
        `a1`.`outras_informacoes` AS `outras_informacoes`,
        `a1`.`salas_horarios` AS `salas_horarios`,
        `a2`.`titulo` AS `titulo`,
        `a2`.`titulo_original` AS `titulo_original`,
        `a2`.`ano_producao` AS `ano_producao`,
        `a2`.`duracao` AS `duracao`,
        `a2`.`pais_origem` AS `pais_origem`,
        `a2`.`diretor` AS `diretor`,
        `a2`.`elenco` AS `elenco`,
        `a2`.`sinopse` AS `sinopse`,
        `a2`.`imagem_full` AS `imagem_full`
    FROM
        ((`wp_cn_filme_post` `a1`
        LEFT JOIN `wp_cn_filme` `a2` ON ((`a1`.`id_wp_cn_filme` = `a2`.`id`)))
        LEFT JOIN `wp_posts` `a3` ON ((`a3`.`ID` = `a1`.`id_wp_posts`)))
        
        where a3.ID is not null and dtstart <> ''
        
        order by post_title ASC";
        $mdb = new MeekroDB();
        $mdb->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $eventos = $mdb->query($query); // misspelled SELECT

        /*echo "<pre>";
        var_dump($eventos);die;*/

        //https://maps.googleapis.com/maps/api/geocode/json?address=Rua%20Bocai%EF%BF%BDva,%202468%20-%20Centro&key=AIzaSyBszRC_PVudlS_S_O_ejw00pZ_fJFU3Q0o
        $cinemas = Array();

        foreach($eventos as $row){
            $cartaz = new stdClass();
    //var_dump($row);die;
            $cartaz->dtstart = $row['dtstart'];
            $cartaz->dtend = $row['dtend'];
            $cartaz->titulo = utf8_encode($row['titulo']);
            $cartaz->titulo_original = utf8_encode($row['titulo_original']);
            $cartaz->ano_producao = $row['ano_producao'];
            $cartaz->duracao = $row['duracao'];
            $cartaz->pais_origem = $row['pais_origem'];
            $cartaz->diretor = $row['diretor'];
            $cartaz->elenco = $row['elenco'];
            $cartaz->sinopse = $row['sinopse'];
            $cartaz->imagem_full = $row['imagem_full'];
            $cartaz->id_cn_filme_post = $row['id_cn_filme_post'];
            $cartaz->id_cn_filme = $row['id_cn_filme'];
            $cartaz->id_wp_post = $row['id_wp_post'];
            $cartaz->post_title = $row['post_title'];
            $cartaz->state = $row['state'];
            $cartaz->city = $row['city'];
            $cartaz->addressID = $row['address'];
            $cartaz->post_content = $row['post_content'];
            $cartaz->outras_informacoes_clean = strip_tags($row['outras_informacoes']);
            $cartaz->outras_informacoes_html = $row['outras_informacoes'];
            $cartaz->ID = $row['ID_POST_'];
            $cartaz->salas_horarios = $row['salas_horarios'];

            $cartaz->geo = GuiaSynchronize::getLatLonFromAddress($cartaz->addressID);

            $cinemas[] = $cartaz;
        }
        DB::disconnect();
        return $cinemas;
        //var_dump($eventos);
    }

}