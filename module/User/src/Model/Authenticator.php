<?php 

	namespace User\Model;

	use RuntimeException;
	use Zend\Db\Adapter\AdapterInterface;
	use Zend\Authentication\AuthenticationService;
	use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
	use Zend\Authentication\Storage\Session as SessionStorage;
	use Zend\Session\SessionManager;

	class Authenticator
	{

		private $dbAdapter;

		public function __construct(AdapterInterface $dbAdapter)
		{
			$this->dbAdapter = $dbAdapter;
		}

		public function authenticate(Login $login)
		{

			$auth = new AuthenticationService();

			$sessionManager = new SessionManager();

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

	        $auth->setStorage(new SessionStorage());

	        $authAdapter
	         	->setIdentity($data['username'])
	        	->setCredential($data['password']);

	        $result = $auth->authenticate($authAdapter);

	        if (! $result->isValid()) {
			    // Authentication failed; print the reasons why:
			} else {
			    // Authentication succeeded; the identity ($username) is stored
			    // in the session:
			    // $result->getIdentity() === $auth->getIdentity();
			    // $result->getIdentity() === $login->username;
			}
		}

		public function checkUser()
		{
			$authAdapter = new AuthAdapter(
				$this->dbAdapter, 
				'users', 
				'username', 
				'password'
			);

			return $authAdapter->getIdentity();
		}


	}