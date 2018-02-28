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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookingController extends Controller {

    public function indexAction(){
        $content = $this->get('templating')->render('LouvreBookingBundle:Booking:index.html.twig',
                array(
                    'titre_page'=>'Musée du Louvre'
                ));
        return new Response($content);
    }

    public function bookingAction() {
        /*$content = $this->get('templating')
                        ->render('LouvreBookingBundle:Booking:booking.html.twig'
            );
        return new Response($content); */
        $ticket = new Ticket();
        $orderOfTickets = new OrderOfTickets();
        $visitor = new Visitor();

        $formBuilder = $this->get('form.factory')
            ->createBuilder(FormType::class, $ticket);
        $formBuilder
            ->add('ticketDate', DateType::class)
            ->add('ticketType', ChoiceType::class)
            ->add('save',       SubmitType::class);

        $form = $formBuilder->getForm();

        return $this->render('LouvreBookingBundle:Booking:booking.html.twig', array(
            'form' => $form->createView(),
        ));


        //créer un form commande avec des relations v
        //ers les 2 autres entités
        // et permettre leur appel
    }

    public function addAction(Request $request) {
        $ticket = new Ticket();
    //    $orderOfTickets = new OrderOfTickets();
    //    $visitor = new Visitor();

        $formBuilder = $this->get('form.factory')
                            ->createBuilder(FormType::class, $ticket);
        $formBuilder
            ->add('ticketDate', DateType::class)
            ->add('ticketType', ChoiceType::class)
            ->add('save',       SubmitType::class);

        $form = $formBuilder->getForm();

        return $this->render('LouvreBookingBundle:Booking:add.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}