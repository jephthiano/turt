<?php
if(isset($_GET)){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$mode = get_single_cookie('dark_mode');
if($mode === 'dark'){ //delete the cookie
	delete_single_cookie('dark_mode');
}else{ // set a new cookie
  set_single_cookie('dark_mode','dark');
}
}// end of if isset
?>