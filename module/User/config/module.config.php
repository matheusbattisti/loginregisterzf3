<?php 

	namespace User;

	use Zend\Router\Http\Segment;

	return [

		'router' => [
	        'routes' => [
	            'user' => [
	                'type'    => Segment::class,
	                'options' => [
	                    'route' => '/user[/:action]',
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