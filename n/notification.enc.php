<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url',"n/".@$_GET['type']."/");
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "NOTIFICATION";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
$type = @$_GET['type'];
if($type !== 'follow'){trigger_error_manual(404);}
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Notifications";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div>
                <?php
                $sender_id_array = multiple_content_data('notification_table','sender_id',$uid,'receiver_id',"AND n_type = '{$type}' ORDER BY n_id DESC",'unique');
                if($sender_id_array === false){
                  ?><div class='j-center j-margin'>No notification</div><?php
                }else{
                    foreach($sender_id_array AS $sender_id){
                        if($type === 'follow'){
                            $link = file_location('home_url',content_data('user_table','u_username',$sender_id,'u_id').'/');
                           ?>
                            <a href="<?=$link?>">
                            <div class="j-row j-text-color3"style="padding:15px 5px;">
                                <div class="j-col s2 m1">
                                    <center><img src="<?=file_location('media_url',get_media('profile_pics',$sender_id));?>" class="j-circle j-border-2 j-color5"style="height:35px;width:35px"></center>
                                </div>
                                <div class="j-col s10 m11 j-container">
                                    <span class="j-bolder"><?=(content_data('user_table','u_fullname',$sender_id,'u_id'))?></span><span> started following you.</span>
                                    <span class='j-right j-text-color7'>
                                    <?=show_date_interval(content_data('notification_table','n_regdatetime',$sender_id,'sender_id',"AND receiver_id = {$uid} AND n_type = '{$type}'"),'short')?>
                                    </span>
                                </div>
                            </div>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $toggle_button_js = true; $update_set_js = true?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>