var formAdmin = {
    calculateTotal: function () {
        var total = 0;
        $('input.price').each(
            function (index, elem) {
                var price = $(elem).val();
                if ($.isNumeric(price)) {
                    total += parseInt(price);
                }
            }
        );
        $('.total').val(total);
        return total;
    },
    formatNumber: function (num) {
        if (num.length == 1) {
            return "0" + num;
        }
        return num;
    },

    disableForm: function (bool) {
        $('ul input').each(
            function (index, elem) {
                $(elem).prop('disabled', bool);
                $('select').prop('disabled', bool);
            })
    }
};

$('.tickets').on('change', '.myBirth', function (e) {

    var parent = $(e.target).closest(".form-inline");
    var idParent = "#" + $(parent).attr("id");
    var inputDayValue = $(idParent + "_day").val();
    var inputMonthValue = $(idParent + "_month").val();
    var inputYearValue = $(idParent + "_year").val();
    var myInput = $(e.target).closest(".myTicket").find("input.price").eq(0);

    var date = formAdmin.formatNumber(inputDayValue) + "-"
        + formAdmin.formatNumber(inputMonthValue) + "-" + inputYearValue;

    var path = $('.myForm').attr('data-path');
    $.post(path, {birthDay: date},
        function (data) {
            $(myInput).val(data);
            if ($('#louvre_bookingbundle_orderoftickets_ticketType').val() == 1) {
                var price = $(myInput).val();
                $(myInput).val(price / 2);
            }
            formAdmin.calculateTotal();
        })
        .fail('La date doit être ressaisie.');

});

$('.myForm').on('change', '#louvre_bookingbundle_orderoftickets_ticketDate', function (e) {
    var ticketDate = $(this).val();
    var path = $('.available').attr('data-path');
    $.post(path, {visitDate: ticketDate},
        function (data) {
            if (data == false) {
                formAdmin.disableForm(true);
            } else {
                formAdmin.disableForm(false);
            }
        })
        .fail('Le nombre d\'entrées disponibles est insuffisant. ' +
            'Veuillez sélectionner moins de billets ou une autre date');
});

$('.myForm').on('change', 'input[type=checkbox]', function (e) {
    var price = $(e.target).closest(".myTicket").find("input.price");

    if ((e.target.checked == true) && (price.val() == 16)) {
        var newPrice = price.val() - 10;
        $(price).val(newPrice);
        formAdmin.calculateTotal();
    } else if ((e.target.checked == false) && (price.val() == 6)) {
        var priceInt = parseInt(price.val());
        var newPrice = (priceInt + 10);
        $(price).val(newPrice);
        formAdmin.calculateTotal();
    }

});

$('.myForm').on('change', '#louvre_bookingbundle_orderoftickets_ticketType', function (e) {
    $('input.price').each(
        function (index, elem) {
            $(elem).val('');
        }
    );
    $('.total').val('');

});













































