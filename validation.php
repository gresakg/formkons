<?php



class Validation {
	
	var $id;
	var $msg;
	var $type;
	var $value;
	var $error;
	
	public function __construct($id, $method) {
		$this->id = $id;
		$this->type = constant("INPUT_".strtoupper($method));
		$this->value = filter_input($this->type, $this->id);
		include 'messages.php';
		$this->msg = $msg;
	}
	
	function required() {
		if(empty($this->value)) $this->set_error('required');
	}
	
	function restrict_to_options($options) {
		if(is_array($options)) {
			if(!in_array($this->value,$options)) $this->set_error('restrict_to_options');
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
	
}

