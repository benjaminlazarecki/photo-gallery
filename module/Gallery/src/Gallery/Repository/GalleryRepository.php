<?php

namespace Gallery\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository of gallery object.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class GalleryRepository extends EntityRepository
{
    /**
     * Return all public gallery.
     *
     * @return array
     */
    public function getAllPublicGallery()
    {
        $qb = $this->createQueryBuilder('gallery');
        $qb
            ->addSelect('gallery, user, image')
            ->innerJoin('gallery.owner', 'user')
            ->leftJoin('gallery.images', 'image')
            ->andWhere('image.order IS NOT NULL')
            ->orderBy('image.order', 'ASC');

        return $qb->getQuery()->getResult();
    }
}

