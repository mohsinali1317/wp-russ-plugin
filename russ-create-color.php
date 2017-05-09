<?php
function russ_create_color() {
    $name = $_POST["name"];
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "russ_colors";

        $wpdb->insert(
                $table_name, //table
                array('Name' => $name), //data
                array('%s') //data format			
        );
        $message.="Color inserted";
        wp_redirect(admin_url('admin.php?page=russ_item_list'));
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/test-plugin/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Color</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Color</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="ss-field-width" /></td>
                </tr>
            </table>
            <input type='submit' name="insert" value='Save' class='button'>
        </form>
    </div>
    <?php
}