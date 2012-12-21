<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter,
    Zend\Validator,
    Doctrine\ORM\EntityManager;

class ImageFormValidator extends InputFilter
{
    /**
     * {@inheritdoc}
     *
     * @param EntityManager
     */
    public function __construct(EntityManager $em)
    {
        //$this->add(array(
            //'name'     => 'name',
            //'required' => true,
            //'filters'  => array(
                //array('name' => 'Zend\Filter\StringTrim'),
                //array('name' => 'Zend\Filter\StringToLower'),
            //),
			////'validators' => array(
				////array(
					////'name' => 'User\Validator\UniqueField',
                    ////'options' => array(
                        ////'entityManager' => $em,
                        ////'repository'    => 'Gallery\Entity\Image',
                        ////'field'         => 'name',
                    ////)
                ////)
            ////),
        //));

        //$this->add(array(
            //'name'       => 'public',
            //'required'   => true,
        //));

        $this->add(array(
            'name'       => 'file',
            'required'   => true,
        ));

        //$this->add(array(
            //'name'     => 'order',
            //'required' => true,
            //'filters'  => array(
                //array('name' => 'Zend\Filter\Int')
            //),
        //));
    }
}

