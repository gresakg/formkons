<?php



class Validation {
	
	var $msg;
	
	public function __construct() {
		include 'messages.php';
		$this->msg = $msg;
	}
	
	function required($value) {
		if(empty($value)) return $this->set_error('required');
		else return false;
	}
	
	function set_error($method, $text=false) {
		if($text !== false) return $text;
		if(isset($this->msg[$method])) return $this->msg[$method];
		else return "Error message not found!";
		
	}
	
}

