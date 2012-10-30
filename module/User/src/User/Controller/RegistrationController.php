<?php

namespace User\Controller;

use Zend\View\Model\ViewModel;

use User\Model\User;
use User\Form\RegisterForm;

/**
 * {@inheritdoc}
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class RegistrationController extends AbstractUserController
{
    /**
     * Register.
     *
     * @return array|\Zend\View\Model\ViewModel
     */
    public function registerAction()
    {
        $form = new RegisterForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($this->getServiceLocator()->get('register_filter'));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = new User();
                $user->exchangeArray($form->getData());

                $password = $this->generatePassword();
                $user->setPassword(md5($password));

                // Save user in database.
                $this->getUserTable()->saveUser($user);

                $view = new ViewModel(array('password' => $password));
                $view->setTemplate('user/registration/confirmRegister.phtml');

                return $view;
            }
        }

        return array('form' => $form);
    }

    /**
     * Generate a random password.
     *
     * @param int $length
     *
     * @return string
     */
    private function generatePassword($length = 8)
    {
        $password = '';

        $dictionary = "12346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

        $i = 0;
        while ($i < $length) {
            $char = substr($dictionary, mt_rand(0, strlen($dictionary)-1), 1);
            $password .= $char;
            $i++;
        }

        return $password;
    }
}
