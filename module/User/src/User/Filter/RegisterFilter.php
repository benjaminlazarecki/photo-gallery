<?php

namespace User\Filter;

use Zend\InputFilter\InputFilter;

/**
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class RegisterFilter extends InputFilter
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->add($this->getFactory()->createInput(array(
            'name'     => 'id',
            'required' => true,
            'filters'  => array(
                array('name' => 'Int'),
            ),
        )));

        $this->add($this->getFactory()->createInput(array(
            'name'     => 'age',
            'required' => true,
            'filters'  => array(),
        )));

        $this->add($this->getFactory()->createInput(array(
            'name'     => 'username',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                'stringLength' => array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 32,
                    ),
                ),
                /*                'dbNoRecordExists' => array(
                                    'name'    => 'Db\NoRecordExists',
                                    'options' => array(
                                        'table'     => 'users',
                                        'field'     => 'nickname',
                                        'adapter'   => $this->adapter,
                                    ),
                                ),
                */
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
                /*                array(
                                    'name'    => 'Db\NoRecordExists',
                                    'options' => array(
                                        'table'     => 'users',
                                        'field'     => 'email',
                                        'adapter'   => $this->adapter,
                                    ),
                                ),
                */
            ),
        )));
    }
}
