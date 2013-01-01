<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\Session\Container,
    Doctrine\ORM\EntityManager;

/**
 * Admin controller.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class AdminController extends AbstractActionController
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
     * The action action.
     *
     * @return array
     */
    public function listAction()
    {
        $user = $this->getUserSession()->offsetGet('user');

        if (!$user->isAdmin()) {
            return $this->getResponse()->setStatusCode(403);
        }

        $users = $this->getEntityManager()->getRepository('User\Entity\User')->getAllUserForAdmin();

        return array(
            'users' => $users,
        );
    }

    /**
     * Remove a user.
     *
     * @return mixed
     */
    public function removeAction()
    {
        $user = $this->getUserSession()->offsetGet('user');

        if (!$user->isAdmin()) {
            return $this->getResponse()->setStatusCode(403);
        }

        $username = $this->params()->fromRoute('username');

        /* @var \User\Entity\User $user */
        $user = $this->getEntityManager()->getRepository('User\Entity\User')->findOneByUsername($username);

        if ($user !== null) {
            $this->getEntityManager()->remove($user);
            $this->getEntityManager()->flush();

            $message = sprintf('User %s was successfully deleted', $user->getUsername());
            $this->flashMessenger()->setNamespace('success')->addMessage($message);
        } else {
            $message = sprintf('User %s does not exist!', $username);
            $this->flashMessenger()->setNamespace('error')->addMessage($message);
        }

        return $this->redirect()->toRoute('admin');
    }

	/**
	 * Unblock a user.
	 *
	 * @return mixed
	 */
    public function unblockAction()
    {
        $user = $this->getUserSession()->offsetGet('user');

        if (!$user->isAdmin()) {
            return $this->getResponse()->setStatusCode(403);
        }

        $username = $this->params()->fromRoute('username');

        /* @var \User\Entity\User $user */
        $user = $this->getEntityManager()->getRepository('User\Entity\User')->findOneByUsername($username);

        if ($user !== null) {
			$user
				->setEnable(true)
				->resetAttempt();

            $this->getEntityManager()->flush();

            $message = sprintf('User %s was successfully unblock', $user->getUsername());
            $this->flashMessenger()->setNamespace('success')->addMessage($message);
        } else {
            $message = sprintf('User %s does not exist!', $username);
            $this->flashMessenger()->setNamespace('error')->addMessage($message);
        }

        return $this->redirect()->toRoute('admin');
    }
}
