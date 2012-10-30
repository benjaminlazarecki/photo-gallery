<?php

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('user_register');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'email',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        $this->add(array(
            'name' => 'age',
            'attributes' => array(
                'type'  => 'int',
            ),
            'options' => array(
                'label' => 'Age',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Register',
                'id' => 'submitbutton',
            ),
        ));
    }
}
