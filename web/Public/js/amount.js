var birthDay;
var myBirthDate;
var total;
var total1=0;

/*
prendre le nombre de billets, et créer un index sur mes input
 */

    //$('#louvre_bookingbundle_orderoftickets_ticketsQuantity').change(function () {
   //     birthDate='';
$('div.myBirth').on('change', 'select', function () {
    birthDate='';
       // $('.myBirth select').change(function (e) {

            //console.log($(this).val());
            //console.log(e);

            var testD = $('.myBirth select:nth-child(1)').val();
            var testM = $('.myBirth select:nth-child(2)').val();
            var testY = $('.myBirth select:nth-child(3)').val();
            console.log('testY : ' + testY);
            if(testD <= 9)
            {
                testD = '0'+testD;
            }
            if(testM <= 9)
            {
                testM = '0' + testM;
            }
            myBirthDate = testD + '-' + testM +'-' + testY;
            console.log('ma birthdate 3: ' + myBirthDate);

        // ************* req AJAX ********************************

            var url = 'http://localhost:8888/Appli-Louvre/web/app_dev.php/louvre_booking/update';
            $.post(url, {birthDay : myBirthDate},
                function (data) {
                    $('input.price').val(data);  //détecter le num d'input grace au num billet
                    data = null;;
                    //  total = data;
                    //  total1 += total;
                    //  $('input.price').val(total);
                    //  $('input#louvre_bookingbundle_orderoftickets_amount').val(total1);
                })
                .fail(function (jqxhr) {
                   alert(jqxhr.responseText);
                });

       // });

    });
    //$('select.myBirth').trigger('change');


