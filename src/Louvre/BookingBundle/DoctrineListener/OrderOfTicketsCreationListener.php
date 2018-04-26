<?php

/**
 * Created by PhpStorm.
 * User: delphinemillotpedrero
 * Date: 22/04/2018
 * Time: 22:58
 */

namespace Louvre\BookingBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Louvre\BookingBundle\Mailer\Mailer;
use Louvre\BookingBundle\Entity\OrderOfTickets;

class OrderOfTicketsCreationListener
{
    private $orderMailer;

    public function __construct(Mailer $mailer)
    {
        $this->orderMailer = $mailer;
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof OrderOfTickets) {
            return;
        }

        $this->orderMailer->sendMessage($entity);
    }

}
