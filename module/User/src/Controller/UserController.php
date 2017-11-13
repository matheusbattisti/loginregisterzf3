<?php

	namespace User\Controller;

	use User\Model\Authenticator;
	use User\Form\LoginForm;
	use User\Model\Login;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;
	use Zend\Authentication\AuthenticationService;

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

	    	if(!$auth->getIdentity()) {

	    		return $this->redirect()->toRoute('user/login');

	    	} else {

	    		return $this->redirect()->toRoute('account');

	    	}
	    }


		public function loginAction()
		{

			$auth = new AuthenticationService();
 
			if(!$auth->getIdentity()) {

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
		        return $this->redirect()->toRoute('login');

	    	} else {

	    		return $this->redirect()->toRoute('account');

	    	}
		}

	}