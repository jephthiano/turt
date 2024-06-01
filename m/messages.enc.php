<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','m/messages/'.@$_GET['cid']);
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "CHAT";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
if(isset($_GET['cid']) && is_string($_GET['cid'])){
	$get_id = test_input(removenum($_GET['cid']));
	if(!empty($get_id)){$chatter_id = content_data('user_table','u_id',$get_id,'u_id');}else{trigger_error_manual(404);}
}else{
	trigger_error_manual(404);
}
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family:Roboto,sans-serif;width:100%;"onload="">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php
			if($chatter_id === false){
				$nav_bar="header";$header="Chat";$back="back";require_once(file_location('inc_path','navigation.inc.php'));
				page_not_available();
			}else{
				$username = content_data('user_table','u_username',$chatter_id,'u_id');
				$location = file_location('home_url',$username.'/');
				$fullname = "<div style='display:inline;'>".content_data('user_table','u_fullname',$chatter_id,'u_id')."</div>";
				$image = "<div style='display:inline;margin-right:15px;'><img class='j-circle j-border-2 j-border-color5'src='".file_location('media_url',get_media('profile_pics',$chatter_id))."'style='height:40px;width:40px'></div>";
				if(is_online($chatter_id)){
					$online = "<span class='j-text-color9'>Online</span>";
				}else{
					$online = "<span class='j-text-color7'>Active ".show_date_interval($last_seen = content_data('last_refresh_table','lr_all_datetime',$chatter_id,'u_id'))." ago</span>";
				}
				$status = "<br><span class='j-small'style='marin-left:120px;position:absolute;top:23px;left:55px;'>{$online}</span>";
				$data = "<a href='{$location}'><span style='line-height:15px;position:relative;'>{$image}{$fullname}{$status}</span></a>";
				$nav_bar="header";$header=$data;$back="back";require_once(file_location('inc_path','navigation.inc.php'));
				?>
				<div id='cht'class='j-padding'style='margin-bottom:300px;'><?php chat_data($chatter_id); // for chat data?></div>
				<br class='j-clearfix'>
				<div>
					<?php
					$chatter_private_account_status = content_data('setting_table','s_private_account',$chatter_id,'u_id');
					$your_private_account_status = content_data('setting_table','s_private_account',$uid,'u_id');
					$chatter_lock_inbox_status = content_data('setting_table','s_lock_inbox',$chatter_id,'u_id');
					$your_lock_inbox_status = content_data('setting_table','s_lock_inbox',$uid,'u_id');
					$chatter_block_status = content_data('block_table','b_id',$uid,'blockee_id',"AND blocker_id = {$chatter_id}");//check if chatter blocks you
					$your_block_status = content_data('block_table','b_id',$uid,'blocker_id',"AND blockee_id = {$chatter_id}");//check if you block chatter
					if($your_private_account_status === 'on'){
						?><center><br><div class='j-text-color5'>You can't message anyone since your account is private.</div></center><?php
					}elseif($chatter_private_account_status === 'on'){
						?><center><br><div class='j-text-color5'>It's a private account, you can't message this account.</div></center><?php
					}elseif($your_block_status){
						?><center><br><div class='j-text-color5'>You've blocked this account, you can't message this account.</div></center><?php
					}elseif($chatter_block_status){
						?><center><br><div class='j-text-color5'>You've been blocked by this account, you can't message this account.</div></center><?php
					}elseif($your_lock_inbox_status === 'on'){
						?><center><br><div class='j-text-color5'>You can't message anyone since you have locked your inbox.</div></center><?php
					}elseif($chatter_lock_inbox_status === 'on'){
						?><center><br><div class='j-text-color5'>User has locked inbox, you can't message this account.</div></center><?php
					}else{
						message_input($chatter_id);//show text input
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
	<?php $triger_click_js = true;$process_image_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>