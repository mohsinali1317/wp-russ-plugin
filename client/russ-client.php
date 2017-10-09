<?php

function my_enqueue_client($hook) {

    prefix_enqueue();

    wp_register_style('crondale-russ-plugin-client', plugins_url('crondale-russ-shop/client/client.css'));
    wp_enqueue_style('crondale-russ-plugin-client');

    wp_enqueue_script('crondale-russ-plugin-client', plugins_url('/client.js', __FILE__ ));
    wp_localize_script( 'crondale-russ-plugin-client', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

// todo: check if we want to download bootstrap directly here in he project
function prefix_enqueue()
{
// JS
    wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('prefix_bootstrap');

// CSS
    wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap');
}


function crondale_russ_shop_client()
{
    global $wpdb;
    $table_colors = $wpdb->prefix . "russ_colors";
    $table_items = $wpdb->prefix . "russ_items";
    $table_item_colors = $wpdb->prefix . "russ_item_colors";
    $table_item_images = $wpdb->prefix . "russ_item_images";

    $html = "";


    $items = $wpdb->get_results("SELECT * from $table_items");

    //$items = $wpdb->get_results($wpdb->prepare("SELECT * from $table_items where Id=%s","1"));

    foreach ($items as $key => $value) {

        $select = "";

        $color_Ids = $wpdb->get_results($wpdb->prepare("SELECT colorId from $table_item_colors where itemId=%s", $value->id));

        $itemImages = $wpdb->get_results($wpdb->prepare("SELECT imageId from $table_item_images where itemId=%d", $value->id));


        $select .= "<select class=\"form-control colors\">";
        $select .= "<option value=\"\">Velg</option>";

        foreach ($color_Ids as $key => $colorId) {
            $colors = $wpdb->get_results($wpdb->prepare("SELECT * from $table_colors where Id=%s", $colorId->colorId));



            foreach ($colors as $key => $color) {
                $select .= "<option value = " . $color->name . " >" . $color->name . " </option>";
            }
        }
        $select .= "</select>";
        ?>

        <div class="russ-plugin">
        <div class="row">
            <div class="col-md-8">
                <div class='item'>
                    <?php require('firstStep.php'); ?>
                </div>

            </div>

            <!-- this here is the image crousel section -->
            
            <!-- todo: I have taken out the image section out, put it back after done with chnages -->

            <div class="col-md-4 images">
                <?php require('imageSection.php'); ?>
            </div>

        </div> 
    </hr>

    <?php
    }

    ?>




    <!-- this here is the pricing section -->
    <div class="row">
        <div class="col-xs-12 col-md-8">
        </hr>
             <div class="tPricing">
                <h3 class="totalPrice green-info-header">
                    Total price Kr. <span> 0 </span> ,-
                </h3>
            </div>
        </div>
    </div>



    <!-- this here is the order form -->
    <div class="row">
        <div class="col-xs-12 col-md-8">
        </hr>
            <?php require_once('secondStep.php'); ?>
        </div>
    </div>


    <!-- this here is after order placed -->
    <div class="row">
        <div class="col-xs-12 col-md-8">
        </hr>
            <?php require_once('thirdStep.php'); ?>
        </div>
    </div>
     
    </div>

<?php
    return $html;
}





function add_order() {

    // Handle request then generate response using echo or leaving PHP and using HTML

    if(isset($_REQUEST['parameters']) && isset($_REQUEST['orderAddress'])){

        global $wpdb;
        $table_order_receiver_info = $wpdb->prefix . "russ_order_receiver_info";
        $table_orders = $wpdb->prefix . "russ_orders";
        $table_order_details = $wpdb->prefix . "russ_order_details";


        $order_receiver_info = $_REQUEST['orderAddress'];
       

        $message = "An order has been created by " . $order_receiver_info['fullName'];

         $wpdb->insert(
            $table_order_receiver_info, //table
            array('fullName' =>$order_receiver_info['fullName'] ,
                'email' => $order_receiver_info['email'],
                'address' => $order_receiver_info['address'],
                'postNumber' => $order_receiver_info['postNumber'],
                'city' => $order_receiver_info['city'],
                'telephone' => $order_receiver_info['telephone'],
                'russGroupName' => $order_receiver_info['russGroupName'])
            );


        if($wpdb->insert_id == 0)
        {
            status_header( 500 );
            echo "Recipeint data error";
            die();
        }


        $receiver_id = $wpdb->insert_id;

        foreach ($_REQUEST['parameters'] as $key => $value){

                   $wpdb->insert(
            $table_orders, //table
            array('frontBack' =>$value['frontBack'] ,
                'extraLogo' => $value['extraLogo'],
                'price' => $value['price'],
                'receiver_id' => $receiver_id,
                'item_id' => $value['itemId']),

            array('%s','%d','%d','%d','%d')
            );
            

           
            $order_id = $wpdb->insert_id;


        if($wpdb->insert_id == 0)
        {
            $wpdb->query($wpdb->prepare("DELETE FROM $table_order_receiver_info WHERE id = %s", $receiver_id));
            status_header( 500 );
            echo "Order error";
            die();
        }

            foreach ($value['orders'] as $k => $v){


            $wpdb->insert(
                $table_order_details, //table
                array('name' =>$v['name'] ,
                    'size' => $v['size'],
                    'color' => $v['color'],
                    'orderId' =>  $order_id ),
                array('%s','%s','%s','%d')
                );

            }
           
        }

    status_header(200);
    echo "It went all fine!!";
    die();

    }

    else
    {
        status_header(500);
        echo "Some data was not sent from server properly.";
        die();

    }
    

   // wp_mail( "mohsinali1017@gmail.com", "Order created", $message );

}

?>