<?php

/**
 * Description of EmailController
 *
 * @author Morettic LTDA
 */
class EmailController {

    //put your code here

    public static function getNeighById($postID){
        $query = "select post_title as bairro from wp_posts where id = (select (meta_value) from wp_postmeta where post_id = $postID and meta_key = 'bairros');";
        $conn = new MysqlDB();
        $conn->execute($query); 
        if($row = $conn->hasNext()){
            return $row['bairro'];
        }else{
            return "";
        }
    }
    
    public static function createWeekNews() {
        $query = "select titulo,from_unixtime((select dtstart+86400 from wp_cn_filme_post where id_wp_cn_filme = a.id limit 1),'%d-%m') as dt from wp_cn_filme as a  where id in (select id_wp_cn_filme from wp_cn_filme_post  where estreia = 2 and FROM_UNIXTIME(dtend)>now()) order by dt desc;";
        $conn = new MysqlDB();
        $conn->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        $conn->execute($query); // misspelled SELECT

        $news = [];
        $str = '<div style="text-align: center;"><strong>Estreias nos Cinemas</strong></div>';
        $str .= "<ul>";
        while ($row = $conn->hasNext()) {
            $str .= '<li style="text-align: left;"><a target="_blank" href="http://guiafloripa.com.br/cinema" style="font-size: 14px;">' /*. $row['dt'] . ' - '*/ . $row['titulo'] . '</a></li>';
        }
        $str .= "</ul>";
        $str .= '<div style="text-align: center;"><strong>Eventos</strong></div>';
        //Consulta os eventos total 16 da view
        $query2 = "select idEvent,DATE_FORMAT(dtFrom,'%d-%m') as dtFrom1,ucfirst(nmPlace) as nmPlace,deEvent,dtFrom,dtUntil from view_random_large_interval order by dtFrom asc";
//        $queryEvento = "select *,DATE_FORMAT(dtFrom,'%d-%m') as dtFrom1 from view_random_events;";

        //echo $queryEvento;

        $eventos = DB::query($query2); // misspelled 
        $str .= "<ul>";
        foreach ($eventos as $e) {
            $bairro = EmailController::getNeighById($e['idEvent']);
            //var_dump($e);die;
            $str .= '<li style="text-align: left;"><a target="_blank" href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $e['idEvent'] . '" style="font-size: 14px;margin-top:15px">' . ucwords($e['deEvent']) . '</a><br><span style="font-size: 11px;margin-top:15px;margin-bottom:10px">' . ucwords($e['nmPlace']) . ' - '.$bairro.'</span></li>';
        }
        $str .= "</ul>";
        //  echo $str;
        // die;
        $template = new Template('./template/template1.html');
        $template->set('{subject}', "Agenda Guia Floripa");
        $template->set('{html_src}', $str);
        $template->set('{call_src}', "Você está recebendo algumas dicas de agendas do Guia Floripa para o fim de semana. Divirta-se!");
        $template->set('{twitter}', "#");
        $template->set('{facebook}', "https://www.facebook.com/Guiafloripa/");
        $template->set('{button_text}', "Visite nosso site");
        $template->set('{button_href}', "http://www.guiafloripa.com.br");
        $data = new stdClass();
        $data->template = $template->render();
        //var_dump($data);die;
        $data->response = LeadController::createEmail(
                        $data->titulo, "Email Semanal Automatico", "Agenda Guia Floripa", "Redação Guia Floripa", $data->template, "", 23, ""
        );
        //echo $data->response['email']['id'];die;
        sleep(0.3);//Sleeps before
        $data->sent = LeadController::sendEmail($data->response['email']['id']);
        //var_dump($data->response);
        $conn->closeConn();




        return $data;
    }

}
