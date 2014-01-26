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

function underscore($str) {

	$str = deaccentuate(trim($str));
    $str = preg_replace(array('/[\s.,\']+/'), '_', strtolower($str));
    $str = preg_replace(array('/[^a-z0-9\-_]+/'),'',$str);
    if(empty($str)) $str="_";
    return $str;
	
}


function deaccentuate($str) {
	$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 
		'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'Č'=>'C', 'È'=>'E', 
		'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 
		'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 
		'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 
		'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'č'=>'c',  'è'=>'e', 'é'=>'e', 
		'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 
		'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 
		'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
	return strtr( $str, $unwanted_array );
}
