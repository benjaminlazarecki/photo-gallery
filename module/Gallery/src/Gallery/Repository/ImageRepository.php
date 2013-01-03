<?php

namespace Gallery\Repository;

use Doctrine\ORM\EntityRepository;

use Gallery\Entity\Gallery;

/**
 * Repository of image object.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class ImageRepository extends EntityRepository
{
    /**
     * Gets gallery image for index and show.
     *
     * @param \Gallery\Entity\Gallery $gallery
     *
     * @return array
     */
    public function getImages(Gallery $gallery)
    {
        $qb = $this->createQueryBuilder('image');

        $qb
            ->andWhere('image.order IS NOT NULL')
            ->andWhere('image.gallery = :gallery')
            ->setParameter('gallery', $gallery)
            ->orderBy('image.order');

        return $qb->getQuery()->getResult();
    }
}
