<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$error = []; $missing = []; $data = [];
if(isset($_POST)){
	if(get_json_data('registration','act') == 0 || get_json_data('all','act') == 0){//if checkout and all act is disabled
		$data["status"] = 'fail';$data["message"] = 'Sign Up is not available at the moment';
	}else{
		$cookie_content = get_user_token_cookie('content');
		$cookie_code = get_user_token_cookie('code');
		$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
		$verify = content_data('token_code_table','c_verify',$cookie_content,'c_content');
		//if  verify is no
		if($verify !== 'yes'){
			$error[] = 'error';
			$data["status"] = 'success';$data["message"] = file_location('home_url','signup/step2/');
		}
		//if cookie content and cookie code are empty or flase || if cookie code is not equal to db code
		if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
			$error[] = 'invalid_number';
			insert_update_delete_user_code('delete',$cookie_content);
		}
		
		// validating and sanitizing phone number
		$phn = ($_POST['phn']);
		if(empty($phn)){
			$error[] = 'invalid_number';
			insert_update_delete_user_code('delete',$cookie_content);
		}elseif(!regex('phonenumber',$phn)){
			$error[] = 'invalid_number';
			insert_update_delete_user_code('delete',$cookie_content);
		}else{
			$phone_number = test_input($phn);
		}
		
		// validating and sanitizing username
		$usr = ($_POST['usr']);
		if(empty($usr) || strlen($usr) < 4){
			$missing['usre'] = "* username must be more than 3 chars";
		}elseif(!regex('username',$usr)){
			$missing['usre'] = "* only alpahnumeric are allowed";
		}elseif(content_data('user_table','u_id',$usr,'u_username') !== false){
			$missing['usre'] = "* Username already taken";
		}else{
			$username = (test_input($usr));
		}
		
		// validating and sanitizing fullname
		$nam = ($_POST['fnm']);
		if(empty($nam)){$missing['fnme'] = "* Name cannot be empty";}else{($fullname = test_input($nam));}
			
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
			$user = new user('insert');
			$user->phnumber = get_id_true_data($phone_number,'u_phnumber');
			$user->username = $username;
			$user->fullname = $fullname;
			$user->password = $password;
			$user_id = $user->sign_up();
			if($user_id == true && is_numeric($user_id)){
				//delete db code and cookie
				insert_update_delete_user_code('delete',$cookie_content);
				//send welcome mail
				//$company_email = get_json_data('support_email','about_us');
				//$company_name = ucwords(get_xml_data('company_name'));
				//$mail = new mail();
				//$mail->p_receiver = $email;
				//$mail->p_subject = "Welcome To {$company_name}";
				//$mail->p_message = user_welcome_message($name);
				//$mail->p_header = implode("\r\n",[
	                                //"From:".$company_name." <".$company_email.">",
	                                //"MIME-Version: 1.0",
	                                //"Content-Type: text/html; charset=UTF-8"
	                            //]);
				//$mailsent = $mail->send_mail();
				require_once(file_location('inc_path','session_set.inc.php'));//setting session
				$data["status"] = 'success';$data["message"] = file_location('home_url','');
			}elseif($user_id === 'fail'){
				$data["status"] = 'fail';$data["message"] = "Error occurred while creating account, please try again later.";
			}
		}else{
			if(!empty($error)){
				if(in_array('invalid_number',$error)){
					$data["status"] = 'success';$data["message"] = file_location('home_url','signup/');
				}
			}else{
				$data["status"] = 'error';$data["errors"] = $missing;
			}
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Error occurred while processing data';
}//end of if empty
echo json_encode($data);
?>