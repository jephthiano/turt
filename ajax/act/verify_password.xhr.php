<?php
if(isset($_POST["pss"])){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	$type = ($_POST['ty']);
	// validating and sanitizing password
	$pass = ($_POST['pss']);
	if(empty($pass)){
		$data["status"] = 'fail';$data["message"] = "Password cannot be empty";
		$error = "error";
	}
	
	if(empty($error)){
		if(password_verify($pass,content_data('user_table','u_password',$uid,'u_id'))){
			$data["status"] = 'success';$data["message"] = $type;
		}else{
			$data["status"] = 'fail';$data["message"] = "Incorrect password";
		}
	}
	echo json_encode($data);
}//end of if isset
?>