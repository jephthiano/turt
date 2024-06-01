<?php
class token_code{
    private $table = 'token_code_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $code;
    public $content;
    public $regdatetime;
    public $type;
    
    public function __construct($conn = ''){
        if(!empty($conn)){
            //CREATE CONNECTION
            require_once(file_location('inc_path','connection.inc.php'));
            $this->dbconn = dbconnect($conn,'PDO');
        }
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
    
    
    public function run_user_request(){
        if($this->type === 'insert' && content_data($this->table,'c_content',$this->content,'c_content') === false){
            $this->dbsql = "INSERT INTO {$this->table}(c_code,c_content) VALUES(:code,:content)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':code',$this->code,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':content',$this->content,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }elseif($this->type === 'update'){
            $this->dbsql = "UPDATE {$this->table} SET c_verify = 'yes' WHERE c_code = :code AND c_content = :content";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':code',$this->code,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':content',$this->content,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }elseif($this->type === 'delete'){
            delete_user_token_cookie();
            $this->dbsql = "DELETE FROM {$this->table} WHERE c_content = :content LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':content',$this->content,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }
    }//end of run request
}
?>