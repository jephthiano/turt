<?php
//TURT FUNCTION STARTS

































//get turt starts
function get_turt($type,$sql,$id){
	global $uid;
	// create connection
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('userselect','PDO');
	$stmt = $conn->prepare($sql);
	if($id !== ""){$stmt->bindParam(':id',$id,PDO::PARAM_STR);}
	$stmt->bindColumn('f_id',$turt_id);
	$stmt->bindColumn('f_original_f_id',$turt_original_f_id);
	$stmt->bindColumn('f_turt',$turt_turt);
	$stmt->bindColumn('f_type',$turt_type);
	$stmt->bindColumn('f_mode',$turt_mode);
	$stmt->bindColumn('f_status',$turt_status);
	$stmt->bindColumn('f_regdatetime',$turt_regdatetime);
	$stmt->bindColumn('u_id',$poster_id);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){
					while($stmt->fetch()){
						if(check_block($poster_id,$uid) === false && check_block($uid,$poster_id) === false){
							?>
							<div class="j-lower-border j-border-color5"style="margin-top: 8px;border-bottom-width: 5px">
								<?php
								if($turt_mode === "original"){ //if the turt is original
									?>
									<div class=""style="padding: 9px">
										<div class="j-row">
											<span class="j-col s2 m2">
												<a href="<?= file_location('home_url',user_data('u_username',$poster_id));?>">
												<img class="j-circle j-image j-border-2 j-card-2 j-border-color5 j-image-size2"src="<?= file_location('media_url','profile_pics/'.get_user_image($poster_id));?>">
												</a>
											</span>
											<span class="j-col s10 m10">
												<a href="<?= file_location('home_url',user_data('u_username',$poster_id));?>"><span class="" style="padding-right: 5px"><b><?= ucwords(user_data('u_fullname',$poster_id));?></b></span></a>
            <a href="<?= file_location('home_url',user_data('u_username',$poster_id));?>"><span class="j-text-color1 ">@<?= user_data('u_username',$poster_id);?></span></a>
												<?php turt_skill_job_3dots('turt',$type,$turt_id); // 3 dots?>
            <a href="<?= file_location('home_url','f/t/'.addnum($turt_id));?>">
            <?php
            if(check_promote_post('turt',"fs_status",$turt_id) === 'active'){
             ?>
             <i class="j-text-color1 <?= icon('flag')?>"> </i><span class="j-text-color1"> Sponsored</span>
             <?php
            }else{
             ?>
             <span class="j-small j-text-color1"><?= showdate($turt_regdatetime,"short"); ?></span>
             <?php
            }
            ?>
												</a>
											</span>
										</div>
									</div>
									<?php
									if($turt_status === "suspended"){ // if the content has been suspended
										content_not_available();
									}else{ //if status is not suspended
										?>
										<a href="<?= file_location('home_url','f/t/'.addnum($turt_id));?>">
										<div class=""style="padding: 2px"><span class="j-wrap"style="display:block"><?= text_length(nl2br($turt_turt),100); ?></span></div>
          </a>
										<span><?php show_turt_media($turt_id); ?></span>
											<?php
									}//end  of if status is not suspended
								}elseif($turt_mode === "shared"){//if the content is shared
									$original_poster_id = turt_data('u_id',$turt_original_f_id); $original_turt = turt_data('f_turt',$turt_original_f_id);
									?>
									<div class=""style="padding: 9px">
										<?php // ORIGINAL INFO STARTS?>
										<div class="j-row">
											<span class="j-col s2 m2">
												<a href="<?= file_location('home_url',user_data('u_username',$poster_id));?>">
												<img class="j-circle j-image j-border-2 j-card-2 j-border-color5 j-image-size2"src="<?= file_location('media_url','profile_pics/'.get_user_image($poster_id));?>">
												</a>
											</span>
											<span class="j-col s10 m10">
												<a href="<?= file_location('home_url',user_data('u_username',$poster_id));?>">
												<span class="" style="padding-right: 5px"><b><?= ucwords(user_data('u_fullname',$poster_id));?></b></span>
												</a>
            <a href="<?= file_location('home_url',user_data('u_username',$poster_id));?>"><span class="j-text-color1 ">@<?= user_data('u_username',$poster_id);?></span></a>
												<?php turt_skill_job_3dots('turt',$type,$turt_id); //3 dots?>
            <a href="<?= file_location('home_url','f/t/'.addnum($turt_id));?>">
												<span class='j-text-color5'style='padding-right:15px;'><b>Shared a post</b></span><span class="j-small j-text-color1"><?= showdate($turt_regdatetime,"short"); ?></span>
												</a>
											</span>
										</div>
									</div>
									<?php
									if($turt_status === "suspended"){ // if the content has been suspended
										content_not_available();
									}else{ //if status is not suspended
										?>
										<a href="<?= file_location('home_url','f/t/'.addnum($turt_id));?>">
										<div class=""style="padding: 3px"> <span class="j-wrap"style="display:block"><?= text_length(nl2br($turt_turt),100); ?></span></div>
										</a>
										<?php
										if(turt_data('f_status',$turt_original_f_id) === "suspended"|| turt_data('f_id',$turt_original_f_id) === false){// if the original shared content has been deleted or suspended
											content_not_available(); 
										}else{ //if the shared content has not been suspended or deleted
											?>
												<div class="j-border j-border-color1 j-round"style="padding: 2px 2px">
													<div class=""style="padding: 9px">
														<div class="j-row">
															<div class="j-col s2">
																<a href="<?= file_location('home_url',user_data('u_username',$original_poster_id));?>">
																<img class="j-circle j-image j-border-2 j-card-2 j-border-color5 j-image-size3"src="<?= file_location('media_url','profile_pics/'.get_user_image($original_poster_id));?>">
																</a>
															</div>
															<div class="j-col s10 "style="padding-left: 5px">
																<div>
																	<a href="<?= file_location('home_url',user_data('u_username',$original_poster_id));?>">
																	<span class="" style="padding-right: 5px"><b><?= ucwords(user_data('u_fullname',$original_poster_id));?></b></span>
																	</a>
                 <a href="<?= file_location('home_url',user_data('u_username',$original_poster_id));?>"><span class="j-text-color1 ">@<?= user_data('u_username',$original_poster_id) ?></span><br></a>
																	<a href="<?= file_location('home_url','f/t/'.addnum($turt_original_f_id));?>">
																	<span class="j-small j-text-color1"><?= showdate(turt_data('f_regdatetime',$turt_original_f_id),"short"); ?></span>
																	</a>
																</div>
															</div>
															<a href="<?= file_location('home_url','f/t/'.addnum($turt_original_f_id));?>">
															<div class="j-wrap"><?= text_length(nl2br($original_turt),100); ?></div>
               </a>
														</div>
													</div>
													<span><?php show_turt_media($turt_original_f_id);?></span>
												</div>
										<?php
										}//if the shared content has not been suspended or deleted ends
									}
								}//end of if the content id shared
        get_like_comment_share_data('home',$turt_id);
        ?>
       </div>
							<?php
						}// end of if the poster has been blocked
					}// end of while
					if($type === "homepage"){ // echo add 3 more people at bottom
      ?>
      <div class="j-lower-border j-border-color5"style="border-bottom-width: 5px">
       <h3 class="j-text-color1"><b>Follow more to add to your turt</b></h3>
       <?php show_users_to_follow(3)?>
      </div>
      <?php
     }
	}else{
				if($type === "homepage"){
						?>
						<div class="j-lower-border j-border-color5"style="border-bottom-width: 5px">
							<h3 class="j-text-color1"><b>Follow more to add to your turt</b></h3>
							<?php show_users_to_follow(5)?>
						</div>
						<?php
				}elseif($type === "search"){
						echo "<center><div class='j-text-color5'>0 post found for the keywords <b>' ".remove_last_value($id)."' </b>,check your spelling or try another keywords</div></center><br>";
				}elseif($type === "trending"){
						echo "<center><div class='j-text-color1'>0 post available</div></center>";
				}elseif($type === "saved"){
						echo "<center><div class='j-text-color1'>0 saved post </div></center>";
				}elseif($type === "profile"){
						echo "<center><div class='j-text-color1'>0 post </div></center>";
				}else{
						echo "<center><div class='j-text-color1'>0 post Available</div></center>";
				}
	} //end of if no turt id found
	closeconnect("stmt",$stmt);
	closeconnect("db",$conn);
}
//get turt ends

