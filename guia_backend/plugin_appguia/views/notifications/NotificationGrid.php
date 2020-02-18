<?php

//995044427162-3i20lnkl1r4tp72hpqh7gcgb5tu9g5co.apps.googleusercontent.com
//995044427162-frej7i577t6b40581cifugpssvdkhjkk.apps.googleusercontent.com
//6QdxlcMCFfzcPRKG4ajFAJL8
/**
 * WP List Table Example class
 *
 * @package   WPListTableExample
 * @author    Matt van Andel
 * @copyright 2016 Matthew van Andel
 * @license   GPL-2.0+
 */

/**
 * Example List Table Child Class
 *
 * Create a new list table package that extends the core WP_List_Table class.
 * WP_List_Table contains most of the framework for generating the table, but we
 * need to define and override some methods so that our data can be displayed
 * exactly the way we need it to be.
 *
 * To display this example on a page, you will first need to instantiate the class,
 * then call $yourInstance->prepare_items() to handle any data manipulation, then
 * finally call $yourInstance->display() to render the table to the page.
 *
 * Our topic for this list table is going to be movies.
 *
 * @package WPListTableExample
 * @author  Matt van Andel
 */
/* wp_enqueue_media('media-upload');
  wp_enqueue_media('thickbox');
  wp_register_script('my-upload', get_stylesheet_directory_uri() . '/js/metabox.js', array('jquery', 'media-upload', 'thickbox'));
  wp_enqueue_media('my-upload');
  wp_enqueue_style('thickbox'); */

class TT_Example_List_Table extends WP_List_Table {

    public function insertUpdateEmail($request) {
        var_dump($request);
    }

    /**
     * TT_Example_List_Table constructor.
     *
     * REQUIRED. Set up a constructor that references the parent constructor. We
     * use the parent reference to set some default configs.
     */
    public function __construct() {
        // Set parent defaults.
        parent::__construct(array(
            'singular' => 'campaign', // Singular name of the listed records.
            'plural' => 'campaigns', // Plural name of the listed records.
            'ajax' => false, // Does this table support ajax?
        ));
    }

    /**
     * Get a list of columns. The format is:
     * 'internal-name' => 'Title'
     *
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     *
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a `column_cb()` method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     *
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information.
     */
    public function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', // Render a checkbox instead of text.
            'title' => _x('Titulo', 'Titulo', 'wp-list-table-example'),
            'murl' => _x('Url', 'Titulo', 'wp-list-table-example'),
                // 'director' => _x('Status', 'Column label', 'wp-list-table-example'),
                // 'rating' => _x('Editado', 'Column label', 'wp-list-table-example'),
                // 'category' => _x('Inicio', 'Column label', 'wp-list-table-example'),
                //  'deplace' => _x('Fim', 'Column label', 'wp-list-table-example'),
                //'published' => _x('Situação', 'Column label', 'wp-list-table-example'),
        );

        return $columns;
    }

    /**
     * Get a list of sortable columns. The format is:
     * 'internal-name' => 'orderby'
     * or
     * 'internal-name' => array( 'orderby', true )
     *
     * The second format will make the initial sorting order be descending
     *
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle),
     * you will need to register it here. This should return an array where the
     * key is the column that needs to be sortable, and the value is db column to
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     *
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within `prepare_items()` and sort
     * your data accordingly (usually by modifying your query).
     *
     * @return array An associative array containing all the columns that should be sortable.
     */
    protected function get_sortable_columns() {
        $sortable_columns = array(
            'title' => array('title', false),
                // 'url' => array('url', false),
                //   'rating' => array('rating', false),
                //   'director' => array('director', false),
        );

        return $sortable_columns;
    }

    /**
     * Get default column value.
     *
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title()
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as
     * possible.
     *
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     *
     * For more detailed insight into how columns are handled, take a look at
     * WP_List_Table::single_row_columns()
     *
     * @param object $item        A singular item (one full row's worth of data).
     * @param string $column_name The name/slug of the column to be processed.
     * @return string Text or HTML to be placed inside the column <td>.
     */
    protected function column_default($item, $column_name) {
        switch ($column_name) {
            case 'murl':
            case 'title':
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
        $actions['general'] = '<a href="admin.php?page=app_guiafloripa_push_add&id=' . $item['ID'] . ' ">' . _x('Editar') . '</a>';
        return sprintf('%1$s <span style="color:silver;">(id:%2$s)</span>%3$s', $item['title'], $item['ID'], $this->row_actions($actions));
    }

    protected function get_bulk_actions() {
        $actions = array(
            'delete' => _x('Remover', 'List table bulk action', 'wp-list-table-example'),
                //         'clone' => _x('Duplicar', 'List table bulk action', 'wp-list-table-example'),
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
        if ('delete' === $this->current_action()) {
            $campaign = "";
            foreach ($_GET['campaign'] as $r1) {
                $campaign .= $r1 . ",";
            }
            $campaign .= "-1";
            $query = "delete FROM wp_posts where post_type = 'notification' and post_author = " . get_current_user_id() . " and ID in ($campaign)";
            $cp = $wpdb->get_results($query);
            $query = "delete FROM wp_postmeta where post_id in ($campaign)";
            $cp = $wpdb->get_results($query);
            echo '<div class="notice notice-success is-dismissible">
              <p><strong>Sucesso. As notificações selecionadas foram excluidas.</strong></p>
              </div>';
        }
    }

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


        $query = "SELECT * FROM wp_posts where post_type = 'notification' and post_author = " . get_current_user_id();   // var_dump($wpdb);
        // echo $query;
        $cp = $wpdb->get_results($query);
        //var_dump($twitterMeta);
        //
        //
        $vet = array();
        foreach ($cp as $t) {
            // var_dump($t);
            //$obj = json_decode($t->meta_value);
            //var_dump($obj);



            $lnk = "<a href='https://twitter.com/search?q=" . urlencode($obj->hashtag) . "&src=typd' target='_blank'>" . $obj->hashtag . "</a>";
            $link = get_post_meta($t->ID, "_note_link", true);
            $vet[] = array(
                'ID' => $t->ID,
                'title' => $t->post_title,
                'murl' => '<a href="' . $link . '" target="_blank">' . $link . '</a>',
                    // 'director' => $ret,
                    //  'quote' => $quo,
                    //   'follow' => $fol,
                    //  'ignore' => $ign,
            );
        }

        $data = $vet;

        // var_dump($data);die;

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
