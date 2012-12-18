<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;

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
        $email->setLabel('email');

        $username = new Element\Text('username');
        $username->setLabel('username');

        $age = new Element\Text('age'); // Wait for NumberFormatter
        $age->setLabel('age');

        $this->setAttribute('method', 'post');

        $this->add($email);
        $this->add($username);
        $this->add($age);

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
            ),
        ));
    }
}
