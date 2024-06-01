<?php
if(isset($_GET['id']) && isset($_GET['type'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	
	//validating and sanitising id
	$id = test_input(removenum($_GET['id']));
	if(empty($id)){$error[] = "id";}else{$account_id = test_input($id);}
	
	//validating and sanitising type
	$type = test_input($_GET['type']);
	//return the follower counter
	user_data($type,$account_id);
}
?>