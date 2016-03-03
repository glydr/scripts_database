<?php

class TableBuilderFromInsert {
    
    private $sql;
    private $insertQuery;
    private $dropTableIfExists;
    
    function __construct(InsertQuery $insertQuery, $dropTableIfExists) {
        $this->insertQuery = $insertQuery;
        $this->dropTableIfExists = $dropTableIfExists;
    }
    
    public function viewSQL() {
        return $this->makeSQL();
    }
    
    public function createTable(Database $db) {
        $sql = $this->makeSQL();
        $db->execute($sql);
        
        if ($db->getError_num()) {
            echo '<br>' . $db->lastError();
        }
    }
    
    private function makeSQL() {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->insertQuery->getTable() . '` ('
            . '`id` int(11) NOT NULL AUTO_INCREMENT,'
            . $this->insertQuery->getFieldBuiler()
            . ', PRIMARY KEY (`id`)'
            . ') ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1; ';
        return $sql;
    }
}
?>
