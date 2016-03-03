<?php


class MetaMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['script_id']);
        if ($old) { return $old; }
        $meta = new Metadata($row['object_name']);
        $meta->setId($row['script_id']);
        $meta->setVersion_id($row['seq']);
        $this->addToMap($meta);
        return $meta;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM tables WHERE id=" . $id;
    }

    public function findAllMissingMetaData($user_id) {
        $emailSQL = "SELECT email FROM users WHERE id = $user_id";
        $this->db->query($emailSQL);
        $emailResult = current($this->db->getAllResults());
        $email = $emailResult['email'];

        $sql = "SELECT
                    scripts.object_name,
                    versions.script_id,
                    versions.seq
                FROM scripts 
                INNER JOIN versions on scripts.id = versions.script_id
                INNER JOIN ( 
                    SELECT  script_id,
                            version_info,
                            source_name,
                            user_id,
                            max(seq) AS maxseq
                    FROM versions
                    GROUP BY script_id) mv on scripts.id = mv.script_id and versions.seq = maxseq
                    JOIN users on mv.user_id = users.id
                    WHERE users.email = '$email' AND
                          users.email <> '' AND
                        (scripts.title = '' OR 
                        scripts.description = '' OR 
                        versions.version_info = '')
                    ORDER BY mv.source_name";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new MetaCollection($results,$this);
        } else {
            return false;
        }
    }

   public function targetClass() {
        return 'Metadata';
   }
}