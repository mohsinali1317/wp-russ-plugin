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
                array('Item_id' => $item_id, 'Image_Id' => $uploaded), //data
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



    $itemImages = $wpdb->get_results($wpdb->prepare("SELECT Image_Id from $table_item_images where Item_Id=%d", $item_id));

    foreach ($itemImages as $s) {
     ?>

        <img src="<?php echo wp_get_attachment_image_url($s->Image_Id); ?>" />
        <?php
    }



} ?>