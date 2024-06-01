<?php
if(isset($_GET)){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));//session
	if(get_single_cookie('login_cookie') === 'yes'){
		//SET COOKIE
		//tokens and ip for(remember me);
		$huser_id = ssl_encrypt_input(addnum($uid));
		$token = random_token();
		$h_token = hash_input($token);
		$selector = random_token(5645);
		$h_selector= hash_input($selector);
		$ipaddress = get_ip_address();
		$huser_ip = ssl_encrypt_input($ipaddress);
		//getting the browser details
		$device = browser_detail('platform');
		$browser = browser_detail('browser');
		//getting location
		$country = get_location_data('country');
		$state = get_location_data('city');
			
		//cookie data
		$cookie_data = $huser_id.":".$token.":".$selector.":".$huser_ip;
		$expiretime = time()+(86400 * 365);
		//insert cookie data into db and create browser cookie
		$user = new user('insert');
		$user->token = $h_token;
		$user->selector = $h_selector;
		$user->ipaddress = $ipaddress;
		$user->device_type = $device;
		$user->browser_type = $browser;
		$user->country = $country;
		$user->state = $state;
		$user->expiretime = $expiretime;
		$insert = $user->insert_cookie_data();
		if($insert === 'success'){
			set_user_cookie_data($cookie_data,$expiretime); // set user cookie_data
			delete_single_cookie('login_cookie'); // delete login cookie cookie
		}
	}
}// end of if isset
?>