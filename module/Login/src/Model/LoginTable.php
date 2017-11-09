<?php 

	namespace Login\Model;

	use RuntimeException;
	use Zend\Db\TableGateway\TableGatewayInterface;
	use Zend\Authentication\AuthenticationService;
	use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;

	class LoginTable
	{

		private $tableGateway;

		public function __construct(TableGatewayInterface $tableGateway)
		{
			$this->tableGateway = $tableGateway;
		}

		public function authenticate(Login $login)
		{
			$authAdapter = new AuthAdapter(
				$tableGateway, 
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
			    // Authentication failed; print the reasons why:
			    foreach ($result->getMessages() as $message) {
			        echo "$message\n";
			    }
			} else {
			    // Authentication succeeded; the identity ($username) is stored
			    // in the session:
			    // $result->getIdentity() === $auth->getIdentity()
			    // $result->getIdentity() === $username
			}
		}

	}