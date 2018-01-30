
<?php

// Abort if this file is accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * LOAD THE CHILD CLASS
 * 
 * Next, we need to create and load a child class that extends WP_List_Table.
 * Most of the work will be done there. Open the file now and take a look.
 */
require dirname(__FILE__) . '/FollowersGrid.php';


/**
 * CALLBACK TO RENDER THE EXAMPLE ADMIN PAGE
 *
 * This function renders the admin page and the example list table. Although it's
 * possible to call `prepare_items()` and `display()` from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function tt_render_list_page() {
    // Create an instance of our package class.
    $test_list_table = new TT_Example_List_Table();

    // Fetch, prepare, sort, and filter our data.
    $test_list_table->prepare_items();

    // Include the view markup.
    include dirname(__FILE__) . '/page_f.php';
    return $test_list_table;
}

$emailController = tt_render_list_page();
?>


