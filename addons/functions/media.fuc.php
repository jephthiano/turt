<?php
//MEDIA STARTS
//get media starts
function get_media($type,$id='',$media='no_media'){
 require_once(file_location('inc_path','connection.inc.php'));
 @$conn = dbconnect('admin','PDO');
	if($type === 'admin'){
  $sql = "SELECT am_link_name,am_extension FROM admin_media_table WHERE ad_id = :id LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('am_link_name',$link_name);
  $stmt->bindColumn('am_extension',$extension);
 }elseif($type === 'profile_pics'){
  $sql = "SELECT um_profilepics_link_name,um_profilepics_extension FROM user_media_table WHERE u_id = :id LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('um_profilepics_link_name',$link_name);
  $stmt->bindColumn('um_profilepics_extension',$extension);
 }elseif($type === 'cover_pics'){
  $sql = "SELECT um_coverpics_link_name,um_coverpics_extension FROM user_media_table WHERE u_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('um_coverpics_link_name',$link_name);
  $stmt->bindColumn('um_coverpics_extension',$extension);
 }elseif($type === 'turt'){
  $sql = "SELECT tm_link_name,tm_extension FROM turt_media_table WHERE t_id = :id LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('tm_link_name',$link_name);
  $stmt->bindColumn('tm_extension',$extension);
 }elseif($type === 'comment'){
  $sql = "SELECT cm_link_name,cm_extension FROM comment_media_table WHERE c_id = :id LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('cm_link_name',$link_name);
  $stmt->bindColumn('cm_extension',$extension);
 }elseif($type === 'reply'){
  $sql = "SELECT rm_link_name,rm_extension FROM reply_media_table WHERE r_id = :id LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('rm_link_name',$link_name);
  $stmt->bindColumn('rm_extension',$extension);
 }elseif($type === 'message'){
  $sql = "SELECT mm_link_name,mm_extension FROM message_media_table WHERE m_id = :id LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('mm_link_name',$link_name);
  $stmt->bindColumn('mm_extension',$extension);
 }else{
  return 'home/no_media.png';
 }
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){
		while($stmt->fetch()){
   $file = $type.'/'.$link_name.".".$extension;
   if(file_exists(file_location('media_path',$file)) && is_file(file_location('media_path',$file))){
    return $file;
   }else{
     if($type === 'admin' || $media === 'human' || $type === 'profile_pics'){
      return 'home/avatar.png';
     }elseif($type === 'cover_pics'){
      return 'home/cover.jpg';
     }else{
      return 'home/no_media.png';
     }
   }
		}
	}else{
  if($type === 'admin' || $media === 'human' || $type === 'profile_pics'){
      return 'home/avatar.png';
     }elseif($type === 'cover_pics'){
      return 'home/cover.jpg';
     }else{
      return 'home/no_media.png';
     }
	}
 closeconnect("stmt",$stmt);closeconnect("db",$conn);
}
//get media ends

// get media type starts
function get_media_type($type,$id){
 if($type === 'message'){
  $media_type = content_data('message_media_table','mm_type',$id,'m_id');
 }else{
  $media_type = false;
 }
 return $media_type;
}
// get media type ends

// comment reply and message filetype starts
function comment_reply_message_filetype($type,$media_type,$file_name){
 if($type === 'message'){
  if($media_type === 'image'){?><img src="<?= file_location('media_url',$file_name)?>"style='max-width:70%;;hieght:auto'><?php }
 }
}
// comment reply and message filetype ends




