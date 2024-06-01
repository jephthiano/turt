<?php
//MESSAGE FUNCTION STARTS
//get all inbox starts
function get_all_inbox($type = 'full'){
	global $uid;
 $chatter_array = [];
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
 $sql2 = "SELECT receiver_id, sender_id FROM message_table WHERE :active_user IN (sender_id,receiver_id) ORDER BY m_regdatetime DESC";
 $stmt = $conn->prepare($sql2);
 $stmt->bindParam(':active_user',$uid,PDO::PARAM_INT);
 $stmt->bindColumn('receiver_id',$receiver);
 $stmt->bindColumn('sender_id',$sender);
 $stmt->execute();
 $numRow = $stmt->rowCount();
 if($numRow < 1){
		?><div class='j-center j-margin'>You have no message</div><?php
	}else{
  while($stmt->fetch()){$chatter_array [] = $sender;$chatter_array [] = $receiver;}
  $chatter_array = array_unique($chatter_array);
  foreach($chatter_array AS $chatter_id){
   if($chatter_id !== $uid){
				$sql2 = "SELECT m_message,receiver_id,sender_id,m_status,m_regdatetime FROM message_table
				WHERE :id IN (receiver_id,sender_id) AND :uid IN (receiver_id,sender_id)
				ORDER BY m_id DESC LIMIT 1";
				$stmt = $conn->prepare($sql2);
				$stmt->bindParam(':id',$chatter_id,PDO::PARAM_INT);
				$stmt->bindParam(':uid',$uid,PDO::PARAM_INT);
				$stmt->bindColumn('m_message',$message);
				$stmt->bindColumn('receiver_id',$receiver);
				$stmt->bindColumn('sender_id',$sender);
				$stmt->bindColumn('m_status',$status);
				$stmt->bindColumn('m_regdatetime',$date);
				$stmt->execute();
				$numRow = $stmt->rowCount();
				if($numRow > 0){
					while($stmt->fetch()){
						$message = ssl_decrypt_message($message);
						$chatter_name = content_data('user_table','u_fullname',$chatter_id,'u_id');
						?>
						<a href="<?= file_location('home_url','m/messages/'.addnum($chatter_id));?>">
						<div class="j-row j-container j-border-bottom j-border-color6" style="padding: 15px 5px;">
							<div class="j-col s2 m1">
								<center>
									<span style="position:relative;">
										<img src="<?= file_location('media_url',get_media('profile_pics',$chatter_id));?>" class="j-circle j-border-2 j-color5"style="height:50px;width:50px">
										<?php if(is_online($chatter_id)){?><i class="<?= icon('circle');?> j-text-color9 "style="position:absolute;top:20px;right:2px;"></i><?php }?>
									</span>
								</center>
							</div>
							<div class="j-col s10 m11 j-container">
								<b><?= ucwords($chatter_name); ?></b>
								<span class="j-text-color1 j-right j-small"><?=message_date($date,''); ?></span><br>
								<span class="j-text-color5"> <?= text_length($message,50,'');?></span>
								<span class="j-right j-small">
								<?php // for message counter or m_status
								if($uid === $sender){
									if($status === 'sent'){
										?><i class='<?= icon('check');?> j-text-color5'></i><?php
									}elseif($status === 'delivered' || $status === 'awared'){
										?><span class='j-text-color5'><i class='<?= icon('check');?>'></i><i class='<?= icon('check');?>'style='position:relative;left:-8px'></i></span><?php
									}elseif($status === 'seen'){
										?><span class='j-text-color1'><i class='<?= icon('check');?>'></i><i class='<?= icon('check');?>'style='position:relative;left:-8px'></i></span><?php
									}else{
										?><i>sending...</i><?php
									}
								}elseif($uid === $receiver){
									$counter = get_indmessage_numrow($uid,$chatter_id);
									if($counter > 0){?><span class="j-color1 j-circle"style="padding:5px 8px;"><?=$counter;?></span><?php }
								}
								?>
								</span>
							</div>
						</div>
						</a>
					<?php
					}
				}
   }//if $uid is not equal $chatter_id
  }//for each end
	}
	//change all sent and delivered message to to awared
	$mess = new message('update');
	$mess->update_status('awared');
}
//get all inbox starts

// get individual unseen message numrow starts
function get_indmessage_numrow($receiver,$sender){
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
	$sql2 = "SELECT	m_id	FROM message_table	WHERE receiver_id = :receiver AND sender_id = :sender AND m_status != 'seen' ";
	$stmt = $conn->prepare($sql2);
	$stmt->bindParam(':receiver',$receiver,PDO::PARAM_INT);
	$stmt->bindParam(':sender',$sender,PDO::PARAM_INT);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){return $numRow;}
	closeconnect("stmt",$stmt);closeconnect("db",$conn);
}
// get individual unseen message numrow ends

