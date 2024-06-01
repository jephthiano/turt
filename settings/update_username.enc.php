<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/update_username/');// session check
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "CHANGE USERNAME";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width:100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Update Username";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
                <form id='upufrm'>
                    <?php
                    $username = content_data('user_table','u_username',$uid,'u_id');
                    get_form_type('text','cuu','','Current Username',$username,'4','20','Current','readonly','required');//current Username
                    get_form_type('text','nwu','upubtn','New Username',$username,'4','20','New','','required',"cuen('username',this,'nwue');");//current Username
                    get_form_button('upubtn','Update','disabled');// submit button
                    ?>
                </form>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $check_uen_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>