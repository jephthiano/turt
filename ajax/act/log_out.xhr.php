<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$error = []; $data = [];
if(isset($_GET['id']) && isset($_GET['type'])){
	//validating and sanitising id
	$id = test_input(removenum($_GET['id']));
	if(empty($id)){$error[] = "id";}else{$cid = test_input($id);}
	
	//validating and sanitising type
	$ty = test_input(($_GET['type']));
	if(empty($ty)){
		$error[] = "ty";
	}elseif($ty !== 'current' && $ty !== 'selective' && $ty !== 'all'){
		$error[] = "ty";
	}else{
		$type = test_input($ty);
	}
	
	if(empty($error)){
		$user = new user('delete');
		$user->id = $cid;
		$log_out = $user->log_out($type);
		if($log_out === 'success'){
			$data["status"] = 'success';$data["message"] = file_location('home_url','');
		}elseif($log_out === 'fail'){
			$data["status"] = 'fail';$data["message"] = "Error occur while running logging out account";
		}
	}else{
		$data["status"] = 'fail';$data["message"] = "Error occur while running request";
	}
}
echo json_encode($data);
?>