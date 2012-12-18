<?php

namespace User\Controller;

use Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController;

use User\Form\RegisterForm,
    User\Entity\User,
    User\Filter\RegisterFilter;

/**
 * Register controller.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class RegisterController extends AbstractActionController
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
     * Register a user.
     *
     * @return array
     */
    public function registerAction()
    {
        $form = new RegisterForm();
        $form->get('submit')->setAttribute('label', 'Register');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            $form->setInputFilter(new RegisterFilter($this->getEntityManager()));
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->populate($form->getData());

                $password = $user->generatePassword();
                $user->setPlainPassword($password);

                $this->getEntityManager()->persist($user->getGallery());
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage('Thank you for your registration!');

                return $this->redirect()->toRoute('gallery');
            }
        }

        return array(
            'form'          => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'noDisplayWell' => true,
        );
    }
}

