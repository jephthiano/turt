<?php
if(isset($_GET['type'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	//validating and sanitising content type
	$type = ($_GET['type']);
	if($type !== 'feed' && $type !== 'mess' && $type !== 'noti'){$error[] = "ty";}
	if(empty($error)){get_noti($type);}
}//end of if isset
?>