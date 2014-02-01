<?php

include_once 'khelpers.php';
include_once 'kelements.php';

class Formkons {
	
	
	var $method;
	var $attributes = array();
	var $elements;
	var $errors = false;
	var $global_wrapper = false;
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
		
		if($this->global_wrapper !== false)
			$this->elements[$id]->set_wrapper($this->global_wrapper['tag'], $this->global_wrapper['attr']);
		
		return $this->elements[$id];
	}
		
	/**
	 * Add a single attribute to the opening form tag
	 * @param type $name
	 * @param type $value
	 */
	public function add_attribute($name, $value) {
		$this->attributes[$name] = $value;
	}
	
	/**
	 * Global upload config. ??
	 * @param type $config
	 */
	public function configure_upload($config) {
		
	}
	
	/**
	 * Checks if form is submitted and populates elements with values.
	 * @return boolean
	 */
	public function submitted_and_valid() {
		if($this->submitted) {
			foreach($this->elements as $id => $element) {
				$element->set_value($element->get_value($this->method));
				if($element->has_errors()) $this->errors = true;
			}			
			return !$this->errors;
		}
		else return false;		
	}
	
	/**
	 * Returns the array of all form values. Non declared values (values of elements 
	 * not set by the formkons) are ignored.
	 * @return type
	 */
	public function values_array() {
		$result = array();
		foreach($this->elements as $id => $element) {
			$result[$id] = $element->value;
		}
		return $result;
	}

	/**
	 * Convenience method for outputing the form with a one liner.
	 * @return string
	 */
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
	 * Create the opening FORM tag with all attributes.
	 * You are required to use this function if you are outputing the form in a 
	 * view (not using the above html() method)
	 */
	public function form_open() {
		$out = "<form";
		$out .= write_attributes($this->attributes);
		$out .= ">";
		return $out;
	}
	
	/**
	 * This is just to be consistent in your view files.
	 * @return string
	 */
	public function form_close() {
		return "</form>";
	}
	
	/**
	 * You can set a global wrapper tag for all elements. It's a convenience. Use 
	 * with care!  
	 * @param type $tag
	 * @param type $attributes
	 */
	public function set_global_wrapper($tag,$attributes=array()) {
		$this->global_wrapper = array('tag'=> $tag,'attr' => $attributes);
	}
	
	/**
	 * This function is private and used by the constructor that needs(?) to know
	 * if the form is submitted in advance. Do not mix with public function submitted_and_valid()
	 * that actually runs all the validation and value abstraction processes.
	 * @param type $method
	 * @return boolean
	 */
	private function is_submitted($method) {
		if($method=="post" && (!empty($_POST))) return true;
		if($method=="get" && (!empty($_GET))) return true;
		return false;
	}
	
}

