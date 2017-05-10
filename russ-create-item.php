<?php
function russ_create_item() {

    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $minAmount = $_POST["minAmount"];
    $frontBackOption = $_POST["frontBackOption"];
    $extraLogoOption = $_POST["extraLogoOption"];
    $colors = $_POST["colors"];


    //insert
    if (isset($_POST['insertItem'])) {

        global $wpdb;
        $table_name = $wpdb->prefix . "russ_items";


        $wpdb->insert(
                $table_name, //table
                array('Name' => $name,'Description' => $description,'Price' => $price,'MinimumOrder' => $minAmount,'FrontBackOption' => $frontBackOption,
                    'ExtraLogo' => $extraLogoOption),
                array('%s','%s','%f','%d','%d', '%d')
        );


        $item_id = $wpdb->insert_id;

        $table_name = $wpdb->prefix . "russ_item_colors";

        foreach ($colors as $key => $value) {
            $wpdb->insert(
                $table_name, //table
                array('Item_Id' => $item_id,'Color_id' => $value), //data
                array('%d', '%d')
            );
        }

         $message.="Item inserted";
         $_POST = array();
        // wp_redirect(admin_url('admin.php?page=russ_item_list'));
    }
    ?>

    <div class="wrap">
        <h2>Add New Item</h2>

        <?php if (isset($message)): ?>
            <div class="updated"><p><?php echo $message; ?></p></div>
        <?php endif; ?>

        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Name</th>
                    <td><input type="text" name="name" value="" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Description</th>
                    <td><input type="text" name="description" value="" class="ss-field-width" /></td>
                </tr>
                 <tr>
                    <th class="ss-th-width">Price</th>
                    <td><input type="number" name="price" step="any" value="" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Minimum amount</th>
                    <td><input type="number" name="minAmount" value="" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Can print front/back option</th>
                    <td>
                        <input type="radio" name="frontBackOption"
                        
                        value="1">Yes
                        <input type="radio" name="frontBackOption"
                        
                        value="0">No
                    </td>
                </tr>
                <tr>
                    <th class="ss-th-width">Extra logo option</th>
                    <td>
                        <input type="radio" name="extraLogoOption"
                        
                        value="1">Yes
                        <input type="radio" name="extraLogoOption"
                        
                        value="0">No
                    </td>
                </tr>

                <?php
                global $wpdb;
                $table_name = $wpdb->prefix . "russ_colors";

                $rows = $wpdb->get_results("SELECT * from $table_name");
                ?>
                <tr>
                <th class="ss-th-width">Select colors</th>
                <td>    
                <select name="colors[]" multiple="multiple">
                    <option>Select colors for this item</option>
                    <?php foreach ($rows as $row) { ?>

                    <option value="<?php echo $row->Id; ?>"><?php echo $row->Name; ?></option>

                    <?php } ?>
                </select>

                </td>
                </tr>

            </table>
            <input type='submit' name="insertItem" value='Save' class='button'>
        </form>

    </div>



    <?php
}