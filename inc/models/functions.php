<?php
function backtrace_filename_includes($name){
	$backtrace_array=debug_backtrace();
	if (strpos($backtrace_array[1]['file'],$name)==false){
		return false;
	}else{
		return true;
	}
}
		
function getHash($string) { 
    return hash_hmac('sha256', $string, ";4:@x-0|^>.(G@}!#8_];@x-{.<+k~$0|^{%`~?S"); 
}

function getMD5($string) { 
    return hash_hmac('MD5', $string, "@@@@s*7dE><sF(d][.,/g}{09)s^"); 
}

function encrypt_string($string,$key){
	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
}

function decrypt_string($string,$key){
	return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
}

function array_iunique($array) {
return array_intersect_key($array,array_unique(array_map("strtolower",$array)));
}


?>