<?php
if(isset($_GET['id'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = '';
	//validating and sanitising id
	$id = test_input(removenum($_GET['id']));
	if(empty($id)){$error[] = "id";}else{$chatter_id = test_input($id);}
	
	//return the chat
	if(empty($error)){
		chat_data($chatter_id);
	}
}
?>