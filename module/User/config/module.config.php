<?php 

	namespace User;

	use Zend\Router\Http\Segment;

	return [

		'router' => [
	        'routes' => [
	            'user' => [
	                'type'    => Segment::class,
	                'options' => [
	                    'route' => '/user',
	                    'constraints' => [
	                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
	                        'id'     => '[0-9]+',
	                    ],
	                    'defaults' => [
	                        'controller' => Controller\UserController::class,
	                        'action'     => 'index',
	                    ],
	                ],
		            'may_terminate' => 'true',
		            'child_routes' => [
		            	'login' => [
			                'type'    => Segment::class,
			                'options' => [
			                    'route' => '/login',
			                    'defaults' => [
			                    	'controller' => Controller\UserController::class,
			                        'action'     => 'login',
			                    ],
			                ],
			            ],
			            'account' => [
			                'type'    => Segment::class,
			                'options' => [
			                    'route' => '/account',
			                    'defaults' => [
			                    	'controller' => Controller\UserController::class,
			                        'action'     => 'account',
			                    ],
			                ],
			            ],
			            'logout' => [
			                'type'    => Segment::class,
			                'options' => [
			                    'route' => '/logout',
			                    'defaults' => [
			                    	'controller' => Controller\UserController::class,
			                        'action'     => 'logout',
			                    ],
			                ],
			            ],
			            'register' => [
			                'type'    => Segment::class,
			                'options' => [
			                    'route' => '/register',
			                    'defaults' => [
			                    	'controller' => Controller\UserController::class,
			                        'action'     => 'register',
			                    ],
			                ],
			            ],
		            ],
	            ],
	        ],
	    ],

		'view_manager' => [
			'template_path_stack' => [
				'user' => __DIR__ . '/../view',
			],
		],

	];