<?php 

	namespace User\Form;

	use Zend\Form\Form;

	class RegisterForm extends Form
	{

		public function __construct($name=null)
		{
			parent::__construct('register');

			$this->add([
			 	'name' => 'id',
			 	'type' => 'hidden',
			 ]);
			
			$this->add([
				'name' => 'name',
				'type' => 'text',
				'options' => [
					'label' => 'Name',
				],
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
				'name' => 'confirmpassword',
				'type' => 'password',
				'options' => [
					'label' => 'Confirm Password',
				],
			]);

			$this->add([
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => [
					'Value' => 'Sign Up',
					'id' 	=> 'submitbutton',
				],
			]);

		}

	}