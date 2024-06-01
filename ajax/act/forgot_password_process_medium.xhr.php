<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$missing = []; $data = [];
if(isset($_POST)){
	$id = get_single_cookie("forgot_password_id");
	//check if it is mobile number or username or email
	$val = get_id_column($id);
	if($val === false){
		$error[] = 'invalid_id';
	}else{
		$col = $val;
	}
	$en_id = get_id_true_data(strtolower($id),$col); //login id from cookie
	$db_id = get_id_true_data(content_data('user_table',$col,$en_id,$col),$col,'decrypt');//decyrpt if id is phnumber or email
	//if login_id is not in database && $db_id is not equal to $id
	if($db_id === false || $db_id !== $id){
		$error[] = 'invalid_id';
		delete_single_cookie("login_id");
	}else{
		$id = test_input($db_id);
	}
	
	// validating and sanitizing medium
	$ty = ($_POST['mhd']);
	if($ty === 'mobile number' || $ty === 'email'){
		$type = test_input($ty);
		if($ty === 'mobile number'){
			$pass_id = get_id_true_data(content_data('user_table','u_phnumber',$en_id,$col),'u_phnumber','decrypt');
		}elseif($ty === 'email'){
			$pass_id = get_id_true_data(content_data('user_table','u_email',$en_id,$col),'u_email','decrypt');
		}
	}else{
		$error[] = 'invalid_medium';
	}
	
	if(empty($missing) && empty($error)){
		//DELETE ANY CODE IN DATABASE AND TOKEN
		insert_update_delete_user_code('delete',$pass_id);
		//SET CODE INTO DATABASE AND SET TOKEN
		$code = generate_code();
		set_user_token_cookie($pass_id,$code);
		if(insert_update_delete_user_code('insert',$pass_id,$code) === true){
			//send text or email
			if($type === 'mobile number'){
				$sent_code_message = true;
			}elseif($type === 'email'){
				$sent_code_message = true;
			}
			if($sent_code_message){
				$data["status"] = 'success';$data["message"] = file_location('home_url','forgot_password/code/');
				//delete cookie
				delete_single_cookie("forgot_password_id");
			}else{
				//DELETE ANY CODE IN DATABASE AND TOKEN
				insert_update_delete_user_code('delete',$pass_id);
				$data["status"] = 'fail';$data["message"] = "Error occurred while sending code to {$type}";
			}
		}else{
			//DELETE ANY CODE IN DATABASE AND TOKEN
			insert_update_delete_user_code('delete',$pass_id);
			$data["status"] = 'fail';$data["message"] = "Error occurred while processing {$type}";
		}
	}else{
		if(!empty($error)){
			if(in_array('invalid_id',$error)){
				$data["status"] = 'success';$data["message"] = file_location('home_url','login/');
			}
			if(in_array('invalid_medium',$error)){
				$data["status"] = 'fail';$data["message"] = "Select a valid medium to receive the code";
			}
		}else{
			$data["status"] = 'error';$data["errors"] = $missing;
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Error occurred while processing data';
}//end of if empty
echo json_encode($data);
?>