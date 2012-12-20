<?php

namespace User\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Captcha;

/**
 * Represent a register form.
 */
class RegisterForm extends Form
{
    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        parent::__construct('register');

        $email = new Element\Email('email');

        $username = new Element\Text('username');

        $age = new Element\Text('age');
        $age->setAttribute('type', 'number'); // Wait for NumberFormatter

        $figlet = new Captcha\Figlet();
        $figlet->setWordLen(5);
        $captcha = new Element\Captcha('captcha');
        $captcha
            ->setCaptcha($figlet)
            ->setAttribute('placeholder', 'Enter the captcha here');

        $this->setAttribute('method', 'post');

        $this->add($email);
        $this->add($username);
        $this->add($age);
        $this->add($captcha);
    }
}
