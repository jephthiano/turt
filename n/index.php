<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','/n/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "NOTIFICATION";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
//change all sent noti to aware
$noti = new notification('update');
$noti->update_status();
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4" style="font-family: Roboto,sans-serif;width: 100%;"onload="">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar = 'nav_bar';require_once(file_location('inc_path','navigation.inc.php'));?>
			<div style='margin-top:1px;'>
				<?php
				$type_array = multiple_content_data('notification_table','n_type',$uid,'receiver_id','','unique');
				if($type_array === false){
					?><div class='j-center j-margin'>No notification</div><?php
				}else{
					foreach($type_array AS $type){
						get_notification_index($type);
					}
				}
				?>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>