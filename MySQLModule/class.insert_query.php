<?php

class InsertQuery {
    
    private $table;
    private $field_cnt;
    private $fields;
    private $values;    
    private $fieldBuiler;
    
    function __construct($table) {
        $this->table = $table;
        $this->field_cnt = 0;
    }
        
    public function addDataToInsert($key, $data) {
        if (is_string($data)) {
            $this->addStringToInsert($key, trim($data));
        } elseif (is_int($data)) {
            $this->addIntToInsert($key, $data);
        } elseif (is_float($data)) {
            $this->addFloatToInsert($key, $data);
        } else {
            echo '<br>' . $key . ':' . $data . ' type cannot be determined';
        }
    }
    
    public function addStringToInsert($field, $value) {
        $this->addToBuilder('varchar(50) NOT NULL', $field);
        $this->addToInsert($field, "'" . $value . "'");
    }
    public function addIntToInsert($field, $value) {
        $this->addToBuilder('int(11) NOT NULL', $field);
        $this->addToInsert($field, intval($value));
    }
    public function addDateTimeToInsert($field, $value) {
        $this->addToBuilder('datetime NOT NULL', $field);
        $this->addToInsert($field, "'" . $value . "'");
    }
    public function addFloatToInsert($field, $value) {
        $this->addToBuilder('float NOT NULL', $field);
        $this->addToInsert($field, $value);
    }
    
    private function addToInsert($field, $value) {
        if ($this->field_cnt == 0) {
            $this->fields = '`' . $field . '`';
            $this->values = $value;
            $this->field_cnt++;
        } else {
            $this->fields .= ', `' . $field . '`';
            $this->values .= ', ' . $value;            
        }
    }
    
    private function addToBuilder($type, $field) {
        if ($this->field_cnt == 0) {
            $this->fieldBuiler = '`' . $field . '` ' . $type;
        } else {
            $this->fieldBuiler .= ', `' . $field . '` ' . $type;
        }        
    }
    
    public function getQuery() {
        $sql = 'INSERT INTO `' . $this->table . '`'
                . ' (' . $this->fields . ') '
                . 'VALUES (' . $this->values . ')';
        return $sql;
    }
    
    public function getFieldBuiler() {
        return $this->fieldBuiler;
    }
    
    public function getTable() {
        return $this->table;
    }

    public function insertRow(Database $db) {
        $db->execute($this->getQuery());
        if ($db->getLastInsertRowId() == 0) {
            echo $db->lastError();
        } else {
            echo "Success";
        }
    }

}
?>
