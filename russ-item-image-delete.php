<?php
/**
 * Created by PhpStorm.
 * User: mohsin
 * Date: 26/05/2017
 * Time: 08:36
 */

function russ_item_image_delete()
{


    if(isset($_GET["itemId"]) && isset($_GET["imageId"])){

        global $wpdb;
        $table_item_images = $wpdb->prefix . "russ_item_images";

        $item_id = $_GET["itemId"];
        $image_id = $_GET["imageId"];

        $wpdb->query($wpdb->prepare("DELETE FROM $table_item_images WHERE Item_Id = %d AND Image_Id = %d", $item_id,$image_id));

        wp_delete_post( $image_id );

        wp_redirect(admin_url('admin.php?page=russ_item_add_image&id='.$item_id));
    }




}


?>

