<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','promote/'.@$_GET['ty'].'/'.@$_GET['cid']);
require_once(file_location('inc_path','session_check.inc.php'));
if(isset($_GET['ty']) && isset($_GET['cid']) && is_numeric($_GET['cid'])){ 
	$ttype = ($_GET['ty']);$cid = ($_GET['cid']);
	if(!empty($ttype) && !empty($cid)){
		$type = $ttype;$content_id = $cid;
		$status = 'fs_status'
		$cur_status = check_promote_post($type,$status,$content_id);
		if($cur_status === 'active' || $cur_status === 'suspended' || $cur_status === 'expired'){
			$text = "insights";
		}else{
			$text = "promote post";
		}
	}else{
		trigger_error_manual(404);
	}
}else{
	trigger_error_manual(404);
}
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = ucwords($text);
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;">
<div class="j-row-padding">
<div class="j-col m1 xl35 j-hide-small j-hide-large j-hide-medium j-fixed-first-column j-padding"id="jafrasa"><?php pre_loading()?></div>
<div class="j-col m1 xl35 j-hide-small j-hide-large j-padding" style=""><div class="j-hide-medium"></div></div>
<div class="j-container j-col m10 l8 xl5 j-color4"style="">
	
	
	
	
	<div id='pfrmctr'><?php require_once(file_location('inc_path','promote_content_form.inc.php')); ?></div>
	
	
	<span id="st"></span>
</div>
<div class="j-col s12 l4 xl35 j-hide-medium j-hide-small j-padding"style=""id="mhfdtahdh"><?php pre_loading()?></div>
</div>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>