
var birthDate;
var $tickets = $('#louvre_bookingbundle_orderoftickets_ticketsQuantity');
var ticketNumber = $tickets.val();

/*if( ticketNumber == 1 ) {

  console.log('ticketNumber ' + ticketNumber);

  $('.myBirth select').change(function (e) {
   // console.log($tickets.val());
    var test = $(this).val();

   // console.log($(this).val());
    var test2 = $('.myBirth select:nth-child(1)').val();
    var test3 = $('.myBirth select:nth-child(2)').val();
    var test4 = $('.myBirth select:nth-child(3)').val();
    if(test2 <= 9) {
      test2 = '0'+test2;
    }
    if(test3 <= 9) {
        test3 = '0' + test3;
    }
    birthDate = test2 + '-' + test3 +'-' + test4;
      console.log('birth ticket 1 ' + birthDate);

    var url = 'http://localhost:8888/Appli-Louvre/web/app_dev.php/louvre_booking/update';
    $.post(url, {birthDay : birthDate},
        function (data) {
            $('input.price:first')
                .val(data);
        })
        .fail('zut');

  });
}*/

$('.tickets').on('change', 'select' , function (e) {
   // console.log('target', e.target);
    //console.log('currentTarget', e.currentTarget);
    //  console.log($(this).val());
  //var test2 = $('.myBirth > select').val();

    console.log('length : ' + $('.myBirth select').length);
    $('.myBirth select').each(function (index) {
       console.log('index ' + index + ' '+ $(this).val());

    });

//  console.log('test 01 : '+ test2);

    var testD = $(':first-child').val();
    var testM = $('.myBirth select:nth-child(2)').val();
    var testY = $('.myBirth select:nth-child(3)').val();
   // console.log('test2 : ' + testD + ' ' + testM + ' ' + testY);

});

console.log('état de mon birth : ' + birthDate);
/*/ * ****************************** req AJAX ********************************
if (null != birthDate) {
        var url = 'http://localhost:8888/Appli-Louvre/web/app_dev.php/louvre_booking/update';
        $.post(url, {birthDay : birthDate},
            function (data) {
                $('input.price')
                    .val(data);
            })
            .fail('zut');
}
*************************************************************************** */