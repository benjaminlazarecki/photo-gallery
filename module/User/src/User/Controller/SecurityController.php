<?php

namespace User\Controller;

use Zend\View\Model\ViewModel;
use Zend\Session\Container;

use User\Model\User;
use User\Form\LoginForm;

/**
 * {@inheritdoc}
 *
 * Represent the security. This class manage authentification.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class SecurityController extends AbstractUserController
{
    /**
     * Allow user to connect on the application.
     *
     * @return array|\Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        // TODO: move block process in service with event.
        $this->getSession()->count = !isset($this->getSession()->count) ? 0 : $this->getSession()->count;

        if ($this->getSession()->count >= 3) {
            $now = new \DateTime();
            $this->getSession()->blockAt = !isset($this->getSession()->blockAt) ? $now : $this->getSession()->blockAt;

            $diff = $now->diff($this->getSession()->blockAt);

            // if it's been 1 minute.
            if ($diff->i >= 1) {
                $this->getSession()->count = 0;
                unset($this->getSession()->blockAt);
            } else {
                $view = new ViewModel(array('ttw' => 60 - $diff->s));
                $view->setTemplate('user/security/block.phtml');

                return $view;
            }
        }
        // TODO: to move

        $form = new LoginForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($this->getServiceLocator()->get('login_filter'));
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user = new User();

                /** @var \User\Model\UserTable $userTable  */
                $userTable = $this->getUserTable();
                $user = $userTable->getUserByEmailAndPassword($form->getData()['email'], md5($form->getData()['password']));

                if ($user === false) {
                    $this->getSession()->count = $this->getSession()->count + 1;

                    $this->flashMessenger()->addMessage('Wrong email or password');
                    return $this->redirect()->toRoute('login');
                }

                $this->flashMessenger()->addMessage(sprintf('Hello %s', $user->getUsername()));
                return $this->redirect()->toRoute('login');
            }
        }

        return array(
            'form'          => $form,
            'count'         => $this->getSession()->count,
            'flashMessages' => $this->flashMessenger()->getMessages()
        );
    }
}