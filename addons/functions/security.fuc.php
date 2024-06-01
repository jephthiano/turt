<?php
//SECURITY FUNCTIONS STARTS
// decode output starts
function decode_data($data){$data = htmlspecialchars_decode($data);return $data;}
//decode output ends

//sanitaition starts
//function test_input($data){
//	$data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
//	$data = trim($data);
//	$data = stripslashes($data);
//	$data = stripslashes($data);
//	$data = stripslashes($data);
//	$data = stripslashes($data);
//	$data = stripslashes($data);
//	$data = htmlspecialchars($data);
//	$data = strip_tags($data);
//	$data = htmlentities($data);
// return $data;
//}
//sanitaition ends

//encryption and decryption 2 starts
define('IV','mwrsaasghsh53456');
define("CIPHER","aes-128-cfb");
define("KEY","6346634bchbjdb");
//encryption
function ssl_encrypt_input($data){
	return openssl_encrypt($data,CIPHER,KEY,OPENSSL_ZERO_PADDING,IV);
}
//decryption
function ssl_decrypt_input($data){
	return openssl_decrypt($data,CIPHER,KEY,OPENSSL_ZERO_PADDING,IV);
}
// message encryption
function ssl_encrypt_message($data){
	return openssl_encrypt($data,CIPHER,KEY,OPENSSL_ZERO_PADDING,IV);
}
// message decryption
function ssl_decrypt_message($data){
	return openssl_decrypt($data,CIPHER,KEY,OPENSSL_ZERO_PADDING,IV);
}
//encryption and decryption 2 ends	

// hash input starts
function hash_input($data){$salt1 = '@jhdge$#fyyigtun76565665nk3?(hryryr())hghg@%^&#$#';$salt2 = 'leehack2DJhs(874764_))';return hash('ripemd128',"$salt1$data$salt2");}
// hash input ends

// hash pass starts
function hash_pass($pass){$options = ['cost' => 10,];return password_hash($pass, PASSWORD_DEFAULT, $options);}
// hash pass ends

// regex starts
function regex($type,$data){
 if($type === 'email'){
  $reg = "/^[\w.-]*@[\w.-]+\.[A-Za-z]{2,6}$/";
 }elseif($type === 'username'){
  $reg = "/^[a-zA-Z0-9\_]*$/";
 }elseif($type === 'phonenumber'){
  $reg = "/^\+?[\d]{11}$/";
 }elseif($type === 'word_comma'){ //for languages and co
  $reg = "/^[\w]*\,?\ ?[\w]*\,?\ ?[\w]*\,?\ ?[\w]*\,?\ ?$/";
 }elseif($type === 'word_space'){
  $reg = "/^[a-zA-Z ]*$/";
 }elseif($type === 'word_number_nospace'){
  $reg = "/^[a-zA-Z0-9]*$/";
 }elseif($type === 'skill'){ // for word . ' - @ 
  $reg = "/^[\w .'-@]+$/";
 }elseif($type === 'sql_date'){
  $reg = "/^[\d]{4}-[\d]{2}-[\d]{2} [\d]{2}:[\d]{2}:[\d]{2}$/";
 }elseif($type === 'account_number'){
  $reg = "/^[\d]{10}$/";
 }else{
  return false;
 }
 return preg_match($reg,$data);
}
// regex ends

//add random number starts
function addnum($data){$first_four = rand(1,9).rand(1,9).rand(1,9).rand(1,9);$last_three = rand(1,9).rand(1,9).rand(1,9);return strrev($first_four.$data.$last_three);}
//add random number ends
	
//remove random number starts
function removenum($data){return strrev(substr(substr($data,3),0,-4));}
//remove random number ends

//SECURITY FUNCTIONS ENDS
?>