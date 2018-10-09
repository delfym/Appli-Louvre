var $collectionHolder;
var $newLinkLi = $('<li class="list-unstyled"></li>').append();
var i = 0;

$collectionHolder = $('ul.tickets');
$collectionHolder.append($newLinkLi);
$collectionHolder.data('index', $collectionHolder.find(':input').length);

if (i === 0) {
    addTicketForm($collectionHolder, $newLinkLi);
}

$('select#louvre_bookingbundle_orderoftickets_ticketsQuantity').change(function (e) {
    var selection;
    event.preventDefault();

    if (i !== 0) {
        // remove the li for the ticket form
        $('li.myTicket').remove();
        addTicketForm($collectionHolder, $newLinkLi);
    };

    selection = $(this).val();

    for (i = 1; i < selection; i++) {
        addTicketForm($collectionHolder, $newLinkLi);
    }

    $('h5.ticketTitle').each(function (count) {
        $(this).text('Billet n°' + (count + 1));
    });
});

function addTicketForm($collectionHolder, $newLinkLi) {

    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li class="myTicket list-unstyled mb-3"></li>').append(newForm);
    $newLinkLi.before($newFormLi);

}
