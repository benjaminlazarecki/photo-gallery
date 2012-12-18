<?php

namespace User\Filter;

use Doctrine\ORM\EntityManager;

use Zend\InputFilter\InputFilter,
    Zend\Validator,
    DoctrineModule\Validator\NoObjectExists;

class RegisterFilter extends InputFilter
{
    /**
     * {@inheritdoc}
     *
     * @param EntityManager $em The entity manager.
     */
    public function __construct(EntityManager $em)
    {
        $this->add(array(
            'name'     => 'username',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'User\Validator\UniqueField',
                    'options' => array(
                        'entityManager' => $em,
                        'field'         => 'username',
                    )
                )
            ),
        ));

        $this->add(array(
            'name'       => 'email',
            'required'   => true,
			'validators' => array(
				array(
					'name' => 'User\Validator\UniqueField',
                    'options' => array(
                        'entityManager' => $em,
                        'field'         => 'email',
                    )
                )
            ),
        ));

        $this->add(array(
            'name'     => 'age',
            'required' => true,
        ));
    }
}

