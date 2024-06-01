<?php
//GENERAL FUNCTIONS STARTS
//classes auto load starts
spl_autoload_register(function ($className){
 $className = str_replace('..','',$className); //to removes .. so as to ensure that it is not used by attacker to get to above folder
 require_once(file_location('inc_path','classes/'.$className.'.cla.php'));
});
//classes auto load ends

//no user surf starts
if(!strstr($_SERVER['SERVER_NAME'],'admin.')){no_user_surf();}
function no_user_surf(){
 if(get_json_data('surfing','act') == 0 || get_json_data('all','act') == 0){
  die(require_once(file_location('home_path','error/no_surfing.enc.php')));
 }
}
//no user surf ends

//close connection function starts
function closeconnect($connectionType='',$connectionVar=''){
	if(@$connectionType === "db"){
		return @$connectionVar = null;
	}elseif(@$connectionType === "stmt"){
		return @$connectionVar = null;
	}elseif(@$connectionType === "curl"){
		return curl_close(@$connectionVar);
	}
}
//close connection function ends

//page not available starts
function page_not_available($type="full"){
	?>
	<br>
	<center>
   <div class="j-padding"style="font-family: Roboto,sans-serif;width: 100%;"">
        <p class="">
            Sorry, the page you are looking for is not available, page may have been deleted, link may have been broken or you may not have access to the content<br><br>
            <a href="<?php if(strstr($_SERVER['SERVER_NAME'],'admin.')){echo file_location('admin_url','');}else{echo file_location('home_url','');}?>"class="j-btn j-bolder j-color1 j-round-large">
            Back to home
            </a>
        </p>
    </div>
	</center>
	<?php
}
//page not available ends

//content not available starts
function content_not_available($type="full"){
	if($type === "short"){
		?>
		<div class='j-color5 j-border j-round j-border-color5'style='min-height:120px;margin-bottom: 3px;'><br><br>
				<div class='j-large j-center j-padding'>Content is not available</div><br>
		</div>
		<?php
	}else{
		?>
		<div class='j-color6 j-border j-border-color5'style='min-height:120px;margin-bottom: 3px;'>
				<div class='j-large j-center j-color7 j-padding'>Content is not available</div><br>
				<center>
					<div class="j-container">The content does not exist. Content may have been deleted or suspended or you may not have access to the content</div>
				</center>
		</div>
		<?php
	}
}
//content not available ends

//no media starts
function no_media_available($type = ''){
 if($type === 'comment'){
  ?>
  <div class="j-center j-text-color1"><b>Comment may have been deleted or the link is broken</b></div>
  <?php
 }elseif($type === 'empty'){
  ?><span class='j-text-color3 j-button alert j-info j-container j-padding j-round-xlarge j-fixalert'id='thealert'>All fields are required</span><?php
 }else{
  ?>
  <br><div class="j-bolder j-text-color4 j-xxlarge">No media to display</div>
  <?php
 }
}
//no media ends

// trigger error starts
function trigger_error_manual($error=404){http_response_code($error);require_once(file_location('home_path','error/index.php'));die();}
// trigger error starts

//time token starts
function time_token(){return time().rand(000000,999999);}
//time token ends
 
// generate random token starts
function random_token($data = ''){return md5(microtime(true).mt_rand().$data);}
// generate random token ends
	
//text length start
function text_length($data,$length,$type='see_more'){
 if(strlen($data) > $length){
  if($type === 'see_more'){
   $data = substr($data,0,$length)."...<i class='j-text-color5'>See More</i>";
  }elseif($type === 'no_dot'){
   $data = substr($data,0,$length);
  }else{
   $data = substr($data,0,$length)."...";
  }  
 }
  return $data;
 }
//text length ends

//function convert to line break starts
function convert_2_br($data){$data2 = str_replace(array("\r\n","\r","\n"),"<br>",$data);echo $data2;}
//function convert to line break ends

//icon starts
function icon($data,$type='fas'){return $type.' fa-'.$data;}
//icon ends

//remove last starts
function remove_last_value($input,$remove = '*'){
	$position = strpos($input,$remove);
	if ($position === false){
		return $input;
	}else{
		$input = substr($input,0,-1);return $input;
	}
}
//remove last ends

//s/n starts
function s_n(){static $x = 1;echo $x;$x++;}
//s/n ends

//re key array starts
function re_key_array($data){if(is_array($data)){$data = implode('|',$data);$data = explode('|',$data);return $data;}else{return false;}}
// re key array ends

//function get_header starts
function get_header($header,$button='settings',$right_menu='',$size=35,$type='home_url'){
 global $color6;
 if(empty($size)){$size=35;}if(empty($type)){$type='home_url';}
 if($button === 'back'){
  $btn = "<span onclick='history.go(-1);'><span style='margin-right:20px;'class='j-btn''><i class='j-xlarge ".icon('arrow-left')."'></i></span></span>";
 }elseif($button = 'hide'){
  $btn = "<span style='margin-right:20px;'></span>";
 }else{
  $btn = "<a href='".file_location($type,$button)."'><span style='margin-right:20px;'class='j-btn''><i class='j-xlarge ".icon('arrow-left')."'></i></span></a>";
 }
 $right_menu = "<span class='j-right'style='padding-top:5px;'>{$right_menu}</span>";
 ?>
 <div class='j-border-bottom j-border-color6 j-color4 dmb6 dm4 j-fixed-top'>
 <div class='j-hide-small j-hide-medium'>
  <div class='j-large j-padding'><span><?=$btn."<div style='display:inline;'>".$header."</div>".$right_menu?></span></div>
 </div>
 <div class='j-hide-large j-hide-xlarge'>
  <div class='j-padding'><span><?=$btn."<div class='j-large'style='display:inline;'>".$header."</div>".$right_menu?></span></div>
  <br class='j-clearfix'>
 </div>
 </div>
 <div style="height:61px;"></div>
 <?php
}
//function get header ends

//fucntion back button starts
function back_btn(){
 ?><span onclick='history.go(-1);'><span style='margin-right:5px;'class='j-btn'><i class='j-xlarge <?=icon('arrow-left')?>'></i></span></span><?php
}
//fucntion back button ends

//back to the top starts
function back_to_top($type=''){
 ?> <div><a class="j-color3 j-button j-right"href="#<?=$type?>"><i class="fa fa-arrow-up j-margin-right"> </i>To the top</a></div><br><br> <?php
}
//back to the top ends

//function misc header starts
function misc_header($data){
 ?>
	<div class='j-display-container j-slideshow-height'style='width:100%'>
		<img src="<?=file_location('media_url','home/logo_large.png')?>"style='height:inherit;width:inherit;'/>
		<div class='j-display-middle j-text-color4 j-slideshow-height'style="font-family:Sofia;width:100%;background-color:rgba(0,0,0,0.4)">
			<?php back_btn();?>
			<center>
				<span class='j-xxxlarge j-hide-small'><b><br><?=strtoupper(get_xml_data('company_name'))?><br><?=strtoupper($data)?></b></span>
				<span class='j-xlarge j-hide-medium j-hide-large j-hide-xlarge'><b><br><?=strtoupper(get_xml_data('company_name'))?><br><?=strtoupper($data)?></b></span>
			</center>
		</div>
	</div>
	<br>
 <?php
}
//function misc header ends

//g to kg starts
function g_2_kg($data){
 return ($data/1000);
}
//g to kg ends

function show_ready_pages(){
 ?>
 <br>
 <div class= j-padding'>
  This page is not ready, You can check out other pages and features that are ready 
 </div>
 <?php
}
//GENERAL FUNCTIONS ENDS

?>