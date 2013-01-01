<?php

namespace Gallery\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UpdateImageForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('image');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'order',
            'attributes' => array(
                'type'  => 'number',
            ),
            'options' => array(
                'label' => 'Order:',
            ),
        ));
    }

}
