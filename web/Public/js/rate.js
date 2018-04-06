var birthDay;
var birthMonth;
var birthYear;
var birthDate;



$('#louvre_bookingbundle_orderoftickets_tickets_0_visitor_birthDate_day')
    .change(function (e)
        {
            birthDay = $('#louvre_bookingbundle_orderoftickets_tickets_0_visitor_birthDate_day').val();
            //console.log('birthDay : ' + birthDay);
        }
    );

$('#louvre_bookingbundle_orderoftickets_tickets_0_visitor_birthDate_month')
    .change(function (e)
        {
            birthMonth = $('#louvre_bookingbundle_orderoftickets_tickets_0_visitor_birthDate_month').val();
            //console.log('birthMonth : ' + birthMonth);
        }
    );

$('#louvre_bookingbundle_orderoftickets_tickets_0_visitor_birthDate_year')
    .change(function (e)
    {
        birthYear = $('#louvre_bookingbundle_orderoftickets_tickets_0_visitor_birthDate_year').val();
        //console.log('birthYear : ' + birthYear);

        if(null == birthMonth){
            birthMonth = '1';
        }
        if(null == birthDay){
            birthDay = '1';
        }
        birthDate = '0'+ birthDay + '-0' + birthMonth + '-' + birthYear;
        //console.log(birthDate);


// ************* req AJAX ******************************** //

        var url = 'http://localhost:8888/Appli-Louvre/web/app_dev.php/louvre_booking/update';
        $.post(url, {birthDay : birthDate},
            function (data) {
                $('input.price')
                    .val(data);
            })
            .fail('zut');

    });