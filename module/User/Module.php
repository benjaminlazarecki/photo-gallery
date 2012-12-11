<?php

namespace User;

use Zend\Mvc\MvcEvent;

use User\Event\ExtendsRegistrationForm;

/**
 * User Module.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class Module
{
    /**
     * The config autoloader.
     *
     * @return array
     */
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

    /**
     * Return the config.
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Bootstrap.
     *
     * @param \Zend\Mvc\MvcEvent $e The mvc event.
     */
    public function onBootstrap(MvcEvent $e)
    {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        // TODO: create a service.
        $extends = new ExtendsRegistrationForm();

        $events->attach('ZfcUser\Form\Register', 'init', function($e) use ($extends) {
            $extends->addAgeFields($e->getTarget());
        });
    }
}
