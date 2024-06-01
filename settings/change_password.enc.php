<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/change_password/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "CHANGE PASSWORD";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Change Password";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
                <form id='cpfrm'>
                    <?php
                    get_form_password('cpbtn','opss','Old Password','','Old Password');//for password input
                    get_form_password('cpbtn','npss','New Password','','New Password');//for password input
                    get_form_button('cpbtn','Change Password')// submit button
                    ?>
                    <br><br><a class="j-text-color3 j-bolder"href="<?=file_location('home_url','forgot_password/');?>">Forget Your Password?</a><br>
                </form>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $pass_show_eye_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>