<?php

namespace Louvre\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderOfTickets
 *
 * @ORM\Table(name="order_of_tickets")
 * @ORM\Entity(repositoryClass="Louvre\BookingBundle\Repository\OrderOfTicketsRepository")
 */
class OrderOfTickets
{
    /**
     * @ORM\OneToOne(targetEntity="Louvre\BookingBundle\Entity\Visitor", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $visitor;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="purchaseDate", type="datetime")
     */
    private $purchaseDate;

    /**
     * @var int
     *
     * @ORM\Column(name="ticketsNumber", type="smallint")
     */
    private $ticketsNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=6, scale=2)
     */
    private $amount;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set purchaseDate.
     *
     * @param \DateTime $purchaseDate
     *
     * @return OrderOfTickets
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate.
     *
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Set ticketsNumber.
     *
     * @param int $ticketsNumber
     *
     * @return OrderOfTickets
     */
    public function setTicketsNumber($ticketsNumber)
    {
        $this->ticketsNumber = $ticketsNumber;

        return $this;
    }

    /**
     * Get ticketsNumber.
     *
     * @return int
     */
    public function getTicketsNumber()
    {
        return $this->ticketsNumber;
    }

    /**
     * Set amount.
     *
     * @param string $amount
     *
     * @return OrderOfTickets
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return string
     */
    public function getAmount()
    {
       // $this->amount = 0;
      //  foreach (($this->getTicket))
        return $this->amount;
    }

    /**
     * Set visitor.
     *
     * @param \Louvre\BookingBundle\Entity\Visitor $visitor
     *
     * @return OrderOfTickets
     */
    public function setVisitor(Visitor $visitor)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor.
     *
     * @return \Louvre\BookingBundle\Entity\Visitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }
}
