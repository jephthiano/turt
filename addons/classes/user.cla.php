<?php
class user{
    private $table = 'user_table';
    private $table2 = 'user_duplicate_table';
    private $table3 = 'setting_table';
    private $table4 = 'last_refresh_table';
    private $table5 = 'follow_table';
    private $table6 = 'block_table';
    private $table7 = 'cookie_data_table';
    private $media_table = 'user_media_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    private $current_user;
    private $last_id;
    
    public function __construct($conn = ''){
        if(!empty($conn)){
            //CREATE CONNECTION
            require_once(file_location('inc_path','connection.inc.php'));
            $this->dbconn = dbconnect($conn,'PDO');
        }
        require_once(file_location('inc_path','class_all_session.inc.php'));
        $this->current_admin = all_session('admin');
        $this->current_user = all_session('user');
    }
    
    public function __destruct(){
    	//CLOSES ALL CONNECTION
        if(is_resource($this->dbconn)){
            closeconnect('db', $this->dbconn);
        }
        if(is_resource($this->dbstmt)){
            closeconnect('stmt',$this->dbstmt);
        }
    }
    
    public function re_hash_pass(){
        $this->new_password = hash_pass($this->current_password);
        $this->dbsql = "UPDATE {$this->table} SET u_password = :password WHERE u_id = :id LIMIT 1";
        $this->dbstmt =  $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':password',$this->new_password,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $this->dbstmt->execute();
    } //end of re hash pass
    
    public function insert_cookie_data(){
        $this->dbsql = "INSERT INTO {$this->table7}(cd_token,cd_selector,cd_ipaddress,cd_device_type,cd_browser_type,cd_country,cd_state,cd_expiretime,u_id)
        VALUES(:token,:selector,:ipaddress,:device_type,:browser_type,:country,:state,:exptime,:user_id)";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':token',$this->token,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':selector',$this->selector,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':ipaddress',$this->ipaddress,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':device_type',$this->device_type,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':browser_type',$this->browser_type,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':country',$this->country,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':state',$this->state,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':exptime',$this->expiretime,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':user_id',$this->current_user,PDO::PARAM_STR);
        if($this->dbstmt->execute()){return 'success';}else{return 'fail';}
    }//end insert cookie
    
