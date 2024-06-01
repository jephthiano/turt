<?php
//USER FUNCTION STARTS
//asterisk user data starts
function asterisk_user_data($type,$data){
	if($type === 'phonenumber'){
		$front = substr($data,0,2);// first two chars
		$back = substr($data,9);// last two chars
		$data = $front.repeat_asterisk(7).$back;
	}
	if($type === 'email'){
		$pos_of_at = stripos($data,'@');//position of at
		$email_username = substr($data,0,$pos_of_at); //email username
		$email_domain = substr($data,$pos_of_at);//($email_domain)
		$length_of_ash = strlen($email_username)-2; //length of chars in username -2
		$front = substr($data,0,1);// first chars
		$back = substr($email_username,$pos_of_at-1);// last two chars
		$data = $front.repeat_asterisk($length_of_ash).$back.$email_domain;
	}
	return $data;
}
//asterisk user data starts

//get number of asterisk starts
function repeat_asterisk($repeat){
	$data = '';
	for($i = 0;$i < $repeat;$i++){$data = $data."*";}
	return $data;
}
//get number of asterisk ends

//get id column starts
function get_id_column($id='',$type='col'){
	if(is_numeric($id) && regex('phonenumber',$id)){
		if($type === 'col'){$col = "u_phnumber";}else{$col = "mobile number";}
	}elseif(regex('email',$id)){
		if($type === 'col'){$col = "u_email";}else{$col = "email";}
	}elseif(regex('username',$id)){
		if($type === 'col'){$col = "u_username";}else{$col = "username";}
	}else{
		$col = false;
	}
	return $col;
}
//get id column ends

//get id true data starts
function get_id_true_data($data,$col,$type="encrypt"){
	if($col === 'u_username'){
		$return = $data;
	}elseif($col === 'u_phnumber' || $col === 'u_email'){
		if($type === 'encrypt'){
			$return = ssl_encrypt_input($data);
		}elseif($type === 'decrypt'){
			$return = ssl_decrypt_input($data);
		}
	}else{
		$return = false;
	}
	return $return;
}
//get id true data ends

