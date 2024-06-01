<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/security_measure/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "SECURITY AND ACCOUNT";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Security & Account";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
				<div class='j-large'style='line-height:35px;'>
                    <p>
                        <a href="<?= file_location('home_url','settings/change_password/');?>">
                        <div style="width:35px;display:inline-block"><i class="<?=icon('lock');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Change password</span>
                            <div class='j-small'style='margin-left:40px;'>Use Strong password to secure your account.</div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/2fa/');?>">
                        <div style="width:35px;display:inline-block"><i class="<?=icon('shield-alt');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Two-factor authentication</span>
                            <div class='j-small'style='margin-left:40px;'>Secure your account when logging in with Two-ways Factor Authentication (2FA).</div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/sessions/');?>">
                        <div style="width:35px;display:inline-block"><i class="<?=icon('users');?> fa-flip-horizontal"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Sesions</span>
                            <div class='j-small'style='margin-left:40px;'>Manage devices where you are logged in.</div>
                        </div>
                        </a>
                    </p>
                </div>
			</div>
        </div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>