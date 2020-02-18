<?php
const CLIENT_ID = '17f5eff2-d613-4483-8119-32d48eb5aeb4';
const CLIENT_SECRET = 'jlhsWBW370|^fnqINGN11!*';
include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';

class Outlook {

    public function getAllContacts() {
        $output = $this->makeRequest();
//var_dump($output);
        $info = json_decode($output);
        $leads = $this->showLeads($info->access_token, 'https://graph.microsoft.com/beta/me/people');

        $mLeads = $leads->value;

        while (isset($leads->nextLink)) {
            $leads = $this->showLeads($info->access_token, $leads->nextLink);
            $mLeads = array_merge($leads->value, $mLeads);
        }

        return $mLeads;
    }

    public function makeRequest() {
        $ch = curl_init();
        $url = "https://login.microsoftonline.com/common/oauth2/v2.0/token";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'redirect_uri' => 'https://app.guiafloripa.com.br/wp-content/plugins/plugin_appguia/views/contatos/outlook.php',
            'client_id' => (CLIENT_ID),
            'client_secret' => (CLIENT_SECRET),
            'top' => 25
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function showLeads($token, $url) {
        $curl_h = curl_init($url);
        curl_setopt($curl_h, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $token",
                )
        );
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl_h);
        $obj = json_decode(str_replace("@odata.", "", $response));
        return $obj;
    }

}

@session_start();
if (isset($_GET['source'])) {
    $myContacts = json_decode($_SESSION['contacts_outlook']);
    $count = 0;
    $ec = new ContatosController();
    $rest = $ec->getTotalLeadsOrDie();
    $myLeadsL = $ec->getMyLeadsEmail();
    //echo "<pre>";
    //                   var_dump($myContacts);die;
    ?>
    <div id="namediv" class="stuffbox">
        <div class="inside">
            <input type="button" onclick="importContacts()" name ="import" value="Importar Selecionados" class="page-title-action"/>
            <table class="form-table editcomment">
                <tbody>
                    <tr>
                        <td class="first" style="width: 5%"><input alt="Selecionar todos" title="Selecionar todos" id="checkAll" type="checkbox"></td>
                       <!-- <td class="first"><b>Avatar</b></td> -->
                        <td class="first"><b>Nome</b></td>
                        <td class="first"><b>Email</b></td>
                      <!--  <td class="first"><b>Importar</b></td> -->
                    </tr>

                    <?php
                    $searchArray = array();
                    foreach ($myContacts as $std) {
                        if (filter_var($std->emailAddresses[0]->address, FILTER_VALIDATE_EMAIL)) {
                            if (in_array($std->emailAddresses[0]->address, $myLeadsL)) {
                                continue; //already exists
                            }
                            $searchArray[] = $std;
                            ?>
                            <tr id="tr_<?php echo $count++ ?>">
                                <td class="first" style="width: 5%"><input title="Importar <?php echo $std->emailAddresses[0]->address; ?>" alt="Importar <?php echo $std->emailAddresses[0]->address; ?>" value="<?php echo $count ?>" type="checkbox"></td>
                               <!-- <td class="first" style="font-size: 15px"><img src="<?php echo $std->avatar; ?>" width="30px"/></td> -->
                                <td class="first" style="font-size: 15px"><?php echo substr($std->displayName, 0, 30); ?></small></td>
                                <td class="first" style="font-size: 15px"><?php echo $std->emailAddresses[0]->address; ?></small></td>
                            </tr>
                            <?php
                        }
                    }
                    $_SESSION['searchArray'] = $searchArray;
                    echo '<div class="notice notice-success" id="msg"> 
                    <p><strong>Foram localizados ' . $count . ' contatos. Selecione os contatos que deseja importar. <br> <code>Seu plano permite importar mais ' . $rest . ' contatos</code></strong></p>
                 </div>';
                    //var_dump($_SESSION['searchArray']);
                    ?>

                </tbody>
            </table>
            <input type="button" onclick="importContacts()" name="import" value="Importar Selecionados" class="page-title-action"/>
        </div>
    </div>
    <script>
        var totalLeads = <?php echo $rest ?>;
        jQuery("#checkAll").click(function () {
            jQuery('input:checkbox').prop('checked', this.checked);
        });
        function importContacts() {
            checkeds = [];
            count = 0;
            canSend = true;
            jQuery('input:checkbox').each(function () {
                if (this.checked) {
                    if (count < totalLeads) {

                        checkeds.push(this.value);
                        count++;
                        myTr = "#tr_" + this.value;
                        jQuery(myTr).addClass("notice-info");
                    } else {
                        canSend = false;
                        jQuery('input:checkbox').prop('checked', false);
                        jQuery('#msg').removeClass("notice-info");
                        jQuery("#msg").addClass("notice-error");
                        jQuery("#msg").html('Você ultrapassou o limite de importação. Selecione no máximo:' + totalLeads);
                        document.location.href = "#top";
                        return canSend;
                    }
                }
            });
            if (!canSend)
                return false;

            var url = "admin-ajax.php?action=importOutlook";
            jQuery(function ($) {
                $.post(url, {ids: JSON.stringify(checkeds)}, function (result) {
                    alert("Contatos importados com sucesso!");
                    window.location.href = "";
                })
            });
            //alert(checkeds);
        }
    </script>
    <?php
} else {
    if (isset($_SESSION['contacts_outlook'])) {
        $myContacts = json_decode($_SESSION['contacts_outlook']);
    } else {
        $outLook = new Outlook();
        $myContacts = $outLook->getAllContacts();
        $_SESSION['contacts_outlook'] = json_encode($myContacts);
    }
    header('Location: https://app.guiafloripa.com.br/wp-admin/admin.php?page=app_guiafloripa_leads_imp&source=outlook');
}