//get user starts
function user_data($type,$id=''){
	global $uid;
	if($type === "side_bar"){
		?>
		<div>
			<img src="<?= file_location('media_url',get_media('profile_pics',$uid));?>"class="j-circle"style="width:35px;height:35px;margin-right:8px;position:relative;top:-10px;"/>
			<span style="line-height:20px;display: inline-block">
				<div><?=content_data('user_table','u_fullname',$uid,'u_id')?></div>
				<div class="j-text-color5">@<?=content_data('user_table','u_username',$uid,'u_id')?></div>
			</span>
		</div>
		<?php
	}elseif($type === 'detail'){
		$username = content_data('user_table','u_username',$id,'u_id');
		$user_block_status = content_data('block_table','b_id',$uid,'blocker_id',"AND blockee_id = {$id}");//check if you blocks this profile id
		$profile_block_status = content_data('block_table','b_id',$uid,'blockee_id',"AND blocker_id = {$id}");//check if this profile id blocks you
		if($user_block_status !== false){ //if you have blocked the profile
			?>
			<div style='margin-top:35px;'><?php user_section_data('account_names',$id); //for name and username?></div>
			<div class="j-center j-large"style="margin-top:25px;">You have blocked @<?=$username?></div>
			<?php
		}elseif($profile_block_status !== false){//if you have been blocked
			?>
			<div style='margin-top:35px;'><?php user_section_data('account_names',$id); //for name and username?></div>
			<div class="j-center j-large"style="margin-top:25px;">@<?=$username?> has blocked You</div>
			<?php
		}else{
			$website = content_data('user_table','u_website',$id,'u_id');
			$state = content_data('user_table','u_state',$id,'u_id');
			$bio = content_data('user_table','u_bio',$id,'u_id');
			$regdatetime = content_data('user_table','u_regdatetime',$id,'u_id');
			$last_seen = is_online($id);
			if($uid === $id){ //for edit profile button
				?><div id="ae3p"class="j-edit-profile-height"><?php user_section_data('edit_profile',$id);?></div><?php
			}else{ // message and follow button
				?>
				<div class="j-center j-edit-profile-height j-right"style="">
					<div id="ainxd"style="display:inline-block"><?php user_section_data('message_button',$id);?></div>
					<div id="faub<?=$id?>"style="display:inline-block;margin-left:5px;"><?php follow_status($type,$id);?></div>
				</div>
				<span class='j-clearfix'></span>
				<?php
			}
			?>
			<div style="position:relative;top:-20px;">
				<div><?php user_section_data('account_names',$id); //for name and username ?></div>
				<?php //for followers andd following?>
				<div id='aff'class='j-center'style="margin:9px;">
					<div class="j-row">
						<div class="j-col s6"><?php user_section_data('following_counter',$id); //for follower counter?></div>
						<div id='fwc'class="j-col s6"><?php user_section_data('follower_counter',$id); //for follower counter?></div>
					</div>
				</div>
				<?php //for account data?>
				<div id="aud"class="j-padding"style='line-height:30px;'>
					<?php
					if(!empty($bio) && !is_null($bio)){?><div id="aub"class=''style='line-height:20px;'><div class=''style="display:inline-block"><?=($bio)?></div></div><?php }
					if(!empty($website) && !is_null($website)){
						?>
						<div id="auw"class=''>
							<div class=' j-text-color7 dmt7'style="width:30px;display:inline-block"><i class="<?=icon('link');?>"></i></div>
							<div class='j-text-color1 j-clickable'style="display:inline-block;"><a href="https://<?=$website?>"target="_blank"><?=($website)?></a></div>
						</div>
						<?php
					}
					if(!empty($state) && !is_null($state)){
						?>
						<div id="aus"class=''>
							<div class=' j-text-color7 dmt7'style="width:30px;display:inline-block"><i class="<?=icon('map-marker-alt');?>"></i></div>
							<div class='j-clickable'style="display:inline-block;"><?=($state)?></div>
						</div>
						<?php
					}
					?>
					<div id="auj"class=''>
						<div class=' j-text-color7 dmt7'style="width:30px;display:inline-block"><i class="<?=icon('clock');?>"></i></div>
						<div class=''style="display:inline-block"><span class='j-text-color7'>Joined</span> <?=show_date($regdatetime,'month')?></div>
					</div>
				</div>
				<?php //for turt, replies, media and likes?>
				<div>
					<div class="j-row j-center j-border-color3 j-color4 dmb3 dm4" style="padding:0px 0px;border-bottom:1px solid">
						<span class="j-col s3 j-clickable laucher" onclick="hornav(this,'turt');"style="color:teal;border-bottom:4px solid teal;"><b>Turt</b></span>
						<span class="j-col s3 j-clickable laucher" onclick="hornav(this,'replies');"><b>Replies</b></span>
						<span class="j-col s3 j-clickable laucher" onclick="hornav(this,'media');"><b>Media</b></span>
						<span class="j-col s3 j-clickable laucher" onclick="hornav(this,'likes');"><b>Likes</b></span>
					</div>
					<div>
						<br>
						<div id='turt'class='shw j-center'>
							Once the feature has been completed, profile turt will be shown here.
						</div>
						<div id='replies'class='shw j-center'style='display:none'>
							Once the feature has been completed, profile replies will be shown here.
						</div>
						<div id='media'class='shw j-center'style='display:none'>
							Once the feature has been completed, profile media will be shown here.
						</div>
						<div id='likes'class='shw j-center'style='display:none'>
							Once the feature has been completed, profile likes will be shown here.
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}elseif($type === 'etpss'){ //enter password
		?>
		<div style='line-height: 35px;'>
		<div class='j-bolder j-large'>Verify your password</div>
		<div class='j-text-color7'>Enter your password to continue</div>
		</div>
		<form id='enpsfrm'onsubmit="vp(this)">
			<?php
			get_form_hidden('ty',$id);//for type (to specify the next user template to run)
			get_form_password('enpsbtn');//for password input
			get_form_button('enpsbtn','Verify','disabled');// submit button
			?>
		</form>
		<?php
	}elseif($type === 'etcd'){// enter code
		$cookie_code = get_user_token_cookie('code');
		?>
		<div style='line-height: 35px;'>
		<div class='j-bolder j-large'>Enter the code we sent to you</div>
		<div class='j-text-color7'>Enter the code you received on your <?=$id?> to continue</div>
		</div>
		<form id='encdfrm'onsubmit="vc(this)">
			<?php
			get_form_hidden('ty',$id);//for type (to specify the next user template to run)
			get_form_type('number','cde','ecdbtn','Code','','1','6','','','required',"trsub(this,'ecdbtn')");//for code input
			get_form_button('ecdbtn','Verify','disabled');// submit button
			?>
		</form>
		<script>$(document).ready(function(){r_m2("Notice!!!<br><?=ucfirst($id)?> message functionality is not ready.<br> Please Use the this <span class='j-bolder'>"+"<?=$cookie_code?>"+" </span> code to continue")})</script>
		<?php
	}elseif($type === 'etem'){//enter email
		$en_email =  content_data('user_table','u_email',$uid,'u_id');
		?>
		<div style='line-height: 35px;'>
		<div class='j-bolder j-large'>Enter new email</div>
		<div class='j-text-color7'>
			<?php
			if($en_email === false || empty($en_email)){
				?>Currently you have no registered email<?php
			}else{
				?>Your current email is <?=get_id_true_data($en_email,'u_email','decrypt')?><?php
			}
			?>
		</div>
		</div>
		<form id='enusidfrm'onsubmit="vuld(this)">
			<?php
			get_form_hidden('ty','etcd');//for type (to specify the next user template to run)
			get_form_type('email','usid','eidbtn','Email','','1','50','','','required',"cuen('email',this,'uside');");//for email input
			get_form_button('eidbtn','Continue','disabled');// submit button
			?>
		</form>
		<?php
	}elseif($type === 'etmn'){ // enter mobile number
		$mobile =  content_data('user_table','u_phnumber',$uid,'u_id');
		?>
		<div style='line-height: 35px;'>
		<div class='j-bolder j-large'>Enter new mobile number</div>
		<div class='j-text-color7'>Your current mobile number is <?=get_id_true_data($mobile,'u_phnumber','decrypt')?></div>
		</div>
		<form id='enusidfrm'onsubmit="vuld(this)">
			<?php
			get_form_hidden('ty','etcd');//for type (to specify the next user template to run)
			get_form_type('tel','usid','eidbtn','Mobile Number','','1','11','','','required',"cuen('mobile number',this,'uside');");//for mobile number input
			get_form_button('eidbtn','Continue','disabled');// submit button
			?>
		</form>
		<?php
	}
}
//get user ends

//get user section data starts
function user_section_data($type='account_image',$id=''){
	global $uid;
	$username = content_data('user_table','u_username',$id,'u_id');
	$fullname = content_data('user_table','u_fullname',$id,'u_id','','null');
	if($type === 'edit_cover_pics'){
		$type = 'cover_pics';
			?>
			<div id='<?=$type?>'>
				<div class='j-clickable'onclick="ti($('#<?=$type.$uid?>_pics'))">
					<img class="j-clickable"style="width:100%;height:150px;"src="<?=file_location('media_url',get_media($type,$uid));?>">
					<span class='j-bold j-vertical-center-element'style='font-size:40px;color:white;'>+</span>
				</div>
			</div>
			<input type="file"name="<?=$type?>_pics"id="<?=$type.$uid?>_pics"class="j-round j-hide"onchange="ci(this,'<?=$type?>');">
			<?php
	}elseif($type === 'edit_profile_pics'){
		$type = 'profile_pics';
		?>
		<div id='<?=$type?>'>
			<div class='j-clickable j-profile-img-position'onclick="ti($('#<?=$type.$uid?>_pics'))">
				<img class="j-circle j-clickable j-image-size1 j-border-3 j-border-color4"src="<?= file_location('media_url',get_media($type,$uid));?>">
				<span class='j-bold j-vertical-center-element'style='font-size:40px;color:white;'>+</span>
			</div>
		</div>
		<input type="file"name="<?=$type?>_pics"id="<?=$type.$uid?>_pics"class="j-round j-hide"onchange="ci(this,'<?=$type?>');">
		<?php
	}elseif($type === 'account_image'){
		$cover_pics = get_media("cover_pics",$id);
		$profile_pics = get_media("profile_pics",$id);
		?>
		<div style="position:relative">
			<a <?php if($cover_pics !== 'home/cover.jpg'){?> href="<?= file_location('home_url',"media/cover_pics/{$username}/");?>" <?php }?>>
			<div>
				<img class=""style="width:100%;height:150px;"src="<?= file_location('media_url',$cover_pics);?>">
			</div>
			</a>
			<a <?php if($profile_pics !== 'home/avatar.png'){?>href="<?= file_location('home_url',"media/profile_pics/{$username}/");?>" <?php }?>class='j-profile-img-position'>
			<div>
				<img class="<?=$profile_pics !== 'home/avatar.png'?"j-clickable":"";?> j-circle j-card-2 j-left j-image-size1 j-border-color4 j-border-3 dmb3"src="<?= file_location('media_url',$profile_pics);?>">
			</div>
			</a>
		</div>
		<?php
	}elseif($type === 'account_names'){
		?>
		<div id="afu"class="j-container"style="margin-top:5px;">
			<div class="j-large"><b><?=$fullname;?></b></div><div class="j-large j-text-color7 dmt7"><?="@".$username;?></a></div>
		</div>
		<?php
	}elseif($type === 'edit_profile'){
		?>
		<a href="<?= file_location('home_url','settings/profile/');?>"class='j-clickable j-btn j-right j-border j-border-color3 j-round dmb3'>Edit profile</a>
		<span class='j-clearfix'>
		<?php
	}elseif($type === 'message_button'){
		$message_privacy = content_data('setting_table','s_lock_inbox',$id,'u_id');
		if($message_privacy === 'on'){
			?>
			<span class="j-color1 j-button j-round j-center" onclick="mla('<?=$username?>')"><i class="<?= icon('lock');?>"style="padding-right: 7px;"></i> Message</span>
			<?php
		}else{
			?>
			<a href="<?= file_location('home_url','m/messages/'.addnum($id));?>"><span class="j-color1 j-button j-round j-center"><i class="<?= icon('envelope');?>"style="padding-right: 7px;"></i> Message</span></a>
			<?php
		}
	}elseif($type === 'following_counter'){
		?>
		<a href="<?= file_location('home_url',"{$username}/following/");?>">
		<b>(<span class='j-text-color7 j-medium dmt7'><?= get_numrow('follow_table','follower_id',$id)?></span>)</b>
		<br>Following
		</a>
		<?php
	}elseif($type === 'follower_counter'){
		?>
		<a href="<?= file_location('home_url',"{$username}/follower/");?>">
			<b>(<span class='j-text-color7 j-medium dmt7'><?= get_numrow('follow_table','followee_id',$id)?></span>)</b>
			<br>Follower
		</a>
		<?php
	}
}
//get user section data ends

// get user template starts
function user_template($type='',$id='',$username='',$fullname='',$bio='',$status='',$verify='',$regdatetime=''){
	if($type === 'user_full_name' || $type === 'user_full_page'){
		if($type === 'user_full_name'){$location = "m/messages/".addnum($id);}else{$location = "{$username}/";}
		?>
		<a href="<?=file_location('home_url',$location)?>">
		<div class=''style="margin-bottom:16px;">
			<div class=''style='width:60px;height:50px;display:inline-block;'>
				<img class=" j-circle"src="<?= file_location('media_url',get_media('profile_pics',$id));?>"style="width:50px;height:50px;">
			</div>
			<div class=''style='display:inline-block;line-height:20px;position:relative;top:8px;'>
				<div><?=$fullname?></div><div class='j-text-color5'>@<?=$username?></div>
			</div>
		</div>
		</a>
		<?php
	}elseif($type === 'people' || $type === 'blocked'){
		?>
		<div class='j-row'style="margin-bottom:20px;">
			<a href="<?=file_location('home_url',"{$username}/")?>">
			<div class='j-col s2 j-center'>
				<img class=" j-circle"src="<?= file_location('media_url',get_media('profile_pics',$id));?>"style="width:50px;height:50px;">
			</div>
			</a>
			<div class='j-col s10'>
				<div style="line-height:20px">
					<div>
						<div id="<?=($type==="people")?"faub":"blubu";?><?=$id?>"class="j-right"style="margin-right:5px;"><?php if($type === 'people'){follow_status($type,$id);}elseif($type === 'blocked'){block_status($type,$id);}?></div>
						<a href="<?=file_location('home_url',"{$username}/")?>">
						<div><div><?=$fullname?></div><div class='j-text-color5'>@<?=$username?></div></div>
						</a>
					</div>
				</div>
				<a href="<?=file_location('home_url',"{$username}/")?>">
				<div class='j-text-color7'style="max-height:45px;overflow:hidden;text-overflow: ellipsis;"><?=$bio?></div>
				</a>
			</div>
		</div>
		<?php
	}
}
// get user template ends
//check user online status starts
function is_online($id,$type = ""){
	global $uid;
	if($uid === $id){
		return true;
	}else{
		$last_seen = content_data('last_refresh_table','lr_all_datetime',$id,'u_id');
		if($last_seen !== false){
			$now = time()-60*60;
			$thetime = strtotime($last_seen);
			if($thetime >= ($now - (60*3))){return true;}else{return false;}
		}else{
			return false;
		}
	}
}
//check user online status ends

//follow status starts
function follow_status($type,$profile_id){
	global $uid;
	if($uid == $profile_id){return '';} // if user and isd are the same return nothing
	$user_follow_status = content_data('follow_table','f_id',$uid,'follower_id',"AND followee_id = {$profile_id}"); //check if current user follows this profile id
	$profile_follow_status = content_data('follow_table','f_id',$uid,'followee_id',"AND follower_id = {$profile_id}"); //check if profile id follows this current user
	if($user_follow_status === false){
		if($profile_follow_status === false){
			$follow = "Follow";
		}else{
			$follow = "Follow Back";
		}
		?><span class="j-text-color3 j-button j-round j-center j-border j-border-color3"onclick="fau('<?=$type?>','follow',<?=addnum($profile_id)?>)"><?=$follow?></span><?php
	}else{
		if($type === 'detail'){
			?><span class="j-text-color3 j-button j-round j-center j-border j-border-color3"onclick="$('#unfollow_modal<?=$profile_id?>').fadeIn('slow');">Following</span><?php
			user_modal('unfollow',$profile_id,$type); //unfollow modal
		}else{
			?><span class="j-text-color3 j-button j-round j-center j-border j-border-color3"onclick="fau('<?=$type?>','unfollow',<?=addnum($profile_id)?>)">Following</span><?php
		}
	}
}
//follow status ends

//block status starts
function block_status($type,$profile_id){
	global $uid;
	if($uid == $profile_id){return '';} // if user and isd are the same return nothing
	if(content_data('block_table','b_id',$uid,'blocker_id',"AND blockee_id = {$profile_id}") === false){//check if current user follows this profile id
		if($type === 'detail'){
			?>
			<div class='j-row j-clickable'onclick="$('#block_modal<?=$profile_id?>').fadeIn('slow');$('#user_3_dots_modal').fadeOut('slow');">
				<div class="j-col s1"><i class='<?= icon('ban');?>'></i></div>
				<div class="j-col s11">Block @<?=content_data('user_table','u_username',$profile_id,'u_id')?></div>
			</div>
			<?php
		}elseif($type === "blocked"){
			?><span class="j-text-color3 j-button j-round j-center j-border j-border-color3"onclick="bau('blocked','block',<?=addnum($profile_id)?>)">Block</span><?php
		}
	}else{
		if($type === 'detail'){
			?>
			<div class='j-row j-clickable'onclick="$('#unblock_modal<?=$profile_id?>').fadeIn('slow');$('#user_3_dots_modal').fadeOut('slow');">
				<div class="j-col s1"><i class='<?= icon('ban');?>'></i></div>
				<div class="j-col s11">Unblock @<?=content_data('user_table','u_username',$profile_id,'u_id')?></div>
			</div>
			<?php
		}elseif($type === 'blocked'){
			?><span class="j-text-color3 j-button j-round j-center j-border j-border-color3"onclick="bau('blocked','unblock',<?=addnum($profile_id)?>)">Unblock</span><?php
		}
	}
}
//block status ends

//settings section starts
function setting_section($type){
	global $uid;
	if($type === 'clmd'){
		$mode = get_single_cookie('dark_mode');
		if($mode === 'dark'){
			?><i id="<?=$type?>"class='<?=icon('toggle-on')?>'onclick="dms('<?=$type?>','dark')"></i><?php
		}else{
			?><i id="<?=$type?>"class='<?=icon('toggle-off')?>'onclick="dms('<?=$type?>','light')"></i><?php
		}
	}else{
		if($type === 'prat'){$col = 's_private_account';}
		if($type === 'lcme'){$col = 's_lock_inbox';}
		if($type === 'dert'){$col = 's_disable_returt';}
		if($type === 'ukat'){$col = 's_unlink_account';}
		if($type === '2ftm'){$col = 's_2fa_text';}
		if($type === '2fe'){$col = 's_2fa_email';}
		if($type === 'lgme'){$col = 's_login_email';}
		$status = content_data('setting_table',$col,$uid,'u_id');
		if($status === 'on'){
			?><i id="<?=$type?>"class='<?=icon('toggle-on')?>'onclick="uus('<?=$type?>','on')"></i><?php
		}else{
			?><i id="<?=$type?>"class='<?=icon('toggle-off')?>'onclick="uus('<?=$type?>','off')"></i><?php
		}
	}
}
//settings section ends
//USER FUNCTION ENDS
?>