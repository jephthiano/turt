<?php
//NOTIFICATION FUNCTION STARTS
//get notfication index starts
function get_notification_index($type){
 global $uid;
 if($type == 'follow'){
  $sender_id_array = multiple_content_data('notification_table','sender_id',$uid,'receiver_id',"AND n_type = '{$type}' ORDER BY n_id DESC",'unique');
  $status_id_array = multiple_content_data('notification_table','n_status',$uid,'receiver_id',"AND n_type = '{$type}' ORDER BY n_id DESC",'unique');
  $total = count($sender_id_array);
  $sender_name = ''; // array to store username
  $image_id = content_data('user_table','u_id',$sender_id_array[0],'u_id');//last sender id
  if($total <= 2){//for 1 and 2 sender
   for($i = 0;$i<$total;$i++){
    if($total === 1){ //if sender in follow category is 1
     $sender_name .= content_data('user_table','u_fullname',$sender_id_array[$i],'u_id');
    }
    if($total === 2){ // put and infront of the second sender
     if($i === 1){$sender_name .= ' and '.content_data('user_table','u_fullname',$sender_id_array[$i],'u_id');}else{$sender_name .= content_data('user_table','u_fullname',$sender_id_array[$i],'u_id');}
    }
   }	
		}elseif($total > 2){ //for more than 2
   for($i = 0;$i<2;$i++){ // put, infront of the second sender and and others at the back
     if($i === 1){$sender_name .= ', '.content_data('user_table','u_fullname',$sender_id_array[$i],'u_id').' and others ';}else{$sender_name .= content_data('user_table','u_fullname',$sender_id_array[$i],'u_id');}
   }
  }
  if($total < 2){$link = file_location('home_url',content_data('user_table','u_username',$image_id,'u_id').'/');}else{$link = file_location('home_url','n/follow/');}
  ?>
  <a href="<?=$link?>"onclick="cnts('<?=$type?>')">
		<div class="j-row <?=in_array('sent',$status_id_array) || in_array('awared',$status_id_array)?"j-color1":"";?> j-border-bottom"style="border-bottom-color:gray;padding:15px 5px;">
			<div class="j-col s2 m1">
				<center><img src="<?=file_location('media_url',get_media('profile_pics',$image_id));?>" class="j-circle j-border-2 j-color5"style="height:35px;width:35px"></center>
			</div>
			<div class="j-col s10 m11 j-container">
				<span class="j-bolder"><?=($sender_name)?></span><span> followed you</span><br>
			</div>
		</div>
		</a>
   <?php
	}
}
//get notfication index ends
//NOTIFICATION FUNCTION ENDS
?>