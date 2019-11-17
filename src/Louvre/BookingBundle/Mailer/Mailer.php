<?php
/**
 * Created by PhpStorm.
 * User: delphinemillotpedrero
 * Date: 20/04/2018
 * Time: 07:23
 */

namespace Louvre\BookingBundle\Mailer;


use Louvre\BookingBundle\Entity\OrderOfTickets;
use Symfony\Component\Templating\EngineInterface;
use Doctrine\ORM\EntityManager;

class Mailer
{
    private $mailer;
    private $templating;
    private $em;


    /**
     * Mailer constructor.
     * @param $mailer
     * @param EngineInterface $templating
     * @param $doctrine
     */
    public function __construct($mailer, EngineInterface $templating, $doctrine)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->em = $doctrine;
    }

    /**
     * @param OrderOfTickets $orderOfTickets
     */
    public function sendMessage(OrderOfTickets $orderOfTickets)
    {
        $message = new \Swift_Message(
            'Validation de votre commande de billetterie'
        );

        $template = 'LouvreBookingBundle:Booking:validationMail.html.twig';
        $orderId = $orderOfTickets->getId();
        $orderHolder = $orderOfTickets->getVisitor()->getId();

        $req = $this->em->getRepository('LouvreBookingBundle:Ticket');
        $tickets = $req->getTickets($orderId, $orderHolder);
        $data ['image_src'] = $message->embed(\Swift_Image:: fromPath(
            'Public/images/logoMail.png'));

        $message
            ->setTo($orderOfTickets->getVisitor()->getEmail())
            ->setFrom(['louvre-accueil@gmail.com' => 'Billetterie du Louvre'])
            ->setContentType('text/html')
            ->setCharset('UTF-8')
            ->setBody(
                $this->templating->render($template,
                    [
                        'name' => $orderOfTickets->getVisitor()->getName(),
                        'firstName' => $orderOfTickets->getVisitor()->getFirstName(),
                        'visitDate' => $orderOfTickets->getTicketDate(),
                        'amount' => $orderOfTickets->getAmount(),
                        'bookingCode' => $orderOfTickets->getBookingCode(),
                        'tickets' => $tickets,
                        'image_src' => $data ['image_src']
                    ])
            );
        $this->mailer->send($message);
    }

}