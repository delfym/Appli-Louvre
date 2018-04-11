var birthDate;
var myInput;
var day;
var month;
var year;
var price = 0;
var total = 0;


$('.tickets').on('change', '.myBirth', function (e) {

    var idTicket = e.target.id.split('_').reverse()[0];
    var idInput = e.target.id.split('_').reverse()[3];

    myInput = '#louvre_bookingbundle_orderoftickets_tickets_' + idInput + '_price';

    switch (idTicket) {
        case 'year' :
            year = e.target.value;
            break;
        case 'month' :
            month = e.target.value;
            if (month <= 9) {
                month = '0' + month;
            }
            break;
        case 'day' :
            day = e.target.value;
            if (day <= 9) {
                day = '0' + day;
            }
            break;
    }
    if (day == null) {
        day = '01';
    }
    if (month == null) {
        month = '01';
    }

    birthDate = day + '-' + month + '-' + year;

// * ****************************** req AJAX ********************************
    if (null != birthDate) {
        var url = 'http://localhost:8888/Appli-Louvre/web/app_dev.php/louvre_booking/update';
        $.post(url, {birthDay: birthDate},
            function (data) {
                $(myInput).val(data);
            })
            .fail('zut');
    }


});

$('.tickets').on('blur', '.myBirth', function (e) {
    $('#louvre_bookingbundle_orderoftickets_ticketsQuantity').change(function () {
        total = 0;
        price = 0;
        $('input.total').val(total);
    });
    console.log(total);
    console.log('input.price.val : ' + $(myInput).val());
    price = $(myInput).val();
    price = parseInt(price);
    // console.log(typeof total);

    total += price;
    console.log('price : ' + price);
    console.log('total : ' + total);

    $('input.total').val(total);
});








