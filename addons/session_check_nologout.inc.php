<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
require_once(file_location('inc_path','session_start.inc.php'));
if(isset($_SESSION['user_id']) && (content_data('user_table','u_id',test_input(ssl_decrypt_input($_SESSION['user_id'])),'u_id') !== false)
   && (content_data('user_table','u_status',test_input(ssl_decrypt_input($_SESSION['user_id'])),'u_id') == "active")){
	$GLOBALS['uid'] = test_input(ssl_decrypt_input($_SESSION['user_id']));
}elseif(isset($_COOKIE['tarcou'])){ // REMEMBER ME COOKIE
	$cookie = $_COOKIE['tarcou'];
	if($cookie !== ""){
		$token = get_user_cookie_data('token');
		$selector = get_user_cookie_data('selector');
		$ipaddress = get_user_cookie_data('ip');
      $user_id = get_user_cookie_data();
      $time = content_data('cookie_data_table','cd_expiretime',$user_id,'u_id',"AND cd_token = '{$token}' AND cd_selector = '{$selector}' AND cd_ipaddress = '{$ipaddress}'");
      if($time !== false){
				if($time >= time()){
					// no chance for suspended users || false user
					if(content_data('user_table','u_status',$user_id,'u_id') !== "active" || content_data('user_table','u_id',$user_id,'u_id') === false){
						require_once(file_location('inc_path','session_destroy.inc.php'));
						require_once(file_location('inc_path','session_redirection.inc.php'));
					}
					$_SESSION['user_id'] = ssl_encrypt_input($user_id);
					$GLOBALS['uid'] = test_input(ssl_decrypt_input($_SESSION['user_id']));
				}else{ // if the time has expired
					require_once(file_location('inc_path','session_destroy.inc.php'));
					require_once(file_location('inc_path','session_redirection.inc.php'));				
				}
		}else{ // if authentication is not true
			require_once(file_location('inc_path','session_destroy.inc.php'));
			require_once(file_location('inc_path','session_redirection.inc.php'));
		}
	}else{// if cookie is false
		require_once(file_location('inc_path','session_destroy.inc.php'));
		require_once(file_location('inc_path','session_redirection.inc.php'));
	}
}else{
	$GLOBALS['uid'] = "";
}
?>