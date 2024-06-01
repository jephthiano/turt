<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
require_once(file_location('inc_path','session_check_nologout.inc.php'));
if(isset($_POST['s'])){
	require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
	$searchtext = test_input(($_POST['s']));
	if(!empty($searchtext)){ // if the search text is not empty
		$searchtext2 = $searchtext."*";
		$sql = "SELECT u_id,u_fullname,u_username FROM user_table
			WHERE MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) AND u_status = 'active' AND u_id != :id
			ORDER BY MATCH(u_username,u_fullname) AGAINST(:searchtext IN BOOLEAN MODE) LIMIT 20";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id',$uid,PDO::PARAM_INT);
		$stmt->bindParam(':searchtext',$searchtext2,PDO::PARAM_STR);
		$stmt->bindColumn('u_id',$id);
		$stmt->bindColumn('u_fullname',$fullname);
		$stmt->bindColumn('u_username',$username);
		$stmt->execute();
		$numRow = $stmt->rowCount();
	}else{
		// select distinct user that have sent message and receive message form active user
		$sql2 = "SELECT DISTINCT u_id,u_fullname,u_username FROM message_table,user_table
		WHERE u_id != :id AND u_status = 'active' AND (:id IN (receiver_id,sender_id) AND u_id IN (receiver_id,sender_id))
		ORDER BY m_regdatetime DESC LIMIT 20";
		$stmt = $conn->prepare($sql2);
		$stmt->bindParam(':id',$uid,PDO::PARAM_INT);
		$stmt->bindColumn('u_id',$id);
		$stmt->bindColumn('u_fullname',$fullname);
		$stmt->bindColumn('u_username',$username);
		$stmt->execute();
		$numRow = $stmt->rowCount();
	}
	if($numRow > 0){
		while($stmt->fetch()){
			user_template('user_full_name',$id,$username,$fullname);
		}
	}else{
		if(!empty($searchtext)){
			?>
			<center>
				<br>
				<div class='j-bolder'>No results found</div>
				<div class='j-text-color5'>Try again with different spelling</div>
			</center>
			<?php
		}else{
			?>
			<center>
				<br>
				<div class='j-bolder'>Search for an account</div>
				<div class='j-text-color5'>Type the username or name of account you want to find</div>
			</center>
			<?php
		}
	}
}// end of if isset
?>
<br><br><br><br>