<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');	// all functions
require_once(file_location('inc_path','session_check.inc.php'));
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo_white.png'); $image_type = substr($image_link,-3);
$page = "SEARCH";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
if(isset($_GET['qry']) && !empty($_GET['qry'])){
	$searchtext = $_GET['qry'];
}else{
	trigger_error_manual(404);
}
//$search_history = new search_history('update_insert');
//$search_history->search_text = $searchtext;
//$search_history->run_request();
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;">
	<div class="j-row">
		<?php require_once(file_location('inc_path','side_bar_1.inc.php')); //first side bar?>
		<div id="" class="j-col m10 l8 xl5">
			<?php require_once(file_location('inc_path','navigation.inc.php'));?>
			<div class='j-dropdown-click j-padding j-color4'style='width:100%;position:sticky;top:0;z-index:1'>
				<div class='j-color4'style="height:50px;">
					<div class="">
						<input type="search"name="sIp"id="sIp"class="j-input j-border-2 j-border-color5 j-round j-color4 j-dropdown"placeholder="Search Turt"
							style="width:100%;outline:none;display:inline"onfocus="getr();"onkeyup="getr();"onsearch="gtsp();"/>
					</div>
				</div>
				<?php user_modal('explore','','search'); //for explore modal?>
				<div class='j-color4'style='margin-top:8px;'>
					<div class="j-center j-border-color3 j-color4 dmb3 dm4" style="padding:0px 0px;border-bottom:1px solid">
						<div class="j-clickable laucher"onclick="hornav(this,'top');"style="width:19%;display:inline-block;color:teal;border-bottom:4px solid teal;"><b>Top</b></div>
						<div class="j-clickable laucher"style='width:19%;display:inline-block;'onclick="hornav(this,'latest');"><b>Latest</b></div>
						<div class="j-clickable laucher"style='width:19%;display:inline-block;'onclick="hornav(this,'people');"><b>People</b></div>
						<div class="j-clickable laucher"style='width:19%;display:inline-block;'onclick="hornav(this,'photos');"><b>Photos</b></div>
						<div class="j-clickable laucher"style='width:19%;display:inline-block;'onclick="hornav(this,'video');"><b>Video</b></div>
					</div>
				</div>
			</div>
			<div id=""class='j-padding-small'>
				<div style='margin-top:20px;'>
					<div id='top'class='shw'>
						<?php
						require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
						$searchtext2 = $searchtext."*";
						$sql = "SELECT u_id,u_fullname,u_username,u_bio FROM user_table
						WHERE MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) AND u_status = 'active'
						ORDER BY MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) LIMIT 20";
						$stmt = $conn->prepare($sql);
						$stmt->bindParam(':id',$uid,PDO::PARAM_INT);
						$stmt->bindParam(':searchtext',$searchtext2,PDO::PARAM_STR);
						$stmt->bindColumn('u_id',$id);
						$stmt->bindColumn('u_fullname',$fullname);
						$stmt->bindColumn('u_username',$username);
						$stmt->bindColumn('u_bio',$bio);
						$stmt->execute();
						$numRow = $stmt->rowCount();
						if($numRow > 0){
							while($stmt->fetch()){
								user_template('people',$id,$username,$fullname,$bio);
							}
						}else{
							?>
							<center>
								<br>
								<div class='j-bolder'>No results found for the keyword '<span class='j-text-color7 j-itallic'> <?=$searchtext?> </span>'</div>
								<div class='j-text-color5'>Try again with different spelling</div>
							</center>
							<?php
						}
						?>
					</div>
					<div id='latest'class='shw j-center'style='display:none'>
						Once the feature has been completed, search latest will be shown here.<br> Only people is ready
					</div>
					<div id='people'class='shw'style='display:none'>
						<?php
						require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
						$searchtext2 = $searchtext."*";
						$sql = "SELECT u_id,u_fullname,u_username,u_bio FROM user_table
						WHERE MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) AND u_status = 'active'
						ORDER BY MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) LIMIT 20";
						$stmt = $conn->prepare($sql);
						$stmt->bindParam(':id',$uid,PDO::PARAM_INT);
						$stmt->bindParam(':searchtext',$searchtext2,PDO::PARAM_STR);
						$stmt->bindColumn('u_id',$id);
						$stmt->bindColumn('u_fullname',$fullname);
						$stmt->bindColumn('u_username',$username);
						$stmt->bindColumn('u_bio',$bio);
						$stmt->execute();
						$numRow = $stmt->rowCount();
						if($numRow > 0){
							while($stmt->fetch()){
								user_template('people',$id,$username,$fullname,$bio);
							}
						}else{
							?>
							<center>
								<br>
								<div class='j-bolder'>No results found for the keyword '<span class='j-text-color7 j-itallic'> <?=$searchtext?> </span>'</div>
								<div class='j-text-color5'>Try again with different spelling</div>
							</center>
							<?php
						}
						?>
					</div>
					<div id='photos'class='shw j-center'style='display:none'>
						Once the feature has been completed, search photos will be shown here.<br> Only people is ready
					</div>
					<div id='video'class='shw j-center'style='display:none'>
						Once the feature has been completed, search video will be shown here.<br> Only people is ready
					</div>
				</div>
			</div>
		</div>
		<?php require_once(file_location('inc_path','side_bar_2.inc.php')); //second side bar?>
	</div>
	<?php $explore_search_js = true;$horn_nav_js = true;?>
<?php require_once(file_location('inc_path','js.inc.php')); ?>
</body>
</html>