// get comment like and share (for turt comment and co div)
function get_like_comment_share_data($page,$id){
	global $uid;
	//getting the poster id of original/shared original
	if(turt_data('f_mode',$id) === "original"){
		$the_poster_id = turt_data('u_id',$id);
	}elseif(turt_data('f_mode',$id) === "shared"){
		$turt_original_f_id = turt_data('f_original_f_id',$id);
		$the_poster_id = turt_data('u_id',$turt_original_f_id);;
	}
	//checking if the content is shared
	if(content_data('s_share','setting_table',$the_poster_id) === 'no' && $the_poster_id !== $uid){//if poster enabled shared
		$share = 'disabled'; 
	}else{ //if poster disabled share or if the poster is current user
		$share = 'enabled';	
	}
	
	if((turt_data('f_mode',$id) === "original" && turt_data('f_status',$id) === "suspended") || //if original and suspended
	   (turt_data('f_mode',$id) === "shared" && turt_data('f_status',$id) === "suspended") || //if shared and the shared is suspended
	   (turt_data('f_mode',$id) === "shared" && turt_data('f_status',$turt_original_f_id) === "suspended") || //if shared and original is suspended
	   (turt_data('f_mode',$id) === "shared" && turt_data('f_id',$turt_original_f_id) === false)){ //if shared and original is deleted
		// if the original content has been deleted or suspended, hide  like and comment text box
	}else{
		if($page === 'home'){
			?>
			<a href="<?= file_location('home_url','f/t/'.addnum($id));?>">
			<div class="j-padding j-text-color5">
				<b>
     <span class="j-left">
      <?php  $likes = get_like_numrow('turt',$id);?>
      <span id='likenumrow<?= $id;?>'><?= $likes;?></span> Like<?php if($likes > 1){echo's';}?>
     </span>
					<span class="j-right"><?php $comment = get_numrow('turtturtback_table','turt_id',$id); echo $comment?> Comment<?php if($comment > 1){echo's';}?></span>
				</b>
			</div><br>
			</a>
			<div class="j-row j-text-color5" style="border-top: solid 1px gray;margin-top:5px;padding: 7px 5px;">
				<b>
					<div class='j-col j-left j-clickable <?= $share === 'enabled' ? ' s4' : ' s6';?>'style="display: inline;"onclick="iadl('turt',<?= addnum($id);?>)">
      <span id='likecol<?= $id?>'>
       <span class='<?php if(check_like('turt',$id,$uid) === true){echo "j-text-color1";}?>'>
        <i class="<?= icon('thumbs-up');?>"></i> Like
       </span>
      </span>
					</div>					
					<a href="<?= file_location('home_url','f/t/'.addnum($id));?>">
					<center>
						<div class='j-col j-clickable <?= $share === 'enabled' ? ' s4 j-center' : ' s6';?>'style="display: inline;">
							<i class="<?= icon('comment');?>"></i> Comment
						</div>
					</center>
					</a>
					<div class='j-col j-clickable <?= $share === 'enabled' ? ' s4' : ' j-hide';?>'style="display: inline;">
						<a class="j-right"href="<?= file_location('home_url','f/returt/'.addnum($id));?>">
						Share <i class="<?= icon('share-alt');?>"></i>
						</a>
					</div>
				</b>
			</div>
			<?php
		}elseif($page === 'details'){ //numrow
			?> 
			<div class="j-text-color5">
				<b>
					<span class="j-left">
      <?php  $likes = get_like_numrow('turt',$id);?>
      <span id='likenumrow<?= $id;?>'><?= $likes;?></span> Like<?php if($likes > 1){echo's';}?>
     </span>
					<span class="j-right">
      <?php $comment = get_numrow('turtturtback_table','turt_id',$id);?>
      <span id='numrow<?= $id;?>'><?= $comment;?></span> Comment<?php if($comment > 1){echo's';}?>
     </span>
				</b>
			</div><br>
			<div class="j-row j-text-color5" style="border-top: solid 1px gray;border-bottom: solid 1px gray;margin-top:5px;padding: 7px 5px;">
				<b>
					<div class='j-col j-left j-clickable <?= $share === 'enabled' ? ' s4' : ' s6';?>'style="display: inline;"onclick="iadl('turt',<?= addnum($id);?>)">
      <span id='likecol<?= $id?>'>
       <span class='<?php if(check_like('turt',$id,$uid) === true){echo "j-text-color1";}?>'>
        <i class="<?= icon('thumbs-up');?>"></i> Like
       </span>
      </span>
					</div>
					<center>
						<div class='j-col j-clickable <?= $share === 'enabled' ? ' s4 j-center' : ' s6';?>'style="display: inline;"onclick="$('#schat').focus();">
							<i class="<?= icon('comment');?>"></i> Comment
						</div>
					</center>
					<div class='j-col j-clickable <?= $share === 'enabled' ? ' s4' : ' j-hide';?>'style="display: inline;">
						<a class="j-right"href="<?= file_location('home_url','f/returt/'.addnum($id));?>">
						Share <i class="<?= icon('share-alt');?>"></i>
						</a>
					</div>
				</b>
			</div>
			<!--comment button and section-->
			<span id="showcomments"></span><br><br>
			<?php
		}//end of else if $page == 'details'
	}//end of if the content is not suspended or deleted
}
// get comment like and share

