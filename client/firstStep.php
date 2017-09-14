 <div class="firstStep">

    <h1>
       <?php echo $value->name . " - " . $value->price; ?>
    </h1>

    <p>
        <?php echo $value->description; ?>
    </p>

    <p class="expand-parent">
        <a class="expand" data-toggle="collapse" href="#collapseItem_<?php echo $value->id; ?>" aria-expanded="false" aria-controls="collapseExample">
            Expand to add items in cart
        </a>
    </p>


    <section class="collapse itemSection" id="collapseItem_<?php echo $value->id; ?>">
    </hr>

    <?php

    if ($value->frontBackOption) {
        ?>
        <div class="radio">
            <label>
                <input type="radio" name="printPosition_<?php echo $value->id; ?>" class="printPosition" value="front" checked/> Trykk foran
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="printPosition_<?php echo $value->id; ?>" class="printPosition" value="back"/> Trykk bak
            </label>
        </div>
        <hr>
        <?php
    }

    else{
        ?>
        <input type="radio" name="printPosition" class="printPosition hidden" value="none" checked/> 
        <?php
    } 

    if ($value->extraLogo) {
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

    for ($i = 0; $i < $value->minimumOrder; $i++) {
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
                    <button class="btn btn-danger flat removeGenser">Fjern</button>
                </div>
            </div>
        </div>

        <?php
    }

    ?>

    <div class="text-center">
        <button class="btn btn-success flat addGenser">
            Legg til
        </button>
    </div>

    <!-- This is the section related to pricing data, minimum number of orders, price per item etc -->
    <div class="pricing">

        <hr>
        <h5 class="pricePerPerson">
            Price per person Kr.  <span class="priceFromData"> </span>  ,-
        </h5>
        <hr>
        <h5 class="totalPrice">
            Total price Kr. <span> </span> ,-
        </h5>

        <!--    just for data-->
        <span class="myData" data-minimum-order ="<?php echo $value->minimumOrder; ?>" data-price="<?php echo $value->price; ?>" data-item-id ="<?php echo $value->id; ?>">
        </span>
    </div>

    </section>

</div>

