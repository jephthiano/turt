<?php
class search_history{
    private $table = 'search_history_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    private $text;
    private $new_text;
    private $current_user;
    
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
    
    
    public function run_request(){
        if($this->text === false){
            $this->dbsql = "INSERT INTO {$this->table}(sh_text,u_id) VALUES(:new_text,:user_id)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':new_text',$this->search_text,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':user_id',$this->current_user,PDO::PARAM_INT);
            if($this->dbstmt->execute()){return true;}else{return false;}   
        }else{
            $this->search_array = explode('|',$this->text);
			$len = count($this->search_array);
				for($i = 0;$i <= $len; $i++){ // remove word that is the same as curren search history
					if(@$this->search_array[$i] === $this->search_text){
						$error[] = 'search exists';
                        array_splice($this->search_array,$i,1);//DELETE THE SEARCH IN ARRAY TEXT
					}
				}
				if($len === 1 && !empty($error)){ //if only one value is in search history and the word is not searchtext
					$this->new_text = implode("|",$this->search_array).$this->search_text;
				}else{
					$this->new_text = implode("|",$this->search_array)."|".$this->search_text;
				}
            $this->dbsql = "UPDATE {$this->table} SET sh_text = :new_text WHERE u_id = :user_id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':new_text',$this->new_text,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':user_id',$this->current_user,PDO::PARAM_INT);
            if($this->dbstmt->execute()){return true;}else{return false;}   
        }
    }//end of run_request
}
?>