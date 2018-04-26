<?php
/**
 * Created by PhpStorm.
 * User: delphinemillotpedrero
 * Date: 20/04/2018
 * Time: 07:23
 */

namespace Louvre\BookingBundle;


class ClientMail
{
    public function sendMail($name, \Swift_Mailer $mailer) {
        $message = (new \Swift_Message('le corps du message'))
            ->setFrom('delfymillot@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'Emails/registration.html.twig',
                    ['name' => $name]
            ),
        'text/html');

        $mailer->send($message);
        return $this->render('louvre_booking_home');
    }
}