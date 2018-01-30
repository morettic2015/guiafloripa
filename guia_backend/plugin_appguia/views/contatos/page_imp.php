<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="notice notice-info"> 
        <p>Importe seus contatos para promover seu negócio</p>
    </div>
    <hr/>
    <a name="top"/>
    <?php
    include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
    $ec = new ContatosController();
    $ec->getTotalLeadsOrDie();
    if (isset($_GET['source'])) {
        if ($_GET['source'] === "google") {
            include_once PLUGIN_ROOT_DIR . 'views/contatos/gmail_import.php';
        } else if ($_GET['source'] === "csv") {
            include_once PLUGIN_ROOT_DIR . 'views/contatos/Csv.php';
            wp_die('CSV');
        }
    } else {
        ?>
        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <table class="form-table editcomment">
                    <tbody>

                        <tr>
                    <!--        <td><center><h1>Outlook</h1></center></td> -->
                            <td><center><h1>Gmail</h1></center></td>
                         <!--   <td><center><h1>Yahoo Mail</h1></center></td> -->
                    <td><center><h1>Arquivo Texto</h1></center></td>
                    </tr>
                    <tr>
                  <!--      <td><a href="https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=000000004C17D3C1&redirect_uri=https://app.guiafloripa.com.br/wp-content/plugins/plugin_appguia/views/contatos/outlook.php&response_type=code&scope=Contacts.Read"><center><img style="width: 100%;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/outlook.jpg"/></a></center></td>
                        -->     <td><a href="admin.php?page=app_guiafloripa_leads_imp&source=google"><center><img style="width: 100%;max-width: 240px;;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/google1.png"/></a></center></td>
                      <!--       <td><a href="#"><center><img style="width: 100%;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/yahoo.png"/></a></center></td>
                        -->      <td><a href="admin.php?page=app_guiafloripa_leads_imp&source=csv"><center><img style="width: 100%;max-width: 240px;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/csv.png"/></a></center></td>
                    </tr>
                    <tr>
                  <!--      <td style="width: 25%;border: 1px"><center><p>Autorize sua conta do Outlook Microsoft para Importar seus contatos e sincronize seus Leads.</p></center></td>
                        --> <td style="width: 25%;border: 1px"><center><p>Autorize o APP Guia Floripa a acessar os seus contatos e sincronize seus Leads</p></center></td>
                    <!--<td style="width: 25%;border: 1px"<center><p>Autorize o APP Guia Floripa a acessar os seus contatos no Yahoo e sincronize seus Lead</p></center></td>
                    -->  <td style="width: 25%;border: 1px"><center><p>Selecione uma planilha com delimitador de campos e cabeçalho. Assim podemos mapear os campos durante a importação.<p><a href="https://docs.google.com/spreadsheets/d/1UhxNISbwdNmRHmUHg4v2i5LJZVK5UBsJXErpU_HUuY8/edit?usp=sharing" class="page-title-action" target="_BLANK">Planilha de exemplo</a></p></p></center></td>

                    </tr>



                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </form>
<?php } ?>
</div>
<style>
    input[type="checkbox"]{
        appearance:none;
        width:40px;
        height:16px;
        border:1px solid #aaa;
        border-radius:2px;
        background:#ebebeb;
        position:relative;
        display:inline-block;
        overflow:hidden;
        vertical-align:middle;
        transition: background 0.3s;
        box-sizing:border-box;
    }
    input[type="checkbox"]:after{
        content:'';
        position:absolute;
        top:-1px;
        left:-1px;
        width:14px;
        height:14px;
        background:white;
        border:1px solid #aaa;
        border-radius:2px;
        transition: left 0.1s cubic-bezier(0.785, 0.135, 0.15, 0.86);
    }
    input[type="checkbox"]:checked{
        background:#a6c7ff;
        border-color:#8daee5;
    }
    input[type="checkbox"]:checked:after{
        left:23px;
        border-color:#8daee5;
    }

    input[type="checkbox"]:hover:not(:checked):not(:disabled):after,
    input[type="checkbox"]:focus:not(:checked):not(:disabled):after{
        left:0px;
    }

    input[type="checkbox"]:hover:checked:not(:disabled):after,
    input[type="checkbox"]:focus:checked:not(:disabled):after{
        left:22px;
    }

    input[type="checkbox"]:disabled{
        opacity:0.5;
    }

</style>
