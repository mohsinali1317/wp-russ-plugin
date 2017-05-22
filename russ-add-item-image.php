<?php
/**
 * Created by PhpStorm.
 * User: mohsin
 * Date: 22/05/2017
 * Time: 09:36
 */

function russ_item_add_image() {

    global $wpdb;
    $table_name = $wpdb->prefix . "russ_colors";

    $item_id = $_GET["id"];

    //echo $item_id;

    if(isset($_FILES['image'])){

        $imageCaption = $_POST["imageCaption"];


        // Use the wordpress function to upload
        // test_upload_pdf corresponds to the position in the $_FILES array
        // 0 means the content is not associated with any other posts


        $data = array(
            'post_excerpt' => $imageCaption
        );

        $uploaded=media_handle_upload('image', 0, $data);

        $attachment_url = wp_get_attachment_url($uploaded);
        echo $attachment_url;


        // Error checking using WP functions
        if(is_wp_error($uploaded)){
            echo "Error uploading file: " . $uploaded->get_error_message();
        }else{
            echo "File upload successful!";
        }
    }


?>

    <div class="wrap">
        <h2>Add Item</h2>

        <h2>Upload a File</h2>
        <!-- Form to handle the upload - The enctype value here is very important -->
        <form  method="post" enctype="multipart/form-data">
            <input type='file' id='image' name='image' accept="image/*" />
            <input type='text' id='imageCaption' name='imageCaption' placeholder="Image caption" />
            <?php submit_button('Upload') ?>
        </form>

    </div>


<?php
    } ?>