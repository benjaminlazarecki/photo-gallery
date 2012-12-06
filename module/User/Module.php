<?php

namespace User;

use User\Event\ExtendsRegistrationForm;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        // TODO: create a service.
        $extends = new ExtendsRegistrationForm();

        $events->attach('ZfcUser\Form\Register', 'init', function($e) use ($extends) {
            $extends->addAgeFields($e->getTarget());
        });
    }
}