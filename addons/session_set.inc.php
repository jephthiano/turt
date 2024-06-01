<?php
//SET SESSION and //set cookie that will enable setting of user cookie data at homepage
require_once(file_location('inc_path','session_start.inc.php'));
$_SESSION['user_id'] = ssl_encrypt_input($user_id);set_single_cookie('login_cookie','yes');
?>