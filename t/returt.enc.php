<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','t/returt/'.@$_GET['tid']);
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "RETURT";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
if(isset($_GET['fid']) AND is_numeric($_GET['fid'])){//getting the value of the get
	$fid = test_input(removenum($_GET['fid']));
	if(!empty($fid)){
		require_once(file_location('inc_path','all_actions.inc.php')); // all actions
	}else{
		trigger_error_manual(404);
	}
}else{
	trigger_error_manual(404);
}
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php require_once(file_location('inc_path','navigation.inc.php'));?>
			<div class='j-center'>
				<br><br>
				This page is still in progress 				<?php show_ready_pages();?><br><br>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>