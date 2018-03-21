<!-- Bootstrap core CSS -->

$(document).ready(function () {

    //formatage du formulaire
    $(".prototype-ticket").addClass("border");

    var $container = $('div.prototype-ticket');

    var selection;
    var lastSelection;
    var count = 0;

    $('select#louvre_bookingbundle_orderoftickets_ticketsQuantity').change(function (e) {
        event.preventDefault();
        event.stopPropagation();

        selection = $(this).val();
        lastSelection = count;

        for (var i = 1; i <= lastSelection; i++) {
            $("section#container-ticket > fieldset").remove();
        }

        count = 0;  //réinitialisation de l'index
        $('div.prototype-ticket:first').hide();

        for (count; count <= selection; count++) {
            addTickets($container);
        }

        $('section#container-ticket h5').each(function (index) {
            $(this).text('Billet n°' + (index + 1));
          //  $('input#container-ticket').attr('class', 'datepicker')
        });

        $('.ticketField-1:nth-child(2)').attr('class', 'ticketField-1' + 1);

        $('.datepicker').datepicker({
            language: "fr"
        });

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    /***** La fonction qui ajoute un formulaire TicketType  *****/
    function addTickets($container) {
        var $prototypeTicket = $container.clone();
        $prototypeTicket = $($prototypeTicket.html()
            .replace(/__name__/g, $('prototype-ticket').length));

        var $proto = $($prototypeTicket);
        $('#container-ticket').prepend($proto);
    }
});
