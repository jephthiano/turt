<?php //SETTINGS AND MISC JS STARTS ?>
<?php if(isset($horn_nav_js) && $horn_nav_js === true){// horizontal navigation [account and home page]?>
function hornav(cont,d){let y=document.getElementsByClassName("laucher");let s=document.getElementsByClassName("shw");for(let i=0;i< y.length;i++){y[i].style.color="";y[i].style.border="0px";}for(let i=0;i< s.length;i++){s[i].style.display="none";}cont.style.color="teal";cont.style.borderBottom="4px solid teal";document.getElementById(d).style.display="block";}
<?php } ?>
<?php //to disable and reenable sign up button if input is not empty?>
function daebtn(s,btn){<?php if(isset($type) && $type === 'step3'){?>let usr=$('#usr').val();let fnm=$('#fnm').val();let pss=$('#pss').val();let t =$('#tupp').is(':checked');if(t === true && usr.length > 0 && fnm.length > 0 && pss.length > 0){btn.prop("disabled",false)}else{btn.prop("disabled",true)}<?php }elseif(php_self('/settings/update_username.enc.php','home')){?>let cuu=$('#cuu').val();let nwu=$('#nwu').val();if(nwu.length < 4 || nwu===cuu){btn.prop("disabled",true);}else{btn.prop("disabled",false);}<?php }else{?>if(s.value.length > 0){btn.prop("disabled",false);}else{btn.prop("disabled",true);}<?php }?>}
<?php if(isset($dark_mode_js) && $dark_mode_js === true){ //dark mode settings [account and settings(index) page] ?>
function dms(t,v){if(v==='dark'){var v='light';d="<?=icon('toggle-off')?>";e="<?=icon('toggle-on')?>";}else{var v='dark';d="<?=icon('toggle-on')?>";e="<?=icon('toggle-off')?>";}$('#'+t).toggleClass(d);$('#'+t).toggleClass(e);$('#'+t).attr("onclick","dms('"+t+"','"+v+"')");$('body').toggleClass('j-color4');$('body').toggleClass('j-color3');$('.dm4').toggleClass('j-color4');$('.dm4').toggleClass('j-color3');$('.dmt7').toggleClass('j-text-color7');$('.dmt7').toggleClass('j-text-color6');$('.dmb3').toggleClass('j-border-color3');$('.dmb3').toggleClass('j-border-color4');$('.dmb6').toggleClass('j-border-color6');$('.dmb6').toggleClass('j-border-color7');$.ajax({type:'GET',url:dar+'act/dms/',cache:false}).done(function(s){gtb(t,v);})}
<?php } ?>
<?php if(isset($update_set_js) && $update_set_js === true){ // get toggle button [2fa, notification (settings) and privacy page]?>
function uus(t,v){if(v==='on'){var v='off';d="<?=icon('toggle-off')?>";e="<?=icon('toggle-on')?>";}else{var v='on';d="<?=icon('toggle-on')?>";e="<?=icon('toggle-off')?>";}$('#'+t).toggleClass(d);$('#'+t).toggleClass(e);$('#'+t).attr("onclick","uus('"+t+"','"+v+"')");$.ajax({type:'GET',url:dar+'act/uus/'+t+'/'+v+'/',cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action();}).done(function(s){$('#st').html(r_m(s.message));gtb(t,v);})}
<?php } ?>
<?php if(isset($toggle_button_js) && $toggle_button_js === true){ // get toggle button [account, settings(index), 2fa, notification (settings) and privacy page]?>
function gtb(i,v){$.ajax({type:'GET',url:dar+'get/gtb/'+i+'/',cache:false}).done(function(s){directResult(s,'bk'+i);})}
<?php } ?>
<?php if(isset($report_js) && $report_js === true){ //report [account page]?>
function rpc(t,i,d){$.ajax({type:'GET',url:dar+'act/rpc/'+t+'/'+i+'/'+d,cache:false,dataType:'JSON'}).fail(function(e,f,g){fail_action();}).done(function(s){successAlert(s);})}
<?php } ?>