<?php
return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'video' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/videos',
                    'defaults' => array(
                        '__NAMESPACE__' => 'VideoManager\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action][/pages/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page'       => '[0-9]*',
                                'perPage'       => '[0-9]*',
                            ),
                            'defaults' => array(
                                'page' => 1
                            ),
                        ),
                    ),
                    'manage' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/manage[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'manage',
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'view' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/view[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'action' => 'view'
                            )
                        ),
                    ),
                    'search' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/search',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'action' => 'search',
                            )
                        ),
                        'may_terminate' => true,
                    )
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            //'VideoManager\Controller\Index' => 'VideoManager\Controller\IndexController'
        ),
        'factories' => array(
            'VideoManager\Controller\Index'  => 'VideoManager\Controller\Factory\IndexControllerFactory',
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'video-layout' => __DIR__ . '/../view/layout/video-layout.phtml',
            'video-records-partial' => __DIR__ . '/../view/video-manager/index/partials/video-records-partial.phtml',
            'view-record' => __DIR__ . '/../view/video-manager/index/partials/video-record.phtml',
            'simple-output' => __DIR__ . '/../view/video-manager/index/simple-output.phtml',
            'copyright' => __DIR__ . '/../view/video-manager/index/copyright-notice.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
