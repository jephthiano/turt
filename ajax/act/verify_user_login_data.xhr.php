<?php
if(isset($_POST["usid"])){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	// validating and sanitizing data
	 $usid = ($_POST['usid']);
	//check if it is mobile number or username or email
	$col = get_id_column($usid);
	if($col === false){
		$error['uside'] = "* invalid input";
	}else{
		$en_usid = get_id_true_data($usid,$col);
		$usr_id = content_data('user_table','u_id',$en_usid,$col); //get u_id through $usid
		if($col === 'u_email'){
			$type = 'email';
			if($usr_id !== false){
				if($usr_id === $uid){
					$error['uside'] = "* current email cannot be used as new email";
				}else{
					$error['uside'] = "* email already taken";
				}
			}else{
				$new_id = (test_input($usid));
			}
		}elseif($col === 'u_phnumber'){
			$type = 'mobile number';
			if($usr_id !== false){
					if($usr_id === $uid){
						$error['uside'] = "* current mobile number cannot be used as new mobile number";
					}else{
						$error['uside'] = "* mobile number already taken";
					}
				}else{
					$new_id = (test_input($usid));
				}
		}else{
			$error['uside'] = "* invalid input";
		}
	}

	if(empty($error)){
		//DELETE ANY CODE IN DATABASE AND TOKEN
			insert_update_delete_user_code('delete',$new_id);
			//SET CODE INTO DATABASE AND SET TOKEN
			$code = generate_code();
			set_user_token_cookie($new_id,$code);
			if(insert_update_delete_user_code('insert',$new_id,$code) === true){
				//send text or email
				if($type === 'mobile number'){
					$sent_code_message = true;
				}elseif($type === 'email'){
					$sent_code_message = true;
				}
				if($sent_code_message){
					$data["status"] = 'success';$data["message"] = $type;
				}else{
					//DELETE ANY CODE IN DATABASE AND TOKEN
					insert_update_delete_user_code('delete',$new_id);
					$data["status"] = 'fail';$data["message"] = "Error occurred while sending code to {$type}";
				}
			}else{
				//DELETE ANY CODE IN DATABASE AND TOKEN
				insert_update_delete_user_code('delete',$new_id);
				$data["status"] = 'fail';$data["message"] = "Error occurred while processing {$type}";
			}
	}else{
		$data["status"] = 'error';$data["errors"] = $error;
	}
	echo json_encode($data);
}//end of if isset
?>