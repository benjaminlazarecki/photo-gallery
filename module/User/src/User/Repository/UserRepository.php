<?php

namespace User\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class UserRepository extends EntityRepository
{
    /**
     * Return all user.
     *
     * @return array
     */
    public function getAllUserForAdmin()
    {
        $qb = $this->createQueryBuilder('user');
        $qb->andWhere('user.admin != 1');

        return $qb->getQuery()->getResult();
    }
}