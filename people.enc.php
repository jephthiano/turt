<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
$page_url = file_location('home_url','people/'.@$_GET['uname'].'/'.@$_GET['type']);// session check
$page_url = file_location('home_url','account/change_password/');
require_once(file_location('inc_path','session_check.inc.php'));
if(isset($_GET['type']) && isset($_GET['uname'])){ 
	$ty = ($_GET['type']);
	$uname = ($_GET['uname']);
	if(!empty($ty) && !empty($uname)){
		$type = $ty;
		$id = content_data('user_table','u_id',$uname,'u_username');
	}else{
		trigger_error_manual(404);
	}
}else{
	trigger_error_manual(404);
}
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = strtoupper(str_replace('_',' ', $type));
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
?>
<!DOCTYPE html >
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<head><?php require_once(file_location('inc_path','meta.inc.php')); ?><title><?php if($type === 'follower'){echo 'Follower';}elseif($type === 'following'){echo 'Following';}elseif($type === 'people_to_follow'){echo 'People to follow';}else{echo '404 Not Found';} ?></title></head>
<body id="body"class="j-color4"style="font-family:Roboto,sans-serif;width:100%;"onload="">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php
			$type_array = ['connect','follower','following'];
			if($id === false || (!in_array($type,$type_array))){
				trigger_error_manual(404);
			}else{
				if($type !== 'connect'){
					$username = content_data('user_table','u_username',$uid,'u_id');
					$location = file_location('home_url',"{$username}/connect/");
					$menu = "<a href='{$location}'class='j-xlarge'><i class='".icon('user-plus')."'></i></a>";
				}
				$nav_bar="header";$header=ucwords($type);$back="back";require_once(file_location('inc_path','navigation.inc.php'));
				?>
				<div style="margin-top:15px;">
					<?php
					if($type === "follower"){ //for followers
						require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
						$sql2 = "SELECT DISTINCT u_id,u_fullname,u_username,u_bio FROM follow_table,user_table
						WHERE followee_id = :id AND follower_id = u_id
						ORDER BY f_id DESC";
						$stmt = $conn->prepare($sql2);
						$stmt->bindParam(':id',$id,PDO::PARAM_INT);
						$stmt->bindColumn('u_id',$fid);
						$stmt->bindColumn('u_fullname',$fullname);
						$stmt->bindColumn('u_username',$username);
						$stmt->bindColumn('u_bio',$bio);
						$stmt->execute();
						$numRow = $stmt->rowCount();
						if($numRow > 0){
							while($stmt->fetch()){user_template('people',$fid,$username,$fullname,$bio);}
						}else{
							?><div class='j-center j-margin j-large'>No follower</div><?php
						}
					}elseif($type === "following"){ //for following
						require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
						$sql2 = "SELECT DISTINCT u_id,u_fullname,u_username,u_bio FROM follow_table,user_table
						WHERE  follower_id = :id AND followee_id = u_id
						ORDER BY f_id DESC";
						$stmt = $conn->prepare($sql2);
						$stmt->bindParam(':id',$id,PDO::PARAM_INT);
						$stmt->bindColumn('u_id',$fid);
						$stmt->bindColumn('u_fullname',$fullname);
						$stmt->bindColumn('u_username',$username);
						$stmt->bindColumn('u_bio',$bio);
						$stmt->execute();
						$numRow = $stmt->rowCount();
						if($numRow > 0){
							while($stmt->fetch()){user_template('people',$fid,$username,$fullname,$bio);}
						}else{
							?><div class='j-center j-margin j-large'>No following</div><?php
						}						
					}elseif($type === "connect"){ //for connect
						$following = multiple_content_data('follow_table','followee_id',$id,'follower_id'); // get people followed by current user
						$blocked = multiple_content_data('block_table','blockee_id',$id,'blocker_id'); // get people blocked by current user
						$blocker = multiple_content_data('block_table','blocker_id',$id,'blockee_id'); // get people that blocked current user
						if($following === false && $blocked === false && $blocker === false){// convert the array of followed users to string if following is not false
							$dont_show_array = 0;
						}else{
							if($following === false){$following = 0;}else{$following = implode(',',$following);}//check if no person is followed
							if($blocked === false){$blocked = 0;}else{$blocked = implode(',',$blocked);} // checked if no person is blocked
							if($blocker === false){$blocker = 0;}else{$blocker = implode(',',$blocker);} // checked if no person blocked current user
							$dont_show_array = $following.','.$blocked.','.$blocker.','.$uid; // merge all users not to be shown in result (all current user too)
						}
						// creating connection
						require_once(file_location('inc_path','connection.inc.php'));
						@$conn = dbconnect('select','PDO');
						$sql = "SELECT DISTINCT u_id,u_fullname,u_username,u_bio,COUNT(u_id) as total FROM follow_table,user_table
						WHERE followee_id NOT IN ({$dont_show_array}) AND followee_id = u_id AND u_status = 'active'
						GROUP BY followee_id ORDER BY RAND() DESC LIMIT 50";
						$stmt = $conn->prepare($sql);
						$stmt->bindColumn('u_id',$top_followee_id);
						$stmt->bindColumn('u_fullname',$fullname);
						$stmt->bindColumn('u_username',$username);
						$stmt->bindColumn('u_bio',$bio);
						$stmt->execute();
						$numRow = $stmt->rowCount();
						$data = [];
						if($numRow > 0){
							while($stmt->fetch()){
								user_template('people',$top_followee_id,$username,$fullname,$bio);
								$data[] = $top_followee_id;
							}
							$top_followee_array = implode(',',$data);//convert array to string
						}else{
							$top_followee_array = "0,";
						}
						//if total is not up to 50
						if($numRow < 50){ // if top followee is not up to 50
							$rem = (50 - $numRow);
							$dont_show_array_followee_data = $top_followee_array.','.$dont_show_array; // join already displayed top followed people and donr_followed people by the user
							$sql = "SELECT DISTINCT u_id,u_fullname,u_username,u_bio FROM user_table
							WHERE u_status = 'active' And u_id NOT IN ({$dont_show_array_followee_data})
							ORDER BY RAND() LIMIT 0,{$rem}";
							$stmt = $conn->prepare($sql);
							$stmt->bindColumn('u_id',$profile_id);
							$stmt->bindColumn('u_fullname',$fullname);
							$stmt->bindColumn('u_username',$username);
							$stmt->bindColumn('u_bio',$bio);
							$stmt->execute();
							$numRow = $stmt->rowCount();
							if($numRow > 0){
								while($stmt->fetch()){
									user_template('people',$profile_id,$username,$fullname,$bio);
								}
							}else{
								?><div class='j-center j-margin j-large'>0 people to connect with</div><?php
							}
						}
					}
					?>	
				</div>
				<?php
			}
			?>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
	<?php $follow_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>