    public function sign_up(){
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            //insert user
            $this->dbsql = "INSERT INTO {$this->table}(u_phnumber,u_username,u_fullname,u_password)
                VALUES(:phnumber,:username,:fullname,:password)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':phnumber',$this->phnumber,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':username',$this->username,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':fullname',$this->fullname,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':password',$this->password,PDO::PARAM_STR);
            $this->dbstmt->execute();
            $this->last_id = $this->dbconn->lastInsertId(); //last id
            //insert user duplicate data
            $this->dbsql = "INSERT INTO {$this->table2}(ud_phnumber,ud_username,ud_fullname,u_id)
                VALUES(:phnumber,:username,:fullname,:id)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':phnumber',$this->phnumber,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':username',$this->username,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':fullname',$this->fullname,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':id',$this->last_id,PDO::PARAM_STR);
			$this->dbstmt->execute();
            // commit the transation
            if($this->dbconn->commit()){
                insert_update_delete_user_code('delete',$this->phnumber);
                $this->log_out('login_signup');// log out current account if any
                return $this->last_id;
            }//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return 'fail';}
        }
    }//end of sign up
    
    public function authenticate_login(){
        //check if user exists
        $this->id = content_data($this->table,'u_id',get_id_true_data($this->login_id,$this->col),$this->col);//encyrpt if id is phnumber or email
        if($this->id !== false){
            $this->status = content_data($this->table,'u_status',$this->id,'u_id');
            $this->password = content_data($this->table,'u_password',$this->id,'u_id');
            if(password_verify($this->current_password,$this->password)){// verify
                if(password_needs_rehash($this->password,PASSWORD_DEFAULT)){$this->re_hash_pass();}//end of if need rehash
                $this->log_out('login_signup');// log out current account if any
                if($this->status === "suspended"){
                    return 'suspended';
                }elseif($this->status === "active"){
                    return $this->id;
                }
            }else{//if password doesnt match
                return 'fail';
            }//end of if passowrd match
        }else{// if user does not exits
            return 'fail';
        }
    }// end of authenticate_login
    
    public function log_out($type){
        if($type === 'login_signup'){
            $this->token = get_user_cookie_data('token');
			$this->selector = get_user_cookie_data('selector');
			$this->ipaddress = get_user_cookie_data('ip');
            $this->u_id = get_user_cookie_data();
            if($this->token !== false && $this->selector !== false && $this->ipaddress !== false){
                $this->dbsql = "DELETE FROM {$this->table7} WHERE cd_token = :token AND cd_selector = :selector AND cd_ipaddress = :ipaddress";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':token',$this->token,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':selector',$this->selector,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':ipaddress',$this->ipaddress,PDO::PARAM_STR);
                $this->dbstmt->execute();
            }
        }elseif($type === 'current'){
            $this->token = get_user_cookie_data('token');
			$this->selector = get_user_cookie_data('selector');
			$this->ipaddress = get_user_cookie_data('ip');
            //delete
            $this->dbsql = "DELETE FROM {$this->table7} WHERE u_id = :u_id AND cd_token = :token AND cd_selector = :selector AND cd_ipaddress = :ipaddress";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':token',$this->token,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':selector',$this->selector,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':ipaddress',$this->ipaddress,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':u_id',$this->current_user,PDO::PARAM_INT);
        }elseif($type === 'selective'){
            $this->dbsql = "DELETE FROM {$this->table7} WHERE u_id = :u_id AND cd_id = :cid";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':cid',$this->id,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':u_id',$this->current_user,PDO::PARAM_INT);
        }elseif($type === 'all'){
            $this->dbsql = "DELETE FROM {$this->table7} WHERE u_id = :u_id";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':u_id',$this->current_user,PDO::PARAM_INT);
        }
        if($type !== 'selective'){
            require_once(file_location('inc_path','session_destroy.inc.php'));
        }
        if($type !== 'login_signup'){
            if($this->dbstmt->execute()){return 'success';}else{return 'fail';}
        }
    }
    
    
    public function update_profile_data(){
        $this->dbsql = "UPDATE {$this->table} SET u_fullname = :fullname, u_bio = :bio, u_website = :website, u_state = :state WHERE u_id = :id LIMIT 1";
        $this->dbstmt =  $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':fullname',$this->fullname,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':bio',$this->bio,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':website',$this->website,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':state',$this->state,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return 'success';}else{return 'fail';} 
    }//end of update profile data
    
    public function update_user_data($type='current_user'){
        $this->dbsql = "UPDATE {$this->table} SET {$this->col} = :value WHERE u_id = :id LIMIT 1";
        $this->dbstmt =  $this->dbconn->prepare($this->dbsql);
		$this->dbstmt->bindParam(':value',$this->data,PDO::PARAM_STR);
        if($type === 'current_user'){
            $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
        }else{
            $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        }
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return 'success';}else{return 'fail';} 
    }//end of update user data
    
    public function update_user_settings(){
        if(content_data($this->table3,'s_id',$this->current_user,'u_id') === false){//if user has no row in setting db
            $this->dbsql = "INSERT INTO {$this->table3}($this->col,u_id) VALUES(:value,:id)";
        }else{
            $this->dbsql = "UPDATE {$this->table3} SET {$this->col} = :value WHERE u_id = :id LIMIT 1";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':value',$this->value,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return 'success';}else{return 'fail';}
    }
    
    public function delete_account(){
        $this->dbsql = "DELETE FROM {$this->table} WHERE u_id = :id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return 'success';}else{return 'fail';}
    }
    
    public function refresh(){
        if(content_data($this->table4,'lr_id',$this->current_user,'u_id') === false){
            $this->dbsql = "INSERT INTO {$this->table4}(u_id) VALUES(:id)";
        }else{
            if($this->type === 'home'){
                $this->dbsql = "UPDATE {$this->table4} SET lr_homepage_datetime = NOW() WHERE u_id = :id";
            }else{
                $this->dbsql = "UPDATE {$this->table4} SET lr_all_datetime = NOW() WHERE u_id = :id";
            }
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
        if($this->dbstmt->execute()){return 'success';}else{return 'fail';}
    }//emd of refresh
    
    public function change_image($type){
        if($type === 'profile_pics'){
            $default = "home/avatar.png";
            $type_link = "um_profilepics_link_name";
            $type_extension = "um_profilepics_extension";
        }elseif($type === 'cover_pics'){
            $default = "home/cover.jpg";
            $type_link = "um_coverpics_link_name";
            $type_extension = "um_coverpics_extension";
        }
        $this->full_file_name = get_media($type,$this->current_user);
        $this->full_path = file_location('media_path',$this->full_file_name);
        if(content_data($this->media_table,'u_id',$this->current_user,'u_id') !== false){
            $this->dbsql = "UPDATE {$this->media_table} SET {$type_link} = :link_name,{$type_extension} = :extension WHERE u_id = :id LIMIT 1";
        }else{
            $this->dbsql = "INSERT INTO {$this->media_table}({$type_link},{$type_extension},u_id)VALUES(:link_name,:extension,:id)";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':link_name',$this->file_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){
            //delete the current image
            if(file_exists($this->full_path) && $this->full_file_name !== $default && is_file($this->full_path)){unlink($this->full_path);}
            return 'success';
        }else{
            //delete image
            $this->full_file_name = $this->file_name.".".$this->extension;
            $this->full_path = file_location('media_path',"{$type}/".$this->full_file_name);
            if(file_exists($this->full_path) && $this->full_file_name !== $default && is_file($this->full_path)){unlink($this->full_path);}
            return 'fail';
        }
    }//end of store user image
    
    public function follow_and_unfollow(){
        if($this->action === 'follow'){ //if there is 0 follow row in database
            $this->dbsql = "INSERT INTO {$this->table5}(follower_id,followee_id) VALUES(:follower_id,:followee_id)";
        }else{
            $this->dbsql = "DELETE FROM {$this->table5} WHERE follower_id = :follower_id AND followee_id = :followee_id LIMIT 1";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':follower_id',$this->current_user,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':followee_id',$this->followee_id,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return 'success';}else{return 'fail';}
    }//end of follow and unfollow
    
    public function block_and_unblock(){
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            // block or ublock
            if($this->action === 'block'){ //if there is 0 block row in database
                $this->dbsql = "INSERT INTO {$this->table6}(blocker_id,blockee_id) VALUES(:blocker_id,:blockee_id)";
            }else{
                $this->dbsql = "DELETE FROM {$this->table6} WHERE blocker_id = :blocker_id AND blockee_id = :blockee_id LIMIT 1";
            }
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':blocker_id',$this->current_user,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':blockee_id',$this->blockee_id,PDO::PARAM_INT);
            $this->dbstmt->execute();
            //delete where current user follows the blockee and vice-versa
            $this->dbsql = "DELETE FROM {$this->table5} WHERE follower_id IN (:follower_id,:followee_id) AND followee_id IN (:follower_id,:followee_id) LIMIT 2";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':follower_id',$this->current_user,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':followee_id',$this->blockee_id,PDO::PARAM_INT);
            $this->dbstmt->execute();// commit the transation
            if($this->dbconn->commit()){
                return 'success';
            }//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return 'fail';}
        }
    }//end of follow and unfollow
}
?>