<?php
/* add_menu_page(
  'Integração de dados APP', // page title
  'Sincronização', // menu title
  'manage_options', // capability
  'app_guiafloripa_manager_backend', // menu slug
  'wpse_91693_render', null, 6
  );
  add_menu_page(
  'Meus Negócios', // page title
  'Negócios', // menu title
  'read', // capability
  'app_guiafloripa_negocio', // menu slug
  'app_guiafloripa_negocio', null, 1
  );
  add_submenu_page('app_guiafloripa_negocio', 'Edite seu Negócio', 'Adicionar', 'read', 'app_guiafloripa_negocio_add', 'app_guiafloripa_negocio_add');
  add_submenu_page('app_guiafloripa_negocio', 'Atividades do negócio', 'Atividades', 'read', 'app_guiafloripa_activity', 'app_guiafloripa_activity');
  add_menu_page(
  'Meus Eventos', // page title
  'Eventos', // menu title
  'read', // capability
  'app_guiafloripa_eventos', // menu slug
  'wpse_91693_events', null, 1
  );
  add_submenu_page('app_guiafloripa_eventos', 'Calendário de Eventos', 'Calendário', 'read', 'app_guiafloripa_eventos_cal', 'app_guiafloripa_eventos_cal');
  add_submenu_page('app_guiafloripa_eventos', 'Adicione seu Evento', 'Adicionar', 'read', 'app_guiafloripa_eventos_add', 'app_guiafloripa_eventos_add');
  add_submenu_page('app_guiafloripa_eventos', 'Importar Eventos do Facebook', 'Importar', 'read', 'app_guiafloripa_eventos_imp', 'app_guiafloripa_eventos_imp');
  //add_submenu_page('app_guiafloripa_eventos', 'Estabelecimentos cadastrados', 'Estabelecimentos', 'read', 'app_guiafloripa_eventos_place', 'app_guiafloripa_eventos_place');

  add_menu_page(
  'Meus Contatos', // page title
  'Contatos', // menu title
  'read', // capability
  'app_guiafloripa_leads', // menu slug
  'app_guiafloripa_leads', null, 2
  );
  add_submenu_page('app_guiafloripa_leads', 'Adicionar Contato', 'Adicionar', 'read', 'app_guiafloripa_leads_add', 'app_guiafloripa_leads_add');
  add_submenu_page('app_guiafloripa_leads', 'Importar Contatos', 'Importar', 'read', 'app_guiafloripa_leads_imp', 'app_guiafloripa_leads_imp');

  /*   add_menu_page(
  'Mensagens', // page title
  'Mensagens', // menu title
  'read', // capability
  'app_guiafloripa_msg', // menu slug
  'asd', null, 6
  );
  add_menu_page(
  'Minhas Notificações', // page title
  'Notificações', // menu title
  'read', // capability
  'app_guiafloripa_push', // menu slug
  'wpse_91693_push', null, 5
  );
  add_submenu_page('app_guiafloripa_push', 'Dispositivos Ativos', 'Dispositivos Ativos', 'read', 'app_guiafloripa_push', 'wpse_91693_push', 2);
  add_submenu_page('app_guiafloripa_push', 'Minhas notificações', 'Minhas notificações', 'read', 'app_guiafloripa_push_list', 'app_guiafloripa_push_list', 3);
  add_submenu_page('app_guiafloripa_push', 'Criar notificação', 'Criar notificação', 'read', 'app_guiafloripa_push_add', 'app_guiafloripa_push_add', 1);
  add_submenu_page('app_guiafloripa_push', 'Estatísticas e Geolocalização', 'Estatísticas', 'read', 'app_guiafloripa_push_map', 'app_guiafloripa_push_map', 3);
  add_menu_page(
  'Lista de Email Marketing', // page title
  'Emails', // menu title
  'read', // capability
  'app_guiafloripa_mail', // menu slug
  'app_guiafloripa_mail', null, 3
  );
  add_submenu_page('app_guiafloripa_mail', 'Criar um Email Marketing', 'Criar', 'read', 'app_guiafloripa_mail_add', 'app_guiafloripa_mail_add');
  add_menu_page(
  'Minhas Mídias', // page title
  'Midias', // menu title
  'read', // capability
  'app_guiafloripa_midia', // menu slug
  'app_guiafloripa_midia', null, 1
  );
  /*    add_menu_page(
  'Chatbot', // page title
  'Chatbot', // menu title
  'read', // capability
  'app_guiafloripa_chatbot', // menu slug
  'asd', null, 6
  );
  add_menu_page(
  'Plano', // page title
  'Plano', // menu title
  'read', // capability
  'app_guiafloripa_money', // menu slug
  'app_guiafloripa_money', null, 7
  );
  add_menu_page(
  'Minhas Hashtags', // page title
  'Twitter', // menu title
  'read', // capability
  'app_guiafloripa_twitter', // menu slug
  'wpse_91693_twitter', null, 4
  );
  add_submenu_page('app_guiafloripa_twitter', 'Adicionar Hashtag de Busca', 'Adicionar', 'read', 'app_guiafloripa_twitter_add_term', 'app_guiafloripa_twitter_add_term');
  add_submenu_page('app_guiafloripa_twitter', 'Minhas Hashtags', ' Hashtags', 'read', 'app_guiafloripa_twitter', 'wpse_91693_twitter');
  add_submenu_page('app_guiafloripa_twitter', 'Meus Seguidores', 'Seguidores', 'read', 'app_guiafloripa_twitter_followers', 'app_guiafloripa_twitter_followers');
  /*  add_menu_page(
  'Facebook posts', // page title
  'Facebook', // menu title
  'read', // capability
  'app_guiafloripa_facebook', // menu slug
  'app_guiafloripa_facebook', null, 4
  );
  add_submenu_page('app_guiafloripa_facebook', 'Criar post', 'Criar', 'read', 'app_guiafloripa_facebook_add', 'app_guiafloripa_facebook_add');

  add_menu_page(
  'Minhas Campanhas', // page title
  'Campanhas', // menu title
  'read', // capability
  'app_guiafloripa_campaigns', // menu slug
  'wpse_91693_campaign', null, 6
  );
  add_submenu_page('app_guiafloripa_campaigns', 'Minhas campanhas', 'Campanhas', 'read', 'app_guiafloripa_campaigns', 'wpse_91693_campaign');
  //add_submenu_page('app_guiafloripa_campaigns', 'Relatório das suas campanhas', 'Relatório', 'read', 'app_guiafloripa_campaigns_report', 'app_guiafloripa_push_map');
  add_submenu_page('app_guiafloripa_campaigns', 'Criar uma Campanha', 'Criar', 'read', 'app_guiafloripa_campaigns_add', 'app_guiafloripa_campaigns_add');

  // add_submenu_page('app_guiafloripa_twitter', 'Nuvem de Hashtags', 'Nuvem de Hashtags', 'read', 'app_guiafloripa_twitter_cloud_tag', 'app_guiafloripa_twitter_cloud_tag');
  //add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Sincronizar', 'manage_options', 'app_guiafloripa_manager_stats', 'wpse_91693_render');
  add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Estatisticas', 'manage_options', 'app_guiafloripa_manager_stats', 'wpse_91693_stats');
  add_submenu_page('app_guiafloripa_manager_backend', 'Guia APP Admin', 'Bug Report', 'manage_options', 'app_guiafloripa_manager_bug', 'wpse_91693_bug');
 */

