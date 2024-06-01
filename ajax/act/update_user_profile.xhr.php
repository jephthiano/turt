<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$error = []; $missing = []; $data = [];
if(isset($_POST)){
	// validating and sanitizing fullname
	$nam = ($_POST['fnm']);
	if(empty($nam)){$missing['fnme'] = "* Name cannot be empty";}else{($fullname = test_input($nam));}
	
	// validating and sanitizing bio
	$bi = ($_POST['bio']);
	if(empty($bi)){
		$bio = NULL;
	}elseif(strlen($bi) > 200){
		$missing['bioe'] = "* bio can not be more 200 char";
	}else{
		$bio = (test_input($bi));
	}
	
	// validating and sanitizing web
	$web = ($_POST['web']);
	if(empty($web)){
		$website = NULL;
	}else{
		$website = (test_input($web));
	}
	
	// validating and sanitizing state
	$ste = ($_POST['ste']);
	if(empty($ste)){
		$state = NULL;
	}else{
		$state = (test_input($ste));
	}
	
	if(empty($error) and empty($missing)){
		$user = new user('user_update');
		$user->fullname = $fullname;
		$user->bio = $bio;
		$user->website = $website;
		$user->state = $state;
		$update_profile = $user->update_profile_data();
		if($update_profile === 'success'){
			$username = content_data('user_table','u_username',$uid,'u_id');
			$data["status"] = 'success';$data["message"] = file_location('home_url',"$username/");
		}elseif($update_profile === 'fail'){
			$data["status"] = 'fail';$data["message"] = "Error occurred while saving data";
		}
	}else{
		if(!empty($error)){
		}else{
			$data["status"] = 'error';$data["errors"] = $missing;
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Error occurred while saving data';
}//end of if empty
echo json_encode($data);
?>