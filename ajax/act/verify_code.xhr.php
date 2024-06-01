<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$error = []; $missing = []; $data = [];
if(isset($_POST) && isset($_POST['cde'])){
	$cookie_content = get_user_token_cookie('content');
	$cookie_code = get_user_token_cookie('code');
	$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
	$db_content = content_data('token_code_table','c_content',$cookie_content,'c_content');
	$code_date = content_data('token_code_table','c_regdatetime',$cookie_content,'c_content');
	//if cookie content and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		$error[] = 'invalid_id';
		insert_update_delete_user_code('delete',$cookie_content);
	}
	
	$type = ($_POST['ty']);
	//if the input type is not the same as the one in the cookie
	if(get_id_column($cookie_content,'name') !== $type){
		$error[] = 'invalid_id';
		insert_update_delete_user_code('delete',$cookie_content);
	}else{
		$col = get_id_column($cookie_content);
	}
	
	//validate user input code
	$rawcode = ($_POST['cde']);
	if((empty($rawcode)) || (strlen($rawcode) !== 6) || (!is_numeric($rawcode))){
		$missing['cdee'] = "* invalid code";
	}elseif($rawcode !== $db_code){
		$missing['cdee'] = "* incorrect code";
	}elseif(time_validity(300,$code_date)){ //if time has not exceed 5 mins
		$missing['cdee'] = "* code has expired";
	}else{
		$code = test_input($rawcode);
	}
	
	if(empty($error) and empty($missing)){
		//update the data in the db
		$user = new user('update');
		$user->data = get_id_true_data($db_content,$col);
		$user->col = $col;
		$update = $user->update_user_data();
		if($update === 'success'){
			$data["status"] = 'success';$data["message"] = file_location('home_url','settings/account/');
		}else{
			$data["status"] = 'fail';$data["message"] = 'Error occurred while veriying code';
			
		}
		//delete cookie and db token
		insert_update_delete_user_code('delete',$cookie_content,$code);
	}else{
		if(!empty($error)){
			if(in_array('invalid_id',$error)){
				$data["status"] = 'success';$data["message"] = file_location('home_url','settings/account/');
			}
		}else{
			$data["status"] = 'error';$data["errors"] = $missing;
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Error occurred while veriying code';
}//end of if empty
echo json_encode($data);
?>