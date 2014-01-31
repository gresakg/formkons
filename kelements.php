<?php

include_once 'validation.php';
include_once 'input.php';
include_once 'checkbox.php';
include_once 'upload.php';


/**
 * All the common methods to all elements
 * This class should be extended by particular elements
 * Methods may be overriden or added.
 */
class Kelements {
	
	var $value = NULL;
	var $attributes = array();
	var $validation =array();
	var $error = array();
	var $html;
	
	var $label;
	var $label_position = "before";
	var $owrapper;
	var $cwrapper;
	
	public function __construct($name,$attributes) {
	
		$this->attributes = $attributes;
		$this->attributes['name'] = $name;

	}
	
	/**
	 * Method for adding a single atribute to the attributes array
	 * @param type $name
	 * @param type $value
	 */
	public function set_attribute($name,$value) {
		$this->attributes[$name] = $value;
	}
	
	/**
	 * Gets the validated value of the element from the $_POST, $_GET or other globals
	 * @param type $id
	 * @return type
	 */
	function get_value($id) {
		//var_dump($this->elements[$id]->validation);
		if(!empty($this->validation)) {
			$validate = new Validation($id, $this->method);
			foreach($this->validation as $method => $args) {
				//for the case when method is passed in the array without arguments
				if(is_numeric($method)) {
					$method = $args;
					$args = NULL;
				}
				$validate->$method($args);				
			}
			$this->error = $validate->error;
			if(!empty($validate->error)) $this->errors = true;
			return $validate->value;
		}
		else {
			return $_POST[$id];
		}
		
	}
	
	/**
	 * (re)sets the value of the element
	 * @param type $value
	 */
	function set_value($value) {
		$this->value = $value;
		// this method must be overriden because it must also set up the value in the form
		// in case validation fails. This may differ from element to element 
	}
	
	/**
	 * This method sets the array of validation methods that should be applied
	 * to the value of the object
	 * @param type $methods
	 */
	public function set_validation($methods) {
		$this->validation = array_merge($this->validation,$methods);
	}
	
	/**
	 * This is an alias of the above set_validation function
	 * @param type $methods
	 */
	public function set_filters($methods) {
		$this->set_validation($methods);
	}
	
	/**
	 * Convenience method for adding a html label to the object
	 * @param type $label
	 * @param string $position Wheter label comes before or after the element
	 * @param type $labeltags Wrap the label with label tags
	 * @param type $attr optional attributes for label tags
	 */
	public function set_label($label,$position="before",$labeltags=true,$attr=false) {
		$this->label_position = $position;
		if($labeltags){
			if(!isset($attr['for'])) $attr['for'] = $this->attributes['name'];
			$this->label = "<label".  write_attributes($attr).">$label</label>";
		}
		else {
			$this->label = $label;
		}
	}
	
	/**
	 * Convenience method that wrapps the element with html tags and adds attributes to the opening tag
	 * @param type $tag
	 * @param type $attributes
	 */
	public function set_wrapper($tag, $attributes) {
		$this->owrapper = "<".$tag;
		if(is_array($attributes)) {
			$this->owrapper .= write_attributes($attributes);
		}
		$this->owrapper .= ">";
		$this->cwrapper = "</".$tag.">";
	}
	
	/**
	 * Output the html of the element
	 * @param type $display_errors
	 * @return string
	 */
	public function html($display_errors = false) {
		$out = "Error! This method must be overriden by element extensions.";
		return $out;
	}
	
	/**
	 * Display validation errors. By default, errors are only separated by newlines
	 * but you can output them as a list.
	 * @param boolean $as_html
	 * @return string
	 */
	public function display_errors($as_html=false) {
		$out = false;
		if(count($this->error) > 0) {		
			foreach($this->error as $error) {
				$line = "$error\n";
				if($html) $line = "<li>".$line."</li>";
				$out .= $line;
			}
			if($html) $out = "<ul class='errors'>".$out."</ul>";
		}
		return $out;
	}
	
	/**
	 * Wrapps the string with wrap tags if they are set
	 * @param type $string
	 */
	protected function wrapp($string) {
		if(empty($this->owrapper)) 
			return $string;
		else
			return $this->owrapper."\n".$string."\n".$this->cwrapper."\n";
			
	}
	
}

