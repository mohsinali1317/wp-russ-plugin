<?php

function russ_item_list() {
    ?>
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
                <td class="manage-column ss-list-width"><?php echo $row->id; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
                <td><a href="<?php echo admin_url('admin.php?page=russ_update_color&id=' . $row->id); ?>">Update</a></td> 
            </tr>
            <?php } ?>
        </table>


        <div class="wrap">
            <h2>Items</h2>
            <div class="tablenav top">
                <div class="alignleft actions">
                    <a href="<?php echo admin_url('admin.php?page=russ_create_item'); ?>">Add New</a>
                </div>
                <br class="clear">
            </div>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . "russ_items";

            $rows = $wpdb->get_results("SELECT * from $table_name");
            ?>
            <table class='wp-list-table widefat fixed striped posts'>
                <tr>
                    <th class="manage-column ss-list-width">ID</th>
                    <th class="manage-column ss-list-width">Name</th>
                    <th class="manage-column ss-list-width">Price</th>
                    <th class="manage-column ss-list-width">Minimum Order</th>
                    <th class="manage-column ss-list-width">Has front back options?</th>
                    <th class="manage-column ss-list-width">Extra logo option</th>
                    <th class="manage-column ss-list-width">Colors</th>
                    <th class="manage-column ss-list-width">Actions</th>

                    <!-- <th>&nbsp;</th> -->
                </tr>
                <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->price; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->minimumOrder; ?></td>
                    <td class="manage-column ss-list-width"><?php  echo (($row->frontBackOption == 1) ?  "Yes" :  "No") ?></td>
                    <td class="manage-column ss-list-width"><?php  echo (($row->extraLogo == 1) ?  "Yes" :  "No")  ?></td>
                    <td class="manage-column ss-list-width">

                        <?php  

                        $table_name_item_colors = $wpdb->prefix . "russ_item_colors";
                        $table_name_colors = $wpdb->prefix . "russ_colors";
                        $res = $wpdb->get_results($wpdb->prepare("SELECT colorId from $table_name_item_colors where itemId=%s", $row->id));
                        foreach( $res as $key => $row1) {
                            $res1 = $wpdb->get_results($wpdb->prepare("SELECT name from $table_name_colors where id=%s", $row1->colorId));
                            foreach ($res1 as $key => $value) {
                                echo $value->name . ", ";
                            }                         
                        }
                        ?>
                    </td>

                     <td><a href="<?php echo admin_url('admin.php?page=russ_item_add_image&id=' . $row->id); ?>">Add Images</a></td>
                </tr>
                <?php } ?>
            </table>



        </div>
        <?php
    }

    ?>