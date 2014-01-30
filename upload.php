<?php

class K_upload extends Kelements {
	
	var $upload_folder = "uploads";
	var $max_file_size = 2000000;
	
	public function __construct($name, $attributes) {
		parent::__construct($name, $attributes);
		$this->set_upload_folder($this->upload_folder);
	}
	
	function html($display_errors = false) {
		$out = "";
		if($this->label_position == "before") 
			$out .= empty($this->label)?"":$this->label;
		if($this->max_file_size > 0) {
			$out .= "<input type='hidden' name='MAX_FILE_SIZE' value='".$this->max_file_size."'>\n";
		}
		$out .= "<input";
		$out .= write_attributes($this->attributes);
		$out .= ">";
		if($this->label_position == "after") 
			$out .= empty($this->label)?"":$this->label;
		
		if($display_errors) $out .= $this->display_errors();
		
		return $out;
	}
	
	function do_upload() {
		$raw_file = $_FILES[$this->attributes['name']]['tmp_name'];
		$filename = $_FILES[$this->attributes['name']]['name'];
		if(is_uploaded_file($raw_file)) {
			if(!move_uploaded_file($raw_file, $this->upload_folder."/".$filename)) {
				die("An error occured uploading file!");
			}
		}
		else {
			die("Error uploading file!");
		}
	}
	
	function set_upload_folder($name) {
		if(is_dir($name)) {
			$this->upload_folder = $name;
		}
		else {
			die("$name does not exist!");
		}
	}
	
	function set_max_file_size($size) {
		$this->max_file_size = $size;
	}
}


