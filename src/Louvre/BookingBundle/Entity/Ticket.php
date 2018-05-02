<?php

namespace Louvre\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Louvre\BookingBundle\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
    /**
     * @ORM\OneToOne(targetEntity="Visitor",
    cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $visitor;

    /**
     * @ORM\ManyToOne(targetEntity="OrderOfTickets",
    inversedBy="tickets")
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
     * @param float $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set visitor.
     *
     * @param \Louvre\BookingBundle\Entity\Visitor $visitor
     *
     * @return Ticket
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

    /**
     * Set orderOfTickets.
     *
     * @param OrderOfTickets $orderOfTickets
     *
     * @return Ticket
     */
    public function setOrderOfTickets(OrderOfTickets $orderOfTickets)
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
}
