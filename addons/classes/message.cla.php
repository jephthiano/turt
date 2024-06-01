<?php
class message{
    private $table = 'message_table';
    private $media_table = 'message_media_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $file_name;
    public $extension;
    
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
    
    
    public function send_message(){
         $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            try{
                //begin transaction
                $this->dbconn->beginTransaction();
                $this->dbsql = "INSERT INTO {$this->table}(m_message,m_type,sender_id,receiver_id) VALUES(:message,:type,:sender_id,:chatter_id)";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':message',$this->message,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':chatter_id',$this->chatter_id,PDO::PARAM_INT);
                $this->dbstmt->bindParam(':sender_id',$this->current_user,PDO::PARAM_INT);
                $this->dbstmt->execute();
                if($this->type !== 'text'){
                    $this->last_id =  $this->dbconn->lastInsertId(); //last id
                    // insert message imagge
                    $this->dbsql = "INSERT INTO {$this->media_table}(mm_type,mm_link_name,mm_extension,m_id) VALUES(:type,:file_name,:extension,:id)";
                    $this->dbstmt =  $this->dbconn->prepare($this->dbsql);
                    $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
                    $this->dbstmt->bindParam(':file_name',$this->file_name,PDO::PARAM_STR);
                    $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
                    $this->dbstmt->bindParam(':id',$this->last_id,PDO::PARAM_STR);
                    $this->dbstmt->execute();   
                }
                // commit the transation
                if($this->dbconn->commit()){
                    return 'success';
                }//if commit
            }catch(PDOException $e){
                //rollback
                if($this->dbconn->rollback()){
                    if($this->type !== 'text'){
                        //delete file
                        $full_file_path = file_location('media_path','message/'.$this->file_name.".".$this->extension);
                        unlink($full_file_path);
                    }
                    return 'fail';
                }//if rollback
            }// end of try and catch   
    }//end of insert message
    
    public function update_status($type){
        if($type === 'deliver'){
			$this->dbsql = "UPDATE {$this->table} SET m_status = 'delivered' WHERE m_status = 'sent' AND receiver_id = :u_id";
			$this->dbstmt = $this->dbconn->prepare($this->dbsql);
        }elseif($type === 'awared'){
            $this->dbsql = "UPDATE {$this->table} SET m_status = 'awared' WHERE m_status IN('sent','delivered') AND receiver_id = :u_id";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        }elseif($type === 'seen'){
            $this->dbsql = "UPDATE {$this->table} SET m_status = 'seen' WHERE m_status IN('sent','delivered','awared') AND receiver_id = :u_id AND sender_id = :sid";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':sid',$this->chatter_id,PDO::PARAM_INT);
        }
        $this->dbstmt->bindParam(':u_id',$this->current_user,PDO::PARAM_INT);
		if($this->dbstmt->execute()){return 'success';}else{return 'fail';}
    }
}
?>