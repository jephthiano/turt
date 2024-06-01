<?php
class notification{
    private $table = 'notification_table';
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
    
    public function insert_notification(){
        $this->dbsql = "INSERT INTO {$this->table}(n_type,n_content_id,receiver_id,sender_id)
        VALUES(:type,:content_id,:receiver_id,:sender_id)";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':content_id',$this->content_id,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':receiver_id',$this->receiver_id,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':sender_id',$this->current_user,PDO::PARAM_INT);
        if($this->dbstmt->execute()){return 'success';}else{return 'fail';}
    }//end insert cookie
    
    public function update_status($type='all'){
        if($type === 'all'){
            $this->dbsql = "UPDATE {$this->table} SET n_status = 'awared' WHERE receiver_id = :receiver_id AND n_status = 'sent'";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        }elseif($type === 'type'){
            $this->dbsql = "UPDATE {$this->table} SET n_status = 'seen' WHERE receiver_id = :receiver_id AND n_type = :type AND n_status IN ('sent','awared')";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
        }
        $this->dbstmt->bindParam(':receiver_id',$this->current_user,PDO::PARAM_INT);
        if($this->dbstmt->execute()){return 'success';}else{return 'fail';}    
        
    }
}
?>