<?php

namespace Gallery;

/**
 * Gallery Module
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
}
