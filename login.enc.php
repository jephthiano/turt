<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$location = file_location('home_url','login/');
if(isset($_GET['page'])){
	$sta = ($_GET['page']);
	if($sta === 'id' || $sta === 'verify'){$type = $sta;}else{$type = 'id';}
}else{
$type = 'id';	
}
if($type === 'id'){
	delete_single_cookie("login_id");
}elseif($type === 'verify'){
	$login_id = get_single_cookie("login_id");
	//check if it is mobile number or username
	$val = get_id_column($login_id);
	if($val === false){
		delete_single_cookie("login_id");die(header("Location:$location"));
	}else{
		$col = $val;
	}
	//if login_id is not in database
	if(content_data('user_table','u_id',get_id_true_data($login_id,$col,'encrypt'),$col) === false){
		delete_single_cookie("login_id");die(header("Location:$location"));
	}
}
//for meta
$follow_type = 'follow';
$image_link = file_location('media_url','home/logo_white.png');
$image_type = substr($image_link,-3);
$page = "LOGIN | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$page_url = file_location('home_url','login/');
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name;?></title></head>
<body class='j-color4'style='font-family:Roboto,sans-serif;width:100%;'>
	<br><br>
	<center>
	<div class="j-round j-panel j-border j-border-color5"style="width:100%;max-width:400px;height:auto;">
		<center>
			<br><br>
			<span class="j-text-color1 j-large"style='line-height:50px'>
				<a href='<?=file_location('home_url','')?>'>
				<img src="<?=file_location('media_url',"home/{$logo}")?>"class="j-logo-size"alt="<?=get_xml_data('company_name')?> LOGO IMAGE">
				</a>
				<br><b class='j-bolder j-text-color7'>LOGIN</b>
			</span><br>
		</center>
		<?php
		if($type === 'id'){
			?>
			<form id='lgp1frm'onsubmit="event.preventDefault();">
				<br>
				<?php
				if(isset($_GET['re'])){$re = ($_GET['re']);}else{$re = file_location('home_url','');}
				get_form_type('text','id','eidbtn','Email, Mobile Number or Username','','4','50');//for id input
				get_form_hidden('re',$re);//for hidden redirection value
				?>
				<a class="j-right j-text-color3 j-bolder"href="<?=file_location('home_url','forgot_password/');?>">Forget Your Password?</a><br class='j-clearfix'><br>
				<?php
				get_form_button('eidbtn','Continue','disabled')// submit button
				?>
			</form>
			<?php
		}elseif($type === 'verify'){
			?>
			<form id='lgp2frm'onsubmit="event.preventDefault();">
				<br>
				<?php
				get_form_type('text','','',$login_id,'','4','20','','disabled');//for disabled id input
				if(isset($_GET['re'])){$re = ($_GET['re']);}else{$re = file_location('home_url','');}
				get_form_hidden('id',$login_id);//for hidden id value
				get_form_hidden('re',$re);//for hidden redirection value
				get_form_password('epssbtn');//for password input
				?>
				<a class="j-right j-text-color3 j-bolder"href="<?=file_location('home_url','forgot_password/');?>">Forget Your Password?</a><br class='j-clearfix'><br>
				<?php
				get_form_button('epssbtn','Log In','disabled')// submit button
				?>
			</form>
			<?php
			$pass_show_eye_js = true;
		}
		?>
		<br>
		<center><a class="j-text-color7 j-center j-bolder"href="<?= file_location('home_url','signup/');?>">Not a member? Sign Up</a></center>
		<br><br><br>
	</div>
	</center>
	<span id='st'></span>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>