<?php

include_once 'khelpers.php';
include_once 'kelements.php';

class Formkons {
	
	
	var $method;
	var $attributes = array();
	var $elements;
	var $errors = false;
	private $submitted = false;
	
	function __construct($config=false) {
		if(is_array($config)) {
			$this->attributes = array_merge($this->attributes,$config);
		}
		if(empty($config['method'])) $this->method = "get";
		else $this->method = "post";
		$this->submitted = $this->is_submitted($this->method);
		
	}
		
	/**
	 * 
	 * @param type $element
	 * @param type $id
	 * @param type $attr either an array of attributes or input type
	 * @return type
	 */
	public function add_element($element, $id, $attr=false)
	{
		$element = strtolower(trim($element));
		
		if($element == "input") {
			if(is_array($attr)) {
				if(empty($attr['type'])) $attr['type'] = "text";
			}
			else $attr = array( "type" => empty($attr)?"text":$attr);
			if($attr['type'] == "checkbox" || $attr['type'] == "radio") $element = "checkbox";//checkboxes and radios need a separate class
			if($attr['type'] == "file") { 
				$element = "upload"; 
				$this->add_attribute("enctype", "multipart/form-data");
			}
		}
		
		$classname = "K_".$element;
		
		$this->elements[$id] = new $classname($id,$attr);
		
		return $this->elements[$id];
	}
	
	public function add_attribute($name, $value) {
		$this->attributes[$name] = $value;
	}
	
	
	public function submitted_and_valid() {
		if($this->submitted) {
			foreach($this->elements as $id => $element) {
				$this->elements[$id]->set_value($this->get_value($id));
			}
			
			return !$this->errors;
		}
		else {
			return false;
		}
		
	}
	
	public function values_array() {
		$result = array();
		foreach($this->elements as $id => $element) {
			$result[$id] = $element->value;
		}
		return $result;
	}


	public function html() {
		$out = $this->form_open();
		
		foreach($this->elements as $id => $element)
		{
			$out .= $element->html(true);
		}
		
		$out .= "</form>";
		
		return $out;
			
	}
	
	/**
	 * Create the opening FORM tag with all attributes
	 */
	public function form_open() {
		$out = "<form";
		$out .= write_attributes($this->attributes);
		$out .= ">";
		return $out;
	}
	
	public function form_close() {
		return "</form>";
	}
	
	/**
	 * This function is private and used by the constructor that needs(?) to know
	 * if the form is submitted in advance. Do not mix with public function submitted()
	 * that actually runs all the validation and value abstraction processes.
	 * @param type $method
	 * @return boolean
	 */
	private function is_submitted($method) {
		if($method=="post" && (!empty($_POST))) return true;
		if($method=="get" && (!empty($_GET))) return true;
		return false;
	}
	
	function get_value($id) {
		// use filter functions and validation
		//var_dump($this->elements[$id]->validation);
		if(!empty($this->elements[$id]->validation)) {
			$validate = new Validation($id, $this->method);
			foreach($this->elements[$id]->validation as $method => $args) {
				//for the case when method is passed in the array without arguments
				if(is_numeric($method)) {
					$method = $args;
					$args = NULL;
				}
				
				$validate->$method($args);
				
			}
			$this->elements[$id]->error = $validate->error;
			if(!empty($validate->error)) $this->errors = true;
			return $validate->value;
		}
		else {
			return $_POST[$id];
		}
		
	}
	
}

