<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter,
    Zend\Validator;

class ImageFormValidator extends InputFilter
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->add(array(
            'name'     => 'name',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StringToLower'),
            ),
        ));

        $this->add(array(
            'name'     => 'public',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'order',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int') 
            ),
        ));
    }
}

