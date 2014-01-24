<?php

include_once 'khelpers.php';
include_once 'kelements.php';

class Formkons {
	
	
	var $method;
	var $attributes = array();
	var $elements;
	private $submitted = false;
	
	function __construct($config=false) {
		if(is_array($config)) {
			$this->attributes = array_merge($this->attributes,$config);
		}
		if(empty($config['method'])) $this->method = "get";
		else $this->method = "post";
		$this->submitted = $this->is_submitted($this->method);
		
	}
		
	function add_attribute($name, $value) {
		$this->attributes[$name] = $value;
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
		}
		
		$classname = "K_".$element;
		
		$this->elements[$id] = new $classname($id,$attr);
		
		// this will not work because validation is not yet defined
		// we need a public method submitted() that will run this after the elements are defined
		//if($this->submitted) 
		//	$this->elements[$id]->value = $this->get_value($id);
		
		return $this->elements[$id];
	}
	
	public function submitted_and_valid() {
		if($this->submitted) {
			foreach($this->elements as $id => $element) {
				$this->get_value($id);
			}
		}
		else {
			return false;
		}
		
	}
	
	public function html() {
		$out = $this->form_open();
		
		foreach($this->elements as $id => $element)
		{
			$out .= $element->html();
		}
		
		$out .= "</form>";
		
		return $out;
			
	}
	
	/**
	 * Create the opening FORM tag with all attributes
	 */
	function form_open() {
		$out = "<form";
		$out .= write_attributes($this->attributes);
		$out .= ">";
		return $out;
	}
	
	function form_close() {
		return "</form>";
	}
	
	/**
	 * This dunction is private and used by the constructor that needs(?) to know
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
		$method = "get_value_".$this->method;
		return $this->$method($id);
		
	}
	
	function get_value_post($id) {
		// use filter functions and validation
		//var_dump($this->elements[$id]->validation);
		if(!empty($this->elements[$id]->validation)) {
			$validate = new Validation($id);
			foreach($this->elements[$id]->validation as $method => $args) {
				//for the case when method is passed in the array without arguments
				if(is_numeric($method)) {
					$method = $args;
					$args = NULL;
				}
				$validate->$method($args);
				
				
			}
		}
		
	}
	
	function get_value_get($id) {
		
	}
}

