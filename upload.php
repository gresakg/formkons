<?php

class K_upload extends Kelements {

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


