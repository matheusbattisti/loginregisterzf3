<?php 

	namespace User\Model;

	use DomainException;
	use Zend\Filter\StringTrim;
	use Zend\Filter\StripTags;
	use Zend\Filter\ToInt;
	use Zend\InputFilter\InputFilter;
	use Zend\InputFilter\InputFilterAwareInterface;
	use Zend\InputFilter\InputFilterInterface;
	use Zend\Validator\StringLength;

	class Register implements InputFilterAwareInterface
	{

		public $id;
		public $name;
		public $email;
		public $password;

		private $inputFilter;

		public function exchangeArray(array $data)
		{
			$this->id = !empty($data['id']) ? $data['id'] : null;
			$this->name = !empty($data['name']) ? $data['name'] : null;
			$this->email = !empty($data['email']) ? $data['email'] : null;
			$this->password = !empty($data['password']) ? $data['password'] : null;
			$this->cpassword = !empty($data['confirmpassword']) ? $data['confirmpassword'] : null;
		}

		public function setInputFilter(InputFilterInterface $inputFilter)
	    {
	        throw new DomainException(sprintf(
	            '%s does not allow injection of an alternate input filter',
	            __CLASS__
	        ));
	    }

	    public function getInputFilter()
	    {
	        if ($this->inputFilter) {
	            return $this->inputFilter;
	        }

	        $inputFilter = new InputFilter();

	        $inputFilter->add([
	            'name' => 'id',
	             'required' => true,
	             'filters' => [
	                 ['name' => ToInt::class],
	            ],
	        ]);

	        $inputFilter->add([
	            'name' => 'name',
	            'required' => true,
	            'filters' => [
	                ['name' => StripTags::class],
	                ['name' => StringTrim::class],
	            ],
	            'validators' => [
	                [
	                    'name' => StringLength::class,
	                    'options' => [
	                        'encoding' => 'UTF-8',
	                        'min' => 1,
	                        'max' => 100,
	                    ],
	                ],
	            ],
	        ]);

	        $inputFilter->add([
	            'name' => 'email',
	            'required' => true,
	            'filters' => [
	                ['name' => StripTags::class],
	                ['name' => StringTrim::class],
	            ],
	            'validators' => [
	                [
	                    'name' => StringLength::class,
	                    'options' => [
	                        'encoding' => 'UTF-8',
	                        'min' => 1,
	                        'max' => 100,
	                    ],
	                ],
	            ],
	        ]);

	        $inputFilter->add([
	            'name' => 'password',
	            'required' => true,
	            'filters' => [
	                ['name' => StripTags::class],
	                ['name' => StringTrim::class],
	            ],
	            'validators' => [
	                [
	                    'name' => StringLength::class,
	                    'options' => [
	                        'encoding' => 'UTF-8',
	                        'min' => 1,
	                        'max' => 100,
	                    ],
	                ],
	            ],
	        ]);

	        $inputFilter->add([
	            'name' => 'confirmpassword',
	            'required' => true,
	            'filters' => [
	                ['name' => StripTags::class],
	                ['name' => StringTrim::class],
	            ],
	            'validators' => [
	                [
	                    'name' => StringLength::class,
	                    'options' => [
	                        'encoding' => 'UTF-8',
	                        'min' => 1,
	                        'max' => 100,
	                    ],
	                ],
	            ],
	        ]);

	        $this->inputFilter = $inputFilter;
	        return $this->inputFilter;
	    }


	}