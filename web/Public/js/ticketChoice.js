

$(document).ready(function() {

    $('input.datepicker').change(function (e) {
        //$('select#louvre_bookingbundle_orderoftickets_ticketType option').val(0).prop('disabled', false);

        var visitDate;
        visitDate = $(this).val();

        var today = new Date();
        var a = today.getFullYear();
        var m = today.getMonth() +1;
        var j = today.getDate();

        var h = today.getHours();

        today = '0'+j + '-0' + m + '-' + a;

        if((today === visitDate) && (h >= 14)) {
            $('#louvre_bookingbundle_orderoftickets_ticketType option:eq(0)')
                .prop('disabled', true);
            $('#louvre_bookingbundle_orderoftickets_ticketType option:eq(1)')
                .prop('selected', true);

        }
    })
});

