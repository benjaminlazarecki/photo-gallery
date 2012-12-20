<?php

namespace Gallery\Controller;

use Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\Validator\File\Size;

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
        // TODO Get the user

        $form = new ImageForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $image = new Image();
            $form->setInputFilter(new ImageFormValidator());

            $nonFile = $request->getPost()->toArray();
            $File    = $this->params()->fromFiles('fileupload');
            $data = array_merge(
                 $nonFile,
                 array('fileupload'=> $File['name'])
             );

            $form->setData($data);
            if ($form->isValid()) {

                $size = new Size(array('max'=>2000000));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);

                if (!$adapter->isValid()) {

                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach($dataError as $key=>$row)
                    {
                        $error[] = $row;
                    }
                    $form->setMessages(array('file'=> $error));
                } else {
                    $config = $this->getServiceLocator()->get('Config');
                    $uploadPath = $config['photo-gallery']['upload_path'];
                    $adapter->setDestination(getcwd() . $uploadPath);
                    if ($adapter->receive($File['name'])) {
                        echo 'ok';
                    }
                }

                $image->populate($form->getData());
                $image->setGallery($owner->getGallery());
                $owner->getGallery()->addImage($image);

                $this->getEntityManager()->flush();

                // TODO Add redirct to owner gallery
            }
        }

        return array(
            'form'          => $form,
        );
    }
}

