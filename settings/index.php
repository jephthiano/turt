<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','notification');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "SETTINGS";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4" style="font-family: Roboto,sans-serif;width: 100%;"onload="">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar = 'nav_bar';require_once(file_location('inc_path','navigation.inc.php'));?>
			<div class='j-padding'>
				<div class='j-large'style='line-height:35px;'>
                    <p><a href="<?= file_location('home_url','settings/settings_privacy/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('cog');?>"></i></div><div style="display:inline-block;">Settings & Privacy</div></a></p>
                    <p><a href="<?= file_location('home_url','bookmark/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('bookmark');?>"></i></div><div style="display:inline-block;">Bookmarks</div></a></p>
                    <p><a href="<?= file_location('home_url','settings/blocked_accounts/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('ban');?>"></i></div><div style="display:inline-block;">Blocked Accounts</div></a></p>
                    <p><a href="<?= file_location('home_url','settings/manage_ads/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('audio-description');?>"></i></div><div style="display:inline-block;">Ads Manager</div></a></p>
                    <p><div class='j-clickable'><div style="width:35px;display:inline-block"><i class="<?=icon('sun');?>"></i></div><div style="display:inline-block;">Dark Mode</div><span id='bkclmd'class="j-right j-text-color1"><?=setting_section('clmd')?></span></div></p>
                    <p><a href="<?= file_location('home_url','settings/manage_ads/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('users');?>"></i></div><div style="display:inline-block;">Help Center</div></a></p>
                    <p><div class="j-clickable j-hover-none"onclick="$('#logout_current_modal').fadeIn('slow');"><div style="width:35px;display:inline-block"><i class="<?=icon('power-off');?>"></i></div><div style="display:inline-block;">Log Out</div></div></p>					
                </div>
			</div>
			<?php user_modal('log_out_current',$uid); //logout modal?>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
	<?php $logout_js = true; $dark_mode_js = true;$toggle_button_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>