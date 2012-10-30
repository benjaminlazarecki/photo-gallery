<?php
namespace User\Filter;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->add($this->getFactory()->createInput(array(
            'name'     => 'password',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 128,
                    ),
                ),
            ),
        )));

        $this->add($this->getFactory()->createInput(array(
            'name'     => 'email',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'EmailAddress',
                    'options' => array(
                    ),
                ),
            ),
        )));
    }
}

