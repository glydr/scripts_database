<?php

abstract class BaseMapper {
    protected $db;
    protected $errorMessage;
    
    function __construct($db) {
        $this->db = $db;
    }
    
    public function find($id) {
        $old = $this->getFromMap($id);
        if ($old) { return $old; }
        $sql = $this->getFindSQLStatement($id);
        $this->db->query($sql);
        if ($row = $this->db->getNextResult()) {
            return $this->createObject($row);
        } else {
            return false;
        }
    }
    
    abstract function getFindSQLStatement($id);
    abstract function createObject($row);
    abstract function targetClass();
    
    public function getErrorMessage() {
        return $this->errorMessage;
    }

    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    protected function addToMap(DomainObject $obj) {
        return ObjectWatcher::add($obj);
    }
    
    protected function getFromMap($id) {
        return ObjectWatcher::exists($this->targetClass(), $id);
    }

}

?>
