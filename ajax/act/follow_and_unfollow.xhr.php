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
		$followee_id = test_input($id);
		if($uid == $followee_id){$error[] = "non";}
	}
	
	//validating and sanitising type
	$ty = test_input(($_GET['type']));
	if(empty($ty)){$error[] = "ty";}else{$type = test_input($ty);}
	
	//validating and sanitising action
	$act = test_input(($_GET['act']));
	if(empty($act)){$error[] = "act";}else{$action = test_input($act);}
	
    if(empty($error)){
		if(content_data('block_table','b_id',$uid,'blocker_id',"AND blockee_id = {$followee_id}") !== false){//check if current user blocks this profile id
			echo "blocked";
		}elseif(content_data('block_table','b_id',$uid,'blockee_id',"AND blocker_id = {$followee_id}") !== false){//check if this profile id blocks current user
			echo "blocked";
		}else{
			$user = new user('insert_delete');
			$user->action = $action;
			$user->followee_id = $followee_id;
			$user->follow_and_unfollow();
			//insert notification if action is follow
			if($action === 'follow'){
				$notification = new notification('insert');
				$notification->type = 'follow';
				$notification->content_id = $followee_id;
				$notification->receiver_id = $followee_id;
				$notification->insert_notification();
			}
			follow_status($type,$followee_id);
		}
    }// end of if empty $error
	
}// end of if isset
?>