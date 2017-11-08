<?php

	namespace Login\Controller;

	use Login\Model\LoginTable;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;
	use Login\Form\LoginForm;
	use Login\Model\Login;

	use Zend\Db\Adapter\Adapter;

	class LoginController extends AbstractActionController
	{

		private $db;
		private $table;

	    public function __construct($db)
	    {
	        $this->db = $db;
	        $this->table = $table;
	    }


		public function indexAction()
		{
			// $result = $this->db->query('SELECT * FROM `testingpdo`', Adapter::QUERY_MODE_EXECUTE);
   //     		echo $result->count();

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
		}

	}