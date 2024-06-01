<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/edit_profile/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "EDIT PROFILE";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body" class="j-color4" style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5"style="position:relative">
			<?php $nav_bar="header";$header="Edit Profile";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <?php //image starts ?>
            <div id="edt_img"class=""style="width:100%;position:relative">
                <?php user_section_data('edit_cover_pics',$uid); //for edit cover pics?>
                <?php user_section_data('edit_profile_pics',$uid); //for edit profile pics?>
            </div>
            <div class='j-container'style="margin-top:50px;">
                <?php
                $fullname = content_data('user_table','u_fullname',$uid,'u_id');
                $bio = content_data('user_table','u_bio',$uid,'u_id');
                $website = content_data('user_table','u_website',$uid,'u_id');
                $state = content_data('user_table','u_state',$uid,'u_id');
                ?>
                <form id='eupfrm'>
                    <?php
                    get_form_type('text','fnm','supbtn','Fullname',$fullname,'3','50','Fullname');//for fullname input
                    get_form_textarea('bio','','Bio',$bio,'4','5','200','Bio','',' ');//for bio input
                    get_form_type('text','web','','Website',$website,'5','70','Website','',' ');//for website input
                    get_form_type('text','ste','','State',$state,'2','50','State','',' ');//for website input
                    get_form_button('supbtn','Save')// submit button
                    ?>
                </form>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $triger_click_js = true;$get_user_data_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>