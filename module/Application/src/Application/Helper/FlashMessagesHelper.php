<?php

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper,
    Zend\Mvc\Controller\Plugin\FlashMessenger;

/**
 * Helper for flash messages.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class FlashMessagesHelper extends AbstractHelper
{
    /**
     * @var FlashMessenger the flash messenger.
     */
    protected $flashMessenger;

    /**
     * Sets flash messenger.
     *
     * @param FlashMessenger $flashMessenger
     */
    public function setFlashMessenger(FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * Invoke method.
     *
     * @return string
     */
    public function __invoke()
    {
        $namespaces = array(
            'error',
            'success',
            'info'
        );

        $result = '';

        foreach ($namespaces as $ns) {
            $this->flashMessenger->setNamespace($ns);

            $messages = array_merge(
                $this->flashMessenger->getMessages(),
                $this->flashMessenger->getCurrentMessages()
            );

            if (!$messages) {
                continue;
            }

            $row = '';
            foreach ($messages as $message) {
                $row .= '<li>' . $message .'</li>';
            }

            $result .=
                '<div class="row">' .
                '<ul class="flashMessages alert alert-' . $ns . '">' .
                $row .
                '</ul>' .
                '</div>';
        }

        return $result;
    }
}
