<div id='st'class='j-fixalert'></div>
<?php
if(isset($nav_bar) && $nav_bar === 'header'){
	if(!isset($menu)){$menu = '';}
	get_header($header,$back,$menu);
}
if((isset($nav_bar) && $nav_bar === 'nav_bar') || php_self('/account.enc.php','home')){
	?>
		<div class=" <?=(php_self('/account.enc.php','home'))?"j-hide":"";?> j-border-color6 dmb6"style="border-bottom:solid 1px;margin-top:5px;padding:8px 8px 0px 8px;">
			<?php
			if(php_self('/index.php','home')){
				?>
				<div class=''>
					<div class='j-bolder j-large'>
						<span class="j-hide-small j-hide-medium">Home</span>
						<span class="j-hide-large j-hide-xlarge">
							<center><img src="<?=file_location('media_url',"home/{$logo}")?>"class="j-logo-size"alt="<?=get_xml_data('company_name')?> LOGO IMAGE"></center>
						</span>
					</div>
					<div class='j-row j-bolder'style="padding:0px 20%;margin-top:20px;">
						<div class='j-clickable laucher'onclick="hornav(this,'you');"style="color:teal;border-bottom:4px solid teal;display:inline-block;">
							For you
						</div>
						<div class='j-clickable laucher j-right'onclick="hornav(this,'fllw');"style="display:inline-block;">
							Following
						</div>
					</div>
				</div>
				<?php
			}
			if(php_self('/explore/index.php','home')){?><div style="margin-bottom:20px;margin-top:10px;"><a class='j-bolder j-large'>Explore</a></div><?php }
			if(php_self('/n/index.php','home')){ ?><div style="margin-bottom:20px;margin-top:10px;"><a class='j-bolder j-large'>Notifications</a></div><?php }
			if(php_self('/m/index.php','home')){ ?><div style="margin-bottom:20px;margin-top:10px;"><a class='j-bolder j-large'>Messages</a></div><?php }
			if(php_self('/bookmark.enc.php','home')){ ?><div style="margin-bottom:20px;margin-top:10px;"><a class='j-bolder j-large'>Bookmarks</a></div><?php }
			if(php_self('/settings/index.php','home')){ ?><div style="margin-bottom:20px;margin-top:10px;"><a class='j-bolder j-large'>Settings</a></div><?php }
			?>
		</div>
		<?php // SMALL SCREEN NAVIGATION ?>
		<div class="j-hide-large j-hide-xlarge j-card-4 j-fixed-nav j-color4 dm4 j-border-color6 dmb6"style="margin:0px; font-size:12px;z-index:1;border-top:solid 1px;">
			<div class="j-row-padding j-center j-xlarge"style="padding: 10px 0px">
				<div class="j-col s2 <?=php_self('/index.php','home')?"j-text-color1":"";?>"style="position:relative;">
					<a id='home2'href="<?= file_location('home_url','');?>"onclick="<?=php_self('/index.php','home')?"iauulr('home')":"";?>">
					<b><i class="<?= icon('home');?>"></i></b><span class="newsfeedspan j-text-color1 j-tiny"style="position:relative;top:-18px;right:0px;"><?php get_noti('feed')?></span>
					</a>
				</div>
				<div class="j-col s3 <?=php_self('/explore/index.php','home') || php_self('/explore/search.enc.php','home')?"j-text-color1":"";?>">
					<?php
					if(php_self('/explore/index.php','home')){
						?><span onclick="$('#sIp').focus()"><b><i class="<?= icon('search');?>"></i></b></span><?php
					}else{
						?><a href="<?= file_location('home_url','explore/');?>"class=""><b><i class="<?= icon('search');?>"></i></b></a><?php
					}
					?>
				</div>
				<div class="j-col s2"style="position:relative;">
					<?php
					if(php_self('/m/index.php','home')){
						?><b><i class="<?= icon('envelope');?> j-text-color1"></i></b><?php
					}else{
						?><a href="<?= file_location('home_url','m/');?>"class=""><b><i class="<?= icon('envelope','far');?> "></i></b></a><?php
					}
					?>
					<?php //get number of user that sent unaware message ?>
					<span class="messagespan"style="position:relative;top:-20px;right:12px;"><?php get_noti('mess')?></span>
				</div>
				<div class="j-col s3"style="position: relative;">
					<?php
					if(php_self('/n/index.php','home')){
						?><b><i class="<?=icon('bell');?> j-text-color1"></i></b><?php	
					}else{
						?><a href="<?= file_location('home_url','n/');?>"><i class="<?=icon('bell','far');?> "></i></a><?php
					}
					?>
					<?php // get number of sent notification ?>
					<span class="notificationspan"style="position:relative;top:-20px;right:15px;"><?php get_noti('noti')?></span>
				</div>
				<div class="j-col s2">
					<?php
					if(php_self('/account.enc.php','home') && $id === $uid){
						?><img src="<?= file_location('media_url',get_media('profile_pics',$uid));?>"style="width: 30px;height:30px"class="j-circle j-border-2 j-border-color3"/><?php
					}else{
						?>
						<a href="<?= file_location('home_url',content_data('user_table','u_username',$uid,'u_id').'/');?>">
						<img src="<?= file_location('media_url',get_media('profile_pics',$uid));?>"style="width: 30px;height:30px"class="j-circle"/>
						</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<?php
		//to post button starts
		if(php_self('/index.php','home')){
			?>
			<a href="<?= file_location('home_url','t/turt/');?>">
			<span class="j-clickable j-color1 j-btn j-circle j-fixed-post j-display-container"style='z-index:2'>
				<i class="<?= icon('plus');?> j-medium"style="position:relative;top:0px;left:5px;"></i>
				<i class="<?= icon('newspaper');?> j-medium"style="position: relative;top:10px;right:5px;"></i>
			</span>
			</a>
			<?php
		}
		//to post button ends
		//new message button
		if(php_self('/m/index.php','home')){
			?>
			<a href="<?= file_location('home_url','m/search/');?>"style="z-index:2">
			<span class="j-clickable j-color1 j-btn j-circle j-fixed-post j-display-container">
				<i class="<?= icon('plus');?> j-medium"style="position: relative;top:0px;left:5px;"></i>
				<i class="<?= icon('envelope');?> j-medium"style="position: relative;top:10px;right:5px;"></i>
			</span>
			</a>
			<?php
		}
		//new message button ends
}
?>
<?php $notification = 'notification'?>