<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * IndexController
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * index.
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }
}
