<?php

class K_checkbox extends Kelements {
	
	var $options = array();
	var $labels = array();
	
	private $i = 0;
	
	public function __construct($name, $attributes) {
		parent::__construct($name, $attributes);
		$this->add_option($attributes['value'],$attributes);
		
	}
	
	public function add_option($value, $attr=array()){
		$this->i++;
		if(!isset($attr['id'])) $attr['id'] = $this->attributes['name'].$this->i;
		if($this->attributes['type'] == "checkbox") $attr['name'] = $this->attributes['name']."[".$this->i."]";
		$attr['value'] = $value;
		$this->options[$this->i] = array_merge($this->attributes,$attr);
	}
	
	function add_option_attributes($id,$attr) {
		foreach($attr as $name => $value) {
			$this->options[$id][$name] = $value; 
		}
	}
	
	function remove_option_attribute($id,$name) {
		if(isset($this->options[$id][$name]))
			unset($this->options[$id][$name]);
	}
	
	public function set_label($label,$position="before",$labeltags=true,$attr=false) {
		$this->label_position = $position;
		if($labeltags){
			$attr['for'] = $this->options[$this->i]['id'];
			$this->labels[$this->i] = "<label".  write_attributes($attr).">$label</label>";
		}
		else {
			$this->labels[$this->i] = $label;
		}
	}
	
	public function html($display_errors = false) {
		$out = "";
		foreach($this->options as $key => $option) {
			if($this->label_position == "before") 
			$out .= empty($this->labels[$key])?"":$this->labels[$key];
		$out .= "<input";
		$out .= write_attributes($option);
		$out .= ">";
		if($this->label_position == "after") 
			$out .= empty($this->labels[$key])?"":$this->labels[$key];
		}
		if($display_errors) $out .= $this->display_errors();
		
		return $out;
	}
	
	function set_value($value, $preserve_in_form = true) {
		foreach($this->options as $key => $option) {
			if($option['value'] === $value) {
				$this->add_option_attributes($key, array("checked"=>"checked"));
			}
			else {
				if($this->attributes['type'] == "radio") {
					$this->remove_option_attribute($key,"checked");
				}
			}
		}
		$this->value = $value;
	}
	
}

