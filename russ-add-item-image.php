<?php
/**
 * Created by PhpStorm.
 * User: mohsin
 * Date: 22/05/2017
 * Time: 09:36
 */

function russ_item_add_image() {

    global $wpdb;
    $table_item_images = $wpdb->prefix . "russ_item_images";

    $item_id = $_GET["id"];

    if(isset($_FILES['image'])){

        $imageCaption = $_POST["imageCaption"];


        // Use the wordpress function to upload
        // test_upload_pdf corresponds to the position in the $_FILES array
        // 0 means the content is not associated with any other posts


        $data = array(
            'post_excerpt' => $imageCaption
        );

        $uploaded=media_handle_upload('image', 0, $data);

        // Error checking using WP functions
        if(is_wp_error($uploaded)){
            echo "Error uploading file: " . $uploaded->get_error_message();
        }else{
            echo "File upload successful!";

            $res = $wpdb->insert(
                $table_item_images, //table
                array('itemId' => $item_id, 'imageId' => $uploaded), //data
                array('%d' , '%d') //data format
            );

        }
    }



?>

    <div class="wrap">
        <h2>Add Image for item</h2>
        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="image">File input</label>
                <input type="file" id='image' name='image' accept="image/*">
            </div>
            <div class="form-group">
                <label>
                   Add Image caption <input type='text' id='imageCaption' name='imageCaption'  class="form-control" placeholder="Image caption" />
                </label>
            </div>
            <?php submit_button('Upload') ?>
        </form>
    </div>


<?php



    $itemImages = $wpdb->get_results($wpdb->prepare("SELECT imageId from $table_item_images where itemId=%d", $item_id));

    foreach ($itemImages as $s) {
     ?>

        <div class="itemImage">
            <img src="<?php echo wp_get_attachment_image_url($s->imageId); ?>" />
            <span><?php echo get_the_excerpt($s->imageId);?></span>
            <a href="<?php echo admin_url('admin.php?page=russ_item_image_delete&itemId=' . $item_id . '&imageId=' . $s->imageId); ?>">Delete Image</a>
        </div>
        <?php
    }



} ?>