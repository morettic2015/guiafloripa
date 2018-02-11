<?php
@session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_ALL);

/**
 * Description of EmailController
 *
 * @author Morettic LTDA
 */
const USER_GROUP_ID = "_usr_grp_id_";
const MY_LEADS_LIST = '_myLeads';
const MY_GROUPS_LIST = '_myGroups';
const MAX_BYTE = 50;
const MAX_MEGA = 500;
const MAX_GIGA = 1000;
const MAX_TERA = 1500;

class ContatosController {

    public function getMyLeadsEmail() {
        global $wpdb;
        $queryMyLeads = "select user_email from wp_users where ID in "
                . "(select distinct meta_value FROM wp_usermeta where user_id = " . get_current_user_id() . " and meta_key = '_myLeads');";

        $cp1 = $wpdb->get_results($queryMyLeads);

        $cp = array();
        foreach ($cp1 as $mm) {
            $cp[] = $mm->user_email;
        }

        return $cp;
    }

    public function getTotalLeadsOrDie() {
        global $wpdb;
        $list = get_user_meta(get_current_user_id(), MY_LEADS_LIST);
        $plano = get_user_meta(get_current_user_id(), '_plano_type', true);
        //var_dump($plano);
        //echo "<PRE>";
        $ids = "";
        foreach ($list as $id1) {
            if (is_numeric($id1)) {
                $ids .= $id1 . ",";
            }
        }
        $ids .= "0";
        // echo "</PRE>";

        $query = "SELECT * FROM wp_users where ID in($ids) ";   // var_dump($wpdb);
        //
       
        // echo $query;
        $cp = $wpdb->get_results($query);
        switch (intval($plano)) {
            case 1:
                $max = MAX_MEGA;
                break;
            case 2:
                $max = MAX_GIGA;
                break;
            case 3:
                $max = MAX_TERA;
                break;
            default :
                $max = MAX_BYTE;
                break;
        }
        $total = $max - count($cp);
        //echo $total;
        if ($total === 0 || $total < 0) {
            echo '<div class="notice notice-warning"> 
                    <p><strong>Você atingiu o limite de ' . $max . ' contatos!<p><a href="admin.php?page=app_guiafloripa_money">Faça um upgrade de seu plano para adicionar mais contatos.</a></p></strong></p>
                 </div>';
            die;
        }
        //$wpdb->close();
        return $total;
    }

