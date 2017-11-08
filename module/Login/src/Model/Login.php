<?php 

	namespace Login\Model;

	class Login
	{

		//public $id;
		public $username;
		public $password;

		public function exchangeArray(array $data)
		{
			print_r($data);
			//$this->id = !empty($data['id']) ? $data['id'] : null;
			$this->username = !empty($data['username']) ? $data['username'] : null;
			$this->password = !empty($data['password']) ? $data['password'] : null;
		}


	}