<?php


class MinistryMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $ministry = new Ministry($row['name']);
        $ministry->setId($row['id']);
        $ministry->setActive_ind($row['active_ind']);
        $this->addToMap($ministry);
        return $ministry;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM ministry WHERE id = " .$id;
    }
    
    public function findAll() {
        $sql = "SELECT * FROM ministry WHERE active_ind = 1";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new MinistryCollection($results, $this);
        } else {
            return new MinistryCollection();
        }
    }

    public function targetClass() {
        return 'Ministry';
    }

}

?>