//chat data starts
function chat_data($chatter_id){
	global $uid;
	$add = "WHERE user_table.u_id = message_table.sender_id AND (receiver_id = $chatter_id OR sender_id = $chatter_id) AND (receiver_id = $uid OR sender_id = $uid)";
	$date_array = multiple_content_data('message_table,user_table','m_regdate','','',$add,'unique');
	if($date_array === false){
		?><center><span class="j-color1 j-tiny j-button j-round-large"><?= date('F d, Y');?></span></center><?php
	}else{
		foreach($date_array AS $date){
			?>
			<center><div class="j-color1 j-tiny j-button j-round-large j-clearfix" style="margin-bottom:15px;clear:both;"><?=message_date($date,"chat");?></div></center>
			<?php
			//select the messages based on the date
			require_once(file_location('inc_path','connection.inc.php'));@$conn = dbconnect('select','PDO');
			$sql = "SELECT m_id,m_message,m_type,m_status,m_regdatetime,sender_id,receiver_id
			FROM message_table
			WHERE (receiver_id = :chatter_id OR sender_id = :chatter_id) AND (receiver_id = :uid OR sender_id = :uid)
			AND m_regdate = :date";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':chatter_id',$chatter_id,PDO::PARAM_INT);
			$stmt->bindParam(':uid',$uid,PDO::PARAM_INT);
			$stmt->bindParam(':date',$date,PDO::PARAM_STR);
			$stmt->bindColumn('m_id',$id);
			$stmt->bindColumn('m_message',$message);
			$stmt->bindColumn('m_type',$type);
			$stmt->bindColumn('m_status',$status);
			$stmt->bindColumn('m_regdatetime',$regdatetime);
			$stmt->bindColumn('sender_id',$sender_id);
			$stmt->bindColumn('receiver_id',$receiver_id);
			$stmt->execute();
			$numRow = $stmt->rowCount();
			if($numRow > 0){
				while($stmt->fetch()){
					$message = ssl_decrypt_message($message);
					if($uid !== $sender_id){ //for other chatter
						?>
						<div class="j-clearfix j-wrap j-color1 j-text-color3 j-round-large" style="margin-bottom:15px;max-width:70%;padding:8px;">
							<?php
							if($type === 'text'){
								?><span style="padding-right:5px;"><?= convert_2_br(($message));?></span><?php
							}else{
									if(!empty($message)){?><span style="padding-right:5px;"><?= convert_2_br(($message));?></span><br><?php }
									if(get_media('message',$id) !== 'home/no_media.png'){
										?>
										<a href="<?= file_location('home_url','media/message/'.addnum($id))?>"class='j-clickable'><span style='max-width:70%;'><?php comment_reply_message_media('message',$id);?></span><br></a>
										<?php
										}
							}
							?>
							<span class="j-small j-text-color7 j-right j-clearfix" style="position:relative;bottom:-10px;padding-left:5px"><?= show_time($regdatetime)?></span>
						</div>
						<?php
					}else{//for current user
						?>
						<div class="j-right j-clearfix j-wrap j-color5 j-text-color3 j-round-large" style="margin-bottom:15px;max-width:70%;padding:8px;">
							<?php
							if($type === 'text'){
								?><span><?= convert_2_br(($message));?></span><?php
							}else{
								$media = get_media('message',$id); $type = get_media_type('message',$id);
									if($media !== 'home/no_media.png'){
										?>
										<a href="<?= file_location('home_url','media/message/'.addnum($id).'/')?>"class='j-clickable'>
											<span style='max-width:70%;'><?php comment_reply_message_filetype('message',$type,$media)?></span><br>
										</a>
										<?php
										if(!empty($message)){?><span><?= convert_2_br(($message));?></span><br><?php }
									}
							}
							?>
							<span class="j-small j-text-color7 j-right j-clearfix" style="position:relative;bottom:-5px;padding-left:5px;">
								<?= show_time($regdatetime)?>
								<?php
								if($status === 'sent'){
									?><i class='<?= icon('check');?>'></i><?php
								}elseif($status === 'delivered' || $status === 'awared'){
									?><span class='j-text-color5'><i class='<?= icon('check');?>'></i><i class='<?= icon('check');?>'style='position:relative;left:-8px'></i></span><?php
								}elseif($status === 'seen'){
									?><span class='j-text-color1'><i class='<?= icon('check');?>'></i><i class='<?= icon('check');?>'style='position:relative;left:-8px'></i></span><?php
								}else{
									?><i>sending...</i><?php
								}
								?>
							</span>
						</div>
						<?php
					} //end of if current user is the sender
				}//end of while
			} // end of numrow > 0
		}// end of for each loop of date
		//change all sent, delivered and awared message to seen (chatter_id shpold be other user not current user)
		$mess = new message('update');
		$mess->chatter_id = $chatter_id;
		$mess->update_status('seen');
	}// end of if data_array is not false
}
//chat data ends

//message input starts
function message_input($id){
 ?>
 <div id='mIp'class="j-fixed-message j-color4"style="z-index:2;padding:0px 5px;">
		<div id='container'class='j-display-container'style='width:100px;height:100px;display:none;margin-bottom:5px;'>
			<div id='prw'style='width:inherit;height:inherit;'></div>
			<span class='j-display-topright j-button j-text-color4 j-circle j-color6 j-large'style='padding:0px 8px'onclick="ri($('#img'),$('#container'),'comes')">x</span>
		</div>
			<span id='imgtri'onclick='ti($("#img"))'class='j-xlarge j-text-color1 j-clickable'style="width:10%;height:40px;position:relative;top:-12px"><i class="<?= icon('image');?>"></i></span>
			<form id='msfrm'method='post'style="display:inline">
				<input type="file"name="img"id="img"class="j-round j-hide"onchange="pi(this,document.getElementById('prw'),'mess');ssend($('#schat').val(),this.value);">
				<input type='hidden'id='chtd'name='chtd'value="<?=addnum($id)?>"/>
				<textarea class="j-round j-border-color6 j-color4"id="schat"name='schat'placeholder="Type a message..."style="width:90%;height:40px;
					outline:none;"onkeyup="ssend(this.value,$('#img').val());"oninput="itah(this,80);"></textarea>
				<button type='submit'id="send"class="j-round j-color1 j-button j-circle"style="display:none;position:relative;top:-15px">Send</button>
			</form>
	</div>

<?php
}
//message input ends
//MESSAGE FUNCTION ENDS
?>