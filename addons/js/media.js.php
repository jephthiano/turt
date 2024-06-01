<?php //MEDIA JS STARTS ?>
<?php if(isset($triger_click_js) && $triger_click_js === true){// trigger cicck js [profile and message]?>
<?php // trigger file upload input ?>
function ti(t){t.trigger('click');}
<?php } ?>
<?php if(isset($process_image_js) && $process_image_js === true){// trigger cicck js [profile and message]?>
<?php // process image?>
function pi(o,f,ty,t='single'){
 if(t ==='multi'){
  const file = o.files;
  if(file.length > 0){
   f.style.display='block';f.innerHTML = '';
   if(file.length > 4){ var f_len = 4;}else{ var f_len = file.length;}
    for(var i = 0; i < f_len; i++){
     const reader = new FileReader(); reader.readAsDataURL(file[i]);
     if(cuft(file[i]) === 'image'){
      reader.addEventListener('load',function(){
       var child = "<img src='"+this.result+"'style='width:23%;height:100px;padding-left:5px;'>";f.innerHTML += child;
      });
     }else if(cuft(file[i]) === 'video') {
      reader.addEventListener('load',function(){
       var child = "<video style='width:23%;height:75px;padding-left:5px;position:relative;top:25px'><source src='"+this.result+"'>Video not supported by your browser</video>";
       f.innerHTML += child;
      });
     }
    }
    if(file.length > 4){f.innerHTML += "<span class='j-xxlarge j-bolder j-text-color2'style='position:absolute;top:35px;right:15%;z-index:2'>+"+(file.length-4)+"<span>";}
  }else{f.style.display='none';f.innerHTML = '';}
 }else{
  const file = o.files[0];
  if(file){
   const reader = new FileReader(); reader.readAsDataURL(file);
   if(cuft(file) === 'image'){
    reader.addEventListener('load',function(){
     if(ty === 'mess'){
      $('#container').show();
      var child = "<img src='"+this.result+"'class=''style='height:inherit;width:inherit'>";
     }else{
      var child = "<img src='"+this.result+"'class='j-circle'style='height:inherit;width:inherit;opacity:0.8'><span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>";
     }
     f.innerHTML = child;
    });
   }else{
    //fil.value='';
    var child = "<span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>";f.innerHTML=child;
    $('#st').html(r_m2('Sorry!!!<br>Only image is allowed, please re-select.'));
   }
  }else{
   if(ty === 'mess'){
    $('#container').hide();var child = " ";
   }else{
    var child = "<span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>";
   }
   f.innerHTML=child;
   }
 }
}
<?php //check upload file type?>
function cuft(f){
 if(f.type.match('image.*')){
  return 'image';
 }else if(f.type.match('video.*')){
  return 'video';
 }else if(f.type.match('audio.*')){
  return 'audio';
 }else{
  return 'other';
 }
}
<?php } ?>
<?php if(php_self('/settings/profile.enc.php','home')){ ?>
<?php //change image (if success refresh the img section by getting it with ajax)?>
function ci(i,t){let f = i.files[0];if(f){let n = i.getAttribute('name');let d = new FormData();d.append(n,f),d.append('t',t);$.ajax({type:'POST',url:dar+'act/ci',data:d,cache:false,contentType:false,processData:false,dataType:'JSON'}).fail(function(e,f,g){fail_action();}).done(function(s){$('#st').html(r_m(s.message));if(s.status==='success'){if(t === 'profile_pics'){gud('side_bar',9999999999,'sbr')}$.ajax({type:'GET',url:dar+'get/gepid/'+t+'/',cache:false}).done(function(s){$('#'+t).html(s);})}})}else{$('#st').html(r_m('No file selected'));}alertoff();}
<?php } ?>