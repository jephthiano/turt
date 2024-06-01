<?php
if(isset($_GET['val']) && isset($_GET['type'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = [];
		
	//validating and sanitising id
	$val = test_input(($_GET['val']));
	if($val !== 'on' && $val !== 'off'){$error[] = "val";}else{$value = test_input($val);}
	
	//validating and sanitising type
	$type = test_input($_GET['type']);
	if($type === 'prat'){$col = 's_private_account';$settings = 'Private account';}
	elseif($type === 'lcme'){$col = 's_lock_inbox';$settings = 'Lock message';}
	elseif($type === 'dert'){$col = 's_disable_returt';$settings = 'Disable returt';}
	elseif($type === 'ukat'){$col = 's_unlink_account';$settings = 'Unlink account';}
	elseif($type === '2ftm'){$col = 's_2fa_text';$settings = '2fa (text message)';}
	elseif($type === '2fe'){$col = 's_2fa_email';$settings = '2fa (email)';}
	elseif($type === 'lgme'){$col = 's_login_email';$settings = 'Email (login)';}
	else{$error[] = "ty";}
	
	//getting the setting value
	if($val === 'on'){$action = 'enabled';}else{$action = 'disabled';}
    if(empty($error)){
		$user = new user('update');
		$user->value = $value;
		$user->col = $col;
		$update = $user->update_user_settings();
		if($update === 'success'){
			$data["status"] = 'success';$data["message"] = "{$settings} {$action}";
		}else{
			$data["status"] = 'fail';$data["message"] = "Error occurred while updating settings";
		}
    }else{
		$data["status"] = 'fail';$data["message"] = "Error occurred while updating settings";
	}
	
}else{
	$data["status"] = 'fail';$data["message"] = "Error occurred while updating settings";
}
echo json_encode($data);
?>