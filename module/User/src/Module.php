<?php 

	namespace User;

	use Zend\Db\Adapter\AdapterInterface;
	use Zend\Db\ResultSet\ResultSet;
	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\Adapter\Adapter;
	use Zend\ModuleManager\Feature\ConfigProviderInterface;

	class Module implements ConfigProviderInterface
	{

		public function getConfig()
		{
			return include __DIR__ . '/../config/module.config.php';
		}

		public function getServiceConfig()
	    {
	        return [
	            'factories' => [
	                Model\Authenticator::class => function($container) {
	                    $dbAdapter =$container->get(AdapterInterface::class);
	                	return new Model\Authenticator($dbAdapter);
	                },
	                Model\RegisterTable::class => function($container) {
	                    $tableGateway = $container->get(Model\RegisterTableGateway::class);
	                    $dbAdapter =$container->get(AdapterInterface::class);
	                    return new Model\RegisterTable($tableGateway, $dbAdapter);
	                },
	                Model\RegisterTableGateway::class => function ($container) {
	                    $dbAdapter = $container->get(AdapterInterface::class);
	                    $resultSetPrototype = new ResultSet();
	                    $resultSetPrototype->setArrayObjectPrototype(new Model\Register());
	                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
	                },
	            ],
	        ];
	    }

	    public function getControllerConfig()
	    {
	        return [
	            'factories' => [
	                Controller\UserController::class => function($container) {
	                    return new Controller\UserController(
	                        $container->get(Model\Authenticator::class),
	                        $container->get(Model\RegisterTable::class)
	                    );
	                },
	            ],
	        ];
	    }

	}