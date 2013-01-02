<?php

namespace Gallery\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ImageForm extends Form
{
    public function __construct($name = null)
    {
        $file = new Element\File('image');

        // we want to ignore the name passed
        parent::__construct('image');
        $this->setAttribute('method', 'post');

        $this->add($file);
    }
}
