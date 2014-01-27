<?php

include_once 'validation.php';
include_once 'input.php';
include_once 'checkbox.php';
include_once 'upload.php';


/**
 * All the common methods to all elements
 */
class Kelements {
	
	var $value = NULL;
	var $attributes = array();
	var $validation =array();
	var $error = array();
	var $html;
	
	var $label;
	var $label_position = "before";
	
	public function __construct($name,$attributes) {
	
		$this->attributes = $attributes;
		$this->attributes['name'] = $name;

	}
	
	public function set_attribute($name,$value) {
		$this->attributes[$name] = $value;
	}
	
	/**
	 * Adds a label to the object
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
	
	public function set_validation($methods) {
		$this->validation = array_merge($this->validation,$methods);
	}
	
	// just an alias
	public function set_filters($methods) {
		$this->set_validation($methods);
	}
	
	/**
	 * Wrapps the element with tags and adds attributes to the opening tag
	 * @param type $tag
	 * @param type $attributes
	 */
	public function set_wrapper($tag, $attributes) {
		
	}
	
	function html($display_errors = false) {
		$out = "Error! This method must be overriden by element extensions.";
		
		return $out;
	}
	
	function set_value($value) {
		$this->value = $value;
		// this method must be overriden because it must also set up the value in the form
		// in case validation fails. This may differ from element to element 
	}
	
	function display_errors() {
		$out = false;
		if(count($this->error) > 0) {
			$out = "<ul class='errors'>";
			foreach($this->error as $error) {
				$out .= "<li>$error</li>";
			}
			$out .= "</ul>";
		}
		return $out;
	}
	
}

