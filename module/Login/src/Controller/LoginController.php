<?php

	namespace Login\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;

	use Zend\Db\Adapter\Adapter;

	class LoginController extends AbstractActionController
	{

		private $db;

	    public function __construct($db)
	    {
	        $this->db = $db;
	    }


		public function indexAction()
		{
			$result = $this->db->query('SELECT * FROM `testingpdo`', Adapter::QUERY_MODE_EXECUTE);
       		echo $result->count();
			return new ViewModel();
		}

	}