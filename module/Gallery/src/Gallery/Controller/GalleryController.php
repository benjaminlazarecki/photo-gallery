<?php

namespace Gallery\Controller;

use Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\Session\Container;

use Gallery\Entity\Image,
    Gallery\Form\ImageForm,
    Gallery\Form\UpdateImageForm,
    Gallery\Form\ImageFormValidator;

/**
 * Controller of gallery.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class GalleryController extends AbstractActionController
{
    /**
     * @var \Zend\Session\Container
     */
    protected $userSession;

    /**
     * @var \Doctrine\ORM\EntityManager
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
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Return the user session container.
     *
     * @return \Zend\Session\Container
     */
    public function getUserSession()
    {
        if ($this->userSession === null) {
            $this->userSession = new Container('user');
        }

        return $this->userSession;
    }

    /**
     * Display a gallery
     *
     * @return array
     */
    public function showAction()
    {
        $em = $this->getEntityManager();

        $username = $this->getEvent()->getRouteMatch()->getParam('username');

        if ($username === null) {
            return $this->redirect()->toRoute('gallery');
        }

        $owner = $this->em->getRepository('User\Entity\User')->findOneByUsername($username);

        if ($owner === null) {
            return $this->redirect()->toUrl($_SERVER['HTTP_REFERER']);
        }

        $user = null;
        if ($this->getUserSession()->offsetExists('user')) {
            $user = $this->getEntityManager()->getRepository('User\Entity\User')
                ->find($this->getUserSession()->offsetGet('user')->getId());

            $images = $em->getRepository('Gallery\Entity\Image')->findBy(
                array('gallery' => $user->getGallery()),
                array('order' => 'ASC')
            );

            if (empty($images)) {
                $message = sprintf('Your gallery is empty. You can add some images to your gallery by following link on the top page!');
                $this->flashMessenger()->setNamespace('info')->addMessage($message);
            }
        } else {
            $images = $this->getEntityManager()->getRepository('Gallery\Entity\Image')->getImages($owner->getGallery());
        }

        $allGallery = $this->getEntityManager()->getRepository('Gallery\Entity\Gallery')->getAllPublicGallery();

        $view = new ViewModel();
        $view
            ->setTemplate('gallery/gallery/index')
            ->setVariable('randomGallery', $owner->getGallery())
            ->setVariable('images', $images)
            ->setVariable('allGallery', $allGallery)
            ->setVariable('owner', $owner)
            ->setVariable('user', $user);

        return $view;
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
        $images = $this->getEntityManager()->getRepository('Gallery\Entity\Image')->getImages($randomGallery);

        return array(
            'randomGallery' => $randomGallery,
            'allGallery'    => $allGallery,
            'images'        => $images,
        );
    }
}
