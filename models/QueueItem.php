<?php


class QueueItem extends DomainObject {
    private $user_id;
    private $report_id;
    private $version_seq;
    private $active_ind;
    private $object_name;
    
    function __construct($user_id, $report_id, $version_seq) {
        $this->user_id = $user_id;
        $this->report_id = $report_id;
        $this->version_seq = $version_seq;
        $this->active_ind = 1;
    }
    
    public function setActive_ind($active_ind) {
        $this->active_ind = $active_ind;
    }

    public function getUser_id() {
        return $this->user_id;
    }
    
    public function getReport_id() {
        return $this->report_id;
    }

    public function getVersion_seq() {
        return $this->version_seq;
    }

    public function getActive_ind() {
        return $this->active_ind;
    }
    
    public function getObject_name() {
        return $this->object_name;
    }

    public function setObject_name($object_name) {
        $this->object_name = $object_name;
    }



}

?>
