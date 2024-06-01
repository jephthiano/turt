<?php
if(isset($_GET)){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	get_all_inbox();
}//end of if isset
?>