<?php

class Database
{
    protected $link;
    protected $result;
    protected $num_rows;
    protected $rows_remaining;
    protected $error_num;
    protected $error_msg;
    
    protected $host;
    protected $user;
    protected $password;
    protected $database;
    
    function __construct($host, $user, $password, $database) 
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect() 
    {
        $this->link = new mysqli($this->host, $this->user, $this->password, $this->database);

        if (mysqli_connect_errno())
        {	
            $this->error_num = mysqli_errno($this->link);
            $this->error_msg = mysqli_error($this->link);
            return false;
        }
        return true;
    }
    
    public function query($sql)
    {
//        $this->writeToLog($sql);
        $this->result = mysqli_query($this->link, $sql);
        if ($this->result) {
            $this->num_rows = $this->result->num_rows;
            $this->rows_remaining = $this->result->num_rows;;
            return true;
        } else {
            $this->error_num = mysqli_errno($this->link);
            $this->error_msg = mysqli_error($this->link);
            return false;
        }
    }
    
    public function execute($sql)
    {
//        $this->writeToLog($sql);
        $this->result = mysqli_query($this->link, $sql);
        if (!$this->result) {
            $this->error_num = mysqli_errno($this->link);
            $this->error_msg = mysqli_error($this->link);
            return false;
        }
        return true;
    }
    
    public function getLastInsertRowId()
    {
        return mysqli_insert_id($this->link);
    }
    
    public function realEscapeString($string)
    {
        return mysqli_real_escape_string($this->link, $string);
    }
    
    public function getNumAffectedRows()
    {
        return $this->link->affected_rows;
    }
    
    public function getNextResult()
    {
        if ($this->rows_remaining > 0) {
            $this->rows_remaining = $this->rows_remaining - 1;
            $result = $this->result;
            return $result->fetch_assoc();
        }
    }
    
    public function getAllResults()
    {
        $results = array();
        while ($this->rows_remaining > 0) {
            $results[] = $this->getNextResult();
        }
        return $results;
    }
    
    public function lastError()
    {
        return "Error num: " . $this->error_num . " message: " . $this->error_msg;
    }

    public function getNum_rows() {
        return $this->num_rows;
    }

    public function getError_num() {
        return $this->error_num;
    }
    
    public function disableAutoCommit() {
        $this->link->autocommit(FALSE);
    }
    
    public function enableAutoCommit() {
        $this->link->autocommit(TRUE);
    }

    public function commit() {
        if ( ! $this->link->commit() ) {
            $this->error_num = mysqli_errno($this->link);
            $this->error_msg = mysqli_error($this->link);
            return false;
        }
        return true;
    }
    
    public function rollback() {
        $this->link->rollback();
    }

    private function writeToLog($sql) {
        $logFile = "sql_log";
        error_log("----------------------------------------------------\n", 3, $logFile);
        error_log("$sql\n", 3, $logFile);
        error_log("\n", 3, $logFile);

    }
}

?>