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
		$this->value = filter_input($type, $this->id);
		include 'messages.php';
		$this->msg = $msg;
	}
	
	function required() {
		if(empty($this->value)) $this->set_error('required');
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

