<?php
if(isset($_GET['value'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$ty = ($_GET['value']);
	//return the  toggle button
	setting_section($ty);
}// end of if isset
?>