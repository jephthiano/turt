<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','/m/search/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "NEW MESSAGE";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;" onload="">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="New Message";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
			<div class="j-padding">
				<input type="text"name="sIp"id="sIp"class="j-input j-border-2 j-border-color5 j-round j-color4"placeholder="Username or name"style="width:100%;outline:none;display:inline"onkeyup="gnmc();"/>
			</div>
			<div id="nmcr"class='j-padding'></div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>