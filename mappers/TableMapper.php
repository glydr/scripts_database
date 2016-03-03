<?php


class TableMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $table = new Table($row['name']);
        $table->setId($row['id']);
        $this->addToMap($table);
        return $table;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM tables WHERE id=" . $id;
    }
    
    public function findByName($name) {
        $name = $this->db->realEscapeString($name);
        $sql = "SELECT * FROM tables WHERE name = '$name' ORDER BY name ASC";
        $this->db->query($sql);
        if ($row = $this->db->getNextResult()) {
            return $this->createObject($row);
        } else {
            return false;
        }
    }
    
    public function findAll() {
        $sql = "SELECT DISTINCT t.* 
                FROM tables t
                WHERE ucase(t.name) != 'DUMMYT'
                ORDER BY t.name";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new TableCollection($results, $this);
        } else {
            return new TableCollection();
        }        
    }
    
    public function findAllByVersionId($version_id) {
        $sql = "SELECT DISTINCT t.* 
                FROM version_table_reltn vtr,
                    tables t
                WHERE vtr.version_id = $version_id 
                AND ucase(t.name) != 'DUMMYT'
                AND t.id = vtr.table_id
                ORDER BY t.name";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new TableCollection($results, $this);
        } else {
            return new TableCollection();
        }
    }
    
    public function insert(Table $table) {
        $name = $this->db->realEscapeString($table->getName());
        $sql = "INSERT INTO tables
                (id, name) 
                VALUES(null, '$name')";
        $result = $this->db->execute($sql);
        if ($result === TRUE) {
            $table->setId($this->db->getLastInsertRowId());
            $this->addToMap($table);
        }
        return $result;
    }
    
    public function insertTableReltnForVersion($version_id, Table $table) {
        $sql = "INSERT INTO version_table_reltn
                (id, table_id, version_id, active_ind)
                VALUES(null, {$table->getId()}, $version_id, 1)";
        return $this->db->execute($sql);
    }
    
    public function removeTableReltnForVersion($version_id, Table $table) {
        $sql = "UPDATE version_table_reltn
                SET 
                    active_ind = 0
                WHERE version_id = $version_id
                  AND table_id = {$table->getId()} AND version_id = $version_id";
        return $this->db->execute($sql);
    }

    public function updateTableRelationsForVersion($version_id, TableCollection $tableCollection) {
        $existingRelations = $this->findAllByVersionId($version_id);
        
        $tablesToAdd = TableCollection::collection_diff($existingRelations, $tableCollection);
        $tablesToRemove = TableCollection::collection_diff($tableCollection, $existingRelations);
        
        $success = TRUE;
        if ($tablesToAdd && $tablesToAdd->getCount() > 0) {
            foreach ($tablesToAdd as $table) {
                if (!$this->insertTableReltnForVersion($version_id, $table)) {
                    $success = FALSE;
                }
            }
        }
        if ($tablesToRemove && $tablesToRemove->getCount() > 0) {
            foreach ($tablesToRemove as $table) {
                $table->setActive_ind(0);
                if (!$this->removeTableReltnForVersion($version_id, $table)) {
                    $success = FALSE;
                }
            }
        }
        return $success;
    }
    
    public function targetClass() {
        return 'Table';
    }

}

?>
