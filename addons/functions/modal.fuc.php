<?php
//MODAL FUNCTION STARTS
//user modal starts
function user_modal($type,$id='none',$subtype=''){
 global $uid;global $color6;
 if($type === 'settings'){
  ?>
  <div  id="settings_modal"class="j-modal j-modal-click j-large j-hide-large j-hide-xlarge">
    <div class="j-card-4 j-modal-content j-modal-content-support2 j-color4 j-round-large j-padding dm4 j-border-color6 dmb6"style="width:100%;max-width:600px;height:auto;border-top:solid 1px">
     <div class="j-large">
      <div class''style='line-height:35px;'>
       <p><a href="<?= file_location('home_url','settings/settings_privacy/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('cog');?>"></i></div><div style="display:inline-block;">Settings & Privacy</div></a></p>
       <p><a href="<?= file_location('home_url','bookmark/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('bookmark');?>"></i></div><div style="display:inline-block;">Bookmarks</div></a></p>
       <p><a href="<?= file_location('home_url','settings/blocked_accounts/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('ban');?>"></i></div><div style="display:inline-block;">Blocked Accounts</div></a></p>
       <p><a href="<?= file_location('home_url','settings/manage_ads/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('audio-description');?>"></i></div><div style="display:inline-block;">Ads Manager</div></a></p>
       <p><div class='j-clickable'><div style="width:35px;display:inline-block"><i class="<?=icon('sun');?>"></i></div><div style="display:inline-block;">Dark Mode</div><span id='bkclmd'class="j-right j-text-color1"><?=setting_section('clmd')?></span></div></p>
       <p><a href="<?= file_location('home_url','settings/manage_ads/');?>"><div style="width:35px;display:inline-block"><i class="<?=icon('users');?>"></i></div><div style="display:inline-block;">Help Center</div></a></p>
       <p><div class="j-clickable j-hover-none"onclick="$('#settings_modal').fadeOut('slow');$('#logout_current_modal').fadeIn('slow');"><div style="width:35px;display:inline-block"><i class="<?=icon('power-off');?>"></i></div><div style="display:inline-block;">Log Out</div></div></p>
      </div>
     </div>
    </div>
   </div>
  <?php
 }elseif($type === 'user_3_dots'){
  //user 3 dots modal starts
  ?>
  <div id="user_3_dots_modal" class="j-modal j-modal-click">
   <div class="j-card-4 j-modal-content j-modal-content-support2 j-color4 j-round-large">
    <div class="j-display-container">
     <div class="j-padding"style='line-height:35px'>
      <?php //for report ?>
      <div class='j-clickable j-row'onclick="$('#user_3_dots_modal').fadeOut('slow');$('#report_user_modal<?= $id;?>').fadeIn('slow');">
       <div class="j-col s1"><i class='<?= icon('flag');?>'></i></div>
       <div class="j-col s11">Report @<?=content_data('user_table','u_username',$id,'u_id')?></div>
      </div>
      <?php //for block content?>
      <div id="blubu<?=$id?>">
       <?php block_status('detail',$id)?>
      </div>
     </div>
    </div>
   </div>
  </div>
  <?php
  user_modal('report',$id,'user'); //report modal
  //user 3 dots modal ends
 }elseif($type === 'log_out_current'){
  //logout current modal starts
  ?>
 <center>
   <div  id="logout_current_modal" class="j-modal j-modal-click">
    <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding dm4"style="width:90%;max-width:400px;height:auto;">
     <div class="j-display-container j-center j-large">
     <div class="j-container"><b>Log Out ?</b></div>
     <div class="j-medium"style="margin-top:10px;">Are you sure want to log out of your account?</div>
     <div class='j-medium'>
							<p style='display:inline'><button class="j-margin j-btn j-border j-border-color3 j-round" onclick="$('#logout_current_modal').fadeOut('slow');">Cancel</button></p>
        <p style='display:inline;'>
         <button id='lobtn<?=$id?>'type="submit"class="j-margin j-btn j-border j-border-color3 j-round"onclick="lg('current',<?=addnum($id)?>)">
          Log Out
         </button>
        </p>
					</div>
    </div>
    </div>
   </div>
  </center>
 <?php
 //logout current modal ends
}elseif($type === 'log_out_one'){
  //logout one modal starts
  ?>
 <center>
   <div  id="logout_one_modal<?=$id?>" class="j-modal j-modal-click">
    <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding j-text-color1"style="width:90%;max-width:400px;height:auto;">
     <div class="j-display-container j-center j-large">
     <span class="j-button j-display-topright j-large j-text-color1 <?=icon('times')?>"onclick="$('#logout_one_modal<?=$id?>').fadeOut('slow');"></span>
     <div class="j-container"><p><b>Log Out <?=$subtype?> Device?</b></p></div>
     <div class="j-medium"style="margin-top:10px;">Are you sure want to log out this device?</div>
     <div class='j-medium'>
							<p style='display:inline'><button class="j-margin j-btn j-border j-border-color3 j-round" onclick="$('#logout_one_modal<?=$id?>').fadeOut('slow');">Cancel</button></p>
        <p style='display:inline;'>
         <button id='lobtn<?=$id?>'type="submit"class="j-margin j-btn j-border j-border-color3 j-round"onclick="lg('selective',<?=addnum($id)?>)">
          Log Out This Device
         </button>
        </p>
					</div>
    </div>
    </div>
   </div>
  </center>
 <?php
 //logout one modal ends
 }elseif($type === 'log_out_all'){
  //logout all modal starts
 ?>
 <center>
   <div  id="logout_all_modal" class="j-modal j-modal-click">
    <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding"style="width:90%;max-width:400px;height:auto;">
     <div class="j-display-container j-center j-large">
     <div class="j-container"><p><b>Log Out All Sessions?</b></p></div>
     <div class="j-medium"style="margin-top:10px;">Are you sure you want to log out of all your sessions including this device?</div>
     <div class='j-medium'>
							<p style='display:inline'><button class="j-margin j-btn j-border j-border-color3 j-round" onclick="$('#logout_all_modal').fadeOut('slow');">Cancel</button></p>
        <p style='display:inline;'>
         <button id='lobtn<?=$id?>'type="submit"class="j-margin j-btn j-border j-border-color3 j-round"onclick="lg('all',<?=addnum($id)?>)">
          Log Out All Sessions
         </button>
        </p>
					</div>
     </div>
    </div>
   </div>
  </center>
 <?php
 //logout all modal ends
 }elseif($type === 'unfollow'){
  //unfollow modal starts
  ?>
  <center>
    <div  id="unfollow_modal<?=$id?>" class="j-modal j-modal-click">
     <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding  dm4" style="width:90%; max-width:400px;height: auto;">
      <div class="j-display-container j-center j-large">
       <div class="j-container"><b>Unfollow @<?=(content_data('user_table','u_username',$id,'u_id'));?>?</b></div>
       <div class="j-medium"style="margin-top:10px;">You will no longer see their Turts in your home timeline anymore, but you can still view their profile.</div>
       <div class="j-medium">
        <p style='display:inline'><button class="j-margin j-btn j-border j-border-color3 j-round" onclick="$('#unfollow_modal<?=$id?>').fadeOut('slow');">Cancel</button></p>
        <p style='display:inline;'>
         <button id='rmbtn<?=$id?>'type="submit"class="j-margin j-btn j-border j-border-color3 j-round"onclick="fau('<?=$subtype?>','unfollow',<?=addnum($id)?>);$('#unfollow_modal<?=$id?>').fadeOut('slow');">
          Unfollow
         </button>
        </p>
       </div>
      </div>
     </div>
    </div>
   </center>
  <?php
  //unfollow modal ends
 }elseif($type === 'block'){
  //block modal starts
  $username = content_data('user_table','u_username',$id,'u_id');
  ?>
  <center>
    <div  id="block_modal<?=$id?>" class="j-modal j-modal-click">
     <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding  dm4" style="width:90%; max-width:400px;height: auto;">
      <div class="j-display-container j-center j-large">
       <div class="j-container"><b>Block @<?=($username);?>?</b></div>
       <div class="j-medium"style="margin-top:10px;">@ <?=$username?> will no longer be able to follow or message you, and you will nort see notificaation from @<?=$username?>.</div>
       <div class='j-medium'>
        <p style='display:inline'><button class="j-margin j-btn j-border j-border-color3 j-round" onclick="$('#block_modal<?=$id?>').fadeOut('slow');">Cancel</button></p>
        <p style='display:inline;'>
         <button id='rmbtn<?=$id?>'type="submit"class="j-margin j-btn j-border j-border-color3 j-round"onclick="bau('<?=$subtype?>','block',<?=addnum($id)?>);$('#block_modal<?=$id?>').fadeOut('slow');">
          Block
         </button>
        </p>
       </div>
      </div>
     </div>
    </div>
   </center>
  <?php
  //block modal ends
 }elseif($type === 'unblock'){
  //unblock modal starts
  $username = content_data('user_table','u_username',$id,'u_id');
  ?>
  <center>
    <div  id="unblock_modal<?=$id?>" class="j-modal j-modal-click">
     <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding  dm4" style="width:90%; max-width:400px;height: auto;">
      <div class="j-display-container j-center j-large">
       <div class="j-container"><b>Unblock @<?=($username);?>?</b></div>
       <div class="j-medium"style="margin-top:10px;">They will be able to follow you and view yout Turts.</div>
       <div class='j-medium'>
        <p style='display:inline'><button class="j-margin j-btn j-border j-border-color3 j-round" onclick="$('#unblock_modal<?=$id?>').fadeOut('slow');">Cancel</button></p>
        <p style='display:inline;'>
         <button id='rmbtn<?=$id?>'type="submit"class="j-margin j-btn j-border j-border-color3 j-round"onclick="bau('<?=$subtype?>','unblock',<?=addnum($id)?>);$('#unblock_modal<?=$id?>').fadeOut('slow');">
          Unblock
         </button>
        </p>
       </div>
      </div>
     </div>
    </div>
   </center>
  <?php
  //unblock modal ends
 }elseif($type === 'report'){
  //report modal starts
  ?>
  <div id="report_<?=$subtype."_modal".$id?>" class="j-modal j-modal-click">
   <div class="j-card-4 j-modal-content j-modal-content-support2 j-color4 j-round-large">
    <div class="j-display-container">
     <div class="j-padding">
      <div class=""><?php get_report_data($subtype,$id)?></div>
     </div>
    </div>
   </div>
  </div>
  <?php
  //report modal ends
 }elseif($type === 'explore'){
  //explore modal starts
  //for small screen
  if($subtype === 'explore' ){$top = 125;}else{$top = 50;}
  ?>
  <div id="explore_modal"class="j-modal-explore j-modal-click j-hide-medium j-hide-large j-hide-xlarge j-color4"style="top:<?=$top?>px;">
   <div class="j-modal-content j-modal-content-explore j-color4"style="width:100%;height:auto;">
    <div id=""class='nmcr j-padding'></div>
   </div>
  </div>
  <?php //for larger screen?>
  <div id='drpdwnid'class="j-dropdown-content j-drpdwn-click j-round j-hide-small j-color4 j-border j-border-color4"style='max-height:500px;width:95%;top:60px;'>
   <div id='drpdwnc'class='nmcr j-padding'></div>
  </div>
  
  <?php
  //explore modal ends
 }
 
 
 
 
 
 
 
 elseif($type === 'delete_turt'){
  //delete feedts
  ?>
  <center>
    <div  id="delete_turt_modal<?=$id?>" class="j-modal j-modal-click">
     <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding j-text-color1" style="width:98%; max-width:400px;height: auto;">
      <div class="j-display-container j-center">
       <span class="j-button j-display-topright j-large j-text-color1 <?=icon('times')?>"onclick="$('#delete_turt_modal<?=$id?>').fadeOut('slow');"></span>
       <div class="j-container j-text-color1"><p><b>Delete Turt?</b></p></div>
       <div>
        <h5 class="j-text-color3">Are you sure want to delete the turt?. The action cannot be reverse.</h5><hr>
        <p style='display:inline;'>
         <button id='rmbtn<?=$id?>'type="submit"class="j-margin j-btn j-hover-color5 j-round j-color1 j-text-color4"onClick="onclick="">
          Delete
         </button>
        </p>
        <p style='display:inline'><button class="j-margin j-btn j-border j-border-color1 j-text-color1 j-hover-color5 j-round" onclick="$('#delete_turt_modal<?=$id?>').fadeOut('slow');">Cancel</button></p>
       </div>
      </div>
     </div>
    </div>
   </center>
  <?php
  //delete feed ends
 }elseif($type === 'delete_comment'){
  //delete comment modal starts
  ?>
  <center>
    <div  id="delete_comment_modal<?=$id?>" class="j-modal j-modal-click">
     <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding j-text-color1" style="width:98%; max-width:400px;height: auto;">
      <div class="j-display-container j-center">
       <span class="j-button j-display-topright j-large j-text-color1 <?=icon('times')?>"onclick="$('#delete_comment_modal<?=$id?>').fadeOut('slow');"></span>
       <div class="j-container j-text-color1"><p><b>Delete Comment?</b></p></div>
       <div>
        <h5 class="j-text-color3">Are you sure want to delete the comment?. The action cannot be reverse.</h5><hr>
        <p style='display:inline;'>
         <button id='rmbtn<?=$id?>'type="submit"class="j-margin j-btn j-hover-color5 j-round j-color1 j-text-color4"onClick="dc(<?=addnum($id);?>,<?=addnum($post_id);?>);">
          Delete Comment
         </button>
        </p>
        <p style='display:inline'><button class="j-margin j-btn j-border j-border-color1 j-text-color1 j-hover-color5 j-round" onclick="$('#delete_comment_modal<?=$id?>').fadeOut('slow');">Cancel</button></p>
       </div>
      </div>
     </div>
    </div>
   </center>
  <?php
  //delete comment modal ends
 }elseif($type === 'delete_reply'){
  //delete reply modal starts
  ?>
  <center>
    <div  id="delete_reply_modal<?=$id?>" class="j-modal j-modal-click">
     <div class="j-card-4 j-modal-content j-color4 j-round-large j-padding j-text-color1" style="width:98%; max-width:400px;height: auto;">
      <div class="j-display-container j-center">
       <span class="j-button j-display-topright j-large j-text-color1 <?=icon('times')?>"onclick="$('#delete_reply_modal<?=$id?>').fadeOut('slow');"></span>
       <div class="j-container j-text-color1"><p><b>Delete Reply?</b></p></div>
       <div>
        <h5 class="j-text-color3">Are you sure want to delete the reply?. The action cannot be reverse.</h5><hr>
        <p style='display:inline;'>
         <button id='rmbtn<?=$id?>'type="submit"class="j-margin j-btn j-hover-color5 j-round j-color1 j-text-color4"onClick="dr(<?=addnum($id);?>,<?=addnum($post_id);?>);">
          Delete Comment
         </button>
        </p>
        <p style='display:inline'><button class="j-margin j-btn j-border j-border-color1 j-text-color1 j-hover-color5 j-round" onclick="$('#delete_reply_modal<?=$id?>').fadeOut('slow');">Cancel</button></p>
       </div>
      </div>
     </div>
    </div>
   </center>
  <?php
  //delete reply modal ends
 }
}
// user modal ends


