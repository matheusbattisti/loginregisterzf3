<?php

	namespace User\Controller;

	use User\Model\Authenticator;
	use User\Form\LoginForm;
	use User\Model\Login;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;
	use Zend\Authentication\AuthenticationService;
	use Zend\Authentication\Storage\Session as SessionStorage;

	use Zend\Db\Adapter\Adapter;

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

	    	if(!$auth->getStorage()) {

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

		        $auth->setStorage(new SessionStorage('abc'));

		        return $this->redirect()->toRoute('user/account');

	    	} else {

	    		return $this->redirect()->toRoute('user/account');

	    	}
		}

		public function logoutAction()
		{

			$auth = new AuthenticationService();
			$auth->clearIdentity();
			return $this->redirect()->toRoute('user/login');

		}

		public function accountAction()
		{

			$auth = new AuthenticationService();

			print_r($auth->getStorage('abc'));
			print_r($auth->hasIdentity());

			if(!$auth->getStorage()) {
				return $this->redirect()->toRoute('user/login');
			} else {
				return new ViewModel();
			}
		}

	}