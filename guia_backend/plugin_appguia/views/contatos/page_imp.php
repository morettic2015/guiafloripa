<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="notice notice-info"> 
        <p>Importe seus contatos para promover seu negócio</p>
    </div>
    <hr/>
    <a name="top"/>
    <?php
    if (isset($_GET['source'])) {
        if ($_GET['source'] === "google") {
            include_once PLUGIN_ROOT_DIR . 'views/contatos/gmail_import.php';
        }
    } else {
        ?>
        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <table class="form-table editcomment">
                    <tbody>

                        <tr>
                            <td><center><h1>Facebook</h1></center></td>
                    <td><center><h1>Gmail</h1></center></td>
                    <td><center><h1>Twitter</h1></center></td>
                    <td><center><h1>Arquivo Texto</h1></center></td>
                    <td><center><h1>Yahoo Mail</h1></center></td>
                    </tr>
                    <tr>
                        <td><a href="#"><center><img style="width: 60%;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/facebook.png"/></a></center></td>
                        <td><a href="admin.php?page=app_guiafloripa_leads_imp&source=google"><center><img style="width: 60%;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/google1.png"/></a></center></td>
                        <td><a href="#"><center><img style="width: 60%;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/twitter.png"/></a></center></td>
                        <td><a href="#"><center><img style="width: 60%;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/csv.png"/></a></center></td>
                        <td><a href="#"><center><img style="width: 60%;border: 1px;border-style: dotted" src="../wp-content/uploads/2018/01/yahoo.png"/></a></center></td>
                    </tr>
                    <tr>
                        <td><center><p> fasdf asdf asdf as</p></center></td>
                    <td><center><p> fasdf asdf asdf as</p></center></td>
                    <td><center><p> fasdf asdf asdf as</p></center></td>
                    <td><center><p> fasdf asdf asdf as</p></center></td>
                    <td><center><p> fasdf asdf asdf as</p></center></td>
                    </tr>

                    <tr>
                        <td><input type="button" name="btSaveTerm" value="Importar Facebook" class="page-title-action"/></td>
                        <td><input type="button" name="btSaveTerm" value="Importar Gmail" class="page-title-action"/></td>
                        <td><input type="button" name="btSaveTerm" value="Importar Twitter" class="page-title-action"/></td>
                        <td><input type="button" name="btSaveTerm" value="Importar Arquivo Txt" class="page-title-action"/></td>
                        <td><input type="button" name="btSaveTerm" value="Importar Yahoo Mail" class="page-title-action"/></td>
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
