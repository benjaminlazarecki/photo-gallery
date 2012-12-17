<?php

namespace Gallery\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ImageForm extends Form
{
    public function __construct($name = null)
    {
        $radio = new Element\Radio('public');
        $radio->setLabel('Public');
        $radio->setValueOptions(array(
             '0' => 'Yes',
             '1' => 'No',
        )); 

        $order = new Element\Text('order');
        $order->setLabel('order');

        $file = new Element\File('file');

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
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
            ),
        ));

        $this->add($radio);
        $this->add($order);
        $this->add($file);
    }
}
