jQuery(document).ready(function($) {

    // setting initial values

    var parameters = [];

    $( ".item" ).each(function( index ) {

        var firstStep = $( this ).children('.firstStep');

        var pricePerPerson = firstStep.children('.pricePerPerson');
        var totalPrice = firstStep.children('.totalPrice');

        var data = firstStep.children('.myData');

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var price = data.data('price');
        var minimumOrder = data.data('minimum-order');

        var totalPrice = price * minimumOrder;
        data.data('total-price',totalPrice );

        spanForPrice.text(price);
        spanForTotalPrice.text(totalPrice);


    });

    $('#extraLogo').click(function() {

        var item = $(this).closest('.item');
        var firstStep = item.children('.firstStep');

        var pricePerPerson = firstStep.children('.pricePerPerson');
        var totalPrice = firstStep.children('.totalPrice');

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var data = firstStep.children('.myData');

        var price = data.data('price');

        var minmumOrders = data.data('minimum-order');

        var itemRows = firstStep.children('.item-row').length;

        var numberOfOrders = itemRows;

        if(itemRows < minmumOrders)
            numberOfOrders = minmumOrders;

        if ($(this).is(':checked')) {
            price += 99;
            priceMaipulation(price,data,spanForPrice,spanForTotalPrice,numberOfOrders);
        }else{
            price -= 99;
            priceMaipulation(price,data,spanForPrice,spanForTotalPrice,numberOfOrders);
        }

    });

    // todo: when adding genser after filling the details it copies the details of the last one and carries it.
    // todo: so create a placeholder element in html doc

    $('.addGenser').click(function() {

        var item = $(this).closest('.item');
        var firstStep = item.children('.firstStep');

        var pricePerPerson = firstStep.children('.pricePerPerson');

        var totalPrice = firstStep.children('.totalPrice');

        var itemRows = firstStep.children('.item-row');

        var itemRow = itemRows.last();

        var newItem = itemRow.clone();

        itemRow.after( newItem );

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var data = firstStep.children('.myData');

        var price = data.data('price');

        var  minimumOrder = itemRows.length + 1;

        priceMaipulation(price,data,spanForPrice,spanForTotalPrice,minimumOrder);


    });

    $('body').on('click', '.removeGenser', function() {
        var item = $(this).closest('.item');
        var firstStep = item.children('.firstStep');

        var pricePerPerson = firstStep.children('.pricePerPerson');

        var totalPrice = firstStep.children('.totalPrice');

        var data = firstStep.children('.myData');
        var price = data.data('price');


        var minimumOrder = data.data('minimum-order');

        var itemRows = firstStep.children('.item-row');

        if(itemRows.length <= minimumOrder)
            return;

        var itemRow = itemRows.last();

        itemRow.remove();

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var numberOfOrders = itemRows.length;

        if(itemRows.length > minimumOrder)
            numberOfOrders -= 1;
        else
            numberOfOrders = minimumOrder;

        priceMaipulation(price,data,spanForPrice,spanForTotalPrice,numberOfOrders);
    });

    $('.goToSecondStep').click(function () {

        var item = $(this).closest('.item');
        var firstStep = item.children('.firstStep');

        var data = firstStep.children('.myData');
        var totalPrice = data.data('total-price');
        var itemRows = firstStep.children('.item-row');



        $( itemRows ).each(function( index ) {
            parameters.push({
                'name' : $(this).find('.nameOnShirt').first().val(),
                'size' : $(this).find('.size').first().val(),
                'color' : $(this).find('.colors').first().val(),

            })
        });

        parameters.frontBack = $('input[name=printPosition]:checked', firstStep).val();
        parameters.extraLogo = $('input[name=extraLogo]', firstStep).is(':checked');
        parameters.price = totalPrice;
        parameters.itemId = data.data('item-id');

       // console.log(parameters);


        firstStep.hide();
        $('.secondStep').show();

    });

    $('.sendOrder').click(function () {

        var secondStep = $(this).closest('.secondStep');

        var fullName = $('.fullName', secondStep).val();
        var email = $('.email', secondStep).val();
        var telephone = $('.telephone', secondStep).val();
        var address = $('.address', secondStep).val();
        var postNumber = $('.postNumber', secondStep).val();
        var city = $('.city', secondStep).val();
        var russGroupName = $('.russGroupName', secondStep).val();


        var orderAddress = {
            'fullName' : fullName,
            'email' : email,
            'telephone' : telephone,
            'address' : address,
            'postNumber' : postNumber,
            'city' : city,
            'russGroupName' : russGroupName
        };


        var order = {
            'frontBack' : parameters.frontBack,
            'extraLogo' : (parameters.extraLogo == true) ? 1 : 0,
            'price' : parameters.price,
            'itemId' : parameters.itemId
        }

        console.log(order);


        // todo: fix the url composition

        $.post({
            url: "http://localhost/tutorials/wordpress/wp-admin/admin-post.php",
            type: "POST",
            cache: false,
            data: {
                action: "add_order",
                parameters:parameters,
                orderAddress : orderAddress,
                order : order
            },
            success: function(response) {
                console.log(response);
            }
        });

    });



});


function priceMaipulation(price, data, spanForPrice, spanForTotalPrice,minimumOrder){

    var totalPrice = price * minimumOrder;
    spanForPrice.text(price);
    spanForTotalPrice.text(totalPrice);
    data.data('price', price);
    data.data('total-price', totalPrice);

}