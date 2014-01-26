<?php

class K_input extends Kelements {
	
	
	function set_value($value, $preserve_in_form = true) {
		if($preserve_in_form) $this->set_attribute("value", $value);
		$this->value = $value;
	}
	
	function html($display_errors = false) {
		$out = "";
		if($this->label_position == "before") 
			$out .= empty($this->label)?"":$this->label;
		$out .= "<input";
		$out .= write_attributes($this->attributes);
		$out .= ">";
		if($this->label_position == "after") 
			$out .= empty($this->label)?"":$this->label;
		
		if($display_errors) $out .= $this->display_errors();
		
		return $out;
	}
	
}

