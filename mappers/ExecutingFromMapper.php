<?php


class ExecutingFromMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $executingFrom = new ExecutingFrom($row['description']);
        $executingFrom->setId($row['id']);
        $executingFrom->setActive_ind($row['active_ind']);
        $this->addToMap($executingFrom);
        return $executingFrom;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM executing_from WHERE id = " . $id;
    }
    
    public function findAll() {
        $sql = "SELECT * FROM executing_from WHERE active_ind = 1";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new ExecutingFromCollection($results, $this);
        } else {
            return new ExecutingFromCollection();
        }
    }
    
    public function targetClass() {
        return 'ExecutingFrom';
    }


}

?>
