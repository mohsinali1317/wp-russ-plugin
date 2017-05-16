<?php


function my_enqueue_client($hook) {

    prefix_enqueue();

    wp_register_style('crondale-russ-plugin-client', plugins_url('crondale-russ-plugin/client/client.css'));
    wp_enqueue_style('crondale-russ-plugin-client');

    wp_enqueue_script('crondale-russ-plugin-client', plugins_url('/client.js', __FILE__ ));
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

    $html = "";

    //$items = $wpdb->get_results($wpdb->prepare("SELECT * from $table_items where Id=%s", 1));

    $items = $wpdb->get_results("SELECT * from $table_items");

    foreach ($items as $key => $value) {

        $select = "";

        $color_Ids = $wpdb->get_results($wpdb->prepare("SELECT Color_Id from $table_item_colors where Item_Id=%s", $value->Id));

        $select .= "<select class=\"form-control colors\">";
        foreach ($color_Ids as $key => $colorId) {
            $colors = $wpdb->get_results($wpdb->prepare("SELECT * from $table_colors where Id=%s", $colorId->Color_Id));



            foreach ($colors as $key => $color) {
                $select .= "<option value = " . $color->Name . " >" . $color->Name . " </option>";
            }

        }
        $select .= "</select>";
        ?>

        <div class='item'>
            <div class="firstStep">
                <h1>
                    <?php echo $value->Name . " - " . $value->Price; ?>
                </h1>
                <p>
                    <?php echo $value->Description; ?>
                </p>
                <hr>

                <?php



                if ($value->FrontBackOption) {
                    ?>
                    <div class="radio">
                        <label>
                            <input type="radio" name="printPosition" class="printPosition" value="front" checked> Trykk foran
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="printPosition" class="printPosition" value="back"> Trykk bak
                        </label>
                    </div>
                    <hr>
                    <?php
                }

                if ($value->ExtraLogo) {
                    ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="extraLogo"  class="extraLogo"> Ekstra brystlogo (+ kr. 99 per genser)
                        </label>
                    </div>

                    <hr>
                    <?php
                }

                ?>

                <div class="row">
                    <label class="col-xs-5 col-sm-4">
                        Navn på rygg
                    </label>
                    <label class="col-xs-4 col-sm-3">
                        Størrelse
                    </label>
                    <label class="col-xs-3 col-sm-2">
                        Farge
                    </label>
                </div>

                <?php

                for ($i = 0; $i < $value->MinimumOrder; $i++) {
                    ?>

                    <div class="form-group item-row">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <input class="form-control nameOnShirt" type="text" name="nameOnShirt"  placeholder="Navn på rygg" >
                            </div>
                            <div class="col-xs-4 col-sm-2">
                                <select class="form-control size">
                                    <option value="xs">XS</option>
                                    <option value="s">S</option>
                                    <option value="m">M</option>
                                    <option value="l">L</option>
                                    <option value="xl">XL</option>
                                    <option value="xxl">2XL</option>
                                    <option value="xxxl">3XL</option>
                                </select>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <?php
                                echo $select;
                                ?>
                            </div>
                            <div class="col-xs-4 col-sm-2">
                                <button class="btn btn--icon removeGenser">Remove</button>
                            </div>
                        </div>
                    </div>

                    <?php
                }

                ?>

                <div class="text-center">
                    <button class="btn addGenser">
                        Add genser
                    </button>
                </div>

                <hr>
                <h5 class="pricePerPerson">
                    Price per person Kr.  <span class="priceFromData"> </span>  ,-
                </h5>
                <hr>
                <h5 class="totalPrice">
                    Total price Kr. <span> </span> ,-
                </h5>

                <!--    just for data-->
                <span class="myData" data-minimum-order ="<?php echo $value->MinimumOrder; ?>" data-price="<?php echo $value->Price; ?>" data-item-id ="<?php echo $value->Id; ?>">
            </span>

                <hr>
                <button class="btn goToSecondStep">Gå videre</button>
                <?php
                ?>


            </div>
            <div class="secondStep" style="display: none">

                <h3>Send bestilling</h3>
                <div class="form-group">
                    <input class="form-control fullName" type="text" placeholder="Fullt navn" autocorrect="off" autocapitalize="words" autocomplete="name">
                </div>
                <div class="form-group">
                    <input class="form-control email" type="email" placeholder="E-post" autocorrect="off" autocapitalize="off" autocomplete="email">
                </div>
                <div class="form-group">
                    <input class="form-control telephone" type="text" placeholder="Telefon" autocorrect="off" autocapitalize="off">
                </div>
                <div class="form-group">
                    <input class="form-control address" type="text" placeholder="Addresse" autocorrect="off">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="form-control postNumber" type="text" placeholder="Postnummer" pattern="d*" novalidate="" autocorrect="off">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control city" type="text" placeholder="Poststed">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <input class="form-control russGroupName" type="text" placeholder="Navn på russegruppe" autocorrect="off">
                </div>
                <hr>

                <span class="error" style="display: none;">Du må fylle inn alle feltene over.</span>

                <hr>

                <p>Når bestillingen er sendt får du instruksjoner om hvor du skal sende logoen.</p>

                <button class="btn sendOrder">Send bestilling</button>


            </div>
            <div class="thirdStep" style="display: none">

                <h3>Takk for bestillingen!</h3>

                <p>Bestilling information</p>


            </div>
        </div>

        <hr>

        <?php
    }


    return $html;
}


// todo: check for the address etc stuff

function prefix_admin_add_order() {
    // Handle request then generate response using echo or leaving PHP and using HTML

    if(isset($_REQUEST['parameters']) && isset($_REQUEST['orderAddress']) && isset($_REQUEST['order'])){

        global $wpdb;
        $table_order_receiver_info = $wpdb->prefix . "russ_order_receiver_info";
        $table_orders = $wpdb->prefix . "russ_orders";
        $table_order_details = $wpdb->prefix . "russ_order_details";



        $order_receiver_info = $_REQUEST['orderAddress'];
        $order = $_REQUEST['order'];

        $message = "An order has been created by " . $order_receiver_info['fullName'];

        echo $message;

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


        $receiver_id = $wpdb->insert_id;


        $wpdb->insert(
            $table_orders, //table
            array('frontBack' =>$order['frontBack'] ,
                'extraLogo' => $order['extraLogo'],
                'price' => $order['price'],
                'receiver_id' => $receiver_id,
                'item_id' => $order['itemId']),

            array('%s','%d','%d','%d','%d')
        );

        $order_id = $wpdb->insert_id;


        foreach ($_REQUEST['parameters'] as $key => $value){


            $wpdb->insert(
                $table_order_details, //table
                array('name' =>$value['name'] ,
                    'size' => $value['size'],
                    'color' => $value['color'],
                    'orderId' =>  $order_id ),
                array('%s','%s','%s','%d')
            );

        }

    }




   // wp_mail( "mohsinali1017@gmail.com", "Order created", $message );





    status_header(200);

  //  die("Server received '{$_REQUEST['parameters']}' from your browser.");




}





?>