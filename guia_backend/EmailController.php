<?php

/**
 * Description of EmailController
 *
 * @author Morettic LTDA
 */
class EmailController {

    //put your code here

    public static function getNeighById($postID) {
        $query = "select post_title as bairro from wp_posts where id = (select (meta_value) from wp_postmeta where post_id = $postID and meta_key = 'bairros');";
        $conn = new MysqlDB();
        $conn->execute($query);
        if ($row = $conn->hasNext()) {
            return $row['bairro'];
        } else {
            return "";
        }
    }

    private static function makeTableStar($result) {
        /*
          $content = '<table cellpadding="0" cellspacing="0" style="border-collapse:separate;vertical-align: text-bottom;" width="100">
          <tbody>
          <tr>
          <td class="mobile-block" style="vertical-align: text-bottom;font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
          <table cellpadding="0" cellspacing="0" style="border-collapse:separate;" width="0">
          <tbody>
          <tr>
          <td class="mini-img" style=" vertical-align: text-bottom;font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 100px;height:100px;"><img src="'.$result[0]['deImg'].'" alt="'.$result[0]['nmPlace'].'"  title="'.$result[0]['nmPlace'].'" style="max-width: 600px; outline: none; text-decoration: none; border-radius: 3px; width: 130px;" class="fr-fic fr-dii">
          <br>
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key='.$result[0]['idEvent'].'">'.$result[0]['dtFrom1'].' '.$result[0]['deEvent'].'</a>
          </td>
          <td class="mini-img" style=" vertical-align: text-bottom;font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 100px;height:100px;"><img src="'.$result[1]['deImg'].'" alt="'.$result[1]['nmPlace'].'"  title="'.$result[1]['nmPlace'].'"  style="max-width: 600px; outline: none; text-decoration: none; border-radius: 3px; width: 130px;" class="fr-fic fr-dii">
          <br>
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key='.$result[1]['idEvent'].'">'.$result[1]['dtFrom1'].' '.$result[1]['deEvent'].'</a>
          </td>
          </tr>
          </tbody>
          </table>
          </td>
          <td class="mobile-block" style="vertical-align: text-bottom;font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
          <table cellpadding="0" cellspacing="0" style="border-collapse:separate;" width="0">
          <tbody>
          <tr>
          <td class="mini-img" style=" vertical-align: text-bottom;font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;100px;height:100px"><img src="'.$result[2]['deImg'].'" alt="'.$result[2]['nmPlace'].'"  title="'.$result[2]['nmPlace'].'"  style="max-width: 600px; outline: none; text-decoration: none; border-radius: 3px; width: 130px;" class="fr-fic fr-dii">
          <br>
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key='.$result[2]['idEvent'].'">'.$result[2]['dtFrom1'].' '.$result[2]['deEvent'].'</a>
          </td>
          <td class="mini-img" style="vertical-align: text-bottom;font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;100px;height:100px"><img src="'.$result[3]['deImg'].'" alt="'.$result[3]['nmPlace'].'"  title="'.$result[3]['nmPlace'].'"  style="max-width: 600px; outline: none; text-decoration: none; border-radius: 3px; width: 130px;" class="fr-fic fr-dii">
          <br>
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key='.$result[3]['idEvent'].'">'.$result[3]['dtFrom1'].' '.$result[3]['deEvent'].'</a>
          </td>
          </tr>
          </tbody>
          </table>
          </td>
          </tr>
          </tbody>
          </table>'; */
         $content = '<br><table cellpadding="0" cellspacing="0" style="border-collapse:separate;" width="0">
          <tbody>
          <tr>
          <td class="mobile-block" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">

          <table cellpadding="0" cellspacing="0" style="border-collapse:separate;" width="100%">
          <tbody>
          <tr>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[0]['idEvent'] . '">
          <img src="' . $result[0]['deImg'] . '" alt="' . $result[0]['nmPlace'] . '"  title="' . $result[0]['nmPlace'] .' '.$result[0]['dtFrom1'].' '.$result[0]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[1]['idEvent'] . '">
          <img src="' . $result[1]['deImg'] . '" alt="' . $result[1]['nmPlace'] . '"  title="' . $result[1]['nmPlace'] .' '.$result[1]['dtFrom1'].' '.$result[1]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          </tr>
          <tr>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[2]['idEvent'] . '">
          <img src="' . $result[2]['deImg'] . '" alt="' . $result[2]['nmPlace'] . '"  title="' . $result[2]['nmPlace'] .' '.$result[2]['dtFrom1'].' '.$result[2]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[3]['idEvent'] . '">
          <img src="' . $result[3]['deImg'] . '" alt="' . $result[3]['nmPlace'] . '"  title="' . $result[3]['nmPlace'] .' '.$result[3]['dtFrom1'].' '.$result[3]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          </tr>
          </tbody>
          </table>
          </td>
          <td class="mobile-block" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">

          <table cellpadding="0" cellspacing="0" style="border-collapse:separate;" width="100%">
          <tbody>
          <tr>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[4]['idEvent'] . '">
          <img src="' . $result[4]['deImg'] . '" alt="' . $result[4]['nmPlace'] . '"  title="' . $result[4]['nmPlace'] .' '.$result[4]['dtFrom1'].' '.$result[4]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[5]['idEvent'] . '">
          <img src="' . $result[5]['deImg'] . '" alt="' . $result[5]['nmPlace'] . '"  title="' . $result[5]['nmPlace'] .' '.$result[5]['dtFrom1'].' '.$result[5]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          </tr>
          <tr>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[6]['idEvent'] . '">
          <img src="' . $result[6]['deImg'] . '" alt="' . $result[6]['nmPlace'] . '"  title="' . $result[6]['nmPlace'] .' '.$result[6]['dtFrom1'].' '.$result[6]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          <td class="mini-img" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 3px;width: 130px;">
          <a href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $result[7]['idEvent'] . '">
          <img src="' . $result[7]['deImg'] . '" alt="' . $result[7]['nmPlace'] . '"  title="' . $result[7]['nmPlace'] .' '.$result[7]['dtFrom1'].' '.$result[7]['deEvent']. '" style="max-width: 100px; outline: none; text-decoration: none; border-radius: 3px; width: 100px;" width="100" class="fr-fic fr-dii">
          </a>
          </td>
          </tr>
          </tbody>
          </table>
          </td>
          </tr>
          </tbody>
          </table>
          '; 

       

        return $content;
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
            $str .= '<li style="text-align: left;"><a target="_blank" href="http://guiafloripa.com.br/cinema" style="font-size: 14px;">' /* . $row['dt'] . ' - ' */ . $row['titulo'] . '</a></li>';
        }
        $str .= "</ul>";
        $str .= '<div style="text-align: center;"><strong>Eventos</strong></div>';
        /**
         * @Query for payed ones :P
         */
        $pics = DB::query("SELECT distinct idEvent,DATE_FORMAT(dtFrom,'%d-%m') as dtFrom1,ucfirst(nmPlace) as nmPlace,deEvent,dtFrom,dtUntil,deImg FROM guiafloripa_app.view_email_events_pics  limit 8;");
        $str .= self::makeTableStar($pics);
        //Consulta os eventos total 16 da view
        $query2 = "select idEvent,DATE_FORMAT(dtFrom,'%d-%m') as dtFrom1,ucfirst(nmPlace) as nmPlace,deEvent,dtFrom,dtUntil from view_random_large_interval where deImg is null or deImg not like '%http%' order by dtUntil asc";

