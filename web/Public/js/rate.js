var birthDate;

var day;
var month;
var year;
var total;

    $('.tickets').on('change', '.myBirth', function (e) {
        console.log(e);
        console.log(e.target.id);
        var idTicket = e.target.id.split('_').reverse()[0];
        var idInput = e.target.id.split('_').reverse()[3];

        var myInput = '#louvre_bookingbundle_orderoftickets_tickets_' + idInput + '_price';
        console.log('my input : ' + myInput);
        // myInput = $(myInput);

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

        total += $(myInput).val();
        console.log('total : ' + total);
    });





