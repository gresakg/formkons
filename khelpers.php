<?php

/**
 * Transform an associative array into a string of valid html/xml name/value attribute
 * pairs to be included in tags
 * @param type $attributes
 * @return string
 */
function write_attributes($attributes) {
	$out = "";
	if(is_array($attributes)) {
		foreach($attributes as $name => $value) {
			$out .= " ".$name."='".$value."'";
		}
	}
	return $out;

}

/**
 * Transform a string into lowercase ascii characters and numbers with spaces
 * transformed into underscores.
 * Handy for urls, filenames etc.
 * @param type $str
 * @return string
 */
function underscore($str) {

	$str = deaccentuate(trim($str));
    $str = preg_replace(array('/[\s.,\']+/'), '_', strtolower($str));
    $str = preg_replace(array('/[^a-z0-9\-_]+/'),'',$str);
    if(empty($str)) $str="_";
    return $str;
	
}

/**
 * Transform accentuated characters to their non accentuated equivalents.
 * @param type $str
 * @return type
 */
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

/**
 * Convert human readable string representation (like 2G, 5M) to bytes
 * @param type $val
 * @return int
 */
function to_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
		
		case 't':
            $val *= 1024;
		case 'g':
            $val *= 1024;
		case 'm':
            $val *= 1024;
		case 'k':
            $val *= 1024;        
		
    }

    return $val;
}
