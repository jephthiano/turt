<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$location = file_location('home_url','signup/');
$location2 = file_location('home_url','signup/step2/');
if(isset($_GET['page'])){
	$sta = ($_GET['page']);
	if($sta === 'step1' || $sta === 'step2' || $sta === 'step3'){$type = $sta;}else{$type = 'step1';}
}else{
$type = 'step1';	
}
if($type === 'step1'){
	delete_user_token_cookie();
}elseif($type === 'step2'){
	$cookie_content = get_user_token_cookie('content');
	$cookie_code = get_user_token_cookie('code');
	$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
	//if cookie email and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		insert_update_delete_user_code('delete',$cookie_content);
		die(header("Location:$location"));
	}
}elseif($type === 'step3'){
	$cookie_content = get_user_token_cookie('content');
	$cookie_code = get_user_token_cookie('code');
	$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
	$verify = content_data('token_code_table','c_verify',$cookie_content,'c_content');
	//if cookie email and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		insert_update_delete_user_code('delete',$cookie_content);die(header("Location:$location"));
	}
	if($verify !== 'yes'){die(header("Location:$location2"));}
}
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png');
$image_type = substr($image_link,-3);
$page = "SIGN UP | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$page_url = file_location('home_url','signup/');
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name;?></title></head>
<body class='j-color4'style='font-family:Roboto,sans-serif;width:100%;'>
	<br><br>
	<center>
	<div class="j-round j-panel j-border j-border-color5"style="width:100%;max-width:400px;height:auto;">
		<br><br>
		<center>
			<span class="j-text-color1 j-large"style='line-height:50px'>
				<a href='<?=file_location('home_url','')?>'>
				<img src="<?=file_location('media_url',"home/{$logo}")?>"class="j-logo-size"alt="<?=get_xml_data('company_name')?> LOGO IMAGE">
				</a>
				<br><b class='j-bolder j-xlarge j-text-color7'>SIGN UP</b>
			</span><br>
		</center>
		<?php
		if($type === 'step1'){
			?>
			<form id='sgp1frm'>
				<?php
				get_form_type('tel','phn','ephnbtn','Mobile Number','','1','11');//for mobile number input
				get_form_button('ephnbtn','Continue','disabled')// submit button
				?>
			</form>
			<?php
		}elseif($type === 'step2'){
			?>
			<form id='sgp2frm'>
				<div class='j-left j-text-color7'>Code has been sent to your mobile number, code expires in 5 minutes</div>
				<br class='j-clearfix'><br>
				<?php
				get_form_type('number','cde','ecdbtn','Code','','1','6','','','required',"trsub(this,'ecdbtn')");//for code input
				get_form_button('ecdbtn','Continue','disabled')// submit button
				?>
			</form>
			<script>$(document).ready(function(){r_m2("Notice!!!<br>Text message functionality is not ready.<br> Please Use the this <span class='j-bolder'>"+"<?=$cookie_code?>"+" </span> code to continue")})</script>
			<?php
			$trigger_submit_js = true;
		}elseif($type === 'step3'){
			?>
			<form id='sgp3frm'>
				<?php
				get_form_type('text','usr','sgpbtn','Username','','1','20','','','required',"cuen('username',this,'usre');");//for username input
				get_form_type('text','fnm','sgpbtn','Fullname','','3','50');//for fullname input
				get_form_password('sgpbtn');//for password input
				get_form_hidden('phn',$cookie_content);//for hidden mobile number value
				?>
				<?php get_form_checkbox('tupp','','',"daebtn(this,$('#sgpbtn'));")?>
				<span class='j-small j-text-color1'>
					I agree to Turt <a href="<?= file_location('home_url','misc/terms_of_service/')?>" target='_blank'>terms of use</a> and <a href="<?= file_location('home_url','misc/privacy_policy/')?>" target='_blank'> privacy policy</a><br>
				</span>
				<br>
				<?php
				get_form_button('sgpbtn','Sign Up','disabled')// submit button
				?>
			</form>
			<?php
			$check_uen_js = true;$pass_show_eye_js = true;
		}
		?>
		<br>
		<center><a class="j-text-color3 j-center j-bolder"href="<?= file_location('home_url','login/id/');?>">Already a member? Login In</a></center>
		<br><br><br>
	</div>
	</center>
	<span id='st'></span>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>