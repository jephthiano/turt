<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
require_once(file_location('inc_path','all_tables.inc.php')); // create all tables
require_once(file_location('inc_path','session_check_nologout.inc.php')); //session
//for meta
$follow_type = 'follow';
$image_link = file_location('media_url','home/logo_white.png');
$image_type = substr($image_link,-3);
$page = "HOME | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$page_url = file_location('home_url','');
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body  id="body"class='j-color4'style="font-family:Roboto,sans-serif;width:100%;"onload="">
	<?php
	if(isset($_SESSION['user_id'])){
		?>
		<div class="j-row">
			<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
			<div id="" class="j-col m10 l8 xl5">
				<?php $nav_bar = 'nav_bar';require_once(file_location('inc_path','navigation.inc.php'));?>
				<div>
					<div id='you'class='shw j-padding'style='margin:9px 9px;'>
						<div class='j-xlarge'>We are still working on the home page!</div>
						<div class='j-text-color7'style="margin:9px 0px">You can still connet with people and topics to follow</div>
						<a href="<?=file_location('home_url',content_data('user_table','u_username',$uid,'u_id')."/connect/")?>"><div class='j-color1 j-round j-btn'>Connect</div></a>
					</div>
					<div id='fllw'class='shw j-padding'style='display:none;margin:9px 9px;'>
						<div class='j-xlarge'>Turt Welcomes you!</div>
						<div class='j-text-color7'style="margin:9px 0px">Now that you are here, let help you to find people and topics to follow</div>
						<a href="<?=file_location('home_url',content_data('user_table','u_username',$uid,'u_id')."/connect/")?>"><div class='j-color1 j-round j-btn'>Yes I'm in</div></a>
					</div>
				</div>
			</div>
			<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
		</div>
		<?php
		$horn_nav_js = true; //for js page
	}else{
		?>
		<div class="j-row min-height"id=""style='background: url("<?= file_location('media_url','hme/home.jpg');?>");'>
			<div class="j-col s12 m6 j-hide-small"></div>
			<div class="j-col s12 m6 j-padding j-right"id="">
				<br><br><br><br>
				<center>
					<img src="<?=file_location('media_url',"home/{$logo}")?>"class="j-logo-size"alt="<?=get_xml_data('company_name')?> LOGO IMAGE">
				</center>
				<div class="j-large j-hp-padding j-bolder">
						<p class='j-xlarge'>Join <?=ucwords(get_xml_data('company_name'))?> and reach the world</p>
						<p>Get connected</p>
						<p>Be informed</p>
				</div><br>
				<center class="j-large">
					<a href="<?= file_location('home_url','login/');?>">
					<span class="j-color1 j-round-large j-button"style="width: 100%;max-width: 400px;"><b>Log in</b></span><br><br>
					</a>
					<a href="<?= file_location('home_url','signup/');?>">
					<span class="j-white j-text-color1 j-round-large j-button j-border-color1 j-border"style="width: 100%;max-width: 400px;"><b>Sign up</b></span><br>
					</a>
				</center>
			</div>
			</div>
			<div class='j-clearfix'></div>
			<div class='j-text-color6'style="position:absolute;bottom:0px;left:50%;transform: translate(-50%,0%)">
				<?php require_once(file_location('inc_path','footer.inc.php'));//FOOTER ?><br class='j-hide-xlarge'><br class='j-hide-xlarge'>
			</div>
		<span id="st"></span>
		</div>
	<?php
	}
	?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>