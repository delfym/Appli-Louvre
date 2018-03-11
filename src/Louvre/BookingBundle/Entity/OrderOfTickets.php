<?php

namespace Louvre\BookingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="ticketsQuantity", type="smallint")
     */
    private $ticketsQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=6, scale=2)
     */
    private $amount;


    /**
     * @ORM\OneToMany(targetEntity="Louvre\BookingBundle\Entity\Ticket",
     *     mappedBy="orderOfTickets")
     */
    private $tickets;

    public function __construct()
    {
        $this->purchaseDate = new \DateTime();
        $this->tickets = new ArrayCollection();
    }

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

    /**
     * Set ticketsQuantity.
     *
     * @param int $ticketsQuantity
     *
     * @return OrderOfTickets
     */
    public function setTicketsQuantity($ticketsQuantity)
    {
        $this->ticketsQuantity = $ticketsQuantity;

        return $this;
    }

    /**
     * Get ticketsQuantity.
     *
     * @return int
     */
    public function getTicketsQuantity()
    {
        return $this->ticketsQuantity;
    }


    /**
     * Add ticket.
     *
     * @param \Louvre\BookingBundle\Entity\Ticket $ticket
     *
     * @return OrderOfTickets
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setOrderOfTickets($this);

        return $this;
    }

    /**
     * Remove ticket.
     *
     * @param \Louvre\BookingBundle\Entity\Ticket $ticket
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTicket(Ticket $ticket)
    {
        return $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
