<?php
	class Validate {
			
		private $_errors = array();
		private $_db = null;
		
		public function __construct() {
			global $sqlcon;
			$this->_db = $sqlcon;
		}
		
		public function check($source, $items = array()) {
			foreach($items as $item => $rules)
			{
				foreach($rules as $rule => $ruleval)
				{
					$value = $source[$item];
					$this->inputName = $rules['name'];
					if($rule === 'required' AND empty($value))
					{
						$this->addError("{$this->inputName}: must not be empty");
					}
					elseif(!empty($value))
					{
						switch($rule)
						{
							case 'min':
								if(strlen($value) < $ruleval)
								{
									$this->addError("{$this->inputName}: too few chars");
								}
								break;
							case 'max':
								if(strlen($value) > $ruleval)
								{
									$this->addError("{$this->inputName}: too many chars");
								}
								break;
							case 'email':
								if(filter_var($value, FILTER_VALIDATE_EMAIL) === false)
								{
									$this->addError("{$this->inputName}: is not a real e-mail");
								}
								break;
							case 'password':
									if(ctype_alnum($value) === false)
									{
											$this->addError("{$this->inputName}: only numbers and letters");
									}
								break;
							case 'unique':
								$check = $this->_db->query("SELECT {$item} FROM {$ruleval} WHERE {$item} = '{$value}'")->num_rows;
								if($check === 1)
								{
									$this->addError("{$this->inputName}: already exists");
								}
								break;
						}
					}
				}
			}
		}
		private function addError($error) {
			$this->_errors[] = $error;
		}
		public function errors() {
			return $this->_errors;
		}
	}
?>