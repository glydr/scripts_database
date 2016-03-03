<?php


class SourceCodeMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $source = new SourceCode($row['source']);
        $source->setId($row['id']);
        $source->setVersion_id($row['version_id']);
        $this->addToMap($source);
        return $source;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM source_code WHERE id=" . $id;
    }
    
    public function findByVersionId($version_id) {
        $sql = "SELECT * FROM source_code WHERE version_id = $version_id";
        $this->db->query($sql);
        if ($row = $this->db->getNextResult()) {
            return $this->createObject($row);
        } else {
            return false;
        }
    }
    
    public function insert(SourceCode $source) {
        $source_code = $this->db->realEscapeString($source->getSource());
        $sql = "INSERT INTO source_code 
                (id, version_id, source) 
                VALUES(null, {$source->getVersion_id()}, '$source_code')";
        if ($this->db->execute($sql)) {
             $source->setId($this->db->getLastInsertRowId());
             $this->addToMap($source);
             return TRUE;
         } else {
             return FALSE;
         }
    }
    
    public function update(SourceCode $source) {
        $source_code = $this->db->realEscapeString($source->getSource());
        $sql = "UPDATE source_code 
                SET
                    version_id = {$source->getVersion_id()}, 
                    source = '{$source_code}'
                WHERE id = {$source->getId()}";
        return $this->db->execute($sql);
    }

    public function targetClass() {
        return 'SourceCode';
    }

}

?>
