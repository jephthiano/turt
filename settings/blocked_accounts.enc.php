<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$page_url = file_location('home_url','settings/blocked_accounts/');
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "BLOCKED ACCOUNTS";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family:Roboto,sans-serif;width:100%;"onload="">
    <div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php $nav_bar="header";$header="Blocked Accounts";$back="back";require_once(file_location('inc_path','navigation.inc.php'));?>
            <div style="margin-top:15px;">
                <?php
                require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
                $sql2 = "SELECT DISTINCT u_id,u_fullname,u_username,u_bio FROM block_table,user_table
                WHERE blockee_id = u_id AND blocker_id = :id
                ORDER BY b_id DESC";
                $stmt = $conn->prepare($sql2);
                $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
                $stmt->bindColumn('u_id',$id);
                $stmt->bindColumn('u_fullname',$fullname);
                $stmt->bindColumn('u_username',$username);
                $stmt->bindColumn('u_bio',$bio);
                $stmt->execute();
                $numRow = $stmt->rowCount();
                if($numRow > 0){
                    while($stmt->fetch()){
                        user_template('blocked',$id,$username,$fullname,$bio);
                    }
                }else{
                    ?><div class='j-center j-margin j-large'>No blocked account</div><?php
                }
                ?>
            </div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
    <?php $block_js = true; $get_user_data_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>