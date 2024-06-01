<?php
// DEVICE AND LOCATION FUNCTION STARTS
//get browser details starts
function browser_detail($type){
 $br = get_browser();
 if($br){
  return $br->$type;
 }else{
  return "unknown type";
 }
}
//get browser details ends

//get ip address starts
function get_ip_address(){
 $geolocation = @unserialize(file_get_contents("https://ip-api.com/php/"));
	if($geolocation && $geolocation['status'] === 'success'){
  $ip_address = $geolocation['query'];
 }else{
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){ // shared network
   $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ // proxy network
   $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
   $ip_address = $_SERVER['REMOTE_ADDR'];
  }
 }
	return $ip_address;
}
//get ip address ends

//check ip address starts
function lock_data($column){
	$ip_address = get_ip_address();
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('userselect','PDO');
	$sql = "SELECT $column FROM lock_table	WHERE l_ipaddress = :ip";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':ip',$ip_address,PDO::PARAM_STR);
	$stmt->bindColumn($column,$result);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){
  while($stmt->fetch()){return $result;}
	}else{
  return false;
 }
	closeconnect("stmt",$stmt);
	closeconnect("db",$conn);
}
//check ip address ends

//get location data starts
function get_location_data($data){
 $geolocation = @unserialize(file_get_contents("http://ip-api.com/php/"));
	if($geolocation && $geolocation['status'] === 'success'){
  return strtolower($geolocation[$data]);
 }else{
  return 'unknown';
 }
}
//get location data ends
// DEVICE AND LOCATION FUNCTION ENDS
?>