/**
 * Description of DashboardController
 *
 * @author Morettic LTDA
 */
class ViewController {

    /**
     * @Dashboard Help 
     */
    public static function dashboardPlano() {
        ?>
        <center>
            <div style="width: 95%;" class="page-title-action">
                <?php
                $plano = get_user_meta(get_current_user_id(), "_plano_type", true);
                if ($plano === "1") {
                    echo "<br><span>Seu plano</span><br>MEGA<br><br>";
                } else if ($plano === "2") {
                    echo "<br><span>Seu plano</span><br>GIGA<br><br>";
                } else {
                    echo "<br><span>Seu plano</span><br>BYTE<br><br>";
                }
                ?>
            </div>
            <!-- Vencimento do plano em 17/04/2018      
             <input type="button" name="btMeuSaldo" value="Adicionar saldo" class="page-title-action"/> -->
        </center>
        <?php
    }

    /**
     * @Dashboard Help Tips
     */
    public static function dashboardTips() {
        global $wpdb; //This is used only if making any database queries

        $helpMe = $wpdb->get_results("SELECT * FROM wp_posts where post_type = 'ajuda_faq' and post_status = 'publish';");
        //var_dump($helpMe);
        echo "<ul>";
        foreach ($helpMe as $help1) {
            echo "<li><a href='#'>" . $help1->post_title . "</a></li>";
        }
        echo "</ul>";
    }

