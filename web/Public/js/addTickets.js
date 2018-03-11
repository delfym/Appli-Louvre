<!-- Bootstrap core CSS -->

$(document).ready(function() {

    //formatage du formulaire
    $("fieldset.form-group").addClass("border");
    $("label").addClass("col-sm-3 d-flex flex-start");
    $("select#louvre_bookingbundle_orderoftickets_tickets0ticketType").addClass("col-sm-8 d-flex flex-end");
    $("input").addClass("col-sm-8 d-flex flex-end");

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#louvre_bookingbundle_orderoftickets_tickets');
    var selection;
    var index = 0;
    var $prototype;

    if(index == 0) {
        addTickets($container);
    }

    $('select#louvre_bookingbundle_orderoftickets_ticketsQuantity').change(function(e) {
        if($prototype.id > 0) {
            var count = $prototype.id + 1;
            for (var i= 1; i < count; i++){
               $("div#louvre_bookingbundle_orderoftickets_tickets > fieldset").remove();
            }
       index = 0;  //réinitialisation de l'index
       addTickets($container); //ajout du billet 1 par défaut
        }

        selection = $(this).val();

        for(index = 1; index <= selection; index++){
            addTickets($container);
        }
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });
    /***** La fonction qui ajoute un formulaire TicketType  *****/
    function addTickets($container) {
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Billet n°' + (index+1))
            .replace(/louvre_bookingbundle_orderoftickets_tickets___name___/g, 'louvre_bookingbundle_orderoftickets_tickets_' + index)
            .replace(/Ticket date/g, 'Date de votre visite')
            .replace(/Ticket type/g, 'Type de ticket')
            .replace(/Visitor/g, 'Vos coordonnées')
            .replace(/Name/g, 'Nom')
            .replace(/First name/g, 'Prénom')
            .replace(/Birth date/g, 'Date de naissance')
            .replace(/Email/g, 'Email')
        ;

        // On crée un objet jquery qui contient ce template
         $prototype = $(template);
         $prototype.id = index;

        // On ajoute le prototype modifié à la fin de la balise <div>
         $container.append($prototype);
    }

    // La fonction qui ajoute un lien de suppression d'un billet
    function deleteTickets($prototype) {
           // $prototype.remove();
    }
});