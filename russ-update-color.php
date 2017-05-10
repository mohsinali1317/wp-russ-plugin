<?php

function russ_update_color() {
    global $wpdb;
    $table_name = $wpdb->prefix . "russ_colors";

    $id = $_GET["id"];

    $name = $_POST["name"];
//update
    if (isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array('Name' => $name), //data
                array('Id' => $id), //where
                array('%s'), //data format
                array('%s') //where format
        );
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE Id = %s", $id));
    } else {//selecting value to update	



        $colors = $wpdb->get_results($wpdb->prepare("SELECT Id,Name from $table_name where Id=%s", $id));


        foreach ($colors as $s) {
            $name = $s->Name;
        }
    }
    ?>
    <div class="wrap">
        <h2>Colors</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Color deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=russ_item_list') ?>">&laquo; Back to colors list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Color updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=russ_item_list') ?>">&laquo; Back to colors list</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Name</th><td><input type="text" name="name" value="<?php echo $name; ?>"/></td></tr>
                </table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('Are you sure you want to delete the color?')">
            </form>
        <?php } ?>

    </div>
    <?php
}