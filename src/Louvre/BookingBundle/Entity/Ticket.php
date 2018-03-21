<?php

namespace Louvre\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Louvre\BookingBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\OneToOne(targetEntity="Louvre\BookingBundle\Entity\Visitor", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $visitor;

    /**
     * @ORM\ManyToOne(targetEntity="Louvre\BookingBundle\Entity\OrderOfTickets",
     * inversedBy="tickets",
     * cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderOfTickets;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=4, scale=2)
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var boolean
     */
    private $reduction;

    /**
     *
     * @ORM\Column(name="ticketDate", type="datetime")
     *
     */
    private $ticketDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ticketType", type="string")
     * @Assert\NotBlank()
     */
    private $ticketType;



    public function __construct()
    {
       // $this->ticketDate = new \DateTime();
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
     * Set price.
     *
     * @param string $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        if(null != $this->reduction) {
            $this->price = $price - 10;
        } else {
            $this->price = $price;
        }
        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set ticketDate.
     *
     * @param \DateTime $ticketDate
     *
     * @return Ticket
     */
    public function setTicketDate($ticketDate)
    {
        $this->ticketDate = $ticketDate;
        //var_dump($this->ticketDate);
        return $this;
    }

    /**
     * Get ticketDate.
     *
     * @return \dateTime
     */
    public function getTicketDate()
    {
        return $this->ticketDate;
    }

    /**
     * Set ticketType.
     *
     * @param string $ticketType
     *
     * @return Ticket
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType.
     *
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    /**
     * Set visitor.
     *
     * @param \Louvre\BookingBundle\Entity\Visitor $visitor
     *
     * @return Ticket
     */
    public function setVisitor(\Louvre\BookingBundle\Entity\Visitor $visitor)
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
     * Set orderOfTickets.
     *
     * @param \Louvre\BookingBundle\Entity\OrderOfTickets $orderOfTickets
     *
     * @return Ticket
     */
    public function setOrderOfTickets(\Louvre\BookingBundle\Entity\OrderOfTickets $orderOfTickets)
    {
        $this->orderOfTickets = $orderOfTickets;

        return $this;
    }

    /**
     * Get orderOfTickets.
     *
     * @return \Louvre\BookingBundle\Entity\OrderOfTickets
     */
    public function getOrderOfTickets()
    {
        return $this->orderOfTickets;
    }

    /**
     * Set reduction.
     *
     * @param bool $reduction
     *
     * @return Ticket
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * Get reduction.
     *
     * @return bool
     */
    public function getReduction()
    {
        return $this->reduction;
    }
}
