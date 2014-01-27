<?php



class Validation {
	
	var $id;
	var $msg;
	var $type;
	var $value;
	var $error;
	private $default_filters = array();
	
	public function __construct($id, $method) {
		$this->id = $id;
		$this->type = constant("INPUT_".strtoupper($method));
		$this->value = $this->get_input($this->type, $this->id);
		include 'messages.php';
		$this->msg = $msg;
	}
	
	function required() {
		if(empty($this->value)) $this->set_error('required');
	}
	
	function restrict_to_options($options) {
		//var_dump($this->value);
		if(is_array($options)) {
			if(is_array($this->value)) {
				if(empty($this->value)) $this->set_error('restrict_to_options');
				foreach($this->value as $value) {
					if(!in_array($value,$options)) { 
						$this->set_error('restrict_to_options');
						return;
					}
				}
			}
			else {
				if(!in_array($this->value,$options)) $this->set_error('restrict_to_options');
			}
		}
		
		else {
			$this->set_error("options_not_set");
		}
	}
	
	/**
	 * Dummy method that allways returns an error.
	 * For debugging purposes.
	 */
	function fail() {
		$this->set_error('fail');
	}
	
	function set_error($method, $text=false) {
		if($text !== false) $this->error[] = $text;
		if(isset($this->msg[$method])) $this->error[] = $this->msg[$method];
		else $this->error[] = "Error message not found!";
		
	}
	
	/**
	 * This method ows it's existance to the fact that php native function filter_input
	 * does not work on array fields
	 * @param string $type
	 * @param string $name
	 * @param array $filters
	 * @return mixed  
	 */
	function get_input($type,$name,$filters=array()) {
		$result = false;
		switch($type) {
			case "post":
				if(isset($_POST[$name])) $result = $_POST[$name];
				break;
			case "get":
				if(isset($_GET[$name])) $result = $_GET[$name];
				break;
			case "cookie":
				if(isset($_COOKIE[$name])) $result = $_COOKIE[$name];
				break;
			case "server":
				if(isset($_SERVER[$name])) $result = $_SERVER[$name];
				break;
			case "request":
			default:
				if(isset($_REQUEST[$name])) $result = $_REQUEST[$name];
				break;
		}
		$filters = array_merge($this->default_filters,$filters);
		if(!empty($filters)) {
			if(is_array($result)) {
				foreach($result as $key => $item) {
					// TODO apply filters on each $item
				}
			}
			else {
				// TODO apply filters on $result
			}
		}
		return $result;
	} 
	
}

