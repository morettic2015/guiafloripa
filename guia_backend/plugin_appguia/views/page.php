<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Adicionar</a><a href="admin.php?page=app_guiafloripa_eventos_add" class="page-title-action">Importar</a></h1>

    <div class="notice notice-info"> 
        <p>Lista de <code>Eventos</code> vinculados ao seu perfil.</p>
    </div>

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="movies-filter" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
        <?php $test_list_table->display() ?>
    </form>

</div>
