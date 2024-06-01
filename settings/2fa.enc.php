<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/2fa/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "TWO-FACTOR AUTHENTICATION";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Two-factor Authentication";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
                <div class='j-large'>
                    <p style="line-height:15px"><div class=""><span class=''>Text Message</span><span class='j-text-color1 j-right'id='bk2ftm'><?=setting_section('2ftm')?></span></div><div class="j-text-color7 j-small">Use your mobile phone to receive a text message with an authentication code when you log in to Turt.</div></p>
                    <p style="line-height:15px;margin-top:25px;"><div class=""><span class=''>Email</span><span class='j-text-color1 j-right'id='bk2fe'><?=setting_section('2fe')?></span></div><div class="j-text-color7 j-small">Receive email with an authentication code when you log in to Turt.</div></p>
                </div>
            </div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $toggle_button_js = true; $update_set_js = true?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>