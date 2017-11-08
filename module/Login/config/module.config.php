<?php 

	namespace Login;

	use Zend\Router\Http\Segment;
	use Zend\ServiceManager\Factory\InvokableFactory;

	return [

		'controllers' => [
			'factories' => [
				Controller\LoginController::class => function($container) {
					return new Controller\LoginController(
						$container->get(\Zend\Db\Adapter\Adapter::class)
					);
				}
			],
		],

		'router' => [
	        'routes' => [
	            'login' => [
	                'type'    => Segment::class,
	                'options' => [
	                    'route' => '/login[/:action[/:id]]',
	                    'constraints' => [
	                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
	                        'id'     => '[0-9]+',
	                    ],
	                    'defaults' => [
	                        'controller' => Controller\LoginController::class,
	                        'action'     => 'index',
	                    ],
	                ],
	            ],
	        ],
	    ],

		'view_manager' => [
			'template_path_stack' => [
				'login' => __DIR__ . '/../view',
			],
		],

	];