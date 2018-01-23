<?php
//echo PLUGIN_ROOT_DIR;
$secret = '~/.credentials/google_contacts_' . date('d_m_y_h') . '_' . get_current_user_id() . '.json';
include_once '/var/www/guiafloripa.morettic.com.br/vendor/autoload.php';
define('APPLICATION_NAME', 'GuiaFloripa Load LEads');
define('CREDENTIALS_PATH', $secret);
define('CLIENT_SECRET_PATH', PLUGIN_ROOT_DIR . 'views/contatos/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/people.googleapis.com-php-quickstart.json
define('SCOPES', implode(' ', array(Google_Service_PeopleService::PLUS_LOGIN,
    Google_Service_PeopleService::CONTACTS_READONLY, Google_Service_PeopleService::USERINFO_EMAIL, Google_Service_PeopleService::USER_EMAILS_READ, Google_Service_PeopleService::USER_PHONENUMBERS_READ)
));

/* if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
  } */

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    // $client->setAccessType('offline');
    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
    if (file_exists($credentialsPath)) {
        //echo "exists";
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
        //var_dump($accessToken);
    } else if (!empty($_GET['code'])) {
        session_start();
        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($_SESSION['code']);

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        //printf("Credentials saved to %s\n", $credentialsPath);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        echo '<div class="notice notice-warning"> 
                    <p><strong>Para importar seus contatos utilize o botão abaixo e autorize o acesso no Google</strong></p>
                 </div>';
        //printf("Open the following link in your browser:\n%s\n", $authUrl);
        echo "<a class=\"button button-primary\" href='$authUrl'>Autorizar Aplicativo no Google</a>";
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    echo $homeDirectory;
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_PeopleService($client);

// Print the names for up to 10 connections.
$optParams = array(
    'pageSize' => 2000,
    'personFields' => 'photos,names,emailAddresses,biographies,addresses,nicknames,occupations,organizations,urls,phoneNumbers,imClients',
);
$results = $service->people_connections->listPeopleConnections('people/me', $optParams);
//echo "<pre>";
if (count($results->getConnections()) == 0) {
    echo '<div class="notice notice-error"> 
                    <p><strong>Nenhum contato encontrado em sua conta do Google</strong></p>
                 </div>';
} else {
    $i = 0;
    $mList = array();
    ?>

    <div id="namediv" class="stuffbox">
        <div class="inside">
            <input type="button" name="import" value="Importar Selecionados" class="page-title-action"/>
            <table class="form-table editcomment">
                <tbody>
                    <tr>
                        <td class="first" style="width: 5%"><input alt="Selecionar todos" title="Selecionar todos" id="checkAll" type="checkbox"></td>
                        <td class="first"><b>Avatar</b></td>
                        <td class="first"><b>Nome</b></td>
                        <td class="first"><b>Email</b></td>
                        <td class="first"><b>Importar</b></td>
                    </tr>
                    <?php
                    foreach ($results->getConnections() as $person) {
                        $std = new stdClass();
                        if (empty($person['emailAddresses'][0]['value'])) {
                            continue;
                        }
                        if (count($person->getNames()) == 0) {
                            $std->name = NULL;
                        } else {
                            $names = $person->getNames();
                            $name = $names[0];
                            $std->name = $name->getDisplayName();
                        }

                        $std->email = $person['emailAddresses'][0]['value'];
                        $std->url = array();
                        $std->phoneNumbers = array();
                        $std->addresses = NULL;
                        $std->avatar = $person['photos'][0]['url'];
                        foreach ($person['phoneNumbers'] as $ph) {
                            $std->phoneNumbers[] = array('type' => $ph['type'], "number" => $ph['value']);
                        }

                        foreach ($person['urls'] as $ph) {
                            $std->urls[] = $ph['value'];
                        }

                        if (count($person['addresses']) > 0) {
                            $std->addresses = $person['addresses'][0]['formattedValue'];
                        }
                        $std->address = $person['addresses'][0]['value'];
                        $std->biographies = $person['biographies'][0]['value'];
                        $std->id = $i++;
                        //var_dump($person['imClients']);
                        $mList[] = $std;
                        ?>
                        <tr>
                            <td class="first" style="width: 5%"><input type="checkbox"></td>
                            <td class="first" style="font-size: 15px"><img src="<?php echo $std->avatar; ?>" width="30px"/></td>
                            <td class="first" style="font-size: 15px"><?php echo substr($std->name, 0, 30); ?></small></td>
                            <td class="first" style="font-size: 15px"><?php echo $std->email; ?></small></td>
                            <td><span title="Importar" alt="Importar" class="page-title-action dashicons-before dashicons dashicons-upload"></span></td>
                        </tr>
                        <?php
                    }
                    echo '<div class="notice notice-success"> 
                    <p><strong>Sucesso. Foram localizados ' . count($mList) . ' contatos. Selecione os contatos que deseja importar</strong></p>
                 </div>';
                    ?>

                </tbody>
            </table>
            <input type="button" name="import" value="Importar Selecionados" class="page-title-action"/>
        </div>
    </div>
    <?php
    /* echo "<pre>";
      var_dump($mList);
      echo "</pre>"; */
    ?>

    <?php
}
?>
<style>
    tr:hover td {
        background-color: yellow;
    }
</style>
<script>

    jQuery("#checkAll").click(function () {
        jQuery('input:checkbox').prop('checked', this.checked);
    });
</script>