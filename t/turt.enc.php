<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','t/turt/'.@$_GET['fid']);;//url redirection current page
require_once(file_location('inc_path','session_check.inc.php'));
//for meta
$follow_type = 'follow';
$image_link = file_location('media_url',get_media('product',$pm_id));
$image_type = substr($image_link,-3);
$page = "TURT".ucwords(content_data('turt_table','t_turt',$id,'t_id','','null'))." | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
if(isset($_GET['fid']) AND is_numeric($_GET['fid'])){ //getting the value of the get 
	$fid = test_input(removenum($_GET['fid']));
	if(!empty($fid)){	
		$id = feed_data('f_id',$fid);
		$poster_id = feed_data('u_id',$id);
	}else{
		trigger_error_manual();
	}
}else{
	trigger_error_manual();
}
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class=""style="font-family: Roboto,sans-serif;width: 100%;">
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