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

        $captcha = new Element\Captcha('captcha');
        $captcha
            ->setCaptcha(new Captcha\Figlet())
            ->setAttribute('placeholder', 'Enter the captcha here');

        $this->setAttribute('method', 'post');

        $this->add($email);
        $this->add($username);
        $this->add($age);
        $this->add($captcha);

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}
