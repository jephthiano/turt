<?php //MESSAGE JS STARTS ?>
<?php if(isset($notification) && $notification === 'notification'){// get unread message number counter (self timer)?>
$(document).ready(function(){setInterval(gsmnr,3000);});function gsmnr(){$.ajax({type:'GET',url:dar+'get/grtn/mess/',cache:false}).done(function(s){$('.messagespan').html(s);})} 
<?php }?>
<?php if($_SERVER['PHP_SELF'] === "/account.enc.php"){//for inbox lock message onclick [account]?>
function mla(u){$('#st').html(r_m('@'+u+' has locked inbox'));alertoff();}
<?php }?>
<?php if($_SERVER['PHP_SELF'] === "/m/index.php"){//for inbox message (self timer) [m index]?>
$(document).ready(function(){setInterval(gmid,1000);}); function gmid(){$.ajax({type:'GET',url:dar+'get/gmid/',cache:false}).done(function(s){$('#msg').html(s);})}
<?php }?>
<?php if($_SERVER['PHP_SELF'] === "/m/messages.enc.php"){?>
function ssend(v,i){var mIpWid = $('#mIp').css('width').slice(0,-2) * (90/100); var newv = (mIpWid-70);if((v.length > 0) || (i !== '')){$('#schat').css('width',newv+'px');$('#send').css('display','inline')}else{$('#schat').css('width',mIpWid+'px');$('#schat').css('height','40px');$('#send').css('display','none');}}<?php //for show send button (onkeyup) [message page] ?>
function itah(e){if(e.scrollHeight < 80){e.style.height = 40 + "px";e.style.height = (e.scrollHeight) + "px";}}<?php //to increase text area (onkeyup) [message page]?>
function ri(o,f){o.val('');f.hide();ssend($('#schat').val(),o.val());} <?php //remove preview image?>
$(document).ready(function(){$('#msfrm').on('submit',function(event){event.preventDefault();$.ajax({type:'POST',url:dar+"act/sm/",data:new FormData(this),cache:false,contentType:false,processData:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('Error ocurred while sending message');}).done(function(s){if(s.status==='success'){gcd(s.message);$('#schat').val("");$('#img').val('');$('#container').hide();ssend('','');}else{successCallback(s);}})})});<?php //send message?>
$(document).ready(function(){setInterval(gcd,1000);});<?php //get chat data (self timer)?>
function gcd(i=''){if(i === ''){i = <?=addnum($chatter_id)?>;}$.ajax({type:'GET',url:dar+'get/gcd/'+i+'/',cache:false}).done(function(s){$('#cht').html(s);});}<?php //get chat data?>
<?php }?>
<?php if($_SERVER['PHP_SELF'] === "/m/search.enc.php"){?>
gnmc();function gnmc(){$.ajax({type:'POST',url:dar+'get/gnmc/',data:{"s":$('#sIp').val()}}).fail(function(e,f,g){fail_action('');}).done(function(s){$('#nmcr').html(s);});}
<?php }?>