<?php

function write_attributes($attributes) {
	$out = "";
	if(is_array($attributes)) {
		foreach($attributes as $name => $value) {
			$out .= " ".$name."='".$value."'";
		}
	}
	return $out;

}

