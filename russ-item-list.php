<?php

echo 1;

function russ_item_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/test-plugin/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Colors</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=russ_create_color'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "russ_colors";

        $rows = $wpdb->get_results("SELECT * from $table_name");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Name</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->Id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->Name; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=russ_update_color&id=' . $row->Id); ?>">Update</a></td> 
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}