// get comment like and co starts
function get_comment_like_and_reply_data($page,$type,$turtback_id,$commenter_id,$owner){
 global $uid;
 ?>
 <div class="j-text-color5">
  <span class=''>
   <b><i class="<?= icon('comment-o');?>"></i> (<?= get_numrow("{$type}reply_table",'f_id',$turtback_id);?>)</b>
  </span>
  <span style='margin-left: 3%'
   onclick='iadl("<?= $type?>_comment",<?= addnum($turtback_id);?>);'>
   <b>
    <span id='likecol<?= $turtback_id;?>'>
     <span class='j-round-large j-button <?php if(check_like("{$type}_comment",$turtback_id,$uid) === true){echo "j-text-color1";}?>'>
     Like<?php $likes = get_like_numrow("{$type}_comment",$turtback_id); if($likes > 1){echo's';}?>
     </span>
    </span>
    (<span id='likenumrow<?= $turtback_id;?>'><?= $likes;?></span>)
   </b>
  </span>
  <?php
  if($page === 'comment'){
    ?>
    <a href="<?= file_location('home_url',"{$type}/replies/".addnum($turtback_id));?>">
    <span class='j-round-large j-button' style='margin-left: 3%'><b>Reply</b></span>
    </a>
    <?php
  }elseif($page === 'reply'){
    ?>
    <span class='j-round-large j-button' style='margin-left: 3%' onclick="$('#sreply').focus();">
     <b>Reply</b>
    </span>
    <?php
  }
  ?>
 </div>
 <?php
}
// get comment like and co ends

