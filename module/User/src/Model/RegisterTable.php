<?php 

	namespace User\Model;

	use Zend\Db\Adapter\AdapterInterface;
	use Zend\Db\TableGateway\TableGatewayInterface;
	use Zend\Validator\Db\RecordExists;
	use Zend\Db\Adapter\Adapter;

	class RegisterTable
	{
		private $tableGateway;

	    public function __construct(TableGatewayInterface $tableGateway, AdapterInterface $dbAdapter)
	    {
	        $this->tableGateway = $tableGateway;
	        $this->dbAdapter = $dbAdapter;
	        $this->validator = new RecordExists([
	        	'table' => 'users',
	        	'field' => 'username',
	        	'adapter' => $this->dbAdapter,
	        ]);
	    }

	    public function saveUser(Register $register)
	    {

	        $data = [ 
	            'username' => $register->email,
	            'password' => $register->password,
	            'confirmpassword' => $register->cpassword,
	            'name' => $register->name,
	        ];

	        if($data['password'] == $data['confirmpassword']) {

	        	if($this->validator->isValid($data['username']) != 1) {

	        		$id = (int) $user->id;

			        if ($id === 0) {
			            $this->tableGateway->insert($data);
			            return true;
			        }

	        	} else {
	        		return array('error' => 'This e-mail is already registered!');
	        	}       

		    } else {
		    	return array('error' => 'The password does not match with confirmation!');
		    }

	    }
	}