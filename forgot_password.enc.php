<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$location = file_location('home_url','forgot_password/');
$location2 = file_location('home_url','forgot_password/medium/');
$location3 = file_location('home_url','forgot_password/code/');
if(isset($_GET['page'])){
	$sta = ($_GET['page']);
	if($sta === 'id' || $sta === 'medium' || $sta === 'code' || $sta === 'password'){$type = $sta;}else{$type = 'id';}
}else{
$type = 'id';
}
if($type === 'id'){
	//delete cookies
	delete_user_token_cookie();delete_single_cookie("forgot_password_id");
}elseif($type === 'medium'){
	$login_id = get_single_cookie("forgot_password_id");
	//check if it is mobile number or username
	$val = get_id_column($login_id);
	if($val === false){
		delete_single_cookie("forgot_password_id");die(header("Location:$location"));
	}else{
		$col = $val;
	}
	//if login_id is not in database
	$en_login_id = get_id_true_data($login_id,$col,'encrypt');
	if(content_data('user_table','u_id',$en_login_id,$col) === false){
		delete_single_cookie("forgot_password_id");die(header("Location:$location"));
	}
}elseif($type === 'code'){
	$cookie_content = get_user_token_cookie('content');
	$cookie_code = get_user_token_cookie('code');
	$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
	//if cookie email and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		insert_update_delete_user_code('delete',$cookie_content);die(header("Location:$location2"));
	}
}elseif($type === 'password'){
	$cookie_content = get_user_token_cookie('content');
	$cookie_code = get_user_token_cookie('code');
	$db_code = content_data('token_code_table','c_code',$cookie_content,'c_content');
	$verify = content_data('token_code_table','c_verify',$cookie_content,'c_content');
	//if cookie email and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_content) || $cookie_content === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		insert_update_delete_user_code('delete',$cookie_content);die(header("Location:$location2"));
	}
	if($verify !== 'yes'){die(header("Location:$location3"));}
}
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png');
$image_type = substr($image_link,-3);
$page = "FORGOT PASSWORD | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$page_url = file_location('home_url','forgot_password/');
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name;?></title></head>
<body class='j-color4'style='font-family:Roboto,sans-serif;width:100%;'>
	<center>
		<br><br>
		<div class="j-round j-panel j-border j-border-color5" style="width:100%; max-width:400px; height:auto;">
			<center>
			<br><br>
			<span class="j-text-color1 j-large "style='line-height:50px'>
				<a href='<?=file_location('home_url','')?>'>
				<img src="<?=file_location('media_url',"home/{$logo}")?>"class="j-logo-size"alt="<?=get_xml_data('company_name')?> LOGO IMAGE">
				</a>
				<br><b class='j-bolder j-large j-text-color5'>FORGOT PASSWORD</b>
			</span><br>
			</center>
			<?php
			if($type === 'id'){
				?>
				<form id='fpp1frm'>
					<br>
					<?php
					get_form_type('text','id','eidbtn','Email, Mobile Number or Username','','4','50');//for id input
					get_form_button('eidbtn','Continue','disabled')// submit button
					?>
				</form>
				<?php
			}elseif($type === 'medium'){
				$tel = get_id_true_data(content_data('user_table','u_phnumber',$en_login_id,$col),'u_phnumber','decrypt');// decrpypt tel
				$email = get_id_true_data(content_data('user_table','u_email',$en_login_id,$col),'u_email','decrypt');// decrpypt email
				$email_status = content_data('user_table','u_verify',$login_id,$col);
				?>
				<form id='fpp2frm'>
					<div class='j-left j-large j-bolder j-text-color7'>Choose where to receive pass code</div>
					<br class='j-clearfix'><br>
					<div class='j-left'>
						<?php get_form_radio('mhd','mobile number','checked');?>
						<span class='j-text-color3'> Mobile Number (<?=asterisk_user_data('phonenumber',$tel)?>)</span>
					</div>
					<br class='j-clearfix'><br>
					<?php
					if((!is_null($email) && !empty($email))){//if email is empty
						?>
						<div class='j-left'>
							<?php get_form_radio('mhd','email');?>
							<span class='j-text-color3'> Email (<?=asterisk_user_data('email',$email)?>)</span>
						</div>
						<br class='j-clearfix'><br>
						<?php
					}
					get_form_button('embtn','Continue')// submit button
					?>
				</form>
				<?php
			}elseif($type === 'code'){
				//check if it is mobile number or email
				if(get_id_column($cookie_content) === 'u_phnumber'){ $medium = "mobile number"; }else{ $medium = "email"; }
				?>
				<form id='fpp3frm'>
					<div class='j-left j-text-color7'>Code has been sent to your <?=$medium?>, code expires in 5 minutes</div>
					<br class='j-clearfix'><br>
					<?php
					get_form_type('number','cde','ecdbtn','Code','','1','6','','','required',"trsub(this,'ecdbtn')");//for code input
					get_form_button('ecdbtn','Continue','disabled')// submit button
					?>
					</form>
				<script>$(document).ready(function(){r_m2("Notice!!!<br><?=ucfirst($medium)?> message functionality is not ready.<br> Please Use the this <span class='j-bolder'>"+"<?=$cookie_code?>"+" </span> code to continue")})</script>
				<?php
				$trigger_submit_js = true;
			}elseif($type === 'password'){
				?>
				<form id='fpp4frm'>
					<?php
					get_form_hidden('id',$cookie_content);//for hidden id value
					get_form_password('epsbtn');//for password input
					get_form_button('epsbtn','Reset Password','disabled')// submit button
					?>
					</form>
				<?php
				$pass_show_eye_js = true;
			}
			?>
			<br>
			<center><a class="j-text-color3 j-center j-bolder"href="<?= file_location('home_url','login/');?>">Back to Login In</a></center>
			<br><br><br>
		</div>
	</center>
	<span id='st'></span>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>