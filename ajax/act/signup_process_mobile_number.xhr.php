<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$missing = []; $data = [];
if(isset($_POST) && isset($_POST['phn'])){
	if(get_json_data('registration','act') == 0 || get_json_data('all','act') == 0){//if checkout and all act is disabled
		$data["status"] = 'fail';$data["message"] = 'Sign Up is not available at the moment';
	}else{
		//validating mobile number
		$phn = ($_POST['phn']);
		$en_phn = get_id_true_data($phn,'u_phnumber');
		if(empty($phn)){
			$missing['phne'] = "* Mobile number cannot be empty";
		}elseif(!regex('phonenumber',$phn)){
			$missing['phne'] = "* Invalid mobile number";
		}elseif(content_data('user_table','u_id',$en_phn,'u_phnumber') !== false){
			$missing['phne'] = "* Mobile number already registered";
		}else{
			$phone_number = test_input($phn);
		}
		
		if(empty($missing)){
			//DELETE ANY CODE IN DATABASE AND TOKEN
			insert_update_delete_user_code('delete',$phone_number);
			//SET CODE INTO DATABASE AND SET TOKEN
			$code = generate_code();
			set_user_token_cookie($phone_number,$code);
			if(insert_update_delete_user_code('insert',$phone_number,$code) === true){
				$sent_code_message = true;
				if($sent_code_message){
					$data["status"] = 'success';$data["message"] = file_location('home_url','signup/step2/');
				}else{
					//DELETE ANY CODE IN DATABASE AND TOKEN
					insert_update_delete_user_code('delete',$phone_number);
					$data["status"] = 'fail';$data["message"] = 'Error occurred while sending code to mobile number';
				}
			}else{
				//DELETE ANY CODE IN DATABASE AND TOKEN
				insert_update_delete_user_code('delete',$phone_number);
				$data["status"] = 'fail';$data["message"] = 'Error occurred while processing mobile number';
			}
		}else{
			$data["status"] = 'error';$data["errors"] = $missing;
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Error occurred while processing mobile number';
}//end of if empty
echo json_encode($data);
?>