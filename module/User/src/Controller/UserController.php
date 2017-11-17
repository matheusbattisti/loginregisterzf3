<?php

	namespace User\Controller;

	use User\Model\Authenticator;
	use User\Form\LoginForm;
	use User\Form\RegisterForm;
	use User\Model\Login;
	use User\Model\Register;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;
	use Zend\Authentication\AuthenticationService;
	use Zend\Session\SessionManager;
	use Zend\View\Helper\FlashMessenger;

	class UserController extends AbstractActionController
	{

		private $table;

	    public function __construct(Authenticator $table)
	    {
	        $this->table = $table;
	        $this->auth = new AuthenticationService();
	    }

	    public function indexAction() 
	    {
	    	if(!$this->auth->hasIdentity()) {
	    		return $this->redirect()->toRoute('user/login');
	    	} else {
	    		return $this->redirect()->toRoute('user/account');
	    	}
	    }


		public function loginAction()
		{

			if(!$this->auth->hasIdentity()) {

				$form = new LoginForm();
				$form->get('submit')->setValue('Sign In');

				$request = $this->getRequest();

		        if (!$request->isPost()) {
		            return ['form' => $form];
		        }

				$login = new Login();

		        $form->setInputFilter($login->getInputFilter());
		        $form->setData($request->getPost());    

		        if (!$form->isValid()) {
		            return ['form' => $form];
		        }

		        $login->exchangeArray($form->getData());
		        
		        $this->table->authenticate($login);

		        $this->flashMessenger()->addInfoMessage('Wrong e-mail or passowrd.');
		        return $this->redirect()->toRoute('user/login');

	    	} else {
	    		return $this->redirect()->toRoute('user/account');
	    	}
		}

		public function registerAction()
		{

			if(!$this->auth->hasIdentity()) {

				$form = new RegisterForm();
				$form->get('submit')->setValue('Sign Up');

				$request = $this->getRequest();

		        if (!$request->isPost()) {
		            return ['form' => $form];
		        }

			} else {
				return $this->redirect()->toRoute('user/account');
			}

		}

		public function logoutAction()
		{

			$sm = new SessionManager();
			$this->auth->clearIdentity('Zend_Auth');
			$this->flashMessenger()->addInfoMessage('Successful logout.');
			return $this->redirect()->toRoute('user/login');

		}

		public function accountAction()
		{

			if(!$this->auth->hasIdentity()) {
				$this->flashMessenger()->addInfoMessage('You are not logged in.');
				return $this->redirect()->toRoute('user/login');
			} else {
				$this->layout()->authOk = true;
				return new ViewModel();
			}
		}

	}