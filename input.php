<?php

class K_input {
	
	var $type = "text";
	var $name;
	var $html;
	
	public function __construct($name,$type) {
		$this->type = $type;
		$this->name = $name;
	}
	
	function set_attribute($name,$value) {
		$this->$name = $value;
	}
	
	function html() {
		return "<input type='".$this->type."' name='".$this->name."'>";
	}
	
}

