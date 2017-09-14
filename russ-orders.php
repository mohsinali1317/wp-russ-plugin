<?php
/**
 * Created by PhpStorm.
 * User: mohsin
 * Date: 26/05/2017
 * Time: 11:27
 */

function russ_orders(){

    ?>

    <div class="wrap">
    <h2>Orders</h2>

    <?php

    global $wpdb;
    $table_orders = $wpdb->prefix . "russ_orders";
    $table_order_receiver_info = $wpdb->prefix . "russ_order_receiver_info";
    $table_items = $wpdb->prefix . "russ_items";

    $orders = $wpdb->get_results("SELECT * from $table_orders");

    ?>

    <table class='wp-list-table widefat fixed striped posts'>
        <tr>
            <th class="manage-column ss-list-width">ID</th>
            <th class="manage-column ss-list-width">Item Name</th>
            <th class="manage-column ss-list-width">Price</th>
            <th class="manage-column ss-list-width">Extra Logo</th>
            <th class="manage-column ss-list-width">Front/Back</th>

            <th class="manage-column ss-list-width">Receiver Name</th>
            <th class="manage-column ss-list-width">Receiver Email</th>
            <th class="manage-column ss-list-width">Receiver Address</th>
            <th class="manage-column ss-list-width">Receiver Telephone</th>
            <th class="manage-column ss-list-width">Receiver Post number</th>
            <th class="manage-column ss-list-width">Receiver City</th>
            <th class="manage-column ss-list-width">Russ Group Name</th>

            <th class="manage-column ss-list-width">Actions</th>

        </tr>
        <?php foreach ($orders as $order)
        {
            $receiver = $wpdb->get_row($wpdb->prepare("SELECT * from $table_order_receiver_info where id=%d", $order->receiver_id));
            $item = $wpdb->get_row($wpdb->prepare("SELECT * from $table_items where Id=%d", $order->item_id));

            ?>

            <tr>
                <td class="manage-column ss-list-width"><?php echo $order->id; ?></td>
                <td class="manage-column ss-list-width"><?php echo $item->name; ?></td>
                <td class="manage-column ss-list-width"><?php echo $order->price . ' kr' ; ?></td>
                <td class="manage-column ss-list-width"><?php echo ($order->extraLogo == 1 ? 'Yes' : 'No'); ?></td>
                <td class="manage-column ss-list-width"><?php echo $order->frontBack; ?></td>

                <td class="manage-column ss-list-width"><?php echo $receiver->fullName; ?></td>
                <td class="manage-column ss-list-width"><?php echo $receiver->email; ?></td>
                <td class="manage-column ss-list-width"><?php echo $receiver->address; ?></td>
                <td class="manage-column ss-list-width"><?php echo $receiver->telephone; ?></td>
                <td class="manage-column ss-list-width"><?php echo $receiver->postNumber; ?></td>
                <td class="manage-column ss-list-width"><?php echo $receiver->city; ?></td>
                <td class="manage-column ss-list-width"><?php echo $receiver->russGroupName; ?></td>

                <td><a href="<?php echo admin_url('admin.php?page=russ_order_details&id=' . $order->id); ?>">Details</a></td>


            </tr>
        <?php } ?>
    </table>
    </div>

    <?php



}

?>