<?php
//DATE AND TIME FUNCTION STARTS
//show date starts
 function showdate($datetime,$type){
	$now = time()+(get_xml_data('time_correction'));
	$thedate = strtotime($datetime);
	$interval = $now-$thedate;
	if($interval < 60){ // if less than 60seconds return in second
		return $interval. " sec ago";
	}elseif($interval >= 60 AND $interval < (60*60)){ // if less than 60 min return in minute
		return floor($interval/60). " min ago";
	}elseif($interval >= (60*60) AND $interval < (60*60*24)){ // if less than 1day return in hours
		return floor($interval/(60*60)). " hr ago";
	}elseif($interval >= (60*60*24) AND $interval < (60*60*24*2)){ //if less than 2days return in day
		return floor($interval/(60*60*24)). " day ago";
	}elseif($interval >= (60*60*24*2) AND $interval < (60*60*24*7)){ //if less than 2days and less than 7 days return in days
		return floor($interval/(60*60*24)). " days ago";
	}elseif($interval >= (60*60*24*7) AND $interval < (60*60*24*14)){ //if greater than 7days  and less than 2 weeks return in week
		return floor($interval/(60*60*24*7)). " week ago";
	}elseif($interval >= (60*60*24*14) AND $interval < (60*60*24*30)){ //if greater than 2 weeks and less than 30days return in weeks
		return floor($interval/(60*60*24*7)). " weeks ago";
	}elseif($interval >= (60*60*24*30) AND $interval < (60*60*24*60)){ //if greater than 1month and less than 2months return in month
		return floor($interval/(60*60*24*30)). " month ago";
	}elseif($interval >= (60*60*24*60) AND $interval < (60*60*24*365)){ //if greater than 2months and less than one year return in months
		return floor($interval/(60*60*24*30)). " month ago";
	}elseif($type === "short"){ //return in full format for short
		return date('jS, M Y',$thedate);
	}else{ // else return in full format
		return date('g:i a - jS, M Y',$thedate);	
	}
 }
//show date ends

//show date interval starts
function show_date_interval($datetime,$type=''){
	$now = time()+(get_xml_data('time_correction'));
	$thedate = strtotime($datetime);
	$interval = $now-$thedate;
	if($interval < 60){ // if less than 60seconds return in second
		return $interval. "s";
	}elseif($interval >= 60 AND $interval < (60*60)){ // if less than 60 min return in minute
		return floor($interval/60). "m";
	}elseif($interval >= (60*60) AND $interval < (60*60*24)){ // if less than 1day return in hours
		return floor($interval/(60*60)). "h";
	}elseif($interval >= (60*60*24) AND $interval < (60*60*24*7)){ //if less than HOURS and less than 7 days return in days
		return floor($interval/(60*60*24)). "d";
	}elseif($interval >= (60*60*24*7)){ //if greater than 7days 
		return floor($interval/(60*60*24*7)). "w";
	}
 }
//show date interval ends

// message date starts
function message_date($datetime,$type){
		$today = date("Y-m-d"); // today day,month and year
		$yesterday = date("Y-m-d",strtotime($today)-60*60*24); // yesterday day,month and year
		$thedate = date('Y-m-d',strtotime($datetime));
		if($today === $thedate){  // if same day return the time not days
			if($type === 'chat'){
				return "Today"; // ECHO TODAY
			}else{
				$thedate = strtotime($datetime);
				return date('g:ia',$thedate); // ECHO ONLY THE TIME
			}
		}elseif($yesterday === $thedate){  //if yesterday return yesterday
			return "Yesterday";
		}else{
			if($type === 'chat'){
				$thedate = strtotime($datetime);
				return date('F d, Y',$thedate);	
			}else{
				$thedate = strtotime($datetime);
				return date('j/n/y',$thedate);	
			}
		}
}	
// message date ends
	
//show date starts
function show_date($date,$type = 'date'){ //for only date
 if($type === 'year'){
  $year = new DateTime($date.'-01');
  return $year->format('Y');
 }elseif($type === 'month'){
  $month = new DateTime($date);
  return $month->format('F Y');
 }else{
  $now = time()+(get_xml_data('time_correction'));
  $today = date("Y-m-d",$now); // today day,month and year
  $yesterday = date("Y-m-d",strtotime($today)-60*60*24); // yesterday day,month and year
  $thedate = date('Y-m-d',strtotime($date));
  if($today === $thedate){  // if same day return the time not days
    return "Today"; // ECHO TODAY
  }elseif($yesterday === $thedate){  //if yesterday return yesterday
    return "Yesterday";
  }else{
    $thedate = strtotime($date);
    return date('M d, Y',$thedate);
  }
 }//end of else
}
//show date ends

//show time starts
function show_time($time){ // for time
 $time = new DateTime($time);
 return $time->format('g:ia');
}
//show time ends

//function process day starts
function process_day($type = 'current',$date = ''){
	if($type === 'current'){
		return date("Y-m-d");
	}elseif($type === 'next'){
		$thedate = new DateTime($date);
  $interval = new DateInterval('P1D');
  $next = $thedate->add($interval);
		return $next->format('Y-m-d');
	}elseif($type === 'previous'){
		$thedate = new DateTime($date);
  $interval = new DateInterval('P1D');
  $prev = $thedate->sub($interval);
		return $prev->format('Y-m-d');
		return date('Y-m-d',$thedate);	
	}
}
//function process day ends

//process month starts
function process_month($type = 'current',$month = ''){
	if($type === 'current'){
		return date("Y-m");
	}elseif($type === 'next'){
  $thedate = new DateTime($month);
  $interval = new DateInterval('P1M');
  $next = $thedate->add($interval);
		return $next->format('Y-m');
	}elseif($type === 'previous'){
		$thedate = new DateTime($month);
  $interval = new DateInterval('P1M');
  $prev = $thedate->sub($interval);
		return $prev->format('Y-m');
	}
}
//process month ends

//process year starts
function process_year($type = 'current',$year = ''){
	if($type === 'current'){
		return date("Y");
	}elseif($type === 'next'){
  $year = $year.'-01';
  $thedate = new DateTime($year);
  $interval = new DateInterval('P1Y');
  $next = $thedate->add($interval);
		return $next->format('Y');
	}elseif($type === 'previous'){
  $year = $year.'-01';
		$thedate = new DateTime($year);
  $interval = new DateInterval('P1Y');
  $prev = $thedate->sub($interval);
		return $prev->format('Y');
	}
}
//process year ends

//check time validity starts
function time_validity($duration,$starttime='',$endtime=''){
 if(empty($endtime)){
  $end_time = time()+(get_xml_data('time_correction'));
 }else{
  $end_time = strtotime($endtime);
 }
 $total_time = strtotime($starttime)+$duration;
 if($total_time < $end_time){ // if total_time has expired
  return true;
 }else{
  return false;
 }
}
//check time validity starts
// DATE AND TIME FUNCTION ENDS
?>