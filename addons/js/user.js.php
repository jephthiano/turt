<?php //USER JS STARTS ?>
<?php if(php_self('/index.php','home') && get_single_cookie('login_cookie') === 'yes'){ //set user cookie data when the login_cookie is set to yes?>
$.ajax({type:'GET',url:dar+'act/sucd/',cache:false})
<?php } ?>
<?php if(php_self('/signup.enc.php','home')){ ?>
<?php if($type === 'step1'){ ?>
<?php //process mobile number?>
$(document).ready(function(){$('#sgp1frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Processing Data','id','ephnbtn');$.ajax({type:'POST',url:dar+"act/spmn/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Continue','id','ephnbtn');}).done(function(s){successRedirect(s,'Continue','id','ephnbtn');})})})
<?php } ?>
<?php if($type === 'step2'){ ?>
<?php //process code?>
$(document).ready(function(){$('#sgp2frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Processing Code','id','ecdbtn');$.ajax({type:'POST',url:dar+"act/spc/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Continue','id','ecdbtn');}).done(function(s){successRedirect(s,'Continue','id','ecdbtn');})})})
<?php } ?>
<?php if($type === 'step3'){ ?>
<?php //process user data?>
$(document).ready(function(){$('#sgp3frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Signing Up','id','sgpbtn');$.ajax({type:'POST',url:dar+"act/spud/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Sign Up','id','sgpbtn');}).done(function(s){successRedirect(s,'Sign Up','id','sgpbtn');})})})
<?php } ?>
<?php } ?>
<?php if(php_self('/login.enc.php','home')){ //FOR LOGIN?>
<?php if($type === 'id'){ ?>
<?php //process id?>
$(document).ready(function(){$('#lgp1frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Processing Id','id','eidbtn');$.ajax({type:'POST',url:dar+"act/lpid/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Continue','id','eidbtn');}).done(function(s){successRedirect(s,'Continue','id','eidbtn');})})})
<?php } ?>
<?php if($type === 'verify'){ ?>
<?php //process login data?>
$(document).ready(function(){$('#lgp2frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Login In','id','epssbtn');$.ajax({type:'POST',url:dar+"act/lpld/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Login In','id','epssbtn');}).done(function(s){successRedirect(s,'Login In','id','epssbtn');})})})
<?php } ?>
<?php } ?>
<?php if(php_self('/forgot_password.enc.php','home')){ //FOR FORGOT PASSWORD?>
<?php if($type === 'id'){ ?>
<?php //process id?>
$(document).ready(function(){$('#fpp1frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Processing Id','id','eidbtn');$.ajax({type:'POST',url:dar+"act/fppid/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Continue','id','eidbtn');}).done(function(s){successRedirect(s,'Continue','id','eidbtn');})})})
<?php } ?>
<?php if($type === 'medium'){ ?>
<?php //process medium?>
$(document).ready(function(){$('#fpp2frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Sending Code','id','embtn');$.ajax({type:'POST',url:dar+"act/fppm/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Continue','id','embtn');}).done(function(s){successRedirect(s,'Continue','id','embtn');})})})
<?php } ?>
<?php if($type === 'code'){ ?>
<?php //process code?>
$(document).ready(function(){$('#fpp3frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Processing Code','id','ecdbtn');$.ajax({type:'POST',url:dar+"act/fppc/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Continue','id','ecdbtn');}).done(function(s){successRedirect(s,'Continue','id','ecdbtn');})})})
<?php } ?>
<?php if($type === 'password'){ ?>
<?php //process password?>
$(document).ready(function(){$('#fpp4frm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Resetting Password','id','epsbtn');$.ajax({type:'POST',url:dar+"act/fppp/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Reset Password','id','epsbtn');}).done(function(s){successRedirect(s,'Reset Password','id','epsbtn','success');})})})
<?php } ?>
<?php } ?>
<?php if(php_self('/settings/profile.enc.php','home')){ //save profile data?>
$(document).ready(function(){$('#eupfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Saving','id','supbtn');$.ajax({type:'POST',url:dar+"act/uup/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Save','id','supbtn');}).done(function(s){successRedirect(s,'Save','id','supbtn');})})})
<?php } ?>
<?php if(php_self('/settings/change_password.enc.php','home')){ //chnage password?>
$(document).ready(function(){$('#cpfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Changing Password','id','enpsbtn');$.ajax({type:'POST',url:dar+"act/cp/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Change Password','id','cpbtn');}).done(function(s){successAlert(s,'Change Password','id','cpbtn');if(s.status === 'success'){$('.pss').val('');}})})})
<?php } ?>
<?php if(php_self('/settings/update_username.enc.php','home')){ //update username?>
$(document).ready(function(){$('#upufrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Updating','id','upubtn');$.ajax({type:'POST',url:dar+"act/upu/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Update','id','upubtn');}).done(function(s){successRedirect(s,'Update','id','upubtn');})})})
<?php } ?>
<?php if(isset($update_emn_js) && $update_emn_js === true){ //update email and update mobile_number page
 //verify password?>
function vp(d){event.preventDefault();$('.mg').html('');loading('Verifying','id','enpsbtn');$.ajax({type:'POST',url:dar+"act/vp/",data:$(d).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Verify','id','enpsbtn');}).done(function(s){successCallback(s,'Verify','id','enpsbtn');if(s.status==='success'){gud(s.message,an(s.message))}})}
<?php //verify new email or mobile number?>
function vuld(d){event.preventDefault();$('.mg').html('');loading('Processing','id','eidbtn');$.ajax({type:'POST',url:dar+"act/vuld/",data:$(d).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Continue','id','eidbtn');}).done(function(s){successCallback(s,'Continue','id','eidbtn');if(s.status==='success'){gud('etcd',an(s.message));}})}
<?php //verify code?>
function vc(d){event.preventDefault();$('.mg').html('');loading('Verifying','id','ecdbtn');$.ajax({type:'POST',url:dar+"act/vc",data:$(d).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Verify','id','ecdbtn');}).done(function(s){successRedirect(s,'Verify','id','ecdbtn');})}
<?php } ?>
<?php if((isset($delete_js) && $delete_js === true) || (isset($deactivate_js) && $deactivate_js === true)){ // for delete and deactivate [delete_account and $deactivate_account page]?>
$(document).ready(function(){
<?php if(isset($delete_js)){ ?>let d = "Delete";let v = "Deleting";<?php }else{ ?>let d = "De-activate";let v = "De-activating";<?php }?>
$('#ddafrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading(v+' Account','id','ddasbtn');$.ajax({type:'POST',url:dar+"act/dda/",data:$(this).serialize(),cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('',d+' Account','id','ddasbtn');}).done(function(s){successRedirect(s,d+' Account','id','ddasbtn');})})})
<?php } ?>
<?php if(isset($logout_js) && $logout_js === true){ //logout (if it is selective call gud() after done) [account, settings (index) and session page]?>
function lg(t,i){var btn = 'lobtn'+rn(i);var id = rn(i);loading('Loggin out','id',btn);$.ajax({type:'GET',url:dar+'act/lg/'+t+'/'+i+'/',cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action('','Log Out','id',btn);}).done(function(s){if(t === 'selective'){if(s.status==='success'){$('#logout_one_modal'+id).fadeOut('slow');;$('#esd'+id).html('');}else{successCallback(s,'Log Out','id',btn,'');}}else{successRedirect(s,'Log Out','id',btn);}})}
<?php } ?>
<?php if(isset($follow_js) && $follow_js === true){ //follow and unfollow //if done update button and get follow counter data and update [account and people page]?>
function fau(t,a,i){var btn = 'faub'+rn(i);$.ajax({type:'GET',url:dar+'act/fau/'+t+'/'+a+'/'+i+'/',cache:false}).fail(function(e,f,g){fail_action();}).done(function(s){if(s === 'blocked'){gud('detail',i);}else{directResult(s,btn);gfc(i);}});}
<?php // get follow counter (mostly after follow and unfollow)?>
function gfc(i){$.ajax({type:'GET',url:dar+'get/gfc/'+i+'/',cache:false}).done(function(s){directResult(s,'fwc');})}
<?php } ?>
<?php if(isset($block_js) && $block_js === true){ //block and unblock // if done update the 3dots block button and get user account data and update [account and blocked_account page]?>
function bau(t,a,i){var btn = 'blubu'+rn(i);$.ajax({type:'GET',url:dar+'act/bau/'+t+'/'+a+'/'+i+'/',cache:false}).fail(function(e,f,g){fail_action();}).done(function(s){if(s !== 'blocked'){directResult(s,btn)}if(t === 'detail'){gud('detail',i);}});}
<?php } ?>
<?php if(isset($trigger_submit_js) && $trigger_submit_js === true){ //trigger code submit after te input is 6 (c is the form, while b is the button id) [sign up (step2), forgot_password(code), update_email and update_mobile_number]?>
function trsub(c,b){if($(c).val().length > 5){$('#'+b).trigger('click');}}
<?php } ?>
<?php if(isset($check_uen_js) && $check_uen_js === true){ //check username,email and mobile number onkeyup [sign up (stpe3),update_username, update_email and update_mobile_number page]?>
function cuen(t,e,d){var ev = e.value;$('#'+d).html('');$.ajax({type:'GET',url:dar+'get/cuen/'+t+'/'+ev+'/',cache:true}).done(function(s){directResult(s,d);})}
<?php } ?>
<?php if(isset($get_user_data_js) && $get_user_data_js === true){ // get user account template [account, blocked_account, sessions, update_email and update_mobile_number]?>
function gud(t,i,r='aud'){$.ajax({type:'GET',url:dar+'get/gud/'+t+'/'+i+'/',cache:false}).done(function(s){directResult(s,r);})}
<?php } ?>
<?php if(isset($pass_show_eye_js) && $pass_show_eye_js === true){ // chnage password input type [signup, login, forgot_password, change_password, delete_account, deactivate_account, update_email and update_mobile_number]?>
function cpit(i){let ps=$('#'+i).attr('type');if(ps==='password'){$('#'+i).attr('type','text');$('#eye'+i).html("<i class='<?=icon("eye-slash")?>'></i>");}else{$('#'+i).attr('type','password');$('#eye'+i).html("<i class='<?=icon("eye")?>'></i>");}}<?php //change password input type (change the inptu type and the eye symbol)?>
<?php } ?>