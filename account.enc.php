<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url',@$_GET['username']);
require_once(file_location('inc_path','session_check.inc.php'));
if(isset($_GET['username']) && is_string($_GET['username'])){
	$get_username = test_input($_GET['username']);
	if(!empty($get_username)){$id = content_data('user_table','u_id',$get_username,'u_username');}else{trigger_error_manual(404);}
}else{
	trigger_error_manual(404);
}
//for meta
$follow_type = 'follow';
$image_link = file_location('media_url',get_media('profile_pics',$id));
$image_type = substr($image_link,-3);
$page = ucwords(content_data('user_table','u_fullname',$id,'u_id','','null'))." | Profile |".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$id===false?"Account Not Exists":$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id=""class="j-col m10 l8 xl5">
			<?php
			$status = content_data('user_table','u_status',$id,'u_id');
			if(($id === false) || ($status === "suspended")){ //if account is not found or it is suspended
				$username = content_data('user_table','u_username',$id,'u_id','','null');
				if($id === false){
					$fullname = "Account Not Exists";
				}else{
					$fullname = content_data('user_table','u_fullname',$id,'u_id','','null');
				}
				$nav_bar="header";$header=$fullname;$back="back";
				require_once(file_location('inc_path','navigation.inc.php'));
				?>
				<?php //details?>
				<span  style="margin-top: 0px" >
				<?php if($id === false){$media = get_media("profile_pics");}else{$media = get_media("profile_pics",$id);}?>
					<div class="j-panel">
						<a href="<?= file_location('home_url','media/profile/'.addnum($id));?>">
						<img class="j-circle j-border-2 j-card-4 j-border-color5 j-left"style="height:auto;width:20%"src="<?= file_location('media_url',$media);?>">
						</a>
						<div class="j-container">
							<div class="j-large j-text-color5"><b>@<?=$get_username;?></b></div><br>
							<div class="j-large j-text-color7 j-center">This account <?=$status === "suspended"?"has been suspended":"does not exist";?></div>
						</div>
					</div>
				</span>
			<?php
			}else{//if account is not false or suspended
				if($uid === $id){
					$menu = "<span class='j-clickable j-xlarge j-hide-large j-hide-xlarge'onclick=\"$('#settings_modal').show()\"><b><i class='".icon('bars')."'></i></b></span>";
				}else{
					$profile_block_status = content_data('block_table','b_id',$uid,'blockee_id',"AND blocker_id = {$id}");//check if this profile id blocks you
					if($profile_block_status === false){//if you have not been blocked
						$menu = "<span class='j-right j-large j-clickable'style='padding-top:3px;'onclick=\"$('#user_3_dots_modal').fadeIn('slow')\"><b><i class='".icon('ellipsis-v')."'></i></b></span>";
					}
				}
				$fullname = content_data('user_table','u_fullname',$id,'u_id','','null');
				$nav_bar="header";$header=$fullname;$back="back";
				require_once(file_location('inc_path','navigation.inc.php'));
				?>
				<?php //profile and cover pics starts ?>
				<div class="j-display-container"style="width:100%;">
					<?php
					user_section_data('account_image',$id); //for account image?
					//for modals
					if($uid === $id){
						user_modal('settings');//for setting modal
						user_modal('log_out_current',$uid); //logout modal
					}else{
						user_modal('user_3_dots',$id,'user'); //3 dots modal
						user_modal('block',$id,'detail'); //block modal
						user_modal('unblock',$id,'detail'); //unblock modal
					}
					?>
				</div>
				<div id="aud"class=""><?php user_data('detail',$id); //user data?></div>
				<?php
			}
			?>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
	<?php
	if($uid === $id){
		$logout_js = true;$dark_mode_js = true;$toggle_button_js = true;
	}else{
		$report_js = true;$follow_js = true;$block_js = true;$get_user_data_js = true;
	}
	$horn_nav_js = true;
	//for js function?>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>