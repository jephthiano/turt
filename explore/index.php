<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','explore/');
require_once(file_location('inc_path','session_check.inc.php'));
//for meta
$follow_type = 'follow';
$image_link = file_location('media_url','home/logo_white.png');
$image_type = substr($image_link,-3);
$page = "EXPLORE | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$page_url = file_location('home_url','');
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar = 'nav_bar';require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-dropdown-click j-padding j-color4'style='width:100%;position:sticky;top:0;z-index:1'>
				<div class='j-color4'style="height:50px;">
					<div class="">
						<input type="search"name="sIp"id="sIp"class="j-input j-border-2 j-border-color5 j-round j-color4 j-dropdown"placeholder="Search Turt"
							style="width:100%;outline:none;display:inline"onfocus="getr();"onkeyup="getr();"onsearch="gtsp();"/>
					</div>
				</div>
				<?php user_modal('explore','','explore'); //for explore modal?>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $explore_search_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>