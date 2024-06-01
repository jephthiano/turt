<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$missing = []; $data = [];
if(isset($_POST)){
	if(get_json_data('login','act') == 0 || get_json_data('all','act') == 0){//if checkout and all act is disabled
		$data["status"] = 'fail';$data["message"] = 'Login is not available at the moment';
	}else{
		$login_id = get_single_cookie("login_id");
		//check if it is mobile number or username
		$val = get_id_column($login_id);
		if($val === false){
			$error[] = 'invalid_id';
		}else{
			$col = $val;
		}
		
		$id = get_id_true_data(strtolower($_POST['id']),$col); //login id from form
		$db_id = get_id_true_data(content_data('user_table',$col,$id,$col),$col,'decrypt');//decyrpt if id is phnumber or email
		//if login_id is not in database && $db_id is not equal to $login_id
		if($db_id === false || $db_id !== $login_id){
			$error[] = 'invalid_id';
			delete_single_cookie("login_id");
		}else{
			$login_id = $db_id;
		}
		
		// validating and sanitizing password
		$pass = ($_POST['pss']);
		if(empty($pass)){$missing['psse'] = "* Input password";}else{$password = test_input($pass);}
		
		if(empty($missing) && empty($error)){
			$user = new user('admin');
			$user->col = $col;
			$user->login_id = $login_id;
			$user->current_password = $password;
			$user_id = $user->authenticate_login();
			//validate login
			if($user_id == true && is_numeric($user_id)){
				delete_single_cookie("login_id");//delete cookie
				require_once(file_location('inc_path','session_set.inc.php'));//setting session
				$data["status"] = 'success';$data["message"] = $_POST["re"];
			}elseif($user_id === 'suspended'){
				$data["status"] = 'fail';$data["message"] = 'Account has been suspended, contact admin.';
			}elseif($user_id === 'fail'){
				$data["status"] = 'fail';$data["message"] = "Wrong passsword";
			}
		}else{
			if(!empty($error)){
				if(in_array('invalid_id',$error)){
					$data["status"] = 'success';$data["message"] = file_location('home_url','login/');
				}
			}else{
				$data["status"] = 'error';$data["errors"] = $missing;
			}
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Error occurred while processing login id number';
}//end of if empty
echo json_encode($data);
?>