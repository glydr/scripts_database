<?php


class QueueMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $item = new QueueItem($row['user_id'], $row['report_id'], $row['version_seq']);
        $item->setActive_ind($row['active_ind']);
        $item->setId($row['id']);
        $item->setObject_name($row['object_name']);
        $this->addToMap($item);
        return $item;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM queue WHERE id = $id";
    }
    
    public function findAllByUserId($user_id) {
        $sql = "SELECT queue.*, scripts.object_name
                FROM queue, scripts
                WHERE queue.user_id = $user_id 
                AND queue.active_ind = 1
                AND scripts.id = queue.report_id";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new QueueItemCollection($results, $this);
        } else {
            return new QueueItemCollection();
        }
    }
    
    public function insert(QueueItem $item) {
        $insert = "INSERT INTO `queue`
            (`id`, `user_id`, `report_id`, `version_seq`, `active_ind`) 
            VALUES(null, {$item->getUser_id()}, '{$item->getReport_id()}',
            {$item->getVersion_seq()}, {$item->getActive_ind()})";
        if ($this->db->execute($insert)) {
             $item->setId($this->db->getLastInsertRowId());
             $this->addToMap($item);
             return TRUE;
         } else {
             return FALSE;
         }
    }
    
    public function update(QueueItem $item) {
        $update = " UPDATE `queue` 
                    SET 
                        `report_id`='{$item->getReport_id()}',
                        `version_seq`={$item->getVersion_seq()},
                        `user_id`={$item->getUser_id()},
                        `active_ind`={$item->getActive_ind()}
                    WHERE id = {$item->getId()}";
        if ($this->db->execute($update)) {
             return TRUE;
         } else {
             return FALSE;
         }
    }
    
    public function targetClass() {
        return 'QueueItem';
    }

    

    
}

?>
