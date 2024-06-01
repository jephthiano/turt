<?php
//OTHER FUNCTION STARTS
//get noti starts
function get_noti($type){
 global $uid;
 if($type === 'noti'){
			$type_array = multiple_content_data('notification_table','n_type',$uid,'receiver_id',"AND n_status = 'sent'",'unique');
			if($type_array !== false){
				$counter = count($type_array);if($counter > 8){$counter = 9;}
				?><span class='j-circle j-color1 j-small'style="padding:2px 6px;"><?=$counter?></span><?php
			}
		}
		if($type === 'mess'){
   $num_array = multiple_content_data('message_table','sender_id',$uid,'receiver_id',"AND m_status NOT IN('awared','seen')",'unique');
   if($num_array !== false){
				$counter = count($num_array);if($counter > 8){$counter = 9;}
				?><span class='j-circle j-color1 j-small'style="padding:2px 6px;"><?=$counter?></span><?php
			}
   //change all sent message to delivered
   $mess = new message('update');
   $mess->update_status('deliver');
		}
		if($type === 'feed'){
			?><i class="<?= icon('circle');?>"></i><?php
		}
}
//get noti ends

//get report data starts
function get_report_data($type,$id){
 if($type === 'user'){
  ?>
  <div class="">
   <b>What issue with @<?= content_data('user_table','u_username',$id,'u_id');?> are you reporting?</b>
  </div><hr>
  <div style="line-height:27px;">
   <?php
   $data = ["Fake account/name","Hacked account","Pretending to be me or someone else","Harassing or bullying others","Posting inappropiate things",
            "Image or Profile info include harmful content","Under the age of 16"];
   foreach($data AS $datum){
    ?>
    <div class="j-clickable"style='margin-top:10px;margin-bottom:10px;'onclick="$('#report_<?=$type?>_modal<?= $id;?>').fadeOut('slow');rpc('<?= $type;?>',<?= addnum($id);?>,'<?=$datum?>');">
      <?=$datum?>
    </div>
    <?php
   }
   ?>
  </div>
  <?php
 }else{
  ?>
  <div class="">
   <b>Why are you reporting this <?=$type?>?</b>
  </div><hr>
  <div style="line-height:27px;">
   <?php
   $data = ["It\'s spam","Hate speech or terrorism","I don\'t just like it","Nudity or sexual content","Violence or dangerous content","False information","Bullying or harrassment",
            "Scam or fraud","Intellectual property violation","Suicide of self-injury","Sale of illegal goods"];
   foreach($data AS $datum){
    ?>
    <div class="j-clickable"style='margin-top:10px;margin-bottom:10px;'onclick="$('#report_<?=$type?>_modal<?= $id;?>').fadeOut('slow');rpc('<?= $type;?>',<?= addnum($id);?>,'<?=$datum?>');">
      <?=$datum?>
    </div>
    <?php
   }
   ?>
  </div>
  <?php
 }
}
//get report data ends
//OTHER FUNCTION ENDS
?>