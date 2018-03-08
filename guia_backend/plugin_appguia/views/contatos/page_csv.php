<?php
include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
include_once PLUGIN_ROOT_DIR . 'views/contatos/Csv.php';
$ec = new ContatosController();
if (!session_id()) {
    session_start();
}
?>
<div id="namediv" class="stuffbox">
    <div class="inside">
        <fieldset>
            <h2>Mapeamento de Contatos</h2>
            <p>
                Faça o upload do arquivo CSV com seus contatos na área abaixo
            </p>
            <div id="dropzone-wordpress">
                <form action="admin-ajax.php?action=submit_dropzonejs" class="dropzone needsclick dz-clickable page-title-action" id="dropzone-wordpress-form">
                    <?php echo wp_nonce_field('protect_content', 'my_nonce_field'); ?>
                    <div class="dz-message needsclick">
                        Arraste seu arquivo CSV aqui.<br>
                        <span class="note needsclick">Para fazer Upload</span>
                    </div>

                </form>
            </div>
            <?php
            if (isset($_SESSION['uploaded_file'])) {

                $columns = Csv::getColumnNames($_SESSION['uploaded_file']);

                $id = Csv::createAttachment($_SESSION['uploaded_file']);
                $_SESSION['attachPID'] = $id;
                // var_dump($csv_column_names);
                //var_dump($_SESSION['uploaded_filetype']);

                $selectOption = "";
                foreach ($columns as $row) {
                    $selectOption .= "<option value='" . $row . "'>" . $row . "</option>";
                }
                ?>
                <p>
                    Faça o mapeamento dos campos abaixo, selecionando o campo de importação correspondente ao campo do app.
                </p>
                <table class="form-table editcomment" style="max-width: 600px">
                    <thead>
                        <tr>
                            <td>
                                <?php echo "<h2>Seu anexo " . $_SESSION['uploaded_filetype']['ext'] . "</h2>"; ?>
                            </td>
                            <td>
                                <a href="#"><span title="Remover" contextmenu="Remover" class="dashicons dashicons-no"></span></a>
                            </td>
                            <td style="width: 100%; float: left; display: inline-block;font-size: 12px;margin: 2px">

                                <?php echo "<a href='" . $_SESSION['uploaded_url'] . "' target=_BLANK><img width='80' title='" . $_SESSION['uploaded_url'] . "' src='https://app.guiafloripa.com.br/wp-content/uploads/2018/01/csv-100x100.png'/></a>"; ?><?php echo "<p>" . filesize($_SESSION['uploaded_file']) . ' bytes' . "</p>"; ?>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Selecione o grupo para importar os contatos
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td>
                                <select style="width: 100%;border-radius: 25px" class="page-title-action">
                                    <optgroup label="Grupo" selected>Grupo</optgroup>
                                    <?php
                                    $_myGroups = $ec->getUserGroups();
                                    foreach ($_myGroups as $opt) {
                                        ?>
                                        <option value="<?php echo $opt; ?>">
                                            <?php echo strtoupper($opt); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="first"><b>Campos de integração</b></td>
                            <td class="first"></td>
                            <td class="first"><b>Campos do APP</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td><input type="text" disabled="" value="Nome" class="page-title-action"></td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td><input type="text" disabled="" value="Sobrenome" class="page-title-action"></td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td><input type="text" disabled="" value="email" class="page-title-action"></td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td><input type="text" disabled="" value="apelido" class="page-title-action"></td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td>
                                <input type="text" disabled="" value="url" class="page-title-action">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td>
                                <input type="text" disabled="" value="Empresa" class="page-title-action">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td>
                                <input type="text" disabled="" value="Whatsapp" class="page-title-action">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>

                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td>
                                <input type="text" disabled="" value="Telefone" class="page-title-action" >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td>
                                <input type="text" disabled="" value="Cpf-Cnpj" class="page-title-action">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%">
                                    <option>Selecione</option>
                                    <?php
                                    echo $selectOption;
                                    ?>
                                </select>
                            </td>
                            <td><span class="dashicons dashicons-arrow-right-alt"></span></td>
                            <td>
                                <input type="text" disabled="" value="Endereço" class="page-title-action">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
            //unset($_SESSION['uploaded_file']);
            ?>
            <input type="submit" name="btSaveTerm" value="Importar" class="page-title-action"/>
        </fieldset>
    </div>
</div>
<script>

    jQuery(function ($) {
        Dropzone.options.dropzoneWordpressForm = {
            //acceptedFiles: "image/*", // all image mime types
            acceptedFiles: ".csv", // only .jpg files
            maxFiles: 1,
            uploadMultiple: false,
            maxFilesize: 2, // 5 MB
            //addRemoveLinks: true,
            //dictRemoveFile: 'X (remove)',
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    console.log(formData);
                    console.log(file);
                    console.log(xhr)
                    formData.append("name", "value"); // Append all the additional input data of your form here!
                    //window.location.href = "admin.php?page=app_guiafloripa_leads_imp&source=csv";
                    location.reload();
                });
            }
        };
    })
// dropzoneWordpressForm is the configuration for the element that has an id attribute
// with the value dropzone-wordpress-form (or dropzoneWordpressForm)

</script>