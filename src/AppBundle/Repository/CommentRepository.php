<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Comment;

/**
 * CommentRepository
 */
class CommentRepository extends EntityRepository
{
    /**
     * @param null|int $numberOfComments
     * 
     * @return null|Comment
     */
    public function getLastComments($numberOfComments = 3)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.article', 'a')
            ->where('a.published = true')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($numberOfComments)
            ->getQuery()
            ->getResult()
            ;
    }
}
