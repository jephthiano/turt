<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$error = []; $missing = []; $data = [];
if(isset($_POST)){
	$cookie_content = get_user_token_cookie('content');
	$cookie_code = get_user_token_cookie('code');
	$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
	$verify = content_data('token_code_table','c_verify',$cookie_content,'c_content');
	//if  verify is no
	if($verify !== 'yes'){
		$error[] = 'error';
		$data["status"] = 'success';$data["message"] = file_location('home_url','forgot_password/code/');
	}
	//if cookie content and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		$error[] = 'invalid_id';
		insert_update_delete_user_code('delete',$cookie_content);
	}
	
	//check if it is mobile number or email
	$val = get_id_column($cookie_content);
	if($val === false){
		$error[] = 'invalid_id';
	}else{
		$col = $val;
	}
	
	//validating id
	$id = strtolower($_POST['id']);
	$en_id = get_id_true_data(strtolower($id),$col); // en login id from id
	$db_id = get_id_true_data(content_data('user_table',$col,$en_id,$col),$col,'decrypt');//decyrpt if id is phnumber or email
	//if login_id is not in database && $db_id is not equal to $cookie_content
	if($db_id === false || $db_id !== $id){
		$error[] = 'invalid_id';
	}
	
	// validating and sanitizing password
	$pass = ($_POST['pss']);
	if(empty($pass)){
		$missing['psse'] = "* Password cannot be empty";
	}elseif((strlen($pass) < 7)){
		$missing['psse'] = "* Password must be more than 6 chars";
	}else{
		$password = hash_pass(test_input($pass));
	}
	
	if(empty($error) and empty($missing)){
		$user = new user('update');
		$user->col = "u_password";
		$user->data = $password;
		$user->id = content_data('user_table','u_id',$en_id,$col);
		$change_password = $user->update_user_data('no id');
		if($change_password === 'success'){
			$data["status"] = 'fail';$data["message"] = "Success!!!<br>Password successfully reset<br><br>
				<a href='".file_location('home_url','login/')."'>
					<div class='j-clickable j-color1 j-btn j-padding j-round'style='width:100%'>Go Back to Login</div>
				</a>";
			//delete db code and cookie
			insert_update_delete_user_code('delete',$cookie_content);
		}elseif($change_password === 'fail'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occcur while resetting password";
		}
	}else{
		if(!empty($error)){
			if(in_array('invalid_id',$error)){
				$data["status"] = 'success';$data["message"] = file_location('home_url','forgot_password/');
			}
		}else{
			$data["status"] = 'error';$data["errors"] = $missing;
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br>Error occurred while processing data';
}//end of if empty
echo json_encode($data);
?>