    /**
     * @Dashboard Events
     */
    public static function dashboardEvents() {
        include_once PLUGIN_ROOT_DIR . 'views/EventControl.php';
        $ec = new EventControl();
        $myEvents = $ec->eventsFullList();
        $vet = array("draft" => 0, "trash" => 0, "publish" => 0);
        if (count($myEvents) > 0) {
            foreach ($myEvents as $ev) {
                if ($ev->post_status === "publish") {
                    $vet["publish"] ++;
                } else if ($ev->post_status === "trash") {
                    $vet["trash"] ++;
                } else {
                    $vet["draft"] ++;
                }
            }
            ?>

            <div id="piechart" style="width: 100%;max-width: 400px; height: 300px;"></div>
            <script type="text/javascript">
                jQuery(function ($) {
                    google.charts.load('current', {'packages': ['corechart']});
                    google.charts.setOnLoadCallback(drawChart1);
                });
                function drawChart1() {
                    var data = google.visualization.arrayToDataTable([
                        ['Status dos eventos', 'Nº de Ocorrências'],
                        ['Publicados', <?php echo $vet["publish"]; ?>],
                        ['Rascunho', <?php echo $vet["draft"]; ?>],
                        ['Lixeira', <?php echo $vet["trash"]; ?>]
                    ]);
                    var options = {
                        title: 'Visão geral dos meus eventos'
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                    chart.draw(data, options);
                }
            </script>
            <?php
        } else {
            echo "<strong><span class=\"dashicons dashicons-dismiss\"></span>Nenhum evento cadastrado</strong>";
        }
    }

    /**
     * @Dashboard Resources
     */
    public static function dashboardResources() {
        include_once PLUGIN_ROOT_DIR . 'views/negocio/NegocioController.php';
        $ec = new NegocioController();
        $stats = $ec->loadStats();
        if ($stats->business[0]->total > 0 OR $stats->events[0]->total > 0 OR $stats->totalMedia > 0 OR $stats->usage > 0) {
            ?>
            <div id="barchart_values" style="width: 100%;max-width: 400px; height: 300px;"></div>
            <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
            <script type="text/javascript">
                jQuery(function ($) {
                    google.charts.load("current", {packages: ["bar"]});
                    google.charts.setOnLoadCallback(drawChart);
                });
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ["Recurso", "total", {role: "style"}],
                        ["Negócios", <?php echo $stats->business[0]->total; ?>, "#448AFF"],
                        ["Eventos", <?php echo $stats->events[0]->total; ?>, "#C2185B"],
                        // ["Email criados", 894, "#d500f9"],
                        // ["Email enviados", 894, "#311b92"],
                        // ["Push criadas", 1049, "#f4ff81"],
                        // ["Push enviadas", 1049, "#ff5722"],
                        //   ["Twitter", 1930, "#263238"],
                        ["Midias", <?php echo $stats->totalMedia; ?>, "#0097A7"],
                        ["Disco(MB)", <?php echo $stats->usage; ?>, "#E040FB"],
                                //   ["Contatos", 2145, "#00e676"]
                    ]);
                    var view = new google.visualization.DataView(data);
                    view.setColumns([0, 1,
                        {calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation"},
                        2]);
                    var options = {
                        title: "Recursos em uso no sistema",
                        bar: {groupWidth: "30%"},
                        legend: {position: "none"},
                    };
                    var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
                    chart.draw(view, options);
                }
            </script>
            <?php
        }else{
            echo "<strong><span class=\"dashicons dashicons-dismiss\"></span>Nenhum recurso em uso no sistema</strong>";
        }
    }

    /**
     * @Init Menus
     */
    public static function initMenus() {
        ViewController::initNavCampanha();
        ViewController::initNavContatos();
        ViewController::initNavEmail();
        ViewController::initNavEvents();
        ViewController::initNavMeuNegocio();
        ViewController::initNavMidias();
        ViewController::initNavPlano();
        ViewController::initNavPush();
        ViewController::initNavSettings();
        ViewController::initNavTwitter();
        ViewController::removeDashBoards();
    }

    public static function removeDashBoards() {
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');
        remove_meta_box('e-dashboard-overview', 'dashboard', 'normal'); //rmove elementor
        remove_meta_box('themeisle', 'dashboard', 'normal');
    }

    /**
     * @Configs
     */
    public static function initNavSettings() {
        add_menu_page(
                'Integração de dados APP', // page title
                'Sincronização', // menu title
                'manage_options', // capability
                'app_guiafloripa_manager_backend', // menu slug
                'wpse_91693_render', null, 6
        );
    }

    /**
     * @Init Eventos mnu
     */
    public static function initNavEvents() {
        add_menu_page(
                'Meus Eventos', // page title
                'Eventos', // menu title
                'read', // capability
                'app_guiafloripa_eventos', // menu slug
                'wpse_91693_events', null, 1
        );
        add_submenu_page('app_guiafloripa_eventos', 'Calendário de Eventos', 'Calendário', 'read', 'app_guiafloripa_eventos_cal', 'app_guiafloripa_eventos_cal');
        add_submenu_page('app_guiafloripa_eventos', 'Adicione seu Evento', 'Adicionar', 'read', 'app_guiafloripa_eventos_add', 'app_guiafloripa_eventos_add');
        add_submenu_page('app_guiafloripa_eventos', 'Importar Eventos do Facebook', 'Importar', 'read', 'app_guiafloripa_eventos_imp', 'app_guiafloripa_eventos_imp');
    }

    /**
     * @Init Menu Email
     */
    public static function initNavEmail() {
        add_menu_page(
                'Lista de Email Marketing', // page title
                'Emails', // menu title
                'read', // capability
                'app_guiafloripa_mail', // menu slug
                'app_guiafloripa_mail', null, 3
        );
        add_submenu_page('app_guiafloripa_mail', 'Criar um Email Marketing', 'Criar', 'read', 'app_guiafloripa_mail_add', 'app_guiafloripa_mail_add');
    }

    /**
     * @Init menu Contatos
     */
    public static function initNavContatos() {
        add_menu_page(
                'Meus Contatos', // page title
                'Contatos', // menu title
                'read', // capability
                'app_guiafloripa_leads', // menu slug
                'app_guiafloripa_leads', null, 2
        );
        add_submenu_page('app_guiafloripa_leads', 'Adicionar Contato', 'Adicionar', 'read', 'app_guiafloripa_leads_add', 'app_guiafloripa_leads_add');
        add_submenu_page('app_guiafloripa_leads', 'Importar Contatos', 'Importar', 'read', 'app_guiafloripa_leads_imp', 'app_guiafloripa_leads_imp');
    }

    public static function initDashboards() {
        /* wp_add_dashboard_widget(
          'wpemail_dashboard_widget', // Widget slug.
          'Campanhas', // Title.
          'email_dashboard_widget_content' // Display function.
          ); */
        wp_add_dashboard_widget(
                'wpquota_dashboard_widget', // Widget slug.
                'Estatísticas de uso', // Title.
                'cota_dashboard_widget_content' // Display function.
        );
        wp_add_dashboard_widget(
                'wpplano_dashboard_widget', // Widget slug.
                'Seu Plano', // Title.
                'plano_dashboard_widget_content' // Display function.
        );
        /*  wp_add_dashboard_widget(
          'wptwitter_dashboard_widget', // Widget slug.
          'Twitter', // Title.
          'twitter_dashboard_widget_content' // Display function.
          ); */
        wp_add_dashboard_widget(
                'wptips_dashboard_widget', // Widget slug.
                'Dicas e tutorias', // Title.
                'tips_dashboard_widget_content' // Display function.
        ); /*
          wp_add_dashboard_widget(
          'wpleads_dashboard_widget', // Widget slug.
          'Contatos', // Title.
          'leads_dashboard_widget_content' // Display function.
          ); */
        wp_add_dashboard_widget(
                'wpeventos_dashboard_widget', // Widget slug.
                'Meus Eventos', // Title.
                'events_dashboard_widget_content' // Display function.
        );
    }

    /**
     * @Init menu Push
     */
    public static function initNavPush() {
        add_menu_page(
                'Minhas Notificações', // page title
                'Notificações', // menu title
                'read', // capability
                'app_guiafloripa_push', // menu slug
                'wpse_91693_push', null, 5
        );
        add_submenu_page('app_guiafloripa_push', 'Dispositivos Ativos', 'Dispositivos Ativos', 'read', 'app_guiafloripa_push', 'wpse_91693_push', 2);
        add_submenu_page('app_guiafloripa_push', 'Minhas notificações', 'Minhas notificações', 'read', 'app_guiafloripa_push_list', 'app_guiafloripa_push_list', 3);
        add_submenu_page('app_guiafloripa_push', 'Criar notificação', 'Criar notificação', 'read', 'app_guiafloripa_push_add', 'app_guiafloripa_push_add', 1);
        add_submenu_page('app_guiafloripa_push', 'Estatísticas e Geolocalização', 'Estatísticas', 'read', 'app_guiafloripa_push_map', 'app_guiafloripa_push_map', 3);
    }

    /**
     * @Init Menu Twitter
     */
    public static function initNavTwitter() {
        add_menu_page(
                'Minhas Hashtags', // page title
                'Twitter', // menu title
                'read', // capability
                'app_guiafloripa_twitter', // menu slug
                'wpse_91693_twitter', null, 4
        );
        add_submenu_page('app_guiafloripa_twitter', 'Adicionar Hashtag de Busca', 'Adicionar', 'read', 'app_guiafloripa_twitter_add_term', 'app_guiafloripa_twitter_add_term');
        add_submenu_page('app_guiafloripa_twitter', 'Minhas Hashtags', ' Hashtags', 'read', 'app_guiafloripa_twitter', 'wpse_91693_twitter');
        add_submenu_page('app_guiafloripa_twitter', 'Meus Seguidores', 'Seguidores', 'read', 'app_guiafloripa_twitter_followers', 'app_guiafloripa_twitter_followers');
    }

    /**
     * @Init Menu Meu NEgócio
     */
    public static function initNavMeuNegocio() {
        add_menu_page(
                'Meus Negócios', // page title
                'Negócios', // menu title
                'read', // capability
                'app_guiafloripa_negocio', // menu slug
                'app_guiafloripa_negocio', null, 1
        );
        add_submenu_page('app_guiafloripa_negocio', 'Edite seu Negócio', 'Adicionar', 'read', 'app_guiafloripa_negocio_add', 'app_guiafloripa_negocio_add');
        add_submenu_page('app_guiafloripa_negocio', 'Atividades do negócio', 'Atividades', 'read', 'app_guiafloripa_activity', 'app_guiafloripa_activity');
    }

    /**
     * @INit Planos menu
     */
    public static function initNavPlano() {
        add_menu_page(
                'Plano', // page title
                'Plano', // menu title
                'read', // capability
                'app_guiafloripa_money', // menu slug
                'app_guiafloripa_money', null, 7
        );
    }

    /**
     * @INit Campanha menu
     */
    public static function initNavCampanha() {
        add_menu_page(
                'Minhas Campanhas', // page title
                'Campanhas', // menu title
                'read', // capability
                'app_guiafloripa_campaigns', // menu slug
                'wpse_91693_campaign', null, 6
        );
        add_submenu_page('app_guiafloripa_campaigns', 'Minhas campanhas', 'Campanhas', 'read', 'app_guiafloripa_campaigns', 'wpse_91693_campaign');
        //add_submenu_page('app_guiafloripa_campaigns', 'Relatório das suas campanhas', 'Relatório', 'read', 'app_guiafloripa_campaigns_report', 'app_guiafloripa_push_map');
        add_submenu_page('app_guiafloripa_campaigns', 'Criar uma Campanha', 'Criar', 'read', 'app_guiafloripa_campaigns_add', 'app_guiafloripa_campaigns_add');
    }

    /**
     * @Init nav Midias
     */
    public static function initNavMidias() {
        add_menu_page(
                'Minhas Mídias', // page title
                'Midias', // menu title
                'read', // capability
                'app_guiafloripa_midia', // menu slug
                'app_guiafloripa_midia', null, 1
        );
    }

}
