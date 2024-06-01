<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$missing = []; $data = [];
if(isset($_POST) && isset($_POST['id'])){
	if(get_json_data('login','act') == 0 || get_json_data('all','act') == 0){//if checkout and all act is disabled
		$data["status"] = 'fail';$data["message"] = 'Login is not available at the moment';
	}else{
		//validating mobile number or username
		$id = strtolower($_POST['id']);
		if(empty($id)){
			$missing['ide'] = "* Login id cannot be empty";
		}else{
			//check if it is mobile number or username
			$val = get_id_column($id);
			if($val === false){
				$missing['ide'] = "* invalid id";
			}else{
				$col = $val;
				$en_id = get_id_true_data($id,$col);//encyrpt if id is phnumber or email
			}
			if(empty($missing)){ // check if does not exists
				if(content_data('user_table','u_id',$en_id,$col) === false){
					if($col === "u_phnumber"){
						$missing['ide'] = "* Mobile number not exists";
					}elseif($col === "u_email"){
						$missing['ide'] = "* Email not exists";
					}else{
						$missing['ide'] = "* Username not exists";
					}
				}else{
					$login_id = (test_input($id));
				}
			}
		}
		
		if(empty($missing)){
			//SET LOGIN ID COOKIE AND REDIRECT TO THE SECOND PAGE
			set_single_cookie("login_id",$login_id);
			$data["status"] = 'success';$data["message"] = file_location('home_url','login/verify/');
		}else{
			$data["status"] = 'error';$data["errors"] = $missing;
		}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Error occurred while processing login id';
}//end of if empty
echo json_encode($data);
?>