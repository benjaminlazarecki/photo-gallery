<?php

namespace Gallery\Form;

use Zend\Form\Form;

/**
 * Form of update image.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class UpdateImageForm extends Form
{
    /**
     * Constructor.
     *
     * @param string|null $name
     */
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
