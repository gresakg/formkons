<?php

class K_input extends Kelements {
	
		
	function html() {
		$out = "";
		if($this->label_position == "before") 
			$out .= empty($this->label)?"":$this->label;
		$out .= "<input";
		$out .= write_attributes($this->attributes);
		$out .= ">";
		if($this->label_position == "after") 
			$out .= empty($this->label)?"":$this->label;
		return $out;
	}
	
}

