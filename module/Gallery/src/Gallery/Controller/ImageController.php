<?php

namespace Gallery\Controller;

use Doctrine\ORM\EntityManager;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\Session\Container;

use Gallery\Entity\Image,
    Gallery\Form\ImageForm,
    Gallery\Form\UpdateImageForm,
    Gallery\Form\ImageFormValidator;

/**
 * Controller of image.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class ImageController extends AbstractActionController
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
     * The image add page.
     *
     * @return array
     */
    public function addAction()
    {
        $isXmlHttpRequest = $this->request->isXmlHttpRequest();

        $viewmodel = new ViewModel();
        $viewmodel->setTerminal($isXmlHttpRequest);
        $viewmodel->setTemplate('gallery/gallery/add');

        $user = $this->getUserSession()->offsetGet('user');
        $owner = $this->getEntityManager()->getRepository('User\Entity\User')->find($user->getId());

        $form = new ImageForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $image = new Image();

            $form->setInputFilter(new ImageFormValidator($this->getEntityManager()));

            $data = $request->getPost()->toArray();

            $filePost = $this->params()->fromFiles('file');
            $file = array('file' => $filePost['name']);

            $data = array_merge($data, $file);

            $form->setData($data);

            if ($form->isValid()) {
                list($width, $height, $type, $attr) = getimagesize($this->params()->fromFiles('file')['tmp_name']);

                $image->populate($form->getData());
                $image
                    ->setFile($this->params()->fromFiles('file'))
                    ->setName($this->params()->fromFiles('file')['name'])
                    ->setWidth($width)
                    ->setHeight($height)
                    ->setGallery($owner->getGallery());

                $owner->getGallery()->addImage($image);

                $this->getEntityManager()->flush();

                $message = sprintf('%s was succesfully added to your gallery!', $image->getName());
                $this->flashMessenger()->setNamespace('success')->addMessage($message);

                return $this->redirect()->toUrl($_SERVER['HTTP_REFERER']);
            }
        }

        $viewmodel->setVariable('form', $form);

        return $viewmodel;
    }

    /**
     * Edit an image.
     *
     * @return void
     */
    public function editAction()
    {
        $image = $this->init();

        if ($image === null) {
            return null;
        }

        $entityManager = $this->getEntityManager();

        $image->setOrder($this->params()->fromPost('order'));
        $entityManager->flush();

        $message = sprintf('%s was successfully update!', $image->getName());
        $this->flashMessenger()->setNamespace('success')->addMessage($message);

        return $this->redirect()->toUrl($_SERVER['HTTP_REFERER']);
    }

    /**
     * Remove an image.
     *
     * @return void
     */
    public function removeAction()
    {
        $image = $this->init();

        if ($image === null) {
            return null;
        }

        $entityManager = $this->getEntityManager();

        $entityManager->remove($image);
        $entityManager->flush();

        $message = sprintf('%s was successfully deleted!', $image->getName());
        $this->flashMessenger()->setNamespace('success')->addMessage($message);

        return $this->redirect()->toUrl($_SERVER['HTTP_REFERER']);
    }

    /**
     * init
     *
     * @return null|Image
     */
    private function init()
    {
        $id = $this->params()->fromPost('id');

        $entityManager = $this->getEntityManager();

        $user = $this->getUserSession()->offsetGet('user');

        if ($user === null) {
            return;
        }

        $user = $this->getEntityManager()->getRepository('User\Entity\User')->find($user->getId());

        $image = $entityManager->getRepository('Gallery\Entity\Image')->findOneBy(array(
            'id'      => $id,
            'gallery' => $user->getGallery(),
        ));

        if ($image === null) {
            return;
        }

        return $image;
    }
}

