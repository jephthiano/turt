<?php
if(isset($_GET['type']) && isset($_GET['id']) && isset($_GET['report'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = [];
	//validating type
	$type = $_GET['type'];
	if($type !== 'user' && $type !== 'turt' && $type !== 'comment' && $type !== 'reply'){$error = 'no type';}
	
	//validating content id
	$id = removenum(test_input($_GET['id']));
	if(empty($id)){
		$error = "empty";
	}else{
		$content_id = test_input($id);
		if($type === 'user'){
			$reportee_id = $content_id;
		}else{
			$error = "empty";
		}
	}
	
	//validating report
	$rep = test_input($_GET['report']);
	if(empty($rep)){
		$error = "empty";
	}else{
		$report_data = test_input($rep);
	}
    if(empty($error)){
		$report = new report('insert');
		$report->type = $type;
		$report->content_id = $content_id;
		$report->report = $report_data;
		$report->reportee_id = $reportee_id;
		$insert = $report->Insert_report();
		if($insert === 'success'){
			$data["status"] = 'success';$data["message"] = "Report successfully sent";
		}else{
			$data["status"] = 'fail';$data["message"] = "Error occurred while sending report";
		}
    }else{
		$data["status"] = 'fail';$data["message"] = "Error occurred while sending report";
	}
	
}else{
	$data["status"] = 'fail';$data["message"] = "Error occurred while sending report";
}
echo json_encode($data);
?>