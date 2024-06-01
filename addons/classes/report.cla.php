<?php
class report{
    private $table = 'report_table';
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
    
    public function insert_report(){
        $this->dbsql = "INSERT INTO {$this->table}(rp_type,rp_content_id,rp_report,reportee_id,reporter_id)
        VALUES(:type,:content_id,:report,:reportee_id,:reporter_id)";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':content_id',$this->content_id,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':report',$this->report,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':reportee_id',$this->reportee_id,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':reporter_id',$this->current_user,PDO::PARAM_INT);
        if($this->dbstmt->execute()){return 'success';}else{return 'fail';}
    }//end insert cookie
}
?>