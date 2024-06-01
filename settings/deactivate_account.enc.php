<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/deactivate_account/');// session check
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "DE-ACTIVATE ACCOUNT";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width:100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="De-activate Account";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
                <div class='j-text-color7'>
                    <div class="j-text-color3 j-bolder j-large">Deactivate your Turt account</div>
                    <div style="margin-top:10px;">
                        Deactivating your account is temporary, your account will be disabled.
                    </div>
                    <div style="margin-top:10px;">
                        Your name, userrname, account details and turts will not be available/viewable on Turt platforms.
                    </div>
                    <div style="margin-top:10px;">
                        Your account details such as username, email and mobile number can not be used with a different account.
                        if you wish to use any of them with another acccount, change it before you continue with deactivation.
                    </div>
                    <div style="margin-top:10px;">
                        Your account visibility can only be restored when you log in again.
                    </div>
                </div>
                <form id='ddafrm'style="margin-top:10px;">
                    <?php
                    get_form_hidden('ty','deactivate');//for type 
                    get_form_password('ddasbtn');//for password input
                    get_form_button('ddasbtn','De-activate Account','disabled');// submit button
                    ?>
                    </form>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $deactivate_js = true;$pass_show_eye_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>