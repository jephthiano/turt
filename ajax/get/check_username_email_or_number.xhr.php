<?php
if(isset($_GET['value'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$data = ($_GET['value']);
	$type = ($_GET['type']);
	
	//getting data col type
	$col = get_id_column($data);
	//validating data
	if($col === false){
		$missing = "invalid";
	}else{
		if($type === 'username' && strlen($data) < 4){$missing = "no report";}
		if($type === "mobile number" && strlen($data) < 11){$missing = "no report";}
		if($type === 'email' && !regex('email',$data)){$missing = "no report";}
	}
		
	if(empty($missing)){
		$db_data = test_input($data);
		$en_db_data = get_id_true_data($db_data,$col);
		if(isset($_SESSION['user_id'])){$user_id = $uid;}else{$user_id = "";}
		$existing_db_id = content_data('user_table','u_id',$en_db_data,$col);
		if($existing_db_id === false){
			echo "<span class='j-text-color1'>* {$db_data} is available <span>";
		}else{
			if($existing_db_id === $user_id){
				echo "<span class='j-text-color2'>* {$db_data} is your current {$type} <span>";
			}else{
				echo "<span class='j-text-color2'>* {$db_data} has been taken <span>";
			}
		}
	}else{
		if($missing ==='invalid'){	echo "* <span class='j-text-color2'>invalid input<span>";}
	}
}
?>