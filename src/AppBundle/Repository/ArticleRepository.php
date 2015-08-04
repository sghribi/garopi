<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Article;

/**
 * Class ArticleRepository
 */
class ArticleRepository extends EntityRepository
{
    /**
     * @param int $nb
     *
     * @return Article[]
     */
    public function getLastArticlesWithCover($nb = 10)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.medias', 'am')
            ->where('am.media IS NOT NULL')
            ->groupBy('a.id')
            ->setMaxResults($nb);

        return $qb->getQuery()->getResult();
    }
}
