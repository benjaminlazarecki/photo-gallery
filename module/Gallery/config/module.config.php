<?php

namespace Gallery;

return array(
    'controllers' => array(
        'invokables' => array(
            'Gallery\Controller\Gallery' => 'Gallery\Controller\GalleryController',
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

    'data-fixture' => array(
        __NAMESPACE__ . '_fixture' => __DIR__ . '/../src/' . __NAMESPACE__ . '/DataFixtures',
    ),
);