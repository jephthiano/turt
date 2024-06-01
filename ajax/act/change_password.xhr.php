<?php
if(isset($_POST["opss"]) && isset($_POST["npss"])){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	// validating and sanitizing old password and new password
	$old_pass = ($_POST['opss']); $new_pass = ($_POST['npss']);
	if(!password_verify($old_pass,content_data('user_table','u_password',$uid,'u_id'))){
		$error['opsse'] = "* Incorrect old password";
	}elseif(empty($new_pass) || (strlen($new_pass) < 7)){
		$error['npsse'] = "* New password must be more than 6 characters<br>";
	}elseif($old_pass === $new_pass){
		$error['npsse'] = "* Current password cannot be used as new password";
	}else{
		$newpass = hash_pass(test_input($new_pass));
	}
	
	if(empty($error)){
		$user = new user('update');
		$user->col = "u_password";
		$user->data = $newpass;
		$change = $user->update_user_data();
		if($change === 'success'){
			$data["status"] = 'success';$data["message"] = "Password successfully changed";
		}else{
			$data["status"] = 'fail';$data["message"] = "Error occurred while changing password";
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $error;
	}
	echo json_encode($data);
}//end of if isset
?>