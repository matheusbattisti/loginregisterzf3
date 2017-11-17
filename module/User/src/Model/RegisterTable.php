<?php 

	namespace User\Model;

	use Zend\Db\TableGateway\TableGatewayInterface;

	class RegisterTable
	{
		private $tableGateway;

	    public function __construct(TableGatewayInterface $tableGateway)
	    {
	        $this->tableGateway = $tableGateway;
	    }

	    public function saveUser(Register $register)
	    {

	        $data = [ 
	            'username' => $register->email,
	            'password' => $register->password,
	            'name' => $register->name,
	        ];

	        $id = (int) $user->id;

	        if ($id === 0) {
	            $this->tableGateway->insert($data);
	            return;
	        }

	    }
	}