    public function importOutlook($request) {
        global $wpdb;
        $gContacts = $_SESSION['searchArray'];
        $list = json_decode(str_replace('\\', "", str_replace('"', "", $request['ids'])));
        $totalAtLeas = $this->getTotalLeadsOrDie();
        if (count($list) > $totalAtLeas) {
            echo "{'error':'Limite ultrapassado'}";
            wp_die();
        }
       
        foreach ($list as $id) {
            $totalAtLeas--;
            $leadOutlookImport = $gContacts[$id-1];
            //echo $gContacts[$id - 1]->email;
            $query1 = "SELECT count(*) as total,ID  FROM wp_users WHERE (user_email) = ('" . $leadOutlookImport->emailAddresses[0]->address . "')";
            // echo $query1;die;
            $hasLead = $wpdb->get_results($query1);

            //var_dump($hasLead);die;
            //var_dump($hasLead);
            if ($hasLead[0]->total > 0) {
                add_user_meta(get_current_user_id(), MY_LEADS_LIST, ($hasLead[0]->ID), false);
                echo "Updated" . $hasLead[0]->ID;
            } else {
                //var_dump($leadOutlookImport);
                $stripMail = sanitize_title($leadOutlookImport->emailAddresses[0]->address);
                $rdmUser = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,10);
                $userdata = array(
                    'user_login' => empty($stripMail)?$rdmUser:$stripMail,
                    'user_nicename' => is_null($leadOutlookImport->displayName) ? "" : sanitize_title($leadOutlookImport->displayName),
                    'user_url' => count($leadOutlookImport->websites) > 0 ? $leadOutlookImport->websites[0]->address : "http://",
                    'user_email' => sanitize_email($leadOutlookImport->emailAddresses[0]->address),
                    'first_name' => is_null($leadOutlookImport->givenName) ? "" : $leadOutlookImport->givenName,
                    'nickname' => is_null($leadOutlookImport->displayName) ? "" : sanitize_title($leadOutlookImport->displayName),
                    'last_name' => is_null($leadOutlookImport->surname) ? "" : $leadOutlookImport->surname,
                    'user_pass' => wp_generate_password()  // When creating an user, `user_pass` is expected.
                );
                $user_id = wp_insert_user($userdata);
                var_dump($userdata);
                echo $user_id;
                if (!is_wp_error($user_id)) {
                    //echo $user_id;
                    if (count($leadOutlookImport->phones) > 0) {
                        update_user_meta($user_id, 'comercial', $leadOutlookImport->phones[0]->number);
                    }
                    //var_dump($leadOutlookImport->phoneNumber);
                    if (count($leadOutlookImport->phones) > 1) {
                        update_user_meta($user_id, 'fixo', $leadOutlookImport->phones[1]->number);
                    }
                    //var_dump($leadOutlookImport->phoneNumber);
                    if (count($leadOutlookImport->phones) > 2) {
                        update_user_meta($user_id, '_whatsapp', $leadOutlookImport->phones[1]->number);
                    }
                    $address = count($leadOutlookImport->postalAddresses) > 0 ? $leadOutlookImport->postalAddresses[0]->address->city : "";
                    update_user_meta($user_id, 'actor', $leadOutlookImport->title);
                    update_user_meta($user_id, 'organization', $leadOutlookImport->companyName);
                    //update_user_meta($user_id, 'content_url', $leadOutlookImport->avatar);
                    update_user_meta($user_id, 'description', $leadOutlookImport->personNotes);
                    update_user_meta($user_id, 'address', $address);
                    update_user_meta($user_id, '_outlook', $leadOutlookImport->id);
                    add_user_meta(get_current_user_id(), MY_LEADS_LIST, ($user_id), false);
                }
            }
            if ($totalAtLeas == 0)
                break;
        }
        $wpdb->close();
        echo $totalAtLeas;

