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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingController extends Controller {

    private $tickets;

    public function indexAction(){
        $content = $this->get('templating')->render('LouvreBookingBundle:Booking:index.html.twig',
                array(
                    'titre_page'=>'Musée du Louvre'
                ));
        return new Response($content);
    }

    public function updateAction(Request $request){
        if ($request->isXmlHttpRequest()){
            $rateChoice = $this->get('louvre_booking.ratechoice');
            $rate = $rateChoice->rate($_POST["birthDay"]);

            return new JsonResponse($rate);
        }
    }

    public function bookingAction(Request $request) {

        $orderOfTickets = new OrderOfTickets();
        $this->tickets = $orderOfTickets;

        $form = $this->get('form.factory')
                     ->create(OrderOfTicketsType::class, $orderOfTickets);

        /**************  requête POST  *********/
        if ($request->isMethod('POST')
            && $form->handleRequest($request)
                    ->isValid()) {

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

            $request->getSession()->getFlashBag()
                    ->add('notice', 'Billet bien enregistré.');

            //envoyer un e-mail de confirmation de commande

            return $this->redirectToRoute('louvre_booking_page');
        }

        return $this->render('LouvreBookingBundle:Booking:booking.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function prepareAction($chargeAmount, $chargeCurrency, $stripeAccountId, $applicationFee, $chargeDescription, $paymentToken) {
        $stripeClient = $this->get('my.stripe.client');
        $paymentToken = $_POST['stripeToken'];
        $stripeClient->createCharge($chargeAmount, $chargeCurrency,
            $paymentToken, $applicationFee, $chargeDescription);

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
     public function checkoutAction(Request $request)
     {
 // Set your secret key: remember to change this to your live secret key in production
 // See your keys here: https://dashboard.stripe.com/account/apikeys
     //    \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

        // $stripeClient = $this->get('flosch.stripe.client');
         $stripeClient = $this->get('my.stripe.client', $request);
         if ($request->isMethod(POST)){

         }
         /**
          * $chargeAmount (int)              : The charge amount in cents, for instance 1000 for 10.00 (of the currency)
          * $chargeCurrency (string)         : The charge currency (for instance, "eur")
          * $paymentToken (string)           : The payment token obtained using the Stripe.js library
          * $stripeAccountId (string|null)   : (optional) The connected string account ID, default null (--> charge to the platform)
          * $applicationFee (int)            : The amount of the application fee (in cents), default to 0
          * $chargeDescription (string)      : (optional) The charge description for the customer
          */
       //  $stripeClient->createCharge($chargeAmount, 'eur', $paymentToken, $applicationFee, $chargeDescription);
 // Token is created using Checkout or Elements!
 // Get the payment token ID submitted by the form:

     }

}