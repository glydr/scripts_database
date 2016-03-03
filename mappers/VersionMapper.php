<?php


class VersionMapper extends BaseMapper {
    private $tableMapper;
    private $sourceCodeMapper;
    
    function __construct(Database $db, TableMapper $tableMapper, SourceCodeMapper $sourceCodeMapper) {
        parent::__construct($db);
        $this->tableMapper = $tableMapper;
        $this->sourceCodeMapper = $sourceCodeMapper;
    }
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $version = new Version();
        $version->setId($row['id']);
        $version->setSource_name($row['source_name']);
        $version->setBeg_eff_dt_tm($row['beg_eff_dt_tm']);
        $version->setEnd_eff_dt_tm($row['end_eff_dt_tm']);
        $version->setSeq($row['seq']);
        $version->setUser_id($row['user_id']);
        $version->setScript_id($row['script_id']);
        $version->setVersion_info($row['version_info']);
        $tableCollection = $this->tableMapper->findAllByVersionId($version->getId());
        $version->setTables($tableCollection);
        $source = $this->sourceCodeMapper->findByVersionId($version->getId());
        if ($source) {
            $version->setSource($source);
        } else {
            $version->setSource(new SourceCode(''));
        }
        $this->addToMap($version);
        return $version;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM versions WHERE id=" . $id;
    }

    public function findAllByScriptId($id) {
        $sql = "SELECT * FROM versions WHERE script_id=" . $id;
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new VersionCollection($results, $this);
        } else {
            return new VersionCollection();
        }
    }
    
    public function insert(Version $version) {
        $description = htmlentities($this->db->realEscapeString($version->getVersion_info()));
        $this->db->disableAutoCommit();
        
        try {
            $insert = "INSERT INTO versions 
                    (id, beg_eff_dt_tm, end_eff_dt_tm, user_id, version_info, seq, script_id, source_name) 
                    VALUES (null, '{$version->getBeg_eff_dt_tm()}', '{$version->getEnd_eff_dt_tm()}',
                    {$version->getUser_id()}, '$description', {$version->getSeq()},
                    {$version->getScript_id()}, '{$version->getSource_name()}')";
			
            if( ! $result = $this->db->execute($insert)) {
                throw new Exception($this->db->lastError());
            }
            $version->setId($this->db->getLastInsertRowId());
            $this->addToMap($version);
            
            // Insert tables
            foreach ($version->getTables() as $table) {
                if (!$this->tableMapper->insertTableReltnForVersion($version->getId(), $table)) {
                    throw new Exception($this->db->lastError());
                }
            }
            
            // Insert the source code
            $version->getSource()->setVersion_id($version->getId());
            if (!$this->sourceCodeMapper->insert($version->getSource())) {
                throw new Exception($this->db->lastError());
            }
            
            // Commit if successful
            if (!$this->db->commit()) {
                throw new Exception($this->db->lastError());
            }  
            $this->db->enableAutoCommit();
            return true;
            
        } catch (Exception $e) {
            // Rollback if not
            echo $e;
            $this->errorMessage = "Unable to save, please try again.";
            $this->db->rollback();
            $this->db->enableAutoCommit();
            return false;
        }
    }
    
    public function update(Version $version) {
        $description = htmlentities($this->db->realEscapeString($version->getVersion_info()));
        $this->db->disableAutoCommit();
        
        try {
            $update = "UPDATE versions 
                        SET beg_eff_dt_tm = '{$version->getBeg_eff_dt_tm()}',
                            end_eff_dt_tm = '{$version->getEnd_eff_dt_tm()}', 
                            user_id = {$version->getUser_id()}, 
                            version_info = '$description', 
                            seq = {$version->getSeq()}, 
                            script_id = {$version->getScript_id()},
                            source_name = '{$version->getSource_name()}'
                        WHERE id = {$version->getId()}";
            if( ! $result = $this->db->execute($update)) {
                throw new Exception($this->db->lastError());
            }
            
            if (!$this->tableMapper->updateTableRelationsForVersion($version->getId(), $version->getTables())) {
                throw new Exception($this->db->lastError());
            }
            
            // Update the source code
            $version->getSource()->setVersion_id($version->getId());
            if (!$this->sourceCodeMapper->update($version->getSource())) {
                throw new Exception($this->db->lastError());
            }
            
            // Commit if successful
            if (!$this->db->commit()) {
                throw new Exception($this->db->lastError());
            }  
            $this->db->enableAutoCommit();
            return true;
            
        } catch (Exception $e) {
            // Rollback if not
            echo $e;
            $this->errorMessage = "Unable to save, please try again.";
            $this->db->rollback();
            $this->db->enableAutoCommit();
            return false;
        }
    }
    
    public function targetClass() {
        return 'Version';
    }

}

?>
