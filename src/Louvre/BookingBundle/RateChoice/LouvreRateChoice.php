<?php
/**
 * Created by PhpStorm.
 * User: delphinemillotpedrero
 * Date: 31/03/2018
 * Time: 19:20
 */

namespace Louvre\BookingBundle\RateChoice;


use Symfony\Component\Validator\Constraints\DateTime;

class LouvreRateChoice
{
    /*
     * définit le tarif applicable
     *
     * @param datetime $birthdate
     * @return float
     */

    public function rate($myDate) {
       if(is_string($myDate)){
           $myDate = new \DateTime($myDate);
       }
        $age = $this->testDates($myDate);

        if ($age >= 60) {
            $price = 12;
        } elseif ($age >= 12) {
            $price = 16;
        } elseif ($age >= 4) {
            $price = 8;
        } else {
            $price = 0;
        }
        return $price;
    }

    public function testDates($myDate){
        $today = new \DateTime();
        $diff = $today->diff($myDate);
        return $diff->format('%y years');
    }
}

