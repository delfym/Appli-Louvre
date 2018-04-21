<?php
/**
 * Created by PhpStorm.
 * User: delphinemillotpedrero
 * Date: 07/02/2018
 * Time: 18:02
 */

namespace Louvre\BookingBundle\Controller;

use Louvre\BookingBundle\Entity\OrderOfTickets;
use Louvre\BookingBundle\Entity\Ticket;
use Louvre\BookingBundle\Entity\Visitor;
use Louvre\BookingBundle\Form\OrderOfTicketsType;
use Louvre\BookingBundle\Form\TicketType;
use Stripe\Error;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookingController extends Controller
{

    private $tickets;

    public function indexAction()
    {
        $content = $this->get('templating')->render('LouvreBookingBundle:Booking:index.html.twig',
            array(
                'titre_page' => 'Musée du Louvre'
            ));
        return new Response($content);
    }

    public function updateAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $rateChoice = $this->get('louvre_booking.ratechoice');
            $rate = $rateChoice->rate($_POST["birthDay"]);

            return new JsonResponse($rate);
        }
    }

    public function availableTicketsAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('LouvreBookingBundle:OrderOfTickets');
            $available = $repository->countTickets($_POST["visitDate"]);
            return new JsonResponse($available);
        }
    }

    public function bookingAction(Request $request)
    {
        $orderOfTickets = new OrderOfTickets();
        $this->tickets = $orderOfTickets;

        $form = $this->get('form.factory')
            ->create(OrderOfTicketsType::class, $orderOfTickets);

        /**************  requête POST  *********/
        if ($request->isMethod('POST')
            && $form->handleRequest($request)
                ->isValid()) {

            $ticketDate = ($_POST["louvre_bookingbundle_orderoftickets"]['ticketDate']);
            $ticketDate = \DateTime::createFromFormat('d-m-Y', $ticketDate);
            $orderOfTickets->setTicketDate($ticketDate);

            $tickets = $orderOfTickets->getTickets();
            $amount = 0;
            foreach ($tickets as $ticket) {
                $rateChoice = $this->get('louvre_booking.ratechoice');
                $rate = $rateChoice->rate($ticket->getVisitor()->getBirthDate());
                $ticket->setPrice($rate);
                $amount += $rate;
            }

            $orderOfTickets->setAmount($amount);
//Création du code de réservation :
            $orderOfTickets->setBookingCode(
                $orderOfTickets->getPurchaseDate(),
                $orderOfTickets->getTicketsQuantity(),
                $orderOfTickets->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($orderOfTickets);

            $em->flush();
            $id = $orderOfTickets->getId();
            $mail = $orderOfTickets->getVisitor()->getEmail();

            $request->getSession()->getFlashBag()
                ->add('notice', 'Billet bien enregistré.');

//envoyer un e-mail de confirmation de commande
$mailer = $this->get('louvre.booking.mailer')->sendMessage($orderOfTickets);

            //Récupération du montant de la commande pour l'affichage sur la page de paiement
             $req = $this->getDoctrine()->getManager()
                            ->getRepository('LouvreBookingBundle:OrderOfTickets');
             $amount = $req->getAmount($id);

             // Récupération de la session
            $session = $request->getSession();
            $session->set('amount', $amount);

            return $this->render('LouvreBookingBundle:Booking:prepare.html.twig',
                array('amount' => $amount,
                      'email' => $mail));
        }

        return $this->render('LouvreBookingBundle:Booking:booking.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function prepareAction()
    {
        return $this->render('LouvreBookingBundle:Booking:prepare.html.twig');
    }

    /*
       /**
        * @Route(
        *     "/checkout",
        *     name="order_checkout",
        *     methods="POST"
        * )
        * @param Request $request
        * @return \Symfony\Component\HttpFoundation\RedirectResponse
        */
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkoutAction(Request $request)
    {
        // Récupération de la session
        $session = $request->getSession();
        $amount = ($session->get('amount')*100);

        $token = $_POST['stripeToken'];
        try {
            $stripeClient = $this->get('flosch.stripe.client');
            $stripeClient->createCharge($amount, 'eur', $token, null, 0, 'Votre paiement de billetterie');

            $this->addFlash("success", "paiement réussi");

            return $this->redirectToRoute("louvre_booking_home");

        } catch (\HttpRequestException $exception){
    var_dump($exception);

            $this->addFlash("error", "Votre paiement n'a pas abouti. 
                Merci de bien vouloir refaire un essai");

            return $this->redirectToRoute("louvre_booking_prepare");
        }

    }
}