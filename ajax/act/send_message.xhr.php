<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $missing = []; $data = [];
	
	//validating and sanitising chatter
	$chat = test_input(removenum($_POST['chtd']));
	if(empty($chat)){$missing[] = "chat";}else{$chatter_id = test_input($chat);}
	
	//validating and sanitising message
	$mess = ($_POST['schat']); $messag = test_input($mess);
	
	if(empty($error) and empty($missing)){
		//FORM IMAGE UPLOAD
		$location = 'message';$size = 5000000;$file_mode = ["image/gif","image/png","image/jpeg"];$file_type = 'image';$input_name = 'img';$file_name = "TURT_mess_".time_token();
		$sizeInMb = '5mb';$ret_message = "File must be jpg, gif or png and must not exceed {$sizeInMb}";$file_correct_ext = [1,2,3];
		require_once(file_location('inc_path','image_upload.inc.php'));
		if(empty($missing) && empty($error)){
			if($file2 === "larger"){ // if file is larger tha expected echo error
				$data["status"] = 'fail';$data["message"] = '>Image is larger than expected';
			}elseif(($file2 === "normal") || ($file2 === "no file" && !empty($messag))){
				if($file2 === "no file"){$text = 'text';}else{$text = 'image';}
				$message = new message('insert');
				$message->message = ssl_encrypt_message($messag);
				$message->type = $text;
				$message->chatter_id = $chatter_id;
				if($file2 === "normal"){$message->file_name = $correct['filename'];$message->extension = $correct['extension'];}
				$send = $message->send_message();
				if($send === 'success'){
					$data["status"] = 'success';$data["message"] = addnum($chatter_id); // chatter_id to be used in gettingthe chat data at ajax done
				}else{
					$data["status"] = 'fail';$data["message"] = 'Error occurred while sending message';
				}
			}else{
				$data["status"] = 'fail';$data["message"] = '>Error occurred while sending message';
			}// end of else if $file = "" // end of else if $file = ""
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $missing;
	}
	echo json_encode($data);
}//end of if isset
?>