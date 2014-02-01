<?php

class K_upload extends Kelements {
	
	var $upload_folder = "uploads";
	
	/**
	 * Set to upload_max_filesize by the constructor if empty
	 * @var type 
	 */
	var $max_file_size;
	
	/**
	 * Overrides the empty default with validation methods required for file uploads.
	 * @var array
	 */
	var $dvalidation = array(
		
	);
	
	public function __construct($name, $attributes) {
		parent::__construct($name, $attributes);
		$this->set_upload_folder($this->upload_folder);
		if(empty($this->max_file_size)) {
			$this->max_file_size = to_bytes(ini_get('upload_max_filesize'));
		}
	}
	
	/**
	 * Checks if the upload folder exists and sets it
	 * @param type $name
	 */
	public function set_upload_folder($name) {
		if(is_dir($name)) {
			if(is_writable($name)) {	
				$this->upload_folder = $name;
			}
			else die("$name is not writable! Please change the permissions or the upload folder!");
			
		}
		else {
			die("$name does not exist!");
		}
	}
	
	/**
	 * Check if the size required is lower than upload_max_filesize and sets it.
	 * If it's greater or equal it sets it to upload_max_filesize
	 * @param type $size
	 */
	public function set_max_file_size($size) {
		$inilimit = to_bytes(ini_get('upload_max_filesize'));
		if($size < $inilimit) $this->max_file_size = $size;
		else $this->max_file_size =  $inilimit;
	}
	
	/**
	 * The upload element gets the value in it's own way
	 * @param type $type this parameter is ignored
	 */
	public function get_value($type) {
		if(isset($_FILES[$this->id])) {
			var_dump($_FILES[$this->id]);
		}
		else {
			return false;
		}
	}
	
	/**
	 * Output the input tag for the element. It will also add a label or wrapp the 
	 * element if either label, wrapper or both are set.
	 * @param type $display_errors
	 * @return type
	 */
	public function html($display_errors = false) {
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
		
		$out = $this->wrapp($out);
		
		return $out;
	}

	/**
	 * Validation methods specifioc to the uload subclass
	 */
	
	
}


