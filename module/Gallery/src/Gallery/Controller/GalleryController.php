<?php

namespace Gallery\Controller;

use Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Gallery\Entity\Image;

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
     * @return array
     */
    public function showAction()
    {
        $username = $this->getEvent()->getRouteMatch()->getParam('username');

        if ($username !== null) {
            $owner = $this->getEntityManager()->getRepository('User\Entity\User')->findOneByUsername($username);
        } else {
            $owner = $this->getPluginManager()->get('zfcuserauthentication')->getIdentity();
        }

        if ($owner === null) {
            return $this->redirect()->toRoute('zfcuser', array('action' => 'login'));
        }

        return array(
            'owner' => $owner,
        );
    }

    /**
     * The homepage of the application.
     *
     * @return array|\Zend\View\Helper\ViewModel
     */
    public function indexAction()
    {
        $allGallery = $this->getEntityManager()->getRepository('Gallery\Entity\Gallery')->getAllPublicGallery();

        // If there is no gallery in the application, we display a message to user.
        if (empty($allGallery)) {
            $view = new ViewModel();
            $view->setTemplate('gallery/gallery/empty');

            return $view;
        }

        $randomGallery = $allGallery[rand(0, count($allGallery) - 1)];

        return array(
            'randomGallery' => $randomGallery,
            'allGallery'    => $allGallery
        );
    }

    /**
     * The image add page.
     *
     * @return array
     */
    public function addAction()
    {
        $owner = $this->getPluginManager()->get('zfcuserauthentication')->getIdentity();

        $form = new ImageForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $image = new Image();

            if ($form->isValid()) {
                $image->populate($form->getData());
                $owner->getGallery()->addImage($image);

                $this->getEntityManager()->flush();

                // TODO Add redirct to owner gallery
            }
        }

        return array('form' => $form);
    }
}