        $eventos = DB::query($query2); // misspelled 
        $str .= "<ul>";
        $i = 0;
        $strTitle = "";
        foreach ($eventos as $e) {
            $bairro = EmailController::getNeighById($e['idEvent']);
            //var_dump($e);die;
            $str .= '<li style="text-align: left;"><a target="_blank" href="http://www.guiafloripa.com.br/guiafloripa-app-redirect/?key=' . $e['idEvent'] . '" style="font-size: 14px;margin-top:15px">' . ucfirst($e['deEvent']) . '</a><br><span style="font-size: 11px;margin-top:15px;margin-bottom:10px">' . ucwords($e['nmPlace']) . ' - ' . $bairro . '</span></li>';
            if ($i < 2) {
                $strTitle .= " | " . ucfirst($e['deEvent']);
                $i++;
            }
        }
        $strTitle .= " e mais!";
        $str .= "</ul>";
        //  echo $str;
        // die;
        $template = new Template('./template/template1.html');
        $template->set('{subject}', "Agenda Guia Floripa $strTitle");
        $template->set('{subject_title}', "Agenda Guia Floripa");
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
                        $data->titulo, "Email Semanal Automatico", "Agenda Guia Floripa " . ($strTitle), "Redação Guia Floripa", $data->template, "", /* 100 */ 23, ""
        );
        //echo $data->response['email']['id'];die;
        // sleep(0.3);//Sleeps before
        // $data->sent = LeadController::sendEmail($data->response['email']['id']);
        //var_dump($data->response);
        $conn->closeConn();




        return $data;
    }

}
