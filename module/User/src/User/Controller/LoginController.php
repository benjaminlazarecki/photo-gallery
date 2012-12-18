<?php

namespace User\Controller;

use Zend\Session\Container,
    Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController;

/**
 * Login controller.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class LoginController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var Zend\Session\Container
     */
    protected $userSession;

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
     * Login action.
     *
     * @return mixed
     */
    public function loginAction()
    {
        $login = $this->params()->fromPost('login');
        $password = $this->params()->fromPost('password');

        $user = $this->getEntityManager()->getRepository('User\Entity\User')->findOneBy(array(
            'username' => $login,
            'password' => sha1($password),
        ));

        if ($user === null) {
            $message = 'Wrong login or password!';

            return array(
                'flashMessages' => array($message),
                'flashError'    => true,
            );
        }

        $this->getUserSession()->offsetSet('user', $user);

        $message = 'Your are logged in!';
        $this->flashMessenger()->addMessage($message);

        return $this->redirect()->toRoute('gallery-show', array('username' => $user->getUsername()));
    }

    /**
     * Lougout a user.
     *
     * @return mixed
     */
    public function logoutAction()
    {
        $userSession = $this->getUserSession()->offsetGet('user');

        if ($userSession !== null) {
            $this->getUserSession()->offsetUnset('user');
        }

        $message = 'Your are logged out!';
        $this->flashMessenger()->addMessage($message);

        return $this->redirect()->toRoute('gallery');
    }
}
