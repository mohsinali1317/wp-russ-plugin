<?php
/**
 * Created by PhpStorm.
 * User: mohsin
 * Date: 26/05/2017
 * Time: 11:27
 */

function russ_order_details(){

    $orderId = $_GET["id"];

    ?>

    <div class="wrap">
        <h2>Orders Details</h2>

        <?php

        global $wpdb;
        $table_orders_details = $wpdb->prefix . "russ_order_details";

        $orders = $wpdb->get_results($wpdb->prepare("SELECT * from $table_orders_details where orderId=%d", $orderId));

        ?>

        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Name</th>
                <th class="manage-column ss-list-width">Size</th>
                <th class="manage-column ss-list-width">Color</th>


            </tr>
            <?php foreach ($orders as $order)
            {
                ?>

                <tr>
                    <td class="manage-column ss-list-width"><?php echo $order->id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $order->name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $order->size ; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $order->color; ?></td>



                </tr>
            <?php } ?>
        </table>
    </div>

    <?php



}

?>