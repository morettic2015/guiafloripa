<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?><a href="admin.php?page=app_guiafloripa_mail_add" class="page-title-action">Criar</a></h1>

    <p class="search-box">
        <label class="screen-reader-text" for="search_id-search-input">
            Buscar contatos:</label> 
        <input id="search_id-search-input" type="text" name="s" value="" /> 
        <input id="search-submit" class="button" type="submit" name="" value="Buscar" />
    </p>
    <div class="notice notice-info"> 
        <p>Lista de <code>Contatos</code>.</p>
    </div>
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="movies-filter" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
        <?php $test_list_table->display() ?>
    </form>

</div>
<style>

    .column-avatar { text-align: left; width:80px !important; overflow:hidden }
    .column-tipo { text-align: left; width:100px !important; overflow:hidden }
    .column-whats { text-align: left; width:150px !important; overflow:hidden }
    .column-email { text-align: left; width:180px !important; overflow:hidden }
    .column-enterprise { text-align: left; width:180px !important; overflow:hidden }

    input[type="checkbox"]{
        appearance:none;
        width:20px;
        height:16px;
        border:1px solid #aaa;
        border-radius:2px;
        background:#ebebeb;
        position:relative;
        display:inline-block;
        overflow:hidden;
        vertical-align:middle;
        margin-right: 10px; 
        transition: background 0.3s;
        box-sizing:border-box;
    }
    input[type="checkbox"]:after{
        content:'';
        position:absolute;
        top:-1px;
        left:-1px;
        width:7px;
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
        left:13px;
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
    .alert{
        margin: 0 auto;
        margin-top: 50px;
        max-width: 640px;
        min-width: 250px;
        width: 80% !important;
        left: 0 !important;
        right: 0 !important;
        height: auto !important;
    }
</style>