<?php
if(isset($_GET['type'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
	$noti = new notification('update');
	$noti->type = test_input($_GET['type']);
	$noti->update_status('type');
}
?>
