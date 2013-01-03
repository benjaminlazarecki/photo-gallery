<?php

namespace User;

return array(
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            ),
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'zfc-user' => __DIR__ . '/../view',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'user-register' => 'User\Controller\RegisterController',
            'user-login'    => 'User\Controller\LoginController',
            'admin'         => 'User\Controller\AdminController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'register' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/register',
                    'defaults' => array(
                        'controller' => 'user-register',
                        'action'     => 'register',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'User\Router\Segment',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'user-login',
                        'action'     => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'user-login',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'admin' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'admin',
                        'action'     => 'list',
                    ),
                ),
            ),
            'remove-user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/remove[/:username]',
                    'constraints' => array(
                        'username' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'admin',
                        'action'     => 'remove',
                    ),
                ),
            ),
            'unblock-user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/unblock[/:username]',
                    'constraints' => array(
                        'username' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'admin',
                        'action'     => 'unblock',
                    ),
                ),
            ),
        ),
    ),
);
