jQuery(document).ready(function($) {

    // setting initial values

    $( ".item" ).each(function( index ) {

        var pricePerPerson = $( this ).children('.pricePerPerson');
        var totalPrice = $( this ).children('.totalPrice');
        var data = $( this ).children('.myData');

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

        var pricePerPerson = item.children('.pricePerPerson');
        var totalPrice = item.children('.totalPrice');

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var data = item.children('.myData');

        var price = data.data('price');

        var minmumOrders = data.data('minimum-order');

        var itemRows = item.children('.item-row').length;

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

    $('.addGenser').click(function() {

        var item = $(this).closest('.item');

        var pricePerPerson = item.children('.pricePerPerson');

        var totalPrice = item.children('.totalPrice');

        var itemRows = item.children('.item-row');

        var itemRow = itemRows.last();

        var newItem = itemRow.clone();

        itemRow.after( newItem );

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var data = item.children('.myData');

        var price = data.data('price');

        var  minimumOrder = itemRows.length + 1;

        priceMaipulation(price,data,spanForPrice,spanForTotalPrice,minimumOrder);


    });


    $('body').on('click', '.removeGenser', function() {
        var item = $(this).closest('.item');

        var pricePerPerson = item.children('.pricePerPerson');

        var totalPrice = item.children('.totalPrice');

        var data = item.children('.myData');
        var price = data.data('price');


        var minimumOrder = data.data('minimum-order');

        var itemRows = item.children('.item-row');

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

    $('.secondStep').click(function () {

        var item = $(this).closest('.item');

        var data = item.children('.myData');

        var price = data.data('price');
        var minimumOrder = data.data('minimum-order');

        var totalPrice = data.data('total-price');

        console.log(totalPrice);



    });

});


function priceMaipulation(price, data, spanForPrice, spanForTotalPrice,minimumOrder){

    var totalPrice = price * minimumOrder;
    spanForPrice.text(price);
    spanForTotalPrice.text(totalPrice);
    data.data('price', price);
    data.data('total-price', totalPrice);

}