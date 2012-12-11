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
    public function getAllPublicGallery()
    {
        $qb = $this->createQueryBuilder('gallery');
        $qb
            ->addSelect('gallery, user, image')
            ->innerJoin('gallery.owner', 'user')
            ->leftJoin('gallery.images', 'image')
            ->andWhere('image.public = true');

        return $qb->getQuery()->getResult();
    }
}