//check like starts
function check_like($type,$turt_id,$liker_id){
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('userselect','PDO');
	$sql = "SELECT * FROM like_table WHERE l_type = :type AND u_id = :liker_id AND f_id = :f_id";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':type',$type,PDO::PARAM_STR);
	$stmt->bindParam(':f_id',$turt_id,PDO::PARAM_INT);
	$stmt->bindParam(':liker_id',$liker_id,PDO::PARAM_INT);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){
		return true;
	}else{
		return false;
	}
	closeconnect("stmt",$stmt);
	closeconnect("db",$conn);
}
//check like ends

//get like numrow starts
	function get_like_numrow($param,$param2){
		// creating connection
		require_once(file_location('inc_path','connection.inc.php'));
		@$conn = dbconnect('userselect','PDO');
		$sql = "SELECT * FROM like_table WHERE l_type = :param AND f_id = :param2";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':param',$param,PDO::PARAM_STR);
		$stmt->bindParam(':param2',$param2,PDO::PARAM_STR);
		$stmt->execute();
		$numRow = $stmt->rowCount();
		if($numRow > 999 && $numRow < 999999){
		$numRow = round($numRow/1000,1);
		return $numRow."K";
		}elseif($numRow > 999999 && $numRow < 999999999){
		$numRow = round($numRow/1000000,1);
		return $numRow."M";
		}elseif($numRow > 999999999){
		$numRow = round($numRow/1000000000,1);
		return $numRow."B";
		}else{
			return $numRow;
		}
	closeconnect("stmt",$stmt);
	closeconnect("db",$conn);
	}
//get like numrow ends

