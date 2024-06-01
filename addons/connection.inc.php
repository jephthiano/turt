<?php
// connection function
function dbconnect($userType, $connectionType){
	if(strstr(file_location('home_url',''),'000webhostapp')){
		#FOR 000WEBHOST
		$username = 'id21093744_all_act';
		$password = 'TURTappsm332$';
		$db = 'id21093744_turt_db';
		$server = 'live';
	}else{
		#FOR LOCAL HOST
		$username = 'root';
		$password = 'jephthahJEHOVAHgod332$';
		$db = 'turtapp_db';
		
		//DEFINING USER ACCCESS
		//if ($userType === "userselect"){// SELECT only for read connection only
		//	$username = 'userselect';
		//	$password = 'our333userselect';
		//}elseif($userType === "userinsert"){// INSERT for and write connection only
		//	$username = 'userinsert';
		//	$password = 'our333userinsert';
		//}elseif($userType === "userupdate"){// UPDATE for and write connection only
		//	$username = 'userupdate';
		//	$password = 'our333userupdate';
		//}elseif($userType === "userdelete"){// DELETE for and delete connection only
		//	$username = 'userdelete';
		//	$password = 'our333userdelete';
		//}elseif($userType === "userdeleteinsert"){// DELETE for and delete connection only
		//	$username = 'root';
		//	$password = 'jephthahJEHOVAHgod332$';
		//}elseif($userType === "admincreateandalluser"){// DELETE for and delete connection only
		//	$username = 'root';
		//	$password = 'jephthahJEHOVAHgod332$';
		//}elseif($userType === "admin"){// ALL GRANT PRIVILEDGES for admin connection only
		//	$username = 'root';
		//	$password = 'jephthahJEHOVAHgod332$';
		//}else{// run this if no connection is specified
		//	exit('Error occurred while connecting to site');
		//}
	}
	//CREATE DATABASE
	@$pre_conn = new mysqli('localhost',$username,$password);
	$sql = "CREATE DATABASE IF NOT EXISTS {$db}";
	@$pre_conn->query($sql);
	// DEFINING CONNECTION TYPE
	if($connectionType === 'PDO'){ // for pdo
		try{
			return new PDO ("mysql:host=localhost; dbname=$db; charset=utf8", $username, $password);
			// set the PDO error mode to excepption
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			echo 'connected successfully';
		}catch(PDOException $e){
			echo 'connection failed:'. $e->getMessage();
		}
	}	
}
?>