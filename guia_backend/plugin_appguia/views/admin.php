<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $title;
$user = wp_get_current_user();
print "<h1>$title</h1>";
print "<p> Registro de ações em nome de <b>(" . $user->user_login . ")</b></p>";
?>

<!-- Start tabs -->
<div>
    <ul class="wp-tab-bar" >
        <li class="wp-tab-active"><a href="#tabs-5">LOG</a></li>
        <li><a href="#tabs-1">Sincronização em Lote</a></li>
        <li><a href="#tabs-2">Sincronização pelo ID</a></li>
        <li><a href="#tabs-3">Visualizar DUMP</a></li>
        <li><a href="#tabs-4">Relatar Problema</a></li>

    </ul>
    <div class="wp-tab-panel" id="tabs-1" style="display: none;">
        <p>
        <h2>Sincronização em LOTE</h2>
        <p>
            Selecione uma opção de Sincronização em Lote
        </p>
        <table>
            <form name="places" method="post">
                <tr>
                    <td class="post-state">
                        <b>Estabelecimentos</b>
                    </td>

                    <td> 
                        <select name="place" class="pressthis-bookmarklet" style="width: 100% !important">
                            <option value="">Selecione</option>
                            <option value="https://guiafloripa.morettic.com.br/estabelecimentos/1">COMER_BEBER</option>
                            <option value="https://guiafloripa.morettic.com.br/estabelecimentos/5">SERVICOS TURISTICOS</option>
                            <option value="https://guiafloripa.morettic.com.br/estabelecimentos/8">HOSPEDAGEM</option>
                           
                        </select>
                    </td>
                    <td>
                        <input class="button action" type="submit" name="bt" id="bt" value="Sincronizar"/>
                    </td>
                </tr>
            </form>
            <form name="eventos" method="post">
                <tr>
                    <td class="post-state">
                        <b>Eventos</b>
                    </td>

                    <td> 
                        <select  name="event"  class="pressthis-bookmarklet" style="width: 100% !important">
                            <option value="">Selecione</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_cinemas/">CINEMA</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_cultura/">CULTURA</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_eventos/">EVENTOS</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_free/">GRATUITO</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_infantil/">INFANTIL</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_lazer/">LAZER</option>
                             <option value="https://guiafloripa.morettic.com.br/sync_zombie/">REGISTROS ZUMBIS(EVENTOS)</option>
                        </select>
                    </td>
                    <td>
                        <input class="button action" type="submit" name="bt" id="bt" value="Sincronizar"/>
                    </td>
                </tr>
            </form>
            </p>
            <form name="propriedades" method="post">
                <tr>
                    <td class="post-state">
                        <b>Propriedades</b>
                    </td>

                    <td> 
                        <select  name="propriedade"  class="pressthis-bookmarklet" style="width: 100% !important">
                            <option value="">Selecione</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_urls/">URLS</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_images/">IMAGENS</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_recorrencias/">RECORRENCIAS</option>
                        </select>
                    </td>
                    <td>
                        <input class="button action" type="submit" name="bt" id="bt" value="Sincronizar"/>
                    </td>
                </tr>
            </form>
        </table>
        <hr>
    </div>
    <div class="wp-tab-panel" id="tabs-2" style="display: none;">
        <p>
        <h2>Geolocalização pelo ID (PLACE)</h2>
        <p>
            Informe o ID para fazer a sincronização
        </p>
        <table>
            <form name="onePlace" method="post">
                <tr>
                    <td class="post-state">
                        <b>Estabelecimentos</b>
                    </td>

                    <td> 
                        <select name="thePlace" class="pressthis-bookmarklet" style="width: 100% !important">
                            <option value="">Selecione</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_comer_manual/">COMER_BEBER</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_tourism_manual/">TURISMO</option>
                            <option value="https://guiafloripa.morettic.com.br/sync_host_manual/">HOSPEDAGEM</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="idPlace" size="6"/>
                    </td>
                    <td>
                        <input class="button action" type="submit" name="bt" id="bt" value="Sincronizar"/>
                    </td>
                </tr>
            </form>
        </table>
        <hr>
        </p>
    </div>
    <div class="wp-tab-panel" id="tabs-3" style="display: none;height: 600px">
        <p>
        <h2>Visualizar pelo ID (PLACE)</h2>
        <table>
            <form name="viewPlace" method="post">
                <tr>
                    <td class="post-state">
                        <b>Estabelecimentos</b>
                    </td>


                    <td>
                        <input type="number" name="nrPlace" size="6"/>
                    </td>
                    <td>
                        <input class="button action" type="submit" name="bt" id="bt" value="Dump"/>
                    </td>
                </tr>
            </form>
        </table>
        <hr>
        </p>
    </div>
    <div class="wp-tab-panel" id="tabs-4" style="display: none;">
        <p>
        <h2>Relatar Problema</h2>
        <p>
            Descreva em detalhes o problema encontrado.
        </p>
        <table>
            <form name="report" method="post">
                <tr>
                    <td class="post-state">
                        <b>Título da ocorrência</b>
                    </td>


                    <td >
                        <input type="text" name="titBug" size="50"  class="pressthis-bookmarklet" />
                    </td>

                </tr>
                <tr>
                    <td class="post-state">
                        <b>Descrição da ocorrência</b>
                    </td>
                    <td>
                        <textarea name='descBug' rows="2" style="width: 100%"  class="pressthis-bookmarklet" ></textarea>
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <input class="button action" type="submit" name="bt" id="bt" value="Relatar"/>
                    </td>
                </tr>
            </form>
        </table>
        <hr>
        </p>
    </div>
    <div class="wp-tab-panel" id="tabs-5" style="height: 800px !important;">
        <p>
        <h2>Resultados</h2>
        <pre>
            <?php
            include PLUGIN_ROOT_DIR . 'views/admin_functions.php';
            ?>
        </pre>

        <hr>
        </p>
    </div>
