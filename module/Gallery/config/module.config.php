<?php

namespace Gallery;

return array(
    'controllers' => array(
        'invokables' => array(
            'gallery' => 'Gallery\Controller\GalleryController',
            'image'   => 'Gallery\Controller\ImageController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'gallery' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/gallery',
                    'defaults' => array(
                        'controller' => 'gallery',
                        'action'     => 'index',
                    ),
                ),
            ),
            'gallery-show' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/gallery-show[/:username]',
                    'constraints' => array(
                        'username' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'gallery',
                        'action'     => 'show',
                    ),
                ),
            ),
            'image-add' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/image/add',
                    'defaults' => array(
                        'controller' => 'image',
                        'action'     => 'add',
                    ),
                ),
            ),
            'image-update' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/image/update',
                    'defaults' => array(
                        'controller' => 'image',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'image-remove' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/image/remove',
                    'defaults' => array(
                        'controller' => 'image',
                        'action'     => 'remove',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'gallery' => __DIR__ . '/../view',
        ),
    ),

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
);
