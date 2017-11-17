<?php

	namespace User\Controller;

	use User\Model\Authenticator;
	use User\Form\LoginForm;
	use User\Model\Login;
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
	    }

	    public function indexAction() 
	    {

			$auth = new AuthenticationService();

	    	if(!$auth->hasIdentity()) {
	    		return $this->redirect()->toRoute('user/login');
	    	} else {
	    		return $this->redirect()->toRoute('user/account');
	    	}
	    }


		public function loginAction()
		{

			$auth = new AuthenticationService();

			if(!$auth->hasIdentity()) {

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

			$auth = new AuthenticationService();

			if(!$auth->hasIdentity()) {
				return new ViewModel();
			} else {
				return $this->redirect()->toRoute('user/account');
			}

		}

		public function logoutAction()
		{

			$auth = new AuthenticationService();
			$sm = new SessionManager();
			$auth->clearIdentity('Zend_Auth');
			$this->flashMessenger()->addInfoMessage('Successful logout.');
			return $this->redirect()->toRoute('user/login');

		}

		public function accountAction()
		{

			$auth = new AuthenticationService();

			if(!$auth->hasIdentity()) {
				$this->flashMessenger()->addInfoMessage('You are not logged in.');
				return $this->redirect()->toRoute('user/login');
			} else {
				return new ViewModel();
			}
		}

	}