</div>
<!-- End tabs -->



<footer>
    Copyright 2017@<br>
    <a href="https://morettic.com.br" target="_BLank">
        <img src="https://morettic.com.br/wp2/wp-content/uploads/2017/06/morettic2.png" width="80"/>
    </a>
</footer>
<style>
    #post-body ul.wp-tab-bar {
        float: left;
        width: 120px;
        text-align: right;
        /* Negative margin for the sake of those without JS: all tabs display */
        margin: 0 -120px 0 5px;
        padding: 0;
        height: 800px ;
    }

    #post-body ul.wp-tab-bar li {
        padding: 8px;
        height: 800px ;

    }

    #post-body ul.wp-tab-bar li.wp-tab-active {
        -webkit-border-top-left-radius: 3px;
        -webkit-border-bottom-left-radius: 3px;
        -webkit-border-top-right-radius: 0px;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
        border-top-right-radius: 0px;
        height: 800px ;
    }

    div.wp-tab-panel-active {
        height: 800px ;
        display:inline;
    }

    div.wp-tab-panel-inactive {
        display:none;
        height: 800px ;
    }

    #post-body div.wp-tab-panel {
        margin: 0 5px 0 125px;
        min-height: 800px ;
        height: 800px ;
    }

    .has-right-sidebar #side-sortables .wp-tab-bar li {
        display: inline;
        line-height: 1.35em;
    }

    .no-js #side-sortables .wp-tab-bar li.hide-if-no-js {
        display: none;
    }

    #side-sortables .wp-tab-bar a {
        text-decoration: none;
    }

    #side-sortables .wp-tab-bar {
        margin: 8px 0 3px;
    }

    #side-sortables .wp-tab-bar {
        margin-bottom: 3px;
    }

    #post-body .wp-tab-bar li.wp-tab-active {
        border-style: solid none solid solid;
        border-width: 1px 0 1px 1px;
        margin-right: -1px;
    }

    #post-body ul.wp-tab-bar {
        float: left;
        width: 120px;
        text-align: right;
        /* Negative margin for the sake of those without JS: all tabs display */
        margin: 0 -120px 0 5px;
        padding: 0;
        height: 800px ;
    }

    #post-body ul.wp-tab-bar li {
        padding: 8px;
        /* display: block; */
        height: 800px ;
    }

    #post-body ul.wp-tab-bar li a {
        text-decoration: underline;
        height: 800px ;
    }

    #post-body ul.wp-tab-bar li.wp-tab-active {
        -webkit-border-top-left-radius: 3px;
        -webkit-border-bottom-left-radius: 3px;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    #post-body div.wp-tab-panel {
        margin: 0 5px 0 125px;
        height: 800px ;
    }

    #post-body ul.wp-tab-bar li.wp-tab-active a {
        font-weight: bold;
        font-size: 14px;
        text-decoration: none;
        height: 800px ;
    }
</style>
<script>
    jQuery(document).ready(function ($) {
        $('.wp-tab-bar a').click(function (event) {
            event.preventDefault();

            // Limit effect to the container element.
            var context = $(this).closest('.wp-tab-bar').parent();
            $('.wp-tab-bar li', context).removeClass('wp-tab-active');
            $(this).closest('li').addClass('wp-tab-active');
            $('.wp-tab-panel', context).hide();
            $($(this).attr('href'), context).show();
        });

        // Make setting wp-tab-active optional.
        $('.wp-tab-bar').each(function () {
            if ($('.wp-tab-active', this).length)
                $('.wp-tab-active', this).click();
            else
                $('a', this).first().click();
        });
    });
</script>