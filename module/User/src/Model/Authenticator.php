<?php 

	namespace User\Model;

	use RuntimeException;
	use Zend\Db\Adapter\AdapterInterface;
	use Zend\Authentication\AuthenticationService;
	use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
	use Zend\Authentication\Storage\Session as SessionStorage;
	use Zend\Session\SessionManager;
	use Zend\Crypt\Password\Bcrypt;

	class Authenticator
	{

		private $dbAdapter;
		private $tableGateway;

		public function __construct(AdapterInterface $dbAdapter)
		{
			$this->dbAdapter = $dbAdapter;
			$this->tableGateway = new TableGateway('users', $this->dbAdapter);
			$this->bcrypt = new Bcrypt();
		}

		public function authenticate(Login $login)
		{

			$auth = new AuthenticationService();

			$sessionManager = new SessionManager();

			$credentialValidationCallback = function($dbCredential, $requestCredential) {
			    return $this->bcrypt->verify($requestCredential, $dbCredential);
			};

			$authAdapter = new AuthAdapter(
				$this->dbAdapter, 
				'users', 
				'username', 
				'password',
				$credentialValidationCallback
			);

			$data = [
	            'email' => $login->email,
	            'password'  => $login->password,
	        ];

	        $auth->setStorage(new SessionStorage());

	        $authAdapter
	         	->setIdentity($data['email'])
	        	->setCredential($data['password']);

	        $result = $auth->authenticate($authAdapter);

	        if (! $result->isValid()) {
			    // Authentication failed; print the reasons why:
			    $messages = $result->getMessages();
			    return $messages;

			} else {
			    // Authentication succeeded; the identity ($username) is stored
			    // in the session:
			    // $result->getIdentity() === $auth->getIdentity();
			    // $result->getIdentity() === $login->username;
			}
		}

	}