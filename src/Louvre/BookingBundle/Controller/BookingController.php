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
        /*$content = $this->get('templating')
                        ->render('LouvreBookingBundle:Booking:booking.html.twig'
            );
        return new Response($content); */

        $orderOfTickets = new OrderOfTickets();

        $form = $this->get('form.factory')
                     ->create(OrderOfTicketsType::class, $orderOfTickets);

        if ($request->isMethod('POST')
            && $form->handleRequest($request)
                    ->isValid()) {
        var_dump(($request));
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderOfTickets);
            $em->flush();

            $request->getSession()->getFlashBag()
                    ->add('notice', 'Billet bien enregistré.');

            return $this->redirectToRoute('louvre_booking_page', array(
                    'id' => $orderOfTickets->getId()));
        }

        return $this->render('LouvreBookingBundle:Booking:booking.html.twig', array(
            'form' => $form->createView(),
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