//turt 3dots starts
function turt_3dots($content_type,$sub_type,$content_id){
	global $uid;
	if($content_type === "turt"){
		$writer_id = turt_data('u_id',$content_id);
	}elseif($content_type === "skill"){
		$writer_id = skill_data('u_id',$content_id);
	}elseif($content_type === "job"){
		$writer_id = job_data('u_id',$content_id);
	}
	?>
	<span class="j-text-color1 j-right j-clickable">
		<i class="j-large <?= icon('ellipsis-h');?>"id="3_dots<?= $content_type.$content_id?>"
		onclick="$('#<?= "3dots_modal_".$content_type.$content_id?>').show();cscs('<?= $content_type?>',<?= $content_id?>);
		cbs('full',<?= $writer_id;?>,<?= $content_id;?>);cfus('full',<?= $content_id?>,<?= addnum($writer_id);?>);crps('<?= $content_type?>',<?= $content_id?>);
		cpcs('<?= $content_type?>',<?= $content_id?>,<?= addnum($content_id);?>);">
		</i>
	</span><br>
					<!--save and report and co starts modal starts-->
					<div  id="<?= '3dots_modal_'.$content_type.$content_id?>" class="j-modal">
					<div class="j-card-4 j-modal-content j-modal-content-support2 j-color6 j-round-large">
						<div class="j-display-container">
							<div class="j-padding j-line-height j-text-color1">
									<?php // FOR SAVE (ALL TYPE AND SUBTYPE)?>
									<span id="savedstatus<?= $content_type.$content_id;?>"class="j-clickable"onclick="$('#<?= "3dots_modal_".$content_type.$content_id?>').hide();"></span>
									<?php // FOR SHARE (ONLY FOR FEED)
											if($content_type === "turt"){
												if(turt_data("f_mode",$content_id) === "shared"){
													$real_writer_id = turt_data('u_id',turt_data('f_original_f_id',$content_id));$the_content_id = turt_data('f_original_f_id',$content_id);
												}else{ $real_writer_id = $writer_id; $the_content_id = $content_id;}
												if((content_data('s_share','setting_table',$real_writer_id) === 'yes' || $real_writer_id === $uid) && turt_data('f_status',$the_content_id) === "active"){// if the poster allow shared and if the active user is the poster
													?>
													<a href="<?= file_location('home_url','f/returt/'.addnum($content_id));?>">
													<div class='j-clickable j-row'>
														<div class="j-col s1"><i class='<?= icon('share-alt');?>'></i></div>
														<div class="j-col s11">Share Post</div>
													</div>
													</a>
												<?php
												}
											}
											?>
											<?php // FOR VIEW POST/JOB/SKILL (IF THE SUBTYPE IS NOT DETAILS)
											if($sub_type !== "details"){
												if($content_type === "turt"){$link = "/t/f/";}elseif($content_type === "skill"){$link = "/s/s/";}elseif($content_type === "job"){$link = "/j/j/";}
												?>
												<a href="<?= file_location('home_url',$link.addnum($content_id));?>">
												<div class='j-clickable j-row'>
														<div class="j-col s1">
															<i class='<?= icon('times-rectangle-o');?>'></i>
														</div>
														<div class="j-col s11">
															View <?php if($content_type === "turt"){echo "Post";}elseif($content_type === "job"){echo "Job/Service";}elseif($content_type === "skill"){echo "CV/Portfolio";}?>
														</div>
													</div>
													</a>
											<?php
											}
											?>
											<?php // FOR FOLLOWED POSTER (IF NOT CURRENT USER) AND SHOW REPORT POST AND BLOCK
											if($uid !== $writer_id){
												?>
													<span id="fstatus<?= $content_id;?>"onclick="$('#<?= "3dots_modal_".$content_type.$content_id?>').hide();"></span>
												<?php // FOR REPORT POST ?>
												<div class='j-clickable j-row'id="reportpost<?= $content_id;?>"onclick="$('#<?= "3dots_modal_".$content_type.$content_id?>').hide();
												$('#reportmodal<?= $content_type.$content_id?>').show();
												">
														<div class="j-col s1">
																<i class='<?= icon('flag');?>'></i>
														</div>
														<div class="j-col s11">
														Report <?php if($content_type === "turt"){echo "Post";}elseif($content_type === "job"){echo "Job/Service";}elseif($content_type === "skill"){echo "CV/Portfolio";}?>
														</div>
												</div>
												<?php // FOR BLOCK POSTER (IF  NOT BLOCKED BEFORE)
												if(check_block($writer_id,$uid) === false){
													?>
													<span id="blockstatus<?= $content_id;?>"onclick="$('#<?= "3dots_modal_".$content_type.$content_id?>').hide();"></span>
													<?php
													}
											}elseif($uid === $writer_id){ // FOR EDIT AND DELETE POSTER (IF CURRENT USER IS THE POSTER)
												if($content_type === "turt"){$links = "/t/edit_turt/";
												}elseif($content_type === "skill"){$links = "/s/edit_cv_portfolio/";
												}elseif($content_type === "job"){$links = "/j/edit_job_work/";}
												?>
            <?php 
            if($content_type === "turt"){ //PROMOTE STATUST
             ?>
             <a href="<?= file_location('home_url','ads/'.$content_type.'/'.addnum($content_id));?>">
            <span id="pstatus<?= $content_id;?>"onclick="$('#<?= "3dots_modal_".$content_type.$content_id?>').hide();"></span>
            </a>
             <?php
            }
            ?>
												<a href="<?= file_location('home_url',$links.addnum($content_id));?>">
												<div class='j-clickable j-row'>
														<div class="j-col s1">
																<i class='<?= icon('edit');?>'></i>
														</div>
														<div class="j-col s11">
               Edit <?php if($content_type === "turt"){echo "Post";}elseif($content_type === "job"){echo "Job/Service";}elseif($content_type === "skill"){echo "CV/Portfolio";}?>
														</div>
												</div>
												</a>
												<div class='j-clickable j-row'onclick="$('#<?= "3dots_modal_".$content_type.$content_id?>').hide();$('#<?= "deletemodal".$content_type.$content_id?>').show()">
														<div class="j-col s1">
																<i class='<?= icon('trash-o');?>'></i>
														</div>
														<div class="j-col s11">
														Delete	<?php if($content_type === "turt"){echo "Post";}elseif($content_type === "job"){echo "Job/Service";}elseif($content_type === "skill"){echo "CV/Portfolio";}?>																						
														</div>
												</div>
											<?php
											}
											?>
							</div>
						</div>
					</div>
					</div>
					<!--save and report and co modal ends-->
					<?php //block modal and unfollow modal
					show_unblock_modal($writer_id);
					show_unfollow_modal($writer_id);
					show_report_modal($content_type,$content_id);
					show_delete_modal($content_type,$content_id);
					?>
	<?php
}
//turt 3dots ends

