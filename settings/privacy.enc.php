<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/privacy/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "PRIVACY";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Privacy";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
                <div class='j-large'>
                    <p style="line-height:15px"><div class=""><span class=''>Private Account</span><span class='j-text-color1 j-right'id='bkprat'><?=setting_section('prat')?></span></div><div class="j-text-color7 j-small">Only people that follow you can see your turts.</div></p>
                    <p style="line-height:15px;margin-top:25px;"><div class=""><span class=''>Lock Inbox</span><span class='j-text-color1 j-right'id='bklcme'><?=setting_section('lcme')?></span></div><div class="j-text-color7 j-small">Only people that you follows you and you follow back will be able to inbox you.</div></p>
                    <p style="line-height:15px;margin-top:25px;"><div class=""><span class=''>Disable Returt</span><span class='j-text-color1 j-right'id='bkdert'><?=setting_section('dert')?></span></div><div class="j-text-color7 j-small">Returt option will not be available for your turts.</div></p>
                    <p style="line-height:15px;margin-top:25px;"><div class=""><span class=''>Unlink Account</span><span class='j-text-color1 j-right'id='bkukat'><?=setting_section('ukat')?></span></div><div class="j-text-color7 j-small">Your account will not appear in search engine result outside Turt.</div></p>
                </div>
            </div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $toggle_button_js = true; $update_set_js = true?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>