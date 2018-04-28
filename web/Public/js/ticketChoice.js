

//$(document).ready(function() {

    $('input.datepicker').change(function (e) {

        var visitDate;
        visitDate = $(this).val();

        var today = new Date();
        var a = today.getFullYear();
        var m = today.getMonth() +1;
        m = m.toString();
        var j = today.getDate();
        j = j.toString();
        var h = today.getHours();

        var currentDay = formAdmin.formatNumber(j) + '-' + formAdmin.formatNumber(m) + '-' + a;

        if((currentDay === visitDate) && (h >= 14)) {
            $('#louvre_bookingbundle_orderoftickets_ticketType option:eq(0)')
                .prop('disabled', true);
            $('#louvre_bookingbundle_orderoftickets_ticketType option:eq(1)')
                .prop('selected', true);
        }
  //  })
});

