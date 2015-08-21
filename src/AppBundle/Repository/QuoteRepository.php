<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Quote;

/**
 * QuoteRepository
 */
class QuoteRepository extends EntityRepository
{
    /**
     * @return null|Quote
     */
    public function getOneRandomQuote()
    {
        $count = $this->createQueryBuilder('q')
            ->select('COUNT(q)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->createQueryBuilder('q')
            ->setFirstResult(mt_rand(0, $count - 1))
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
            ;
    }
}
