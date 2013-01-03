<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter,
    Zend\Validator;

/**
 * Validator of image form.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class ImageFormValidator extends InputFilter
{
    /**
     * {@inheritdoc}
     *
     * @param EntityManager
     */
    public function __construct()
    {
        $this->add(array(
            'name'     => 'image',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'File\IsImage',
                ),
                array(
                    'name' => 'File\Extension',
                    'options' => array('extension' => 'jpeg, jpg, png')
                ),
                array(
                    'name' => 'File\Size',
                    'options' => array('max' => 5 * 1024 * 1024)
                )
            )
        ));
    }
}
