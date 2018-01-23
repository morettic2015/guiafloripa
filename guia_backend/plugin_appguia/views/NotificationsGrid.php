<?php

const FREEGEOIP = "https://freegeoip.net/json/";
const ONESIGNAL = "https://onesignal.com/api/v1/";
const ONE_SIGNAL_REST_API = "_onesignal_rest_api_key";
const ONE_SIGNAL_APP_ID = "_onesignal_app_id";
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
class NotificationsGrid extends WP_List_Table {

    /**
     * TT_Example_List_Table constructor.
     *
     * REQUIRED. Set up a constructor that references the parent constructor. We
     * use the parent reference to set some default configs.
     */
    public function __construct() {
        // Set parent defaults.
        parent::__construct(array(
            'singular' => 'push', // Singular name of the listed records.
            'plural' => 'pushes', // Plural name of the listed records.
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
            'title' => _x('Dispositivo', 'Hashtag de busca', 'wp-list-table-example'),
            'follow' => _x('Primeira sessão', 'Seguir autor', 'wp-list-table-example'),
            'rating' => _x('Última sessão', 'Adicionar aos favoritos', 'wp-list-table-example'),
            'director' => _x('Sessões', 'Retwittar post', 'wp-list-table-example'),
            'quote' => _x('Linguagem', 'Menção no retweet', 'wp-list-table-example'),
            'ip' => _x('IP', 'Ignorar tweet', 'wp-list-table-example'),
            'city' => _x('Cidade', 'Ignorar tweet', 'wp-list-table-example'),
            'uf' => _x('UF', 'Ignorar tweet', 'wp-list-table-example'),
            'pais' => _x('Pais', 'Ignorar tweet', 'wp-list-table-example'),
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
            'rating' => array('rating', false),
            'follow' => array('follow', false),
            'director' => array('director', false),
            'ignore' => array('ignore', false),
            'ip' => array('ignore', false),
            'city' => array('ignore', false),
            'uf' => array('ignore', false),
            'pais' => array('ignore', false),
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
            case 'rating':
            case 'director':
            case 'quote':
            case 'follow':
            case 'ignore':
            case 'ip':
            case 'uf':
            case 'city':
            case 'pais':
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
        $delete_query_args = array(
            'page' => $page,
            'action' => 'segment',
            'push' => $item['ID'],
        );

        $actions['segment'] = sprintf(
                '<a href="%1$s">%2$s</a>', esc_url(wp_nonce_url(add_query_arg($delete_query_args, 'admin.php'), 'send_segment' . $item['ID'])), _x('Agrupar', 'List table row action', 'wp-list-table-example')
        );

        // Return the title contents.
        return sprintf('%1$s <br><span style="color:silver;font-size:10px">(id:%2$s)</span>%3$s', $item['title'], $item['ID'], $this->row_actions($actions)
        );
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
            'segment' => _x('Agrupar', 'List table bulk action', 'wp-list-table-example'),
            'export' => _x('Enviar Mensagem', 'List table bulk action', 'wp-list-table-example'),
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
        global $wpdb;
        // Detect when a bulk action is being triggered.
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
        $per_page = 20;

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



        $OneSignalWPSetting = get_option('OneSignalWPSetting');
//var_dump($OneSignalWPSetting);
        $OneSignalWPSetting_app_id = $OneSignalWPSetting['app_id'];
        $OneSignalWPSetting_rest_api_key = $OneSignalWPSetting['app_rest_api_key'];
        $pluginList = get_option('active_plugins');
        $plugin = 'onesignal-free-web-push-notifications/onesignal.php';
        if (in_array($plugin, $pluginList) && $OneSignalWPSetting_app_id && $OneSignalWPSetting_rest_api_key) {
            //$onesignal_extra_info = get_option('oss_settings_page');
            $args = array(
                'headers' => array(
                    'Authorization' => 'Basic ' . $OneSignalWPSetting_rest_api_key,
                    'Cache-Control' => 'max-age=31536000'
                )
            );
            $url = ONESIGNAL . "players?app_id=" . $OneSignalWPSetting_app_id . "&limit=500&offset=0";
            $response = wp_remote_get($url, $args);
            $response_to_arrays = json_decode(wp_remote_retrieve_body($response), true);
            //var_dump($response_to_arrays);
            //Verify if has keys
            $user_custom_api_key = get_user_meta(get_current_user_id(), ONE_SIGNAL_REST_API, true);
            
            //var_dump($user_custom_api_key);die;
            $user_custom_app_id = get_user_meta(get_current_user_id(), ONE_SIGNAL_APP_ID, true);
            if (!empty($user_custom_api_key) && !empty($user_custom_api_key)) {
                $args = array(
                    'headers' => array(
                        'Authorization' => 'Basic ' . $user_custom_api_key,
                        'Cache-Control' => 'max-age=31536000'
                    )
                );
               // echo "Não tem a porra da chave..... mane";
                $url = ONESIGNAL . "players?app_id=" . $user_custom_app_id . "&limit=500&offset=0";
                $response1 = wp_remote_get($url, $args);
                $response_to_arrays1 = json_decode(wp_remote_retrieve_body($response1), true);
                //echo "<pre>";
                //var_dump($response_to_arrays1);
                //die;
                $total = array_merge($response_to_arrays['players'], $response_to_arrays1['players']);
                // echo(count($response_to_arrays1));
                // var_dump($response_to_arrays1);die;
                $response_to_arrays = $total;
                
               // var_dump($response_to_arrays);die;
                //echo(count($response_to_arrays));die;
            }else{
                $response_to_arrays = $response_to_arrays['players'];
            }
            //echo $user_custom_api_key;die;
            //ar_dump($user_custom_api_key);die;
            $response_counter = 0;
            $vet = [];
            foreach (array_reverse($response_to_arrays) as $response_array) {

                //  echo "<pre>";
                //   var_dump($response_array);die;
                $ip = $response_array['ip'];
                $user_sessions = $response_array['session_count'];
                $user_language = $response_array['language'];
                $user_device = $response_array['device_model'];
                $user_status = $response_array['invalid_identifier'];
                $final_readable_last_active = date('d/m/y h:i:s', $response_array['last_active']);
                $final_readable_first_session = date('d/m/y h:i:s', $response_array['created_at']);
                $did = $response_array['id'];
                $geo = get_option($ip);

                if ($geo === false) {
                    $urlFreeGeoIp = FREEGEOIP . $ip;
                    $args = array('headers' => array(
                            'If-Modified-Since: Sat, 29 Oct 1994 19:43:31 GMT',
                            'Cache-Control: max-age=31536000',
                        ),
                    );
                    $r1 = wp_remote_get($urlFreeGeoIp, $args);
                    $jsGeo = json_decode(wp_remote_retrieve_body($r1), true);
                    //Save IP to Wp_options //lesss io resource...faster from database
                    add_option($ip, json_encode($jsGeo), '', false);
                    //var_dump($jsGeo);
                } else {
                    $jsGeo = get_object_vars(json_decode($geo));
                }

                $obj = json_decode($t->meta_value);
                //var_dump($obj);


                $vet[] = array(
                    'ID' => $did,
                    'title' => $user_device,
                    'rating' => $final_readable_last_active,
                    'director' => $user_sessions,
                    'quote' => $user_language,
                    'follow' => $final_readable_first_session,
                    'ignore' => $ign,
                    'ip' => $ip,
                    'city' => $jsGeo['city'],
                    'uf' => $jsGeo['region_name'],
                    'pais' => $jsGeo['country_code'],
                );
            }
        }


        //  foreach ($twitterMeta as $t) {
        //var_dump($t);
        //   }

        $data = $vet;
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

function isSerialized($str) {
    return ($str == serialize(false) || @unserialize($str) !== false);
}
