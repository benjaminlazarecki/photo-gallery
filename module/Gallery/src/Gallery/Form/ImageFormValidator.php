<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter,
    Zend\Validator,
    Doctrine\ORM\EntityManager,
    Zend\Validator\File\Size;

class ImageFormValidator extends InputFilter
{
    /**
     * {@inheritdoc}
     *
     * @param EntityManager
     */
    public function __construct(EntityManager $em)
    {
        $this->add(array(
            'name'     => 'file',
            'required' => true,
        ));
    }
}

