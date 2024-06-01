<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
if(isset($_POST['t'])){
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $missing = []; $data = [];
	
	//validating and sanitising content type
	$ty = ($_POST['t']);
	if($ty !== 'cover_pics' && $ty !== 'profile_pics'){$missing[] = "t";}else{$type = test_input($ty);}
	
	if(empty($error) and empty($missing)){
		//FORM IMAGE UPLOAD
		$location = $type;$size = 8000000;$file_mode = ["image/png","image/jpeg"];$file_type = 'image';$input_name = "{$type}_pics";$file_name = "TURT_{$type}_".time_token();
		$sizeInMb = '8mb';$ret_message = "File must be jpg or png and must not exceed {$sizeInMb}"; $file_correct_ext = [2,3];
		require_once(file_location('inc_path','image_upload.inc.php'));
		if(empty($missing) && empty($error)){
			if($file2 === "larger"){ // if file is larger tha expected echo error
				$data["status"] = 'fail';$data["message"] = '>Picture is larger than expected';
			}elseif($file2 === 'no file'){
				$data["status"] = 'fail';$data["message"] = '>No picture uploaded';
			}elseif($file2 === 'normal' && empty($error)){
				if($type === 'profile_pics'){
					$user = new user('insert_update');
					$user->file_name = $correct['filename'];
					$user->extension = $correct['extension'];
					$change = $user->change_image($type);
				}elseif($type === 'cover_pics'){
					$user = new user('user');
					$user->file_name = $correct['filename'];
					$user->extension = $correct['extension'];
					$change = $user->change_image($type);
				}else{
					$missing[] = 'missing';
				}
				if($change === "success" && empty($missing)){
					$data["status"] = 'success';$data["message"] = "Pics successfully updated";
				}else{// else if not updated
					$data["status"] = 'fail';$data["message"] = "Error occurred while updating pics";
				}// end of else if not updated
			}else{
				$data["status"] = 'fail';$data["message"] = "Error occurred while updating pics";
			}
		}
	}
	echo json_encode($data);
}
?>