<?php

include_once 'input.php';
include_once 'checkbox.php';
include_once 'upload.php';


/**
 * All the common methods to all elements
 * This class should be extended by particular elements
 * Methods may be overriden or added.
 */
class Kelements {
	
	var $id;
	var $value = NULL;
	var $attributes = array();
	var $validation =array();
	var $error = array();
	var $msg;
	var $html;
	
	var $label;
	var $label_position = "before";
	var $owrapper;
	var $cwrapper;
	
	var $default_filters = array();
	
	public function __construct($name,$attributes) {
	
		$this->attributes = $attributes;
		$this->attributes['name'] = $name;
		$this->id = $name;
		include 'messages.php';
		$this->msg = $msg;

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
	function get_value($type) {
		//var_dump($this->elements[$id]->validation);
		$value = $this->get_input($type);
		$value = $this->run_validation($value);	
		return $value;
		
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
	 * Iterates through the validation array and applies all the validation methods
	 * to value
	 * @param mixed $value raw value
	 * @return mixed validated value
	 */
	protected function run_validation($value) {
		if(!empty($this->validation)) {
			foreach($this->validation as $method => $args) {
				//for the case when method is passed in the array without arguments
				if(is_numeric($method)) {
					$method = $args;
					$args = NULL;
				}
				
				if(is_callable($method)) {
					if(is_array($args)) {
						array_unshift($args,$value);
						call_user_func_array($method, $args);
					}
					else {
						$value = $method($value);
					}
				}
				$value = $this->$method($value, $args);				
			}
		}
		return $value;
	}
	
	/**
	 * This method ows it's existance to the fact that php native function filter_input
	 * does not work on array fields. It fetches the value and TODO applies native 
	 * php filters on the value
	 * @param string $type
	 * @param string $name
	 * @param array $filters
	 * @return mixed  
	 */
	protected function get_input($type,$filters=array()) {
		$result = false;
		switch($type) {
			case "post":
				if(isset($_POST[$this->id])) $result = $_POST[$this->id];
				break;
			case "get":
				if(isset($_GET[$this->id])) $result = $_GET[$this->id];
				break;
			case "cookie":
				if(isset($_COOKIE[$this->id])) $result = $_COOKIE[$this->id];
				break;
			case "server":
				if(isset($_SERVER[$this->id])) $result = $_SERVER[$this->id];
				break;
			case "request":
			default:
				if(isset($_REQUEST[$this->id])) $result = $_REQUEST[$this->id];
				break;
		}
		$filters = array_merge($this->default_filters,$filters);
		if(!empty($filters)) {
			if(is_array($result)) {
				foreach($result as $key => $item) {
					// TODO apply filters on each $item
				}
			}
			else {
				// TODO apply filters on $result
			}
		}
		return $result;
	} 
	
	/**
	 * Returns true if element object has (validation) errors
	 * @return boolean
	 */
	public function has_errors() {
		if(empty($this->error))
			return false;
		else 
			return true;
	}
	
	/**
	 * Sets error messages
	 * @param type $method
	 * @param type $text
	 */
	protected function set_error($method, $text=false) {
		if($text !== false) $this->error[] = $text;
		if(isset($this->msg[$method])) $this->error[] = $this->msg[$method];
		else $this->error[] = "Error message not found!";	
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
				if($as_html) $line = "<li>".$line."</li>";
				$out .= $line;
			}
			if($as_html) $out = "<ul class='errors'>".$out."</ul>";
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
	
	/**
	 * VALIDATION METHODS
	 * Validation methods for an object are logically part of that object, so
	 * no extra validation class is required.
	 * 
	 * Validation methods specific to certain elements may be defined in subclasses
	 * for that elements.
	 */
	
	/**
	 * Sets error if $value is missing
	 * @param type $value
	 * @return type
	 */
	function required($value) {
		if(empty($value)) 
			$this->set_error('required');
		return $value;
	}
	
	/**
	 * Returns error if $value is not one of the specified options
	 * @param mixed $value
	 * @param type $options
	 * @param bool $strict if true empty will resolve to error
	 * @return type
	 */
	function restrict_to_options($value, $args) {
		
		if(empty($args['strict'])) $args['strict'] = false;
		extract($args);
		
		if(empty($value))
			if($strict) {
				$this->set_error('restrict_to_options');
				return $value;
			}
			else { 
				return $value;
			}
		if(is_array($options)) {
			if(is_array($value)) {
				foreach($value as $item) {
					if(!in_array($item, $options)) { 
						$this->set_error('restrict_to_options');
						return $value;
					}
				}
			}
			else {
				if(!in_array($value,$options)) { 
					$this->set_error('restrict_to_options');
					return $value;
				}
			}
		}
		
		else {
			$this->set_error("options_not_set");
		}
		
		return $value;
	}
	
	/**
	 * Dummy method that allways returns an error.
	 * For debugging purposes.
	 */
	function fail($value) {
		$this->set_error('fail');
		return $value;
	}
}

