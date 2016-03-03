<?php


class ReportMapper extends BaseMapper {
    private $versionMapper;
    
    function __construct(Database $db, VersionMapper $versionMapper) {
        parent::__construct($db);
        $this->versionMapper = $versionMapper;
    }
    
    public function getFindSQLStatement($id) {
        return "SELECT * FROM scripts WHERE id=" . $id;
    }
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $report = new Report($row['object_name']);
        $report->setId($row['id']);
        $report->setTitle($row['title']);
        $report->setDescription($row['description']);
        $report->setSn_task_num($row['sn_task_num']);
        $report->setMinistry($row['ministry_id']);
        $am = new AudienceMapper($this->db);
        $audienceCollection = $am->findAllByScriptId($row['id']);
        $report->setAudiences($audienceCollection);
        $report->setExecutedLocations($row['executed_from']);
        $versionCollection = $this->versionMapper->findAllByScriptId($report->getId());
        $report->setVersions($versionCollection);
        $this->addToMap($report);
        return $report;
    }
    
    public function findByObjectNameAndMinistry($name, $ministry_id) {
        $name = $this->db->realEscapeString($name);
        $sql = "SELECT * FROM scripts WHERE object_name = '$name' and ministry_id = $ministry_id";
        $this->db->query($sql);
        if ($row = $this->db->getNextResult()) {
            return $this->createObject($row);
        } else {
            return false;
        }
    }
    
    public function findByVersionId($id) {
        $sql = "SELECT * FROM versions v, scripts s 
                WHERE v.id = $id AND s.id = v.script_id";
        $this->db->query($sql);
        if ($row = $this->db->getNextResult()) {
            return $this->createObject($row);
        } else {
            return false;
        }
    }
    
    public function insert(Report $report) {
        $title = htmlentities($this->db->realEscapeString($report->getTitle()));
        $description = htmlentities($this->db->realEscapeString($report->getDescription()));
        
        $insert = "INSERT INTO scripts 
                (id, object_name, description, title, ministry_id) 
                VALUES (null, '{$report->getObject_name()}', 
                '$description', '$title', {$report->getMinistry()})";
		
        if(!$this->db->execute($insert)) {
            $this->errorMessage = "Unable to save, please try again.";
			$this->errorMessage = $this->db->lastError();
            return FALSE;
        } else {
            $report->setId($this->db->getLastInsertRowId());
            $this->addToMap($report);
            return TRUE;
        }
    }

    public function update(Report $report) {
        $title = htmlentities($this->db->realEscapeString($report->getTitle()));
        $description = htmlentities($this->db->realEscapeString($report->getDescription()));
        
        $update = "UPDATE `scripts` 
                    SET 
                        `description`='$description',
                        `title`='$title',
                        `sn_task_num`='{$report->getSn_task_num()}',
                         executed_from = '{$report->getExecutedLocations()}'
                    WHERE `id` = {$report->getId()}";
        if (!$this->db->execute($update)) {
            $this->errorMessage = "Unable to save, please try again.";
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function targetClass() {
        return 'Report';
    }

}

?>
