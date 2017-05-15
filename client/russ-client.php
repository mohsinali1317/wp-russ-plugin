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

    $items = $wpdb->get_results($wpdb->prepare("SELECT * from $table_items where Id=%s", 1));

    foreach ($items as $key => $value) {

        $select = "";

        $color_Ids = $wpdb->get_results($wpdb->prepare("SELECT Color_Id from $table_item_colors where Item_Id=%s", $value->Id));

        foreach ($color_Ids as $key => $colorId) {
            $colors = $wpdb->get_results($wpdb->prepare("SELECT * from $table_colors where Id=%s", $colorId->Color_Id));

            $select .= "<select class=\"form-control colors\">";
            $select .= "<option> Select Color </option>";

            foreach ($colors as $key => $color) {
                $select .= "<option value = " . $color->Id . " >" . $color->Name . " </option>";
            }
            $select .= "</select>";
        }
        ?>

        <div class='item'>
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
                        <input type="radio" name="printposition" value="front"> Trykk foran
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="printposition" value="back"> Trykk bak
                    </label>
                </div>
                <hr>
                <?php
            }

            if ($value->ExtraLogo) {
                ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="extraLogo" id="extraLogo"> Ekstra brystlogo (+ kr. 99 per genser)
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
                            <input class="form-control" type="text" name="nameOnShirt" placeholder="Navn på rygg">
                        </div>
                        <div class="col-xs-4 col-sm-2">
                            <select class="form-control">
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
            <span class="myData" data-minimum-order ="<?php echo $value->MinimumOrder; ?>" data-price="<?php echo $value->Price; ?>">

            </span>

            <hr>
            <button class="btn secondStep">Gå videre</button>
            <?php
            ?>


        </div>

        <?php
    }


    return $html;
}






?>