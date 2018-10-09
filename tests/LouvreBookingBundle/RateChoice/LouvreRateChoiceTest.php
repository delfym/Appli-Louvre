<?php
/**
 * Created by PhpStorm.
 * User: delphinemillotpedrero
 * Date: 26/04/2018
 * Time: 15:56
 */

namespace Tests\LouvreBookingBundle\RateChoice;

use Louvre\BookingBundle\RateChoice\LouvreRateChoice;
use PHPUnit\Framework\TestCase;

class LouvreRateChoiceTest extends TestCase
{
    public function testTestDatesTypeDate(){
        $rate = new LouvreRateChoice();
        $result = $rate->testDates(new \DateTime('2016-04-26'));
        $this->assertSame('2 years' , $result);
    }

    public function testRate0(){
        $rate = new LouvreRateChoice();
        $result = $rate->rate('2016-04-26');
        $this->assertSame(0 , $result);
    }

    public function testRate8(){
        $rate = new LouvreRateChoice();
        $result = $rate->rate('2009-04-26');
        $this->assertSame(8 , $result);
    }

    public function testRate12(){
        $rate = new LouvreRateChoice();
        $result = $rate->rate('1934-04-26');
        $this->assertSame(12 , $result);
    }

    public function testRate16(){
        $rate = new LouvreRateChoice();
        $result = $rate->rate('2005-04-26');
        $this->assertSame(16 , $result);
    }
}