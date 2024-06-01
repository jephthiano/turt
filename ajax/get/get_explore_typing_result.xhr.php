<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
require_once(file_location('inc_path','session_check_nologout.inc.php'));
if(isset($_POST['s'])){
	require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
	$searchtext = (($_POST['s']));
	if(!empty($searchtext)){ // if the search text is not empty
		$searchtext2 = $searchtext."*";
		$sql = "SELECT u_id,u_fullname,u_username FROM user_table
			WHERE MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) AND u_status = 'active' AND u_id != :id
			ORDER BY MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) LIMIT 10";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id',$uid,PDO::PARAM_INT);
		$stmt->bindParam(':searchtext',$searchtext2,PDO::PARAM_STR);
		$stmt->bindColumn('u_id',$id);
		$stmt->bindColumn('u_fullname',$fullname);
		$stmt->bindColumn('u_username',$username);
		$stmt->execute();
		$numRow = $stmt->rowCount();
	}else{
		// if not empty show search history instead
		$sql = "SELECT sh_text FROM search_history_table WHERE u_id = :id LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id',$uid,PDO::PARAM_INT);
		$stmt->bindColumn('sh_text',$sh_text);
		$stmt->execute();
		$numRow = $stmt->rowCount();
	}
	if($numRow > 0){
		if(!empty($searchtext)){
			while($stmt->fetch()){
				user_template('user_full_page',$id,$username,$fullname);
			}
			?>
			<a href="<?= file_location('home_url','explore/search?qry='.rawurlencode($searchtext));?>"><div class='j-text-color7'style='margin-bottom:15px;'>Search for <?=$searchtext;?></div></a>
			<?php
			if(regex('username',$searchtext)){
				?><a href="<?=file_location('home_url',"{$searchtext}/")?>"><div class='j-text-color7'>Go to @<?=$searchtext?></div></a><?php
			}
			?>
			<div class='j-hide-medium j-hide-large j-hide-xlarge'><br><br><br><br><br><br></div>
			<?php
		}else{
			while($stmt->fetch()){
				$search_array = explode(',',$sh_text);
				rsort($search_array);
				$len = count($search_array);
				for($i = 0;$i <= 7; $i++){
					?>
					<div class="j-text-color7" style="margin-bottom:15px;padding-left: 0px;">
						<a href="<?= file_location('home_url','explore/search?qry='.rawurlencode($search_array[$i]));?>"><span><?= @$search_array[$i];?></span></a>
					</div>
					<?php
				}
			}//end of while
		}
	}else{
		if(!empty($searchtext)){
			?>
			<a href="<?= file_location('home_url','explore/search?qry='.rawurlencode($searchtext));?>"><div class='j-text-color7'style='margin-bottom:15px;'>Search for <?=$searchtext;?></div></a>
			<?php
			if(regex('username',$searchtext)){
				?><a href="<?=file_location('home_url',"{$searchtext}/")?>"><div class='j-text-color7'>Go to @<?=$searchtext?></div></a><?php
			}
		}else{
			?>
			<br><center><div class='j-text-color7'>Try searching for people, topics or keywords</div></center>
			<?php
		}
	}
}// end of if isset
?>