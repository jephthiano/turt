<?php
//TOKEN AND COOKIE FUNCTION STARTS

//generate code starts
function generate_code(){return rand(100000,999999);}
//generate code ends

//set login cookie_data starts
function set_user_cookie_data($cookie_data,$expiretime){
 setcookie("tarcou",$cookie_data,$expiretime,"/","",true,true);
}
//set login cookie_data ends

//get login cookie_data starts
function get_user_cookie_data($type='user_id'){
 	if(isset($_COOKIE['tarcou'])){
   $cookie = $_COOKIE['tarcou'];
   if(!empty($cookie)){
    list($huser_id,$token,$selector,$huser_ip) = explode(':',$cookie);
    if($type === 'user_id'){
     return removenum(ssl_decrypt_input($huser_id));
    }elseif($type === 'token'){
     return $h_token = hash_input($token);
    }elseif($type === 'selector'){
     return$h_selector= hash_input($selector);
    }elseif($type === 'ip'){
     return $user_ip = ssl_decrypt_input($huser_ip);
    }else{
     return false;
    }
   }else{
    return false;
   }
  }else{
  return false;
  }
}
//get login cookie_data ends

//delete login cookie_data starts
 function delete_user_cookie_data(){if(isset($_COOKIE['tarcou'])){setcookie("tarcou","",time()-3600,"/","",true,true);}}
//delete login cookie_data ends

//insert and delete user code starts
function insert_update_delete_user_code($type,$content,$code = ''){
 $token_code = new token_code('admin');
 $token_code->type = $type;
 $token_code->content = $content;
 $token_code->code = $code;
 return $token_code->run_user_request();
}
//insert and delete user code ends

//set user token starts
function set_user_token_cookie($content,$code=''){
 $en_content = ssl_encrypt_input($content);
 $en_code = ssl_encrypt_input($code);
 $cookie_data = $en_content.":".$en_code;
 $expiretime = time()+(1800); //30 mins
 setcookie("_shbywetahkd",$cookie_data,$expiretime,"/","",true,true);
}
//set user token ends

//get user token starts
function get_user_token_cookie($type='content'){
 if(isset($_COOKIE['_shbywetahkd'])){
  $cookie = $_COOKIE['_shbywetahkd'];
  if(!empty($cookie)){
   list($de_content,$de_code) = explode(':',$cookie);
   if($type === 'content'){
    return test_input(ssl_decrypt_input($de_content));
   }elseif($type === 'code'){
    return test_input(ssl_decrypt_input($de_code));
   }else{
    return false;
   }
  }else{
   return false;
  }
 }else{
  return false;
  }
 }
//get user token ends

//delete user token starts
function delete_user_token_cookie(){if(isset($_COOKIE['_shbywetahkd'])){setcookie("_shbywetahkd","",time()-3600,"/","",true,true);}}
//delete user token ends


//set single cookie starts
function set_single_cookie($type,$id=''){
 if($type === 'login_id'){$cookie_name = "_wszlesyz";$expiretime = time()+(1800);} //30 mins
 if($type === 'forgot_password_id'){$cookie_name = "_wmytreomix";$expiretime = time()+(1800);} //30 mins
 if($type === 'login_cookie'){$cookie_name = "_gdwrgwevg";$expiretime = time()+(1800);}//30 mins
 if($type === 'dark_mode'){$cookie_name = "_jhyrgvreojfhd";$expiretime = time()+(86400 * 365);} //365 days
 $cookie_data = ssl_encrypt_input($id);
 setcookie($cookie_name,$cookie_data,$expiretime,"/","",true,true);
}
//set single cookie ends

//get single cookie starts
function get_single_cookie($type){
 if($type === 'login_id'){$cookie_name = "_wszlesyz";}
 if($type === 'forgot_password_id'){$cookie_name = "_wmytreomix";}
 if($type === 'login_cookie'){$cookie_name = "_gdwrgwevg";}
 if($type === 'dark_mode'){$cookie_name = "_jhyrgvreojfhd";}
 if(!isset($_COOKIE[$cookie_name]) || empty($_COOKIE[$cookie_name])){
  return false;
 }else{
  return ssl_decrypt_input($_COOKIE[$cookie_name]);
 }
}
//get single cookie ends

//delete single cookie starts
function delete_single_cookie($type){
 if($type === 'login_id'){$cookie_name = "_wszlesyz";}
 if($type === 'forgot_password_id'){$cookie_name = "_wmytreomix";}
 if($type === 'login_cookie'){$cookie_name = "_gdwrgwevg";}
 if($type === 'dark_mode'){$cookie_name = "_jhyrgvreojfhd";}
 setcookie($cookie_name,"",time()-3600,"/","",true,true);
}
//delete single cookie ends
//FORGOT PASSWORD FUNCTION ENDS
?>