//comment reply 3 dots starts
function comment_reply_3dots($content_type,$content_id,$writer_id,$post_id){
	//$post_id for gc();
	global $uid;
	if($content_type === "job_comment" || $content_type === "skill_comment" || $content_type === "turt_comment"){ // for comment
		?>
					<span class="j-text-color1 j-right j-clickable">
      <i class="<?= icon('ellipsis-v');?>"
       onclick="crps('<?= $content_type?>',<?= $content_id?>);$('#comment_turtbackmodal<?= $writer_id.$content_type.$content_id;?>').show();">
      </i>
     </span><br>
					<!--modal starts-->
					<div  id="comment_turtbackmodal<?= $writer_id.$content_type.$content_id;?>" class="j-modal">
					<div class="j-card-4 j-modal-content j-modal-content-support2 j-color6 j-round-large">
						<div class="j-display-container">
							<span class="j-button j-display-topright j-large j-text-color2 <?= icon('remove');?>"
								  onclick="$('#comment_turtbackmodal<?= $writer_id.$content_type.$content_id;?>').hide();">
							</span>
							<div class="j-container j-line-height j-text-color1">
											<?php
											if($writer_id !== $uid){
												?>
												<div class='j-clickable j-row'onclick="$('#comment_turtbackmodal<?= $writer_id.$content_type.$content_id;?>').hide();
																$('#reportmodal<?= $content_type.$content_id?>').show();">
																		<div class="j-col s1">
																				<i class='<?= icon('flag');?>'></i>
																		</div>
																		<div class="j-col s11">
																		Report <?php if($content_type === "turt"){echo "Post";}elseif($content_type === "job"){echo "Job/Service";}elseif($content_type === "skill"){echo "CV/Portfolio";}?>
																		</div>
												</div>					
											<?php
											}
											?>
											<?php
											if($writer_id === $uid){
												?>
												<div class='j-clickable j-row'onclick="$('#comment_turtbackmodal<?= $writer_id.$content_type.$content_id;?>').hide();
													$('#deletecommentmodal<?= $content_type.$content_id;?>').show();
													">
														<div class="j-col s1">
																<i class='<?= icon('trash-o');?>'></i>
														</div>
														<div class="j-col s11">
														 Delete Comment
														</div>
												</div>
											<?php
											}
											?>
							</div>
						</div>
					</div>
					</div>
					<!--modal ends-->
<?php
	}elseif($content_type === "job_reply" || $content_type === "skill_reply" || $content_type === "turt_reply"){ // for replies
?>
<!--start of 3 dots menu-->
					<span class="j-text-color1 j-right j-clickable">
      <i class="<?= icon('ellipsis-v');?>"
       onclick="crps('<?= $content_type?>',<?= $content_id?>);$('#reply_turtbackmodal<?= $writer_id.$content_type.$content_id;?>').show();">
      </i>
     </span><br>
					<!--save and report modal starts-->
					<div  id="reply_turtbackmodal<?= $writer_id.$content_type.$content_id;?>" class="j-modal">
					<div class="j-card-4 j-modal-content j-modal-content-support2 j-color6 j-round-large">
						<div class="j-display-container">
							<div class="j-container j-line-height j-text-color1">
											<?php
											if($writer_id !== $uid){
												?>
												<div class='j-clickable j-row'onclick="$('#reply_turtbackmodal<?= $writer_id.$content_type.$content_id;?>').hide();
																	$('#reportmodal<?= $content_type.$content_id?>').show();
																">
																		<div class="j-col s1">
																				<i class='<?= icon('flag');?>'></i>
																		</div>
																		<div class="j-col s11">
																		Report 
																		</div>
												</div>
												<?php
											}
											?>
											<?php
											if($writer_id === $uid){
												?>
												<div class='j-clickable j-row'onclick="$('#reply_turtbackmodal<?= $writer_id.$content_type.$content_id;?>').hide();
													$('#deletereplymodal<?= $content_type.$content_id;?>').show();">
														<div class="j-col s1">
																<i class='<?= icon('trash-o');?>'></i>
														</div>
														<div class="j-col s11">
														Delete Comment
														</div>
												</div>
											<?php
											}
											?>
							</div>
						</div>
					</div>
					</div>
					<!--save and report modal ends-->
					<!--end of 3 dots menu-->
<?php
	}// end of for replies
	show_report_modal($content_type,$content_id);
	show_delete_comment_modal($content_type,$content_id,$post_id);
}
//comment reply 3 dots ends

