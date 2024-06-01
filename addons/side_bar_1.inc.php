<div class="j-col m1 min-height  j-hide-small j-hide-large j-hide-xlarge j-border-color6 dmb6"style="border-right:solid 2px ;"></div>
<div class=" j-col l4 xl35 j-hide-small j-hide-medium min-height j-border-color6 dmb6"style="border-right:solid 2px;position:sticky;top:0">
	<div class=''>
		<div id="first_side_bar">
					<?php
					$username = content_data('user_table','u_username',$uid,'u_id');
					?>
					<div style="padding:9px 20%;line-height:45px;"class="j-large">
						<div style="overflow-x:hidden;">
							<div style="margin-bottom:5px;">
								<a href='<?=file_location('home_url','')?>'onclick="<?=php_self('/index.php','home')?"iauulr('home')":"";?>">
								<img src="<?=file_location('media_url',"home/{$logo}")?>"class="j-logo-size"alt="<?=get_xml_data('company_name')?> LOGO IMAGE">
								</a>
							</div>
							<a id='home1'href="<?=file_location('home_url','')?>"onclick="<?=php_self('/index.php','home')?"iauulr('home')":"";?>">
							<div class="<?=php_self('/index.php','home')?"j-bolder":"";?>">
								<div style="width:35px;display:inline-block"><i class="<?= icon('home');?>"></i></div>Home
								<span class="newsfeedspan j-text-color1 j-small"style="position:relative;top:-12px;left:-8px;"><?php get_noti('feed')?></span>
							</div>
							</a>
							<?php
							if(php_self('/explore/index.php','home')){
								?>
								<div class="j-bolder j-clickable"><div style="width:35px;display:inline-block"><i class="<?= icon('search');?>"></i></div>Explore</div>
								<?php
							}else{
								?>
								<a id=''href="<?=file_location('home_url','explore/')?>">
								<div class="<?=php_self('/explore/search.enc.php','home')?"j-bolder":"";?>"><div style="width:35px;display:inline-block"><i class="<?= icon('search');?>"></i></div>Explore</div>
								</a>
								<?php
							}
							if(php_self('/m/index.php','home')){
								?>
								<div class="j-bolder j-clickable">
									<div style="width:35px;display:inline-block"><i class="<?= icon('envelope');?>"></i></div>Messages
									<span class="messagespan"style="position:relative;top:-12px;left:-10px;"><?php get_noti('mess')?></span>
								</div>
								<?php
							}else{
								?>
								<a id=''href="<?=file_location('home_url','m/')?>">
								<div>
									<div style="width:35px;display:inline-block"><i class="<?= icon('envelope');?>"></i></div>Messages
									<span class="messagespan"style="position:relative;top:-12px;left:-10px;"><?php get_noti('mess')?></span>
								</div>
								</a>
								<?php
							}
							if(php_self('/n/index.php','home')){
								?>
								<div class="j-bolder j-clickable">
									<div style="width:35px;display:inline-block"><i class="<?= icon('bell');?>"></i></div>Notifications
									<span class="notificationspan"style="position:relative;top:-12px;left:-10px;"><?php get_noti('noti')?></span>
								</div>
								<?php
							}else{
								?>
								<a id=''href="<?=file_location('home_url','n/')?>">
								<div>
									<div style="width:35px;display:inline-block"><i class="<?= icon('bell');?>"></i></div>Notifications
									<span class="notificationspan"style="position:relative;top:-12px;left:-10px;"><?php get_noti('noti')?></span>
								</div>
								</a>
								<?php
							}
							if(php_self('/bookmark.enc.php','home')){
								?>
								<div class="j-bolder j-clickable"><div style="width:35px;display:inline-block"><i class="<?= icon('bookmark');?>"></i></div>Bookmarks</div>
								<?php
							}else{
								?>
								<a id=''href="<?=file_location('home_url','bookmark/')?>">
								<div><div style="width:35px;display:inline-block"><i class="<?= icon('bookmark');?>"></i></div>Bookmarks</div>
								</a>
								<?php
							}
							if(php_self('/account.enc.php','home') && $id === $uid){
								?>
								<div class="j-bolder j-clickable"><div style="width:35px;display:inline-block"><i class="<?= icon('user');?>"></i></div>Profile</div>
								<?php
							}else{
								?>
								<a id=''href="<?=file_location('home_url',"{$username}/")?>">
								<div><div style="width:35px;display:inline-block"><i class="<?= icon('user');?>"></i></div>Profile</div>
								</a>
								<?php
							}
							if(php_self('/settings/index.php','home')){
								?>
								<div class="j-bolder j-clickable"><div style="width:35px;display:inline-block"><i class="<?= icon('cog');?>"></i></div>Settings</div>
								<?php
							}else{
								?>
								<a id=''href="<?=file_location('home_url',"settings/")?>">
								<div><div style="width:35px;display:inline-block"><i class="<?= icon('cog');?>"></i></div>Settings</div>
								</a>
								<?php
							}
							?>
							<?php //for lower setting and account details ?>
							<div style="position:fixed;bottom:20px;left:5.7%;width:17%;">
								<a id=''href="<?=file_location('home_url',"{$username}/")?>">
								<div id='sbr'class="j-medium">
									<?php user_data('side_bar')?>
								</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php $notification = 'notification'?>