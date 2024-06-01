<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	// validating and sanitizing username
	$nwu = ($_POST['nwu']);
	$usr_id = content_data('user_table','u_id',$nwu,'u_username');
	if(empty($nwu) || strlen($nwu) < 4){
		$data["status"] = 'fail';$data["message"] = "Username must be more than 3 chars";
		$missing = "error";
	}elseif(!regex('username',$nwu)){
		$data["status"] = 'fail';$data["message"] = "Only alpahnumeric are allowed";
		$missing = "error";
	}elseif($usr_id !== false){
		if($usr_id === $uid){
			$data["status"] = 'fail';$data["message"] = "Current username cannot be used as new username";
		}else{
			$data["status"] = 'fail';$data["message"] = "Username already taken";
		}
		$missing = "error";
	}else{
		$username = (test_input($nwu));
	}
	
	if(empty($missing)){
		$user = new user('update');
		$user->data = $username;
		$user->col = 'u_username';
		$update = $user->update_user_data();
		if($update === 'success'){
			$data["status"] = 'success';$data["message"] = file_location('home_url',"settings/account/");
		}else{
			$data["status"] = 'fail';$data["message"] = "Error occcur while updating username";
		}
	}
	echo json_encode($data);
}//end of if isset
?>