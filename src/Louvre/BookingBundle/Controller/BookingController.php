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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingController extends Controller {

    public function indexAction(){
        $content = $this->get('templating')->render('LouvreBookingBundle:Booking:index.html.twig',
                array(
                    'titre_page'=>'Musée du Louvre'
                ));
        return new Response($content);
    }

    public function bookingAction(Request $request) {

        $orderOfTickets = new OrderOfTickets();

        $form = $this->get('form.factory')
                     ->create(OrderOfTicketsType::class, $orderOfTickets);

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

    public function addAction(Request $request) {
      //  $ticket = new Ticket();
        $orderOfTickets = new OrderOfTickets();
    //    $visitor = new Visitor();


        $form = $this->get('form.factory')
            ->create(OrderOfTicketsType::class, $orderOfTickets);

        $form
            ->add('ticketDate', DateType::class)
            ->add('ticketType', ChoiceType::class)
            ->add('save',       SubmitType::class);

        $form = $form->getForm();

        return $this->render('LouvreBookingBundle:Booking:add.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}