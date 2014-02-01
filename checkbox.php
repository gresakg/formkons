<?php

/**
 * This class is used for both checkboxes and radios, because they differ only in
 * few details.
 */
class K_checkbox extends Kelements {
	
	var $options = array();
	var $labels = array();
	
	/**
	 * Iterator of options
	 * @var integer
	 */
	private $i = 0;
	
	public function __construct($name, $attributes) {
		parent::__construct($name, $attributes);
		$this->add_option($attributes['value'],$attributes);
		
	}
	
	/**
	 * Add a new option with the same name
	 * @param type $value
	 * @param type $attr
	 */
	public function add_option($value, $attr=array()){
		$this->i++;
		if(!isset($attr['id'])) $attr['id'] = $this->attributes['name'].$this->i;
		if($this->attributes['type'] == "checkbox") $attr['name'] = $this->attributes['name']."[".$this->i."]";
		$attr['value'] = $value;
		$this->options[$this->i] = array_merge($this->attributes,$attr);
	}
	
	/**
	 * Add an attribute to a specific option element
	 * @param type $id
	 * @param type $attr
	 */
	public function add_option_attributes($id,$attr) {
		foreach($attr as $name => $value) {
			$this->options[$id][$name] = $value; 
		}
	}
	
	/**
	 * Remove an attribute from an option element
	 * @param type $id
	 * @param type $name
	 */
	public function remove_option_attribute($id,$name) {
		if(isset($this->options[$id][$name]))
			unset($this->options[$id][$name]);
	}
	
	/**
	 * Sets the value property. It also selects/checks the right option(s)
	 * @param type $value
	 * @param type $preserve_in_form
	 */
	public function set_value($value, $preserve_in_form = true) {		
		foreach($this->options as $key => $option) {
			if(is_array($value)) $v=$value[$key]; 
			else $v=$value;
			if($option['value'] === $v) {
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
	
	/**
	 * Convenience method for adding a label to the specific option
	 * @param type $label
	 * @param type $position
	 * @param type $labeltags
	 * @param type $attr
	 */
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
	
	/**
	 * Outputs the whole bunch as html
	 * @param type $display_errors
	 * @return type
	 */
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
		
		$out = $this->wrapp($out);
		
		return $out;
	}
	
}