<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$error = []; $missing = []; $data = [];
if(isset($_POST) && isset($_POST['cde'])){
	$cookie_content = get_user_token_cookie('content');
	$cookie_code = get_user_token_cookie('code');
	$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
	$code_date = content_data('token_code_table','c_regdatetime',$cookie_content,'c_content');
	//if cookie content and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		$error[] = 'invalid_id';
		insert_update_delete_user_code('delete',$cookie_content);
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
		//set cookie and db code to verified
		if(insert_update_delete_user_code('update',$cookie_content,$code)){
			$data["status"] = 'success';$data["message"] = file_location('home_url','forgot_password/password/');
		}else{
			$data["status"] = 'fail';$data["message"] = 'Error occurred while processing code';
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
	$data["status"] = 'fail';$data["message"] = 'Error occurred while processing data';
}//end of if empty
echo json_encode($data);
?>