//admin modal starts
function admin_modal($type,$id='none',$subtype=''){
 if($type === 'log_out'){
 ?>
 <!--logout modal starts-->
 <center>
  <div id="log_out_modal"class="j-modal j-modal-click">
   <div class="j-card-4 j-modal-content j-light-color5 j-round-large j-padding j-text-color1"style="width:98%;max-width:400px;height:auto;">
    <div class="j-display-container j-center">
     <span class="j-button j-display-topright j-large j-text-color1 <?=icon('times')?>"onclick="$('#log_out_modal').fadeOut('slow');"></span>
     <div class="j-container j-text-color1"><p><b>Log Out?</b></p></div>
     <div>
      <h5 class="j-text-color3">Are you sure want to log out of your account?</h5><hr>
							<p style='display:inline'><button id='lobtn'class="j-margin j-btn j-round-large j-color1 j-text-color4"onClick="lg();">Log Out</button></p>
       <p style='display:inline'><button class="j-margin j-btn j-border j-border-color1 j-text-color3 j-hover-color1 j-round-large"onclick="$('#log_out_modal').fadeOut('slow');">Cancel</button></p>
					</div>
    </div>
   </div>
  </div>
	</center>
	<!--logout modal ends-->
 <?php
 }elseif($type === 'delete_account'){
  ?>
  <!--delete account modal starts-->
  <center>
   <div  id="delete_account_modal" class="j-modal j-modal-click">
    <div class="j-card-4 j-modal-content j-light-color5 j-round-large j-padding j-text-color1" style="width:98%; max-width:400px;height: auto;">
     <div class="j-display-container j-center">
      <span class="j-button j-display-topright j-large j-text-color1 <?=icon('times')?>"onclick="$('#delete_account_modal').fadeOut('slow');"></span>
      <div class="j-container j-text-color1"><p><b>Delete Account?</b></p></div>
      <div>
       <h5 class="j-text-color3">Are you sure want to delete your account?. The action cannot be reverse.</h5><hr>
       <span class='j-text-color1 mg j-left'id='pse'></span>
       <input type="password"class=" j-input j-medium j-border j-border-color5 j-round-large"placeholder="Password"
          name="ps"id="ps"value=""style="width:100%;"/>
							<p style='display:inline'><button type="submit"id='dabtn'class="j-margin j-btn j-round j-color1 j-text-color4"onClick="da($('#ps'))">Delete Account</button></p>
       <p style='display:inline'><button class="j-margin j-btn j-border j-border-color1 j-text-color1 j-hover-color1 j-round" onclick="$('#delete_account_modal').fadeOut('slow');">Cancel</button></p>
      </div>
     </div>
    </div>
   </div>
  </center>
  <!--delete account modal ends-->
  <?php
 }
}
//admin modal ends

//image modal starts
function image_modal($type,$id,$s_id=-1500000000){
}
//image modal ends
//MODAL FUNCTIONS ENDS
?>