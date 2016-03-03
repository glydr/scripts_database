<?php


class AudienceMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $audience = new Audience($row['description']);
        $audience->setId($row['id']);
        $audience->setActive_ind($row['active_ind']);
        if (isset($row['cnt'])) {
            $audience->setCount($row['cnt']);
        }
        
        $this->addToMap($audience);
        return $audience;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM target_audience WHERE id = " . $id;
    }
    
    public function findAllByScriptId($script_id) {
        $sql = "SELECT ta.* 
                FROM script_target_reltn str,
                    target_audience ta
                WHERE str.script_id = $script_id
                  AND str.active_ind = 1
                  AND ta.id = str.target_audience_id";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new AudienceCollection($results, $this);
        } else {
            return new AudienceCollection();
        }        
    }

    public function findAll() {
        $sql = "SELECT * FROM target_audience WHERE active_ind = 1";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new AudienceCollection($results, $this);
        } else {
            return new AudienceCollection();
        }
    }
    
    public function findAllDistinctThatHaveScripts() {
        $sql = "SELECT DISTINCT ta.* 
                FROM target_audience ta
                INNER JOIN script_target_reltn str ON str.target_audience_id = ta.id
                WHERE ta.active_ind = 1";
        $sql = "SELECT ta.id, ta.active_ind, ta.description, count(*) as cnt
                FROM target_audience ta
                INNER JOIN script_target_reltn str ON str.target_audience_id = ta.id
                WHERE ta.active_ind = 1
                GROUP BY ta.description";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new AudienceCollection($results, $this);
        } else {
            return new AudienceCollection();
        }
    }
    
    public function insertAudienceReltnForScript($script_id, Audience $audience) {
        $sql = "INSERT INTO script_target_reltn
                (id, script_id, target_audience_id, active_ind)
                VALUES(null, $script_id, {$audience->getId()}, 1)";
        return $this->db->execute($sql);
    }
    
    public function removeAudienceReltnForScript($script_id, Audience $audience) {
        $sql = "UPDATE script_target_reltn
                SET 
                    active_ind = 0
                WHERE script_id = $script_id
                  AND target_audience_id = {$audience->getId()}";
        return $this->db->execute($sql);
    }

    public function updateAudienceReltnForScript($script_id, AudienceCollection $audienceCollection) {
        $existingRelations = $this->findAllByScriptId($script_id);
        
        $audiencesToAdd = AudienceCollection::collection_diff($existingRelations, $audienceCollection);
        $audiencesToRemove = AudienceCollection::collection_diff($audienceCollection, $existingRelations);
        
        $success = TRUE;
        if ($audiencesToAdd && $audiencesToAdd->getCount() > 0) {
            foreach ($audiencesToAdd as $audience) {
                if (!$this->insertAudienceReltnForScript($script_id, $audience)) {
                    $success = FALSE;
                }
            }
        }
        if ($audiencesToRemove && $audiencesToRemove->getCount() > 0) {
            foreach ($audiencesToRemove as $audience) {
                $audience->setActive_ind(0);
                if (!$this->removeAudienceReltnForScript($script_id, $audience)) {
                    $success = FALSE;
                }
            }
        }
        return $success;
    }
    
    public function targetClass() {
        return 'Audience';
    }

}

?>
