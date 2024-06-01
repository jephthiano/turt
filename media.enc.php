<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','media/'.@$_GET['type'].'/'.@$_GET['cid']);
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "MEDIA";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
if(isset($_GET['type']) && isset($_GET['cid'])){ 
	$type = ($_GET['type']);$cid = ($_GET['cid']);
	if(!empty($type) && !empty($cid)){
		if($type !== 'profile_pics' && $type !== 'cover_pics'){trigger_error_manual(404);}
	}else{
		trigger_error_manual(404);
	}
}else{
	trigger_error_manual(404);
}
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
	<center>
	<div class=""style="width:100%;max-width:500px;">
		<?php
		if($type === 'profile_pics' || $type === 'cover_pics'){
			$id = content_data('user_table','u_id',$cid,'u_username');
			if($id === false){
				trigger_error_manual(404);
			}else{
				?>
				<div class="j-left j-text-color3 j-xxlarge j-clickable"><?php back_btn();?></div>
				<br class='j-clearfix'>
				<div class="j-total-center"style="width:100%;max-width:500px;max-height:80%">
					<img src="<?=file_location('media_url',get_media($type,$id))?>"style="width:inherit;max-height:500px;"/>
				</div>
				<?php
			}// end if id is not false
		}
		?>
	</div>
</center>
<div id="st"></div>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>