<?php //NOTIFICATION JS STARTS ?>
<?php if(isset($notification) && $notification === 'notification'){?>
$(document).ready(function(){setInterval(gnfn,3000);setInterval(gsnnr,3000);});
function gnfn(){$.ajax({type:'GET',url:dar+'get/grtn/feed/',cache:false}).done(function(s){$('.newsfeedspan').html(s);;})}<?php // get new feed notfication foor home button (self timer)?>
function gsnnr(){$.ajax({type:'GET',url:dar+'get/grtn/noti/',cache:false}).done(function(s){$('.notificationspan').html(s);})}<?php // get unread notification number counter (self timer)?>
<?php } ?>
<?php if($_SERVER['PHP_SELF'] === "/n/index.php"){ ?>
function cnts(t){$.ajax({type:'GET',url:dar+'act/cnts/'+t+'/',cache:false})}<?php //change al type notification status oncick(notification page)?>
<?php }?>