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
                <td class="manage-column ss-list-width"><?php echo $row->Id; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->Name; ?></td>
                <td><a href="<?php echo admin_url('admin.php?page=russ_update_color&id=' . $row->Id); ?>">Update</a></td> 
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
                    <!-- <th>&nbsp;</th> -->
                </tr>
                <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->Id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->Name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->Price; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->MinimumOrder; ?></td>
                    <td class="manage-column ss-list-width"><?php  echo (($row->FrontBackOption == 1) ?  "Yes" :  "No") ?></td>
                    <td class="manage-column ss-list-width"><?php  echo (($row->ExtraLogo == 1) ?  "Yes" :  "No")  ?></td>
                    <td class="manage-column ss-list-width">

                        <?php  

                        $table_name_item_colors = $wpdb->prefix . "russ_item_colors";
                        $table_name_colors = $wpdb->prefix . "russ_colors";
                        $res = $wpdb->get_results($wpdb->prepare("SELECT Color_Id from $table_name_item_colors where Item_Id=%s", $row->Id));
                        foreach( $res as $key => $row1) {
                            $res1 = $wpdb->get_results($wpdb->prepare("SELECT Name from $table_name_colors where Id=%s", $row1->Color_Id));
                            foreach ($res1 as $key => $value) {
                                                     # code...
                                echo $value->Name . ", ";
                            }                         
                        }
                        ?>
                    </td>
                    <!-- <td><a href="<?php echo admin_url('admin.php?page=russ_update_color&id=' . $row->Id); ?>">Update</a></td>  -->
                </tr>
                <?php } ?>
            </table>



        </div>
        <?php
    }

    ?>