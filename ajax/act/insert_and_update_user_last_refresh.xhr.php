<?php
if(isset($_GET['val'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');	// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));//session
	//validating and sanitising content type
	$ty = ($_GET['val']);
	if(empty($ty)){$type = 'all';}else{$type = test_input($ty);}
	
	$user = new user('insert_update');
	$user->type = $type;
	$user->refresh();	
}
?>