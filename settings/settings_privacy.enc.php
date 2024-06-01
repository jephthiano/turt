<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/account/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "ACCOUNT SETTINGS";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Setttings & Privacy";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
				<div class='j-large'style='line-height:35px;'>
                    <p>
                        <a href="<?= file_location('home_url','settings/account/');?>">
                        <div style="display:inline-block;width:35px;"><i class="<?=icon('user');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Account Settings</span>
                            <div class='j-small'style='margin-left:38px;'>Your account information (Change email, Change username, Change mobile number, De-activate account and Delete account).</div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/security/');?>">
                        <div style="display:inline-block;width:35px;"><i class="<?=icon('shield-alt');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Security & Account</span>
                            <div class='j-small'style='margin-left:40px;'>Manage your account security (Change password, 2FA and Sessions).</div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/privacy/');?>">
                        <div style="display:inline-block;width:35px;"><i class="<?=icon('lock');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Privacy</span>
                            <div class='j-small'style='margin-left:40px;'>Manage your privacy. Let others see what you want them to see.</div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/notification/');?>">
                        <div style="display:inline-block;width:35px;"><i class="<?=icon('bell');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Notification</span>
                            <div class='j-small'style='margin-left:40px;'>Manage your notifications. Choose when to receive alerts and notifications.</div>
                        </div>
                        </a>
                    </p>
                </div>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>