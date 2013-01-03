<?php

namespace Gallery\Form;

use Zend\Form\Form;
use Zend\Form\Element\File;

/**
 * Form of an image.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class ImageForm extends Form
{
    /**
     * Constructor
     *
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $file = new File('image');

        // we want to ignore the name passed
        parent::__construct('image');
        $this->setAttribute('method', 'post');

        $this->add($file);
    }
}
