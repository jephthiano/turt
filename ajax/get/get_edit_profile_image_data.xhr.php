<?php
if(isset($_GET['value'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$ty = ($_GET['value']);
	//return the image section
	if($ty === 'profile_pics'){
		user_section_data('edit_profile_pics',$uid); //for edit profile pics
	}elseif($ty === 'cover_pics'){
		user_section_data('edit_cover_pics',$uid); //for edit cover pics
	}
}
?>