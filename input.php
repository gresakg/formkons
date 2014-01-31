<?php

class K_input extends Kelements {
	
	
	/**
	 * Sets the value property. It also resets the value if form has errors, but 
	 * you can prevent it if you want.
	 * @param type $value
	 * @param type $preserve_in_form set this to false to prevent the element to be
	 * repopulated
	 */
	function set_value($value, $preserve_in_form = true) {
		if($preserve_in_form) $this->set_attribute("value", $value);
		$this->value = $value;
	}
	
	/**
	 * Output the input tag for the element. It will also add a label or wrapp the 
	 * element if either label, wrapper or both are set.
	 * @param type $display_errors
	 * @return type
	 */
	function html($display_errors = false) {
		$out = "";
		if($this->label_position == "before") 
			$out .= empty($this->label)?"":$this->label;
		$out .= "<input";
		$out .= write_attributes($this->attributes);
		$out .= ">\n";
		if($this->label_position == "after") 
			$out .= empty($this->label)?"":$this->label;
		
		if($display_errors) $out .= $this->display_errors();
		
		$out = $this->wrapp($out);
		
		return $out;
	}
	
}

