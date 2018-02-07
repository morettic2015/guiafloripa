<?php

use Abraham\TwitterOAuth\TwitterOAuth;

class TT_Example_List_Table extends WP_List_Table {

    /**
     * TT_Example_List_Table constructor.
     *
     * REQUIRED. Set up a constructor that references the parent constructor. We
     * use the parent reference to set some default configs.
     */
    public function __construct() {
        // Set parent defaults.
        parent::__construct(array(
            'singular' => 'lead', // Singular name of the listed records.
            'plural' => 'leads', // Plural name of the listed records.
            'ajax' => false, // Does this table support ajax?
        ));
    }

    public function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', // Render a checkbox instead of text.
            'avatar' => _x('Foto', 'Foto', 'wp-list-table-example'),
            'title' => _x('Nome', 'Nome', 'wp-list-table-example'),
            'email' => _x('Apelido', 'Column label', 'wp-list-table-example'),
            'desc' => _x('Informações', 'Column label', 'wp-list-table-example'),
            'murl' => _x('Website', 'Column label', 'wp-list-table-example'),
        );

        return $columns;
    }

    protected function get_sortable_columns() {
        $sortable_columns = array(
            'title' => array('title', false),
                //   'rating' => array('rating', false),
                //   'director' => array('director', false),
        );

        return $sortable_columns;
    }

    protected function column_default($item, $column_name) {
        switch ($column_name) {
            case 'avatar':
            case 'tipo':
            case 'email':
            case 'whats':
            case 'enterprise':
            case 'desc':
            case 'murl':
                return $item[$column_name];
            default:
                return print_r($item, true); // Show the whole array for troubleshooting purposes.
        }
    }

    /**
     * Get value for checkbox column.
     *
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     *
     * @param object $item A singular item (one full row's worth of data).
     * @return string Text to be placed inside the column <td>.
     */
    protected function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], // Let's simply repurpose the table's singular label ("movie").
                $item['ID']                // The value of the checkbox should be the record's ID.
        );
    }

    /**
     * Get title column value.
     *
     * Recommended. This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'title'. Every time the class
     * needs to render a column, it first looks for a method named
     * column_{$column_title} - if it exists, that method is run. If it doesn't
     * exist, column_default() is called instead.
     *
     * This example also illustrates how to implement rollover actions. Actions
     * should be an associative array formatted as 'slug'=>'link html' - and you
     * will need to generate the URLs yourself. You could even ensure the links are
     * secured with wp_nonce_url(), as an expected security measure.
     *
     * @param object $item A singular item (one full row's worth of data).
     * @return string Text to be placed inside the column <td>.
     */
    protected function column_title($item) {
        $page = wp_unslash($_REQUEST['page']); // WPCS: Input var ok.
        // Build edit row action.
        //showPop(action,id)
        //trial cannot upload images
        //  $actions['general'] = '<a href="admin.php?page=app_guiafloripa_leads_add&pid=' . $item['ID'] . ' ">' . _x('Editar', 'Editar') . '</a>';
        //  $actions['group'] = '<a href="admin.php?page=app_guiafloripa_leads_add&pid=' . $item['ID'] . '#groups">' . _x('Grupos', 'Grupos') . '</a>';
        //  $actions['notes'] = '<a href="admin.php?page=app_guiafloripa_leads_add&pid=' . $item['ID'] . '#notes">' . _x('Adicionar nota', 'Add Nota') . '</a>';
        /* $actions['dates'] = '<a href="javascript:showPop(\'dates\',' . $item['ID'] . ')">' . _x('Datas') . '</a>';
          $actions['categ'] = '<a href="javascript:showPop(\'categ\',' . $item['ID'] . ')">' . _x('Categorias') . '</a>';
          $actions['location'] = '<a href="javascript:showPop(\'local\',' . $item['ID'] . ')">' . _x('Localização') . '</a>';
          if (get_user_meta(get_current_user_id(), "_plano_type", true)) {
          $actions['pic'] = '<a href="javascript:showPop(\'image\',' . $item['ID'] . ')">' . _x('Imagem') . '</a>';
          }
          $actions['comp'] = '<a href="javascript:showPop(\'comp\',' . $item['ID'] . ')">' . _x('Complemento') . '</a>';
         */
        // Return the title contents.
        return sprintf('%1$s <span style="color:silver;">(id:%2$s)</span>%3$s', $item['title'], $item['ID'], $this->row_actions($actions));
    }

    /**
     * Get an associative array ( option_name => option_title ) with the list
     * of bulk actions available on this table.
     *
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     *
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     *
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     *
     * @return array An associative array containing all the bulk actions.
     */
    protected function get_bulk_actions() {
        $actions = array(
            //   'notes' => _x('Adicionar nota', 'List table bulk action', 'wp-list-table-example'),
            'group' => _x('Vincular grupo', 'List table bulk action', 'wp-list-table-example'),
                // 'delete' => _x('Remover', 'List table bulk action', 'wp-list-table-example'),
                //  'clone' => _x('Duplicar', 'List table bulk action', 'wp-list-table-example'),
        );


        return $actions;
    }

    /**
     * Handle bulk actions.
     *
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     *
     * @see $this->prepare_items()
     */
    protected function process_bulk_action() {
        global $wpdb; //This is used only if making any database queries
        // Detect when a bulk action is being triggered.
        //echo $this->current_action();
        if ('group' === $this->current_action()) {
            include_once PLUGIN_ROOT_DIR . 'views/contatos/ContatosController.php';
            $ec = new ContatosController();
            $leadsSelected = [];
            //foreach ($_GET['lead'])
            // var_dump($_POST['lead']);
            foreach ($_POST['lead'] as $l1) {
                $leadsSelected[] = $l1;
            }
            ?>
            <div id="dialog-confirm" title="Grupos do(s) contato(s)">
                <p>
                    <input type="text" style="width: 80%" name="groupName" id="groupName" placeholder="Novo Grupo"/>
                    <input type="button" id="plus" name="plus" value="+" class="button button-primary" style="width: 50px">
                    <input type="hidden" name="vlGroups" id="vlGroups"/>
                    <select name="myGroups" id="myGroups" style="width: 100%;height: 120px;margin-top: 10px" size="7">
                        <?php
                        $_myGroups = $ec->getUserGroups();
                        foreach ($_myGroups as $opt) {
                            ?>
                            <option value="<?php echo $opt; ?>">
                                <?php echo strtoupper($opt); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <br>
                    <input onclick="addToUser()" type="button" id="addGroup"  name="addGroup" value="Adicionar" class="button button-primary" style="width: 90px">
                    <input type="hidden" id="myGroupsVal" name="myGroupsVal"/>
                <hr>
                <div id="userGroups" style="max-width: 100%">

                </div>

            </p>
            </div>
            <script>
                var mdialog;
                jQuery(function ($) {
                    mdialog = $("#dialog-confirm").dialog({
                        resizable: false,
                        height: "auto",
                        width: 400,
                        modal: true,
                        buttons: {
                            "Salvar": function () {
                                var groups = document.getElementById('myGroups');
                                var groupsList = new Array();
                                for (i = 0; i < groups.length; i++) {
                                    if (groups[i].disabled) {
                                        groupsList.push(groups[i].text)
                                    }
                                }

                                var x = document.forms[0].action;
                                var option = document.createElement("option");
                                option.text = "Agrupar....";
                                option.value = "make";
                                x.add(option);

                                $("#movies-filter").append('<input type="text" name="myGroups1" value=\'' + JSON.stringify(groupsList) + '\'/>');

                                document.forms[0].action.value = "make";
                                document.forms[0].submit();
                            },
                            Cancelar: function () {
                                $(this).dialog("close");
                            }
                        }
                    });
                    $('input[type=checkbox]').each(function () {
                        //alert(leadsList.indexOf(this.value));
                        if (leadsList.indexOf(this.value) >= 0) {
                            this.checked = true;
                        }
                    });
                });
                var leadsList = <?php echo json_encode($leadsSelected); ?>;


                document.getElementById('plus').onclick = function () {
                    jQuery.ajax({
                        url: "admin-ajax.php?action=insert_groups_profile",
                        type: 'post',
                        data: {
                            groupName: document.getElementById('groupName').value
                        },
                        success: function (response) {
                            var optionOne = response.split(",");
                            if (optionOne[1] === undefined)
                                return;
                            var x = document.getElementById("myGroups");
                            var option = document.createElement("option");
                            option.text = optionOne[1];
                            option.value = optionOne[1];
                            x.add(option);
                        },
                        error: function (e) {
                            alert(e);
                        }

                    });
                }
                function addToUser() {
                    var sel = document.getElementById("myGroups");
                    var dest = document.getElementById("userGroups");
                    var opt1 = document.createElement("button");
                    opt1.setAttribute("id", sel.value);
                    opt1.setAttribute("value", sel.value);
                    opt1.setAttribute("class", "button button-primary");
                    opt1.setAttribute("style", "margin:5px;font-size:8px");
                    opt1.setAttribute("name", sel.value);
                    opt1.onclick = function () {
                        // alert(this.innerHTML);
                        removeGroupByClick(this);
                    }
                    opt1.appendChild(document.createTextNode(sel.value));
                    dest.appendChild(opt1);
                    for (var i = 0, iLen = sel.length; i < iLen; i++) {
                        if (sel[i].value === sel.value) {
                            sel[i].disabled = true;
                            break;
                        }
                    }
                }
                function removeGroupByClick(element) {
                    if (confirm("Deseja remover o usuário do grupo:" + element.value + "?")) {
                        element.remove();
                        sel = document.getElementById("myGroups");
                        for (i = 0; i < sel.length; i++) {
                            if (sel[i].text === element.value) {
                                sel[i].disabled = false;
                                break;
                            }
                        }
                    }
                }
            </script>
            <?php
        } else if ('make' === $this->current_action()) {
            //echo "<pre>";
            //var_dump($_POST['lead']);
            $groups = $_POST['myGroups1'];
            $groups = str_replace('\\', "", $groups);
            //echo $groups;

            $jsonGroups = json_decode($groups);
            foreach ($jsonGroups as $tkGroup) {
                $token = "_tweet_" . $tkGroup;
                foreach ($_POST['lead'] as $idLead) {
                    $query = "delete FROM wp_usermeta where meta_key = '$token' and meta_value = '$idLead' and user_id = " . get_current_user_id();
                    //echo $query;
                    $twitterMeta = $wpdb->get_results($query);
                    //var_dump($twitterMeta);
                    $l = add_user_meta(get_current_user_id(), $token, $idLead, false);
                }
            }

            echo '<div class="notice notice-success"> 
                    <p><strong>Contatos do twitter vinculados aos grupos selecionados.</strong></p>
                 </div>';
        }
    }

    /**
     * Prepares the list of items for displaying.
     *
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here.
     *
     * @global wpdb $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     */
    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /*
         * First, lets decide how many records per page to show
         */
        $per_page = 15;

        /*
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        /*
         * REQUIRED. Finally, we build an array to be used by the class for column
         * headers. The $this->_column_headers property takes an array which contains
         * three other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);

        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();

        /*
         * GET THE DATA!
         * 
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example
         * package slightly different than one you might build on your own. In
         * this example, we'll be using array manipulation to sort and paginate
         * our dummy data.
         * 
         * In a real-world situation, this is probably where you would want to 
         * make your actual database query. Likewise, you will probably want to
         * use any posted sort or pagination data to build a custom query instead, 
         * as you'll then be able to use the returned query data immediately.
         *
         * For information on making queries in WordPress, see this Codex entry:
         * http://codex.wordpress.org/Class_Reference/wpdb
         */

        $wp_upload_dir = wp_upload_dir();

        $filename = $wp_upload_dir['path'] . '/t2_' . get_current_user_id . '_' . date('d_m_y') . '.cache';

        //echo $filename;
        $myFollowers = null;
        if (file_exists($filename)) {
            //echo "cache";
            $handle = fopen($filename, "r");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
            $myFollowers = unserialize($contents);
            echo '<div class="notice notice-warning"> 
                    <p><strong>Contatos do twitter carregados do cache. Proxima sincronização em 24 horas</strong></p>
                 </div>';
        } else {
            //echo "live";
            $ck = get_user_meta(get_current_user_id(), '_ck', true);
            $cs = get_user_meta(get_current_user_id(), '_cs', true);
            $at = get_user_meta(get_current_user_id(), '_at', true);
            $ac = get_user_meta(get_current_user_id(), '_ac', true);

            $twitterConn = new TwitterOAuth($ck, $cs, $at, $ac);
            // var_dump($twitterConn);
            $myFollowers = $twitterConn->get("followers/list", ["count" => 200]);
            $myFollowers1 = $myFollowers;
            $hasMore = true;
            while ($hasMore) {
                if ($myFollowers1->next_cursor > 0) {
                    $myFollowers1 = $twitterConn->get("followers/list", ["count" => 200, "cursor" => $myFollowers1->next_cursor]);
                    $myFollowers->users = array_merge($myFollowers->users, $myFollowers1->users);
                } else {
                    $hasMore = false;
                }
            }

            $open = fopen($filename, "a");
            $write = fputs($open, serialize($myFollowers));
            fclose($open);
            echo '<div class="notice notice-warning"> 
                    <p><strong>Contatos do twitter sincronizados.<br> O cache criado expira em 24 horas.</strong></p>
                 </div>';
        }

        if (isset($myFollowers->errors)) {
            echo '<div class="notice notice-error"> 
                    <p><strong>O seguinte erro ocorreu.<code>' . $myFollowers->errors[0]->message . '</code> Verifique suas credenciais.</strong></p>
                 </div>';
            die;
        }
        //echo "<pre>";
        // var_dump($myFollowers->users);
        //  die;
        //var_dump($_POST);//die;
        $token = "_tweet_" . strtoupper($_POST['f_group']);
        //echo $token;
        $lFilter = get_user_meta(get_current_user_id(), $token, false);
        ;
        //var_dump($lFilter);

        foreach ($myFollowers->users as $follower) {
            //var_dump($follower);
            // die;
            if (isset($_POST['f_group'])&&$_POST['f_group']!==""&&!in_array($follower->id, $lFilter)) {
                continue;
            }

            $vet[] = array(
                'ID' => $follower->id,
                'title' => $follower->name,
                'email' => $follower->screen_name,
                'desc' => $follower->description,
                'murl' => '<a target=_BLANK alt="' . $follower->url . '" href="' . $follower->url . '">' . $follower->url . '</a>',
                'avatar' => '<img alt="Foto de perfil" src="' . $follower->profile_image_url . '" class="avatar avatar-26 photo" height="26" width="26">',
            );
        }

        $data = $vet;


        //  var_dump($data);die;

        /*
         * This checks for sorting input and sorts the data in our array of dummy
         * data accordingly (using a custom usort_reorder() function). It's for 
         * example purposes only.
         *
         * In a real-world situation involving a database, you would probably want
         * to handle sorting by passing the 'orderby' and 'order' values directly
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary. In other words: remove this when
         * you implement your own query.
         */
        usort($data, array($this, 'usort_reorder'));

        /*
         * REQUIRED for pagination. Let's figure out what page the user is currently
         * looking at. We'll need this later, so you should always include it in
         * your own package classes.
         */
        $current_page = $this->get_pagenum();

        /*
         * REQUIRED for pagination. Let's check how many items are in our data array.
         * In real-world use, this would be the total number of items in your database,
         * without filtering. We'll need this later, so you should always include it
         * in your own package classes.
         */
        $total_items = count($data);

        /*
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to do that.
         */
        $data = array_slice($data, ( ( $current_page - 1 ) * $per_page), $per_page);

        /*
         * REQUIRED. Now we can add our *sorted* data to the items property, where
         * it can be used by the rest of the class.
         */
        $this->items = $data;

        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args(array(
            'total_items' => $total_items, // WE have to calculate the total number of items.
            'per_page' => $per_page, // WE have to determine how many items to show on a page.
            'total_pages' => ceil($total_items / $per_page), // WE have to calculate the total number of pages.
        ));
    }

    /**
     * Callback to allow sorting of example data.
     *
     * @param string $a First value.
     * @param string $b Second value.
     *
     * @return int
     */
    protected function usort_reorder($a, $b) {
        // If no sort, default to title.
        $orderby = !empty($_REQUEST['orderby']) ? wp_unslash($_REQUEST['orderby']) : 'title'; // WPCS: Input var ok.
        // If no order, default to asc.
        $order = !empty($_REQUEST['order']) ? wp_unslash($_REQUEST['order']) : 'asc'; // WPCS: Input var ok.
        // Determine sort order.
        $result = strcmp($a[$orderby], $b[$orderby]);

        return ( 'asc' === $order ) ? $result : - $result;
    }

}
