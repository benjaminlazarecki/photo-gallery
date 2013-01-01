<?php

namespace User\Controller;

use Zend\Session\Container,
    Doctrine\ORM\EntityManager,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\View\Model\JsonModel;

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
        $isXmlHttpRequest = $this->request->isXmlHttpRequest();

        $username = $this->params()->fromPost('login');
        $password = $this->params()->fromPost('password');

        $viewmodel = new ViewModel();
        $viewmodel->setTerminal($isXmlHttpRequest);

        /* @var \User\Entity\User $user */
        $user = $this->getEntityManager()->getRepository('User\Entity\User')->findOneBy(array(
            'username' => $username,
            'password' => sha1($password),
        ));

        $isDisable = $this->getEntityManager()->getRepository('User\Entity\User')->findOneBy(array(
            'username' => $username,
            'enable' => false,
        ));

        if ($isDisable) {
            return $this->handleDisableAccount($viewmodel);
        }

        if ($user === null) {
            $attempts = $this->addAttempt($username);

            if ($attempts === 'disable') {
                return $this->handleDisableAccount($viewmodel);
            }

            $message = 'Wrong login or password!';

            $viewmodel->setVariables(array(
                'errors'   => $message,
                'attempts' => $attempts,
            ));

            return $viewmodel;
        }

        $user->resetAttempt();
        $this->getEntityManager()->flush();

        $this->getUserSession()->offsetSet('user', $user);

        $jsonModel = new JsonModel();

        $message = 'Your are logged in!';
        $this->flashMessenger()->setNamespace('success')->addMessage($message);

        $router = $this->getEvent()->getRouter();
        if ($user->isAdmin()) {
            $jsonModel->setVariable('redirect', $router->assemble(
                array('username' => $user->getUsername()),
                array('name' => 'admin')
            ));

            error_reporting(0);
            // That kill kitty but i have an strange error :
            //Unknown: &quot;id&quot; returned as member variable from __sleep() but does not exist in Unknown on line 0

            return $jsonModel;
        }

        $jsonModel->setVariable('redirect', $router->assemble(
            array('username' => $user->getUsername()),
            array('name' => 'gallery-show')
        ));

        error_reporting(0);

        return $jsonModel;
    }

    /**
     * Add an attempt.
     *
     * @param string $username
     *
     * @return int|null
     */
    protected function addAttempt($username)
    {
        /* @var \User\Entity\User $user */
        $user = $this->getEntityManager()->getRepository('User\Entity\User')->findOneBy(array(
            'username' => $username,
        ));

        if ($user !== null && !$user->isAdmin()) {
            if ($user->getAttempt() < 3) {
                $user->addAttempt();
                $this->getEntityManager()->flush();
            }

            if ($user->getAttempt() === 3) {
                $user->setEnable(false);
                $this->getEntityManager()->flush();
                return 'disable';
            }

            return $user->getAttempt();
        }

        return null;
    }

    /**
     * Factorize some code for disable account.
     *
     * @param ViewModel $viewmodel
     *
     * @return array
     */
    protected function handleDisableAccount(ViewModel $viewmodel)
    {
        $message = 'Sorry but your account is disable!';

        $viewmodel->setVariables(array('errors' => $message));

        return $viewmodel;
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
        $this->flashMessenger()->setNamespace('success')->addMessage($message);

        return $this->redirect()->toRoute('gallery');
    }
}
