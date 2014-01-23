<?php

include_once 'input.php';

class Konform {
	
	var $accept_charset;
	var $action = false;
	var $autocomplete = "on";
	var $enctype;
	var $method="post";
	var $name;
	var $novalidate;
	var $target;
	var $id;
	var $elements;
	
	function add_element($element, $id, $attr=false)
	{
		$element = strtolower(trim($element));
		if($element == "input") {
			if(is_array($attr)) {
				if(empty($attr['type'])) $type = "text";
				else $type = $attr['type'];
			}
			else $type = $attr;
		}
		$classname = "K_".$element;
		$this->elements[$id] = new $classname($id,$type);
		
		return $this->elements[$id];
	}
	
	function html() {
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
		$out = "<form>\n";
		return $out;
	}
	
}