        /*  $headers[] = 'From: Experiências Digitais <root@experienciasdigitais.com.br>';


          wp_mail("malacma@hotmail.com", "Lead Imports", $_SESSION['contacts_outlook'], $headers); */
    }

    public function importGmail($request) {
        global $wpdb;
        $gContacts = json_decode($_SESSION['gContacts']);
        $list = json_decode(str_replace('\\', "", str_replace('"', "", $request['ids'])));
        $totalAtLeas = $this->getTotalLeadsOrDie();

        if (count($list) > $totalAtLeas) {
            echo "{'error':'Limite ultrapassado'}";
            wp_die();
        }

        foreach ($list as $id) {
            $totalAtLeas--;
            //echo $gContacts[$id - 1]->email;
            $query1 = "SELECT count(*) as total,ID  FROM wp_users WHERE (user_email) = ('" . $gContacts[$id - 1]->email . "')";
            //echo $query1;
            $hasLead = $wpdb->get_results($query1);
            //var_dump($hasLead);
            if ($hasLead[0]->total > 0) {
                add_user_meta(get_current_user_id(), MY_LEADS_LIST, ($hasLead[0]->ID), false);
            } else {
                //var_dump($gContacts[$id - 1]);
                $leadName = explode(" ", $gContacts[$id - 1]->name);
                $userdata = array(
                    'user_login' => sanitize_title($gContacts[$id - 1]->name),
                    'user_nicename' => sanitize_title($gContacts[$id - 1]->name),
                    'user_url' => count($gContacts[$id - 1]->url) > 0 ? $gContacts[$id - 1]->url[0] : "",
                    'user_email' => sanitize_email($gContacts[$id - 1]->email),
                    'first_name' => count($leadName) > 0 ? $leadName[0] : "",
                    'nickname' => sanitize_title($gContacts[$id - 1]->name),
                    'last_name' => count($leadName) > 1 ? $leadName[1] : "",
                    'user_pass' => wp_generate_password()  // When creating an user, `user_pass` is expected.
                );
                $user_id = wp_insert_user($userdata);
                //echo $user_id;
                if (count($gContacts[$id - 1]->phoneNumbers) > 0) {
                    update_user_meta($user_id, 'comercial', $gContacts[$id - 1]->phoneNumbers[0]->number);
                }
                var_dump($gContacts[$id - 1]->phoneNumber);
                if (count($gContacts[$id - 1]->phoneNumbers) > 1) {
                    update_user_meta($user_id, 'fixo', $gContacts[$id - 1]->phoneNumbers[1]->number);
                }
                update_user_meta($user_id, 'content_url', $gContacts[$id - 1]->avatar);
                update_user_meta($user_id, 'description', $gContacts[$id - 1]->biographies);
                update_user_meta($user_id, 'address', $gContacts[$id - 1]->addresses);
                add_user_meta(get_current_user_id(), MY_LEADS_LIST, ($user_id), false);
            }
            if ($totalAtLeas == 0)
                break;
        }
        $wpdb->close();
        echo $totalAtLeas;
    }

    public function getNickName($nick) {
        global $wpdb;
        $query = "SELECT count(*) as total FROM wp_users WHERE user_login = '" . sanitize_title($nick) . "'";
        //echo $query;
        $group = $wpdb->get_results($query);
        //var_dump($group);
        return $group[0]->total;
        $wpdb->close();
    }

    public function getUpdateGroups($request) {
        global $wpdb;
        $query = "SELECT * FROM wp_usermeta WHERE user_id = " . get_current_user_id() . " and meta_key = '_myGroups' and meta_value = '" . $request['groupName'] . "'";
        $group = $wpdb->get_results($query);
        if (empty($group)) {
            //echo "novo";
            $id = add_user_meta(get_current_user_id(), MY_GROUPS_LIST, ($request['groupName']), false);
            echo $id . "," . $request['groupName'];
        }
        $wpdb->close();
    }

    public function getUserGroups() {
        $_myGroups = get_user_meta(get_current_user_id(), MY_GROUPS_LIST, false);
        return$_myGroups;
    }

    public function getLead($request) {
        if (empty($request['pid'])) {
            return false;
        }
        $myLeads = get_user_meta(get_current_user_id(), MY_LEADS_LIST);
        $hasLead = false;
        foreach ($myLeads as $pid) {
            if ($pid === $request['pid'])
                $hasLead = true;
        }
        if (!$hasLead) {
            echo '<div class="notice notice-error"> 
                    <p><strong><code>Ocorreu um erro. </code>Você não tem permissão para acessar este contato!</strong></p>
                 </div>';
            wp_die();
        }


        $lead = new stdClass();

        $user = get_user_by('ID', $request['pid']);

        $lead->info = $user;
        //var_dump($user);

        $lead->comercial = get_user_meta($user->ID, 'comercial', true);
        $lead->last_name = get_user_meta($user->ID, 'last_name', true);
        $lead->first_name = get_user_meta($user->ID, 'first_name', true);
        $lead->nickname = get_user_meta($user->ID, 'nickname', true);
        $lead->whatsapp = get_user_meta($user->ID, '_whatsapp', true);
        $lead->pj = get_user_meta($user->ID, 'pj', true);
        $lead->pfpj = get_user_meta($user->ID, 'pfpj', true);
        $lead->fixo = get_user_meta($user->ID, 'fixo', true);
        $lead->address = get_user_meta($user->ID, 'address', true);
        $lead->comp = get_user_meta($user->ID, 'comp', true);
        $lead->organization = get_user_meta($user->ID, 'organization', true);
        $lead->actor = get_user_meta($user->ID, 'actor', true);
        $lead->content_url = get_user_meta($user->ID, 'content_url', true);
        $lead->facebook = get_user_meta($user->ID, 'facebook', true);
        $lead->Skype = get_user_meta($user->ID, 'Skype', true);
        $lead->LinkedIn = get_user_meta($user->ID, 'LinkedIn', true);
        $lead->Twitter = get_user_meta($user->ID, 'Twitter', true);
        $lead->Instagram = get_user_meta($user->ID, 'Instagram', true);
        $lead->Google = get_user_meta($user->ID, 'Google', true);
        $lead->description = get_user_meta($user->ID, 'description', true);
        $lead->groupList = $this->getLeadGroups($user->ID);


        //Default logo
        if (empty($lead->content_url)) {
            $token = md5(strtolower(trim($user->user_email)));
            $lead->content_url = 'https://www.gravatar.com/avatar/' . $token;
        }
        $facebook_id = get_user_meta($user->ID, '_fb_user_id', true);
        if (!empty($facebook_id)) {
            $lead->content_url = "https://graph.facebook.com/$facebook_id/picture";
        }
        if (empty($lead->facebook) && !empty($facebook_id)) {
            $lead->facebook = "https://www.facebook.com/app_scoped_user_id/$facebook_id/";
        }

        return $lead;
    }

    public function saveUpdateProfile($request) {

        if (!isset($request['email']))
            return false;
//var_dump($request);die;
        $userdata = array(
            'user_login' => sanitize_title($request['nick']),
            'user_nicename' => sanitize_title($request['nick']),
            'user_url' => $request['website'],
            'user_email' => sanitize_email($request['email']),
            'first_name' => $request['firstName'],
            'nickname' => sanitize_title($request['nick']),
            'last_name' => $request['lastName'],
            'user_pass' => wp_generate_password()  // When creating an user, `user_pass` is expected.
        );
        $user = get_user_by('email', $request['email']);
        if ($user->ID) {
            $userdata['ID'] = $user->ID;
            unset($userdata['user_pass']);
        }
        $user_id = wp_insert_user($userdata);

        //var_dump($userdata);die;
        update_user_meta($user_id, 'comercial', $request['phone2']);
        update_user_meta($user_id, '_whatsapp', $request['whats']);
        update_user_meta($user_id, 'fixo', $request['phone1']);
        update_user_meta($user_id, 'pj', empty($request['pj']) ? 0 : 1);
        update_user_meta($user_id, 'pfpj', $request['pfpj']);
        update_user_meta($user_id, 'facebook', $request['facebook']);
        update_user_meta($user_id, 'Skype', $request['Skype']);
        update_user_meta($user_id, 'LinkedIn', $request['LinkedIn']);
        update_user_meta($user_id, 'Twitter', $request['Twitter']);
        update_user_meta($user_id, 'Instagram', $request['Instagram']);
        update_user_meta($user_id, 'Google', $request['Google']);
        update_user_meta($user_id, 'address', $request['address']);
        update_user_meta($user_id, 'comp', $request['comp']);
        update_user_meta($user_id, 'organization', $request['organization']);
        update_user_meta($user_id, 'actor', $request['actor']);
        update_user_meta($user_id, 'content_url', $request['content_url']);
        update_user_meta($user_id, 'description', $request['txtBio']);

        // var_dump($userdata);die;
//On success
        $myLeads = get_user_meta(get_current_user_id(), MY_LEADS_LIST);
        //var_dump($myLeads);
        if (empty($myLeads)) {
            $myLeads = array();
            $myLeads[] = $user_id;
        } else {
            //$myLeads = json_decode($myLeads);
            //var_dump($myLeads);

            $myLeads[] = $user_id;
        }
        // var_dump($myLeads);

        add_user_meta(get_current_user_id(), MY_LEADS_LIST, ($user_id), false);

        $this->updateGroupsForLead($request['vlGroups'], $user_id);
        if (!is_wp_error($user_id)) {
            if ($user->ID) {//Edition mode
                echo '<div class="notice notice-success is-dismissible"> 
                    <p><strong><code>Contato</code> salvo com sucesso.</strong></p>
                 </div>';
            } else { //news
                echo '<div class="notice notice-success is-dismissible"> 
                    <p><strong><code>Contato</code> salvo com sucesso. Visualize seus <a href="admin.php?page=app_guiafloripa_leads"> contatos</a> cadastrados</strong></p>
                 </div>';
                wp_die();
            }
        } else {
            echo '<div class="notice notice-error"> 
                    <p><strong><code>Ocorreu um erro. Verifique os campos e tente outra vez!</strong></p>
                 </div>';
            wp_die();
        }
    }

    public function updateGroupsBatch($request) {
        foreach ($request['leadsList'] as $leadID) {
            $this->updateGroupsForLead($request['groupName'], $leadID, false);
        }
    }

    public function updateGroupsForLead($groups, $idLead, $remove = true) {
        //echo  urldecode($groups);
        global $wpdb;
        $strQueryGroups = "";
        $groups = json_decode(urldecode($groups));
        //var_dump($groups);
        foreach ($groups as $g1) {
            $strQueryGroups .= "'" . $g1 . "',";
        }
        $strQueryGroups .= "''";
        //echo $strQueryGroups;
        $query = "SELECT umeta_id as group_id FROM wp_usermeta where user_id = " . get_current_user_id() . " and meta_key = '_myGroups' and meta_value in ($strQueryGroups)";

        //echo $query;
        $groupsIDS = $wpdb->get_results($query);
        //Remove old and insert new one
        $metaKey = USER_GROUP_ID . get_current_user_id();
        if ($remove) {
            $deleteOlds = "delete FROM wp_usermeta where user_id = $idLead and meta_key = '$metaKey'";
            $remove = $wpdb->get_results($deleteOlds);
        }
        //var_dump($remove);
        //$idsGroups = "";
        foreach ($groupsIDS as $id) {
            add_user_meta($idLead, $metaKey, $id->group_id, false);
        }

        //var_dump($groupsIDS);
    }

    public function getDashBoard() {
        global $wpdb;
        $list = get_user_meta(get_current_user_id(), MY_LEADS_LIST);
        $plano = get_user_meta(get_current_user_id(), '_plano_type', true);
        //var_dump($plano);
        //echo "<PRE>";
        $ids = "";
        foreach ($list as $id1) {
            if (is_numeric($id1)) {
                $ids .= $id1 . ",";
            }
        }
        $ids .= "0";
        // echo "</PRE>";

        $query = "SELECT * FROM wp_users where ID in($ids) ";   // var_dump($wpdb);
        //
       
        // echo $query;
        $cp = $wpdb->get_results($query);
        switch (intval($plano)) {
            case 1:
                $max = MAX_MEGA;
                break;
            case 2:
                $max = MAX_GIGA;
                break;
            case 3:
                $max = MAX_TERA;
                break;
            default :
                $max = MAX_BYTE;
                break;
        }
        $total = $max - count($cp);
        ?>

        <!--  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />
          <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
          <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
          <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
          <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script> -->

        <h3>Você tem <?php echo count($cp); ?> contatos de <?php echo $max; ?> possíveis para o seu plano</h3>
        <!-- <div id="graph1" style="height: 180px;width: 100%"></div>
         <script>
          /*   Morris.Donut({
                 element: 'graph1',
                 data: [
                     {value: <?php echo $max; ?>, label: 'Total do Plano'},
                     {value: <?php echo count($cp); ?>, label: 'Cadastrados'},
                 ],
                 backgroundColor: '#ccc',
                 labelColor: '#f79129',
                 colors: [
                     '#2499c8',
                     '#f79129',
                     '#a4ce3f',
                     '#c0358a',
                 ],
                 formatter: function (x) {
                     return x;
                 }
             });*/

             //document.getElementById('ctPushs').innerHTML = '<b>Notificações analisadas:<?php echo $response_counter; ?></b>';
         </script> -->

        <?php
    }

    public function getLeadGroups($contactIDD) {
        global $wpdb;
        $metaKey = USER_GROUP_ID . get_current_user_id();
        $query = "select upper(meta_value) as groupName from wp_usermeta where umeta_id in ( select meta_value  from wp_usermeta where user_id = $contactIDD and meta_key = '$metaKey')";
        $groups = $wpdb->get_results($query);
        return $groups;
    }

}
