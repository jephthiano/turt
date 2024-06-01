<?php
//DELETE STORED COOKIE DATA IN BROWSER
delete_user_cookie_data(); //login cookie
delete_single_cookie('dark_mode'); //dark mode cookie
//DELETE SESSION
if(isset($_SESSION['user_id'])){
    $_SESSION = [];//empty the $_SESSION array
    if($type !== 'login_signup'){
        //invalidate the session cookie
        if(isset($_COOKIE[session_name()])){
            $param = session_get_cookie_params();
            setcookie(session_name(),'',time()-86400,$param['path'],$param['domain'],$param['secure'],$param['httponly']); //24hours ago
        }
        session_destroy();//destroy session
    }
}
require_once(file_location('inc_path','session_start.inc.php'));
?>