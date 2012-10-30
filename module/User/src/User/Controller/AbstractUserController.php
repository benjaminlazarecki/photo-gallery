<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

/**
 * This class should be extends by all user class.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
abstract class AbstractUserController extends AbstractActionController
{
    /** @var \User\Model\UserTable */
    protected $userTable;

    /** @var \Zend\Session\Container */
    protected $session;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->session = new Container();
    }

    /**
     * Return the session.
     *
     * @return \Zend\Session\Container
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Return a user table.
     *
     * @return \User\Model\UserTable
     */
    protected function getUserTable()
    {
        if (!isset($this->userTable)) {
            $this->userTable = $this->getServiceLocator()->get('User\Model\UserTable');
        }

        return $this->userTable;
    }
}
