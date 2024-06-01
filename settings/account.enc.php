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
			<?php $nav_bar="header";$header="Account Setttings";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
				<div class='j-large'style='line-height:35px;'>
                    <p>
                        <a href="<?= file_location('home_url','settings/update_username/');?>">
                        <div style="width:35px;display:inline-block"><i class="<?=icon('user');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Username</span>
                            <div class='j-medium'style='margin-left:40px;'>@<?=content_data('user_table','u_username',$uid,'u_id')?></div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <?php
                        $ema = content_data('user_table','u_email',$uid,'u_id');
                        if(empty($ema) || is_null($ema)){$email = 'Add email';}else{$email = get_id_true_data($ema,'u_email','decrypt');}
                        ?>
                        <a href="<?= file_location('home_url','settings/update_email/');?>">
                        <div style="width:35px;display:inline-block"><i class="<?=icon('envelope');?>"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Email</span>
                            <div class='j-medium'style='margin-left:40px;'><?=$email?></div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/update_mobile_number/');?>">
                        <div style="width:35px;display:inline-block"><i class="<?=icon('phone');?> fa-flip-horizontal"></i></div>
                        <div style="display:inline;line-height:15px;">
                            <span>Mobile Number</span>
                            <div class='j-medium'style='margin-left:40px;'><?=get_id_true_data(content_data('user_table','u_phnumber',$uid,'u_id'),'u_phnumber','decrypt');?></div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/deactivate_account/');?>">
                        <div class='j-clickable'onclick="">
                            <div style="width:35px;display:inline-block"><i class="<?=icon('ban');?>"></i></div>
                            <div style="display:inline;line-height:15px;">
                                <span>De-activate Account</span>
                                <div class='j-small'style='margin-left:40px;'>De-activate your account for the main time.</div>
                            </div>
                        </div>
                        </a>
                    </p>
                    <p>
                        <a href="<?= file_location('home_url','settings/delete_account/');?>">
                        <div class="j-clickable j-hover-none"onclick="">
                            <div style="width:35px;display:inline-block"><i class="<?=icon('trash');?>"></i></div>
                            <div style="display:inline;line-height:15px;">
                                <span>Delete Account</span>
                                <div class='j-small'style='margin-left:40px;'>Your account will be deleted and the action can not be reversed.</div>
                            </div>
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