<?php
function all_session($type='user'){
 if(strstr($_SERVER['SERVER_NAME'],'admin.')){
   require_once(file_location('admin_inc_path','session_start.inc.php'));
   if(isset($_SESSION['admin_id'])){
    $cla_current_admin = test_input(ssl_decrypt_input($_SESSION['admin_id']));
   }
 }else{
    require_once(file_location('inc_path','session_start.inc.php'));
    if(isset($_SESSION['user_id'])){
     $cla_current_user = test_input(ssl_decrypt_input($_SESSION['user_id']));
    }
 }
 if($type === 'admin' && isset($cla_current_admin)){
  return $cla_current_admin;
 }elseif($type === 'user' && isset($cla_current_user)){
  return $cla_current_user;
 }else{
  return '';
 }
 }