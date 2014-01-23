<?php

include_once 'khelpers.php';
include_once 'kelements.php';

class Formkons {
	
	var $submitted = false;
	var $method;
	var $attributes = array();
	var $elements;
	
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
		if($this->submitted) 
			$this->elements[$id]->value = $this->get_value($id);
		
		return $this->elements[$id];
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
	
	function is_submitted($method) {
		if($method=="post" && (!empty($_POST))) return true;
		if($method=="get" && (!empty($_GET))) return true;
		return false;
	}
	
	function get_value($id) {
		return $this->get_value_{$this->method}($id);
	}
	
	function get_value_post($id) {
		// use filter functions and validation
	}
	
	function get_value_get($id) {
		
	}
}

