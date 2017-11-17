<?php 

	namespace User\Form;

	use Zend\Form\Form;

	class LoginForm extends Form
	{

		public function __construct($name=null)
		{
			parent::__construct('login');

			$this->add([
			 	'name' => 'id',
			 	'type' => 'hidden',
			 ]);

			$this->add([
				'name' => 'email',
				'type' => 'email',
				'options' => [
					'label' => 'E-mail',
				],
			]);

			$this->add([
				'name' => 'password',
				'type' => 'password',
				'options' => [
					'label' => 'Password',
				],
			]);

			$this->add([
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => [
					'Value' => 'Sign In',
					'id' 	=> 'submitbutton',
				],
			]);

		}

	}