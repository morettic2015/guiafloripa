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
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?> <a href="admin.php?page=app_guiafloripa_twitter" class="page-title-action">Listar Hashtags</a></h1>
    <?php
    include_once PLUGIN_ROOT_DIR . 'views/TwitterControl.php';
    $tc = new TwitterControl();
    $tc->saveTerm($_POST);
    $tc->verifyConfig();

    $hashTag = $tc->loadByUmetaId($_GET);
   // var_dump($hashTag);
    $json = json_decode($hashTag->meta_value);
   // var_dump($json);
    ?>

    <h2>Adicione uma hashtag</h2>
    <div style="background:#ececec;border:1px solid #ccc;padding:0 10px;margin-top:5px;margin-bottom: 10px;border-radius:5px;"  class="pressthis-bookmarklet" >
        <p>  Adicione uma <code>HashTag</code> vinculada ao seu <code>negócio.</code> <br>Configure as <code>ações</code> desejadas e salve a sua <code>HashTag</code>.<br> Alternativamente você pode adicionar hashtags a serem <code>ignoradas</code>.</p>
    </div>
    <div id="message-term"></div>
    <hr/>
    <form id="terms-crud" onsubmit="return validate()" name="terms" action="admin.php?page=app_guiafloripa_twitter_add_term" method="post">
        <?php
        //Hidden only when it has
        //echo $hashTag->umeta_id;
        if (isset($hashTag->umeta_id)) {
            echo "<input type='hidden' name='umeta_id' value='" . $hashTag->umeta_id . "'>";
        }
        ?>

        <div id="namediv" class="stuffbox"><div id="message-term"></div>
            <div class="inside">
                <fieldset>
                    <table class="form-table editcomment">
                        <tbody>
                            <tr>
                                <td class="first"> Ignorar?</td>
                                <td>
                                    <input onclick="disableChecks(this)" type="checkbox" name="ignore" value="SIM">
                                </td>
                            </tr>
                            <tr>
                                <td class="first"><label for="name">Hashtag:</label></td>
                                <td><input type="text" name="hashtag" id="title" value="" spellcheck="true"  size="30"></td>
                            </tr>
                            <tr>
                                <td class="first">Adicionar aos favoritos</td>
                                <td><input type="checkbox" name="favoritos" value="SIM"></td>
                            </tr>
                            <tr>
                                <td class="first">Retweetar</td>
                                <td> <input type="checkbox" name="retweetar" value="SIM"></td>
                            </tr>
                            <tr>
                                <td class="first"> Seguir autor</td>
                                <td>
                                    <input type="checkbox" name="follow" value="SIM">
                                </td>
                            </tr>
                            <tr>
                                <td class="first">Parar de seguir depois de 72 horas </td>
                                <td>
                                    <input type="checkbox" name="unfollow" value="SIM">
                                </td>
                            </tr>
                            <tr>
                                <td class="first">Tirar dos favoritos depois de 72 horas </td>
                                <td>
                                    <input type="checkbox" name="unfavorite" value="SIM">
                                </td>
                            </tr>
                            <tr>
                                <td class="first"> 
                                    Remover retweet depois de 72 horas
                                </td>
                                <td>
                                    <input type="checkbox" name="unretweet" value="SIM">
                                </td>
                            </tr>
                            <tr>
                                <td class="first">Menção no twitter</td>
                                <td>
                                    <input type="text" name="quote" value="" max="50" maxlength="50" spellcheck="true" size="30">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <br>
                    <input type="submit" name="btSaveTerm" value="Salvar" class="page-title-action"/>
                </fieldset>
            </div>
        </div>
    </form>

</div>
<script>

    function disableChecks(element) {
        if (element.checked) {
            document.terms.follow.checked = false;
            document.terms.unfollow.checked = false;
            document.terms.retweetar.checked = false;
            document.terms.unretweet.checked = false;
            document.terms.unfavorite.checked = false;
            document.terms.favoritos.checked = false;
            document.terms.follow.disabled = true;
            document.terms.unfollow.disabled = true;
            document.terms.retweetar.disabled = true;
            document.terms.unretweet.disabled = true;
            document.terms.unfavorite.disabled = true;
            document.terms.favoritos.disabled = true;
            document.terms.quote.readOnly = true;
            document.terms.quote.value = "";
        } else {
            document.terms.follow.disabled = false;
            document.terms.unfollow.disabled = false;
            document.terms.retweetar.disabled = false;
            document.terms.unretweet.disabled = false;
            document.terms.unfavorite.disabled = false;
            document.terms.favoritos.disabled = false;
            document.terms.quote.readOnly = false;

        }
    }


    function validate() {
        document.getElementById('message-term').innerHTML = "";
        if (document.terms.hashtag.value === "") {
            var erro1 = '<div class="notice notice-error is-dismissible"><p><strong>A hashtag é obrigatória. Ex: #floripa</strong></p></div>';
            document.getElementById('message-term').innerHTML += erro1;
            return false;
        }
        if (!document.terms.follow.checked && document.terms.unfollow.checked) {
            var erro1 = '<div class="notice notice-error is-dismissible"><p><strong>Você so pode parar de seguir um seguidor....</strong></p></div>';
            document.terms.unfollow.checked = false;
            document.getElementById('message-term').innerHTML += erro1;
            return false;
        }
        if (!document.terms.retweetar.checked && document.terms.unretweet.checked) {
            var erro1 = '<div class="notice notice-error is-dismissible"><p><strong>Você remover um tweet que você tweetar...</strong></p></div>';
            document.terms.unretweet.checked = false;
            document.getElementById('message-term').innerHTML += erro1;
            return false;
        }
    }
    
    <?php $tc->disableCheck($json); ?>
    
</script>