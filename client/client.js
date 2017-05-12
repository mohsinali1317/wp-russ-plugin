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

        spanForPrice.text(price);
        spanForTotalPrice.text(price * minimumOrder);




    });

    $('#extraLogo').click(function() {

        var pricePerPerson = $(this).closest('.item').children('.pricePerPerson');
        var totalPrice =$(this).closest('.item').children('.totalPrice');

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var data = $(this).closest('.item').children('.myData');

        var price = data.data('price');
        var minimumOrder = data.data('minimum-order');

        if ($(this).is(':checked')) {
            price += 99;
            priceMaipulation(price,data,spanForPrice,spanForTotalPrice,minimumOrder);
        }else{
            price -= 99;
            priceMaipulation(price,data,spanForPrice,spanForTotalPrice,minimumOrder);
        }

    });

    $('.addGenser').click(function() {

        var item = $(this).closest('.item');

        var pricePerPerson = item.children('.pricePerPerson');

        var totalPrice = item.children('.totalPrice');

        var itemRow = item.find('.item-row').last();

        var newItem = itemRow.clone();

        itemRow.after( newItem );

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');

        var data = item.children('.myData');

        var price = data.data('price');
        var minimumOrder = data.data('minimum-order');

        price += 99;
        priceMaipulation(price,data,spanForPrice,spanForTotalPrice,minimumOrder);


    });


    $('body').on('click', '.removeGenser', function() {
        var item = $(this).closest('.item');

        var pricePerPerson = item.children('.pricePerPerson');

        var totalPrice = item.children('.totalPrice');

        var data = item.children('.myData');
        var price = data.data('price');


        var minimumOrder = data.data('minimum-order');

        var itemRows = item.find('.item-row');

        if(itemRows.length <= minimumOrder)
            return;

        var itemRow = itemRows.last();

        itemRow.remove( );

        var spanForPrice = pricePerPerson.children('.priceFromData');
        var spanForTotalPrice = totalPrice.children('span');




        price -= 99;
        priceMaipulation(price,data,spanForPrice,spanForTotalPrice,minimumOrder);
    });




});


function priceMaipulation(price, data, spanForPrice, spanForTotalPrice,minimumOrder){

    spanForPrice.text(price);
    spanForTotalPrice.text(price * minimumOrder);
    data.data('price', price);
}