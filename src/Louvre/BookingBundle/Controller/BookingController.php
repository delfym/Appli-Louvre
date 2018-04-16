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

    public function availableTicketsAction(Request $request){
        if($request->isXmlHttpRequest()){
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('LouvreBookingBundle:OrderOfTickets');
            $available = $repository->countTickets($_POST["visitDate"]);
            return new JsonResponse($available);
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
            $request->getSession()->getFlashBag()
                    ->add('notice', 'Billet bien enregistré.');

            //envoyer un e-mail de confirmation de commande

            return $this->redirectToRoute('louvre_booking_page');
        }

        return $this->render('LouvreBookingBundle:Booking:booking.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function prepareAction() {
        $stripeClient = $this->get('my.stripe.client');
        $this->get('flosch_stripe', 'sk_test_w6uF3kR1ABIF0p4wkk0evG8E');
        //$key = $stripeClient->stripeApiKey;
        $amount = "1000";

        return $this->render('LouvreBookingBundle:Booking:prepare.html.twig', ['key'=>$key,'amount' => $amount]);
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
         //var_dump($request);
         try {
             $stripeClient = $this->get('my.stripe.client');
             $paymentToken = $_POST['stripeToken'];

             $stripeClient->createCharge($request);
// die();
             $this->addFlash("paiement réussi", "paiement réussi  :-)");
         } catch (\Stripe\Error\Card $e) {
             $this->addFlash("error", "Snif ça marche pas :(");

             return $this->redirectToRoute("prepare");
         }

     }



}