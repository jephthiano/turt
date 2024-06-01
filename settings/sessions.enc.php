<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','settings/sessions/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "SESSIONS";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Sessions";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div class='j-padding'>
				<div class='j-bolder j-large j-margin'>
                    You are logged in on these devices
                </div>
                <div id='aud'>
                    <?php
                    $id = get_user_cookie_data('user_id');
                    $ipaddress = get_user_cookie_data('ip');
                    $token = get_user_cookie_data('token');
                    $selector = get_user_cookie_data('selector');
                    //for currenct user active session
                    require_once(file_location('inc_path','connection.inc.php'));
                    @$conn = dbconnect('select','PDO');
                    $sql = "SELECT cd_id,cd_device_type,cd_browser_type,cd_country,cd_state FROM cookie_data_table
                    WHERE u_id = :id AND cd_token = :token AND cd_selector = :selector AND cd_ipaddress = :ipaddress LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
                    $stmt->bindParam(':token',$token,PDO::PARAM_STR);
                    $stmt->bindParam(':selector',$selector,PDO::PARAM_STR);
                    $stmt->bindParam(':ipaddress',$ipaddress,PDO::PARAM_STR);
                    $stmt->bindColumn('cd_id',$id);
                    $stmt->bindColumn('cd_device_type',$device_type);
                    $stmt->bindColumn('cd_browser_type',$browser_type);
                    $stmt->bindColumn('cd_country',$country);
                    $stmt->bindColumn('cd_state',$state);
                    $stmt->execute();
                    $numRow = $stmt->rowCount();
                    if($numRow > 0){
                        while($stmt->fetch()){
                            ?>
                            <div class='j-card j-color4 j-padding j-display-container j-round j-border-bottom'>
                                <div>
                                    <span class='j-bolder'><?= $device_type?></span><span class='j-bolder j-padding j-text-color5'><?= ucwords($state.", ".$country)?></span><br>
                                    <span class='j-text-color1'><?= $browser_type?></span><br><br><br>
                                    <span class='j-display-bottomright j-text-color9 j-round j-button j-margin j-small j-bolder'>Active Device</span>
                                </div>
                            </div><br>
                            <?php
                        }//end of while
                    }//end of if $numrow > 1
                    //for others user active session
                    $sql = "SELECT cd_id,cd_device_type,cd_browser_type,cd_country,cd_state,cd_login_time FROM cookie_data_table
                    WHERE u_id = :id AND (cd_token != :token OR cd_selector != :selector OR cd_ipaddress != :ipaddress) ORDER BY cd_id DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
                    $stmt->bindParam(':token',$token,PDO::PARAM_STR);
                    $stmt->bindParam(':selector',$selector,PDO::PARAM_STR);
                    $stmt->bindParam(':ipaddress',$ipaddress,PDO::PARAM_STR);
                    $stmt->bindColumn('cd_id',$id);
                    $stmt->bindColumn('cd_device_type',$device_type);
                    $stmt->bindColumn('cd_browser_type',$browser_type);
                    $stmt->bindColumn('cd_country',$country);
                    $stmt->bindColumn('cd_state',$state);
                    $stmt->bindColumn('cd_login_time',$login_time);
                    $stmt->execute();
                    $numRow = $stmt->rowCount();
                    if($numRow > 0){
                        while($stmt->fetch()){
                            ?>
                            <div id='esd<?=$id?>'>
                                <div class='j-card j-color4 j-padding j-display-container j-round j-border-bottom'>
                                    <div>
                                        <span class='j-bolder'><?= $device_type?></span><span class='j-bolder j-padding j-text-color5'><?= ucwords($state.", ".$country)?></span><br>
                                        <span class='j-text-color1'><?= $browser_type?></span><span class='j-padding'><?= show_date($login_time)?></span>
                                        <span class='j-text-gray'> <?= show_time($login_time)?></span><br><br><br>
                                        <span class='j-display-bottomright j-color1 j-round j-button j-margin j-small'onclick="$('#logout_one_modal<?=$id?>').fadeIn('slow');">
                                        Log Out This Device
                                        </span><br>
                                    </div>
                                </div><br>
                            </div>
                            <?php user_modal('log_out_one',$id,$device_type." ".$browser_type)?>
                            <?php
                        }//end of while
                        ?>
                        <br>
                        <div class='j-color1 j-round j-block j-button'onclick="$('#logout_all_modal').fadeIn('slow')">
                            <span>Log Out All Sessions</span>
                        </div>
                        <?php user_modal('log_out_all',$uid)?>
                        <?php
                    }//end of if $numrow > 1
                    ?>
                </div>
                <br>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $get_user_data_js = true;$logout_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php'));?>
</body>
</html>