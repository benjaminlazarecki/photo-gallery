<?php

namespace Gallery\Controller;

use Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController;

/**
 * Controller of gallery.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class GalleryController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Set the entity manager.
     *
     * EntityManager is set on bootstrap.
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get the entity manager
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Display a gallery
     *
     * @param $username
     *
     * @return array
     */
    public function showAction($username)
    {
        $owner = $this->getEntityManager()->getRepository('Album\Entity\Album')->findOneByUserName($username);

        return array(
            'owner' => $owner,
        );
    }
}
