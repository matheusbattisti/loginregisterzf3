<?php 

	namespace Login\Model;

	use RuntimeException;
	use Zend\Db\TableGateway\TableGatewayInterface;

	class LoginTable
	{

		private $tableGateway;

		public function __construct(TableGatewayInterface $tableGateway)
		{
			$this->tableGateway = $tableGateway;
		}

		public function authenticate()
		{

		}

	}