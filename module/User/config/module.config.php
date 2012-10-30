<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\SecurityController',
            'User\Controller\Registration' => 'User\Controller\RegistrationController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action'     => 'login',
                    ),
                ),
            ),
            'register' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/register',
                    'defaults' => array(
                        'controller' => 'User\Controller\Registration',
                        'action'     => 'register',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),

    'service_manager' => array(
        'services' => array(
            'login_filter'    => new \User\Filter\LoginFilter(),
            'register_filter' => new \User\Filter\RegisterFilter(),
        )
    ),
);