//message comment and reply input starts
function message_comment_reply_input($type,$id,$subtype=''){
 ?>
 <div class="j-fixed-message j-color4" style="z-index:2;">
				<center>
     <span id='imgtri'onclick='trigger_input($("#img"))'class='j-xlarge j-text-color1'style="width:10%;height:40px;position:relative;top:-15px">
     <i class="<?= icon('image');?>"></i>
     </span>
					<textarea class="j-round-large j-border-color1" id="schat" name='schat' placeholder="Type a message..."style="width:90%;height:40px;
     outline:none;"onkeyup="ssend(this.value,$('#img').val());"oninput="itah(this,80);"></textarea>
					<span id="send" class="j-round j-color1 j-button j-large j-circle"style="display:none;position:relative;top:-15px"
      <?php
      if($type === 'message'){
       ?>
       onclick="im($('#schat').val(),<?= addnum($id);?>,document.getElementById('img'));"
       <?php
      }elseif($type === 'comment'){
       ?>
       onclick="iuc('<?=$subtype?>',<?= addnum($id);?>,$('#schat').val(),document.getElementById('img'));"
       <?php
      }elseif($type === 'reply'){
       ?>
       onclick="iur('<?=$subtype?>',<?= addnum($id);?>,$('#schat').val(),document.getElementById('img'));"
       <?php
      }
      ?>>send
      </span>
     <input type="file"name="img"id="img"class="j-round j-hide"onchange="pui(this,document.getElementById('preview'),'mess');ssend($('#schat').val(),this.value);">
     </center>
    <div id='container'class='j-display-container'style='width:100px;height:100px;display:none;margin-left:14%;margin-bottom:5px;'>
     <div id='preview'style='width:inherit;height:inherit;'></div>
     <span class='j-display-topright j-button j-text-color4 j-circle j-color5 j-large j-padding-small'onclick="ri($('#img'),$('#container'),'comes')">x</span>
    </div>
			</div>
<?php
}
//message comment and reply input ends
//TURT FUNCTION ENDS
?>