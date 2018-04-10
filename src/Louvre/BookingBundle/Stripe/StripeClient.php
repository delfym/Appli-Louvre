<?php
/**
 * Created by PhpStorm.
 * User: delphinemillotpedrero
 * Date: 10/04/2018
 * Time: 17:44
 */

namespace Louvre\BookingBundle\Stripe;

use Flosch\Bundle\StripeBundle\Stripe\StripeClient as BaseStripeClient;

class StripeClient extends BaseStripeClient
{
    public function __construct($stripeApiKey = 'sk_test_w6uF3kR1ABIF0p4wkk0evG8E')
    {
        parent::__construct($stripeApiKey);

        return $this;
    }
/*
    public function checkout($_POST)
    {         /**
     * $chargeAmount (int)              : The charge amount in cents, for instance 1000 for 10.00 (of the currency)
     * $chargeCurrency (string)         : The charge currency (for instance, "eur")
     * $paymentToken (string)           : The payment token obtained using the Stripe.js library
     * $stripeAccountId (string|null)   : (optional) The connected string account ID, default null (--> charge to the platform)
     * $applicationFee (int)            : The amount of the application fee (in cents), default to 0
     * $chargeDescription (string)      : (optional) The charge description for the customer
     */
 /*       $token = $_POST['stripeToken'];
        try {
            $charge = \Stripe\Charge::create([
                'amount' => 999, //faire une req sur la commande
                'currency' => 'eur',
                'description' => 'Votre paiement Stripe',
                'source' => $token,
            ]);
            $this->addFlash("paiement réussi", "paiement réussi  :-)");
        } catch (\Stripe\Error\Card $e) {
            $this->addFlash("error", "Snif ça marche pas :(");
            return $this->redirectToRoute("prepare");
            // The card has been declined
        }
    }  */
}