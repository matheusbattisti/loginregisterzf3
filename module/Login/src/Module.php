<?php 

	namespace Login;

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
	                	return new Model\Authenticator($container->get(AdapterInterface::class));
	                },
	            ],
	        ];
	    }

	    public function getControllerConfig()
	    {
	        return [
	            'factories' => [
	                Controller\LoginController::class => function($container) {
	                    return new Controller\LoginController(
	                        $container->get(Model\Authenticator::class)
	                    );
	                },
	            ],
	        ];
	    }

	}