<?php 

	namespace Login\Model;

	use RuntimeException;
	use Zend\Db\TableGateway\TableGatewayInterface;
	use Zend\Db\Adapter\AdapterInterface;
	use Zend\Authentication\AuthenticationService;
	use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;

	class LoginTable
	{

		private $tableGateway;
		private $dbAdapter;

		//public function __construct(TableGatewayInterface $tableGateway)
		public function __construct(AdapterInterface $dbAdapter)
		{
			$this->tableGateway = $tableGateway;
			$this->dbAdapter = $dbAdapter;
		}

		public function authenticate(Login $login)
		{

			$authAdapter = new AuthAdapter(
				$this->dbAdapter, 
				'users', 
				'username', 
				'password'
			);

			$data = [
	            'username' => $login->username,
	            'password'  => $login->password,
	        ];

	        $authAdapter
	        	->setIdentity($data['username'])
	        	->setCredential($data['password']);

	        $result = $authAdapter->authenticate();

	        if (! $result->isValid()) {
	        	print_r($result); exit;
			    // Authentication failed; print the reasons why:
			    foreach ($result->getMessages() as $message) {
			        echo "$message\n";
			    }
			} else {
			    // Authentication succeeded; the identity ($username) is stored
			    // in the session:
			    // $result->getIdentity() === $auth->getIdentity()
			    // $result->getIdentity() === $username
			    print_r($result); exit;
			}
		}

	}