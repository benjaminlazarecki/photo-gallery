<?php

namespace Gallery\Controller;

use Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\Session\Container;

use Gallery\Entity\Image,
    Gallery\Form\ImageForm,
    Gallery\Form\ImageFormValidator;

/**
 * Controller of gallery.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class GalleryController extends AbstractActionController
{
    /**
     * @var Zend\Session\Container
     */
    protected $userSession;

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
     * Return the user session container.
     *
     * @return Zend\Session\Container
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
        $username = $this->getEvent()->getRouteMatch()->getParam('username');

        if ($username === null) {
            return $this->redirect()->toRoute('gallery');
        }

        $owner = $this->getEntityManager()->getRepository('User\Entity\User')->findOneByUsername($username);

        if ($owner === null) {
            return $this->redirect()->toRoute('login');
        }

        return array(
            'owner'         => $owner,
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
            'allGallery'    => $allGallery,
        );
    }

    /**
     * The image add page.
     *
     * @return array
     */
    public function addAction()
    {
        $user = $this->getUserSession()->offsetGet('user');
        $owner = $this->getEntityManager()->getRepository('User\Entity\User')->find($user->getId());

        $form = new ImageForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $image = new Image();

            $form->setInputFilter(new ImageFormValidator($this->getEntityManager()));

            $data = $request->getPost()->toArray();

            $filePost = $this->params()->fromFiles('file');
            $file = array('file'=> $filePost['name']);

            $data = array_merge($data, $file);

            $form->setData($data);

            if ($form->isValid()) {

                $image->populate($form->getData());
                $image->setFile($this->params()->fromFiles('file'));
                $image->setGallery($owner->getGallery());
                $owner->getGallery()->addImage($image);

                $this->getEntityManager()->flush();

                $this->redirect()->toRoute('gallery');
            }
        }

        return array(
            'form' => $form,
        );
    }
}

