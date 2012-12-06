<?php

namespace User\Event;

use Zend\Form\Form;

/**
 * This class allow to add field on User registration form.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class ExtendsRegistrationForm
{
    /**
     * Add age user attribute to registration form.
     *
     * @param \Zend\Form\Form $form
     */
    public function addAgeFields(Form $form)
    {
        $form->add(array(
            'name' => 'age',
            'attributes' => array(
                'type'  => 'integer',
            ),
            'options' => array(
                'label' => 'Age',
            )
        ));
    }
}
