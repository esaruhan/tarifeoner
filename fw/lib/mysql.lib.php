<?php

class Database {

    private $DbLink = false;
    private $DbHost = "";
    private $DbUser = "";
    private $DbPass = "";
    private $DbName = "";
    private $DbErrors = array();
    private $DbErrorNum = 0;
    private $DbResultSet = null;

    public function __construct($db) {
        global $mysqlInfo; 
        if($db){
            self::_setDb($mysqlInfo);
        }
        self::_Connect();
        if ($this->DbLink)
            self::_SelectDb();
    }
    private function _setDb($data){
        $this->DbHost=$data['host'];
        $this->DbUser=$data['user'];
        $this->DbPass=$data['password'];
        $this->DbName=$data['database'];
    }
    public function __deconstruct() {
        self::_Disconnect();
    }

    private function _Connect() {
        $this->DbLink = mysql_connect($this->DbHost . ":3306", $this->DbUser, $this->DbPass);
        if (!$this->DbLink) {
            $this->DbErrors[$this->DbErrorNum++] = mysql_error($this->DbLink);
        }
    }

    private function _Disconnect() {
        mysql_close($this->DbLink);
    }

    private function _SelectDB() {
        if (!mysql_select_db($this->DbName, $this->DbLink))
            $this->DbErrors[$this->DbErrorNum++] = mysql_error($this->DbLink);
        else {
            mysql_query("SET NAMES 'utf8'");
            mysql_query("SET CHARACTER SET utf8");
            mysql_query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");
        }
    }

    public function Query($query, $getResultSet=true) {
        
        //@todo: real escape yapmayi unutma
        $this->DbResultSet = mysql_query($query, $this->DbLink);
        
        if (!$this->DbResultSet) {
            $this->DbErrors[$this->DbErrorNum++] = mysql_error($this->DbLink);
            return $this->DbErrors;
        } else if ($getResultSet) {
            return $this->_GetResultSet();
            
        }
    }

    public function AffectedRows() {
        return mysql_affected_rows($this->DbLink);
    }

    public function InsertID() {
        return mysql_insert_id($this->DbLink);
    }
    
    public function FetchAssoc(){
        return mysql_fetch_assoc($this->DbResultSet);
    }
    
    public function NumRows(){
        return mysql_num_rows($this->DbResultSet);
    }

    private function _GetResultSet() {
        return $this->DbResultSet;
    }

    function _GetErrors() {
        return $this->DbErrors;
    }
    
}

?>