//show turt media starts
function show_turt_media($id){
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('userselect','PDO');
	$sql = "SELECT fm_id,fm_link_name,fm_content_type,fm_extension,f_id
									FROM turt_media_table
									WHERE f_id = :id
									ORDER BY fm_id ASC";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':id',$id,PDO::PARAM_INT);
	$stmt->bindColumn('fm_id',$fm_id);
	$stmt->bindColumn('fm_link_name',$fm_link_name);
	$stmt->bindColumn('fm_content_type',$fm_content_type);
	$stmt->bindColumn('fm_extension',$fm_extension);
	$stmt->bindColumn('f_id',$f_id);
	$stmt->execute();
	$numRow = $stmt->rowCount();
 if($numRow === 0){
  return false;
 }elseif($numRow === 1){
		while($stmt->fetch()){
   if($fm_content_type === 'video'){
    ?>
    <center>
     <div style="height:auto;width:100%" class="">
      <?php check_if_image_or_video("full_details",$fm_content_type,$fm_link_name,$fm_extension,"auto","100%");?> <br>
    </div>
    </center>
    <?php
   }elseif($fm_content_type === 'image'){
    ?>
    <center>
     <a href="<?= file_location('home_url','media/turt/'.addnum($id));?>">
     <div style="height:auto;width:100%" class="">
      <?php check_if_image_or_video("full_details",$fm_content_type,$fm_link_name,$fm_extension,"auto","100%");?><br>
     </div>
     </a>
    </center>
    <?php
   }
		}// end of while for if ($numRow === 1)
	}elseif($numRow === 2){
		?>
  <a href="<?= file_location('home_url','media/turt/'.addnum($id));?>">
		<div style="max-height:400px;width:100%"class="j-row">
			<?php
			while($stmt->fetch()){
				?>
				<div class="j-col s6"style="padding: 2px;">
					<?php check_if_image_or_video("short_details",$fm_content_type,$fm_link_name,$fm_extension,"400px","100%");?>
				</div>
    <?php
			}// end of while for if ($numRow === 2)
			?>
		</div>
  </a>
		<?php
	}elseif($numRow === 3){
		?>
  <a href="<?= file_location('home_url','media/turt/'.addnum($id));?>">
		<div style="max-height:400px;width:100%" class="j-row">
			<?php
			// select only first media
				$sql = "SELECT fm_id,fm_link_name,fm_content_type,fm_extension,f_id
											FROM turt_media_table
											WHERE f_id = :id
											ORDER BY fm_id ASC LIMIT 1";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':id',$id,PDO::PARAM_INT);
				$stmt->bindColumn('fm_id',$fm_id);
				$stmt->bindColumn('fm_link_name',$fm_link_name);
				$stmt->bindColumn('fm_content_type',$fm_content_type);
				$stmt->bindColumn('fm_extension',$fm_extension);
				$stmt->bindColumn('f_id',$f_id);
				$stmt->execute();
				$numRow2 = $stmt->rowCount();
				if($numRow2 === 1){
					?>
					<div class="j-col s6"style="padding: 2px;">
						<?php while($stmt->fetch()){ check_if_image_or_video("short_details",$fm_content_type,$fm_link_name,$fm_extension,"400px","100%");} ?>
					</div>
					<?php
				}
				?>
				<?php
    // select only last two media
				$sql = "SELECT fm_id,fm_link_name,fm_content_type,fm_extension,f_id
											FROM turt_media_table
											WHERE f_id = :id
											ORDER BY fm_id DESC LIMIT 2";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':id',$id,PDO::PARAM_INT);
				$stmt->bindColumn('fm_id',$fm_id);
				$stmt->bindColumn('fm_link_name',$fm_link_name);
				$stmt->bindColumn('fm_content_type',$fm_content_type);
				$stmt->bindColumn('fm_extension',$fm_extension);
				$stmt->bindColumn('f_id',$f_id);
				$stmt->execute();
				$numRow2 = $stmt->rowCount();
				if($numRow2 === 2){
						while($stmt->fetch()){
							?>
       <div class="j-col s6"style="padding: 2px;">
        <?php check_if_image_or_video("short_details",$fm_content_type,$fm_link_name,$fm_extension,"200px","100%");?>
        </div>
       <?php
      }// end of while for if ($numRow === 2)
				}
				?>
		</div>
  </a>
		<?php
	}elseif($numRow === 4){
		?>
  <a href="<?= file_location('home_url','media/turt/'.addnum($id));?>">
		<div style="max-height:400px;width:100%" class="j-row">
			<?php
			while($stmt->fetch()){
				?>
				<div class="j-col s6"style="padding:2px;height:200px;">
					<?php check_if_image_or_video("short_details",$fm_content_type,$fm_link_name,$fm_extension,"200px","100%");?>
				</div>
				<?php
			}// end of while for if ($numRow === 4)
			?>
		</div>
  </a>
		<?php
	}elseif($numRow > 4){
  $remaining = $numRow - 4;
		// select only first four
		$sql = "SELECT fm_id,fm_link_name,fm_content_type,fm_extension,f_id
									FROM turt_media_table
									WHERE f_id = :id
									ORDER BY fm_id ASC LIMIT 4";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id',$id,PDO::PARAM_INT);
		$stmt->bindColumn('fm_id',$fm_id);
		$stmt->bindColumn('fm_link_name',$fm_link_name);
		$stmt->bindColumn('fm_content_type',$fm_content_type);
		$stmt->bindColumn('fm_extension',$fm_extension);
		$stmt->bindColumn('f_id',$f_id);
		$stmt->execute();
		$numRow2 = $stmt->rowCount();
		if($numRow2 === 4){
			?>
   <a href="<?= file_location('home_url','media/turt/'.addnum($id));?>"style='z-index:1'>
			<div style="max-height:400px;width:100%;position:relative;z-index:0;"class="j-row">
				<?php
				while($stmt->fetch()){
					?>
					<div class="j-col s6"style="padding:2px;height:200px;">
						<?php check_if_image_or_video("short_details",$fm_content_type,$fm_link_name,$fm_extension,"200px","100%");?>
						</div>
					<?php
				}// end of while for if ($numRow === 2)
					?>
					<span class="j-text-color4 j-xxxlarge"style="position:absolute;bottom:15%;left:70%;"><?= "+".$remaining?></span>
			</div>
   </a>
			<?php
		}
	}// end of if else
closeconnect("stmt",$stmt);
closeconnect("db",$conn);
}
//show turt media ends

// check if image or video starts
function check_if_image_or_video($type,$media_type,$media_link_name,$extension,$height,$width){
	if($media_type === "image"){
		$file_path = file_location('media_path','turt_image/'.$media_link_name.'.'.$extension);
	}elseif($media_type === 'video'){
		$file_path = file_location('media_path','turt_video/'.$media_link_name.'.'.$extension);
	}
	if(file_exists($file_path)){
		if($media_type === "image"){
   ?>
			<img class="j-center" src="<?= file_location('media_url','turt_image/'.$media_link_name.'.'.$extension);?>"style="width:<?= $width;?>;height:<?= $height;?>;">
			<?php
		}elseif($media_type === "video"){
			?>
			<video <?php if($type === "full_details"){echo "controls";}?> style="width:<?= $width;?>;height:<?= $height;?>;">
				<source src="<?= file_location('media_url','turt_video/'.$media_link_name.'.'.$extension);?>"type="video/<?= $extension;?>">Video not supported by your browser
			</video>
			<?php
		}
	}else{ //if the file does not exists
		if($media_type === "image"){
			?>
			<img class="j-center j-round-large" src="<?= file_location('media_url','turt_image/available_not_image.jpg');?>"style="width:<?= $width;?>;height:<?= $height;?>;">
			<?php
		}else{
			?>
			<img class="j-center j-round-large" src="<?= file_location('media url','turt_video/available_not_video.jpg');?>"style="width:<?= $width;?>;height:<?= $height;?>;">
			<?php
		}
	}
}
// check if image or video ends
//MEDIA ENDS
?>