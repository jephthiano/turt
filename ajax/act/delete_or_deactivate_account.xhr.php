<?php
if(isset($_POST["pss"])){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	$type = ($_POST['ty']);
	// validating and sanitizing password
	$pass = ($_POST['pss']);
	if(!password_verify($pass,content_data('user_table','u_password',$uid,'u_id'))){$error['psse'] = "* incorrect password";}
	
	if(empty($error)){
		$delete = '';$current_user = $uid;
		if($type === 'deactivate'){
			$user = new user('update');
			$user->col = "u_status";
			$user->data = "deactivated";
			$delete = $user->update_user_data();
		}elseif($type === 'delete'){
			$cover_pics = get_media('cover_pics',$uid);$profile_pics = get_media('profile_pics',$uid); // get cover pics and profle pics
			$user = new user('update');
			$user->id = $uid;
			$delete = $user->delete_account();
		}
		if($delete === 'success'){
			if($type === 'delete'){
				//delete profile_pics images
				$profile_full_path = file_location('media_path',$profile_pics);
				if(file_exists($profile_full_path) && $profile_pics !== 'home/avatar.png'){unlink($profile_full_path);}
				//delete coverpics image
				$cover_full_path = file_location('media_path',$cover_pics);
				if(file_exists($cover_full_path) && $cover_pics !== 'home/cover.jpg'){unlink($cover_full_path);}
			}
			//to be used in session destroy
			$type = "all"; 
            require_once(file_location('inc_path','session_destroy.inc.php'));
			$data["status"] = 'success';$data["message"] = "";
		}else{
			$data["status"] = 'fail';$data["message"] = "Error occcur while running request";
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $error;
	}
	echo json_encode($data);
}//end of if isset
?>
