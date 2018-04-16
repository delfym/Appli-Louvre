<?php

namespace Louvre\BookingBundle\Repository;

/**
 * OrderOfTicketsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderOfTicketsRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param $ticketDate
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countTickets($ticketDate)
    {
        $ticketDate = new \DateTime($ticketDate);
        $ticketDate = $ticketDate->format('Y-m-d');

        $ticketsNumber = $this->createQueryBuilder('o')
                ->select('COUNT(o.id)')
                ->where('o.ticketDate = :myDate')
                ->setParameter('myDate', $ticketDate)
                ->getQuery()->getSingleScalarResult();

        if($ticketsNumber <= 2) {
            return true;
        }
        return false;
    }
}
