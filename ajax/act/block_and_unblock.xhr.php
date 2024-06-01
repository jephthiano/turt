<?php
if(isset($_GET['id']) && isset($_GET['type'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = [];
		
	//validating and sanitising id
	$id = test_input(removenum($_GET['id']));
	if(empty($id)){
		$error[] = "id";
	}else{
		$blockee_id = test_input($id);
		if($uid == $blockee_id){$error[] = "non";}
	}
	
	//validating and sanitising type
	$ty = test_input(($_GET['type']));
	if(empty($ty)){$error[] = "ty";}else{$type = test_input($ty);}
	
	//validating and sanitising action
	$act = test_input(($_GET['act']));
	if(empty($act)){$error[] = "act";}else{$action = test_input($act);}
	
    if(empty($error)){
		if(content_data('block_table','b_id',$uid,'blockee_id',"AND blocker_id = {$blockee_id}") !== false){//check if this profile id blocks current user
			echo "blocked";
		}else{
			$user = new user('insert_delete');
			$user->action = $action;
			$user->blockee_id = $blockee_id;
			$run_request = $user->block_and_unblock();
			block_status($type,$blockee_id);
		}
    }// end of if empty $error
	
}// end of if isset
?>