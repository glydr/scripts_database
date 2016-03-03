<?php


class SearchResult {
    private $report_id;
    private $title;
    private $object_name;
    private $report_description;
    private $version_seq;
    private $version_id;
    private $version_description;
    private $resultCount = 0;
    
    function __construct($object_name) {
        $this->object_name = $object_name;
    }
    
    public function getReport_id() {
        return $this->report_id;
    }

    public function setReport_id($report_id) {
        $this->report_id = $report_id;
    }

    public function getObject_name() {
        return $this->object_name;
    }

    public function getReport_description() {
        return $this->report_description;
    }

    public function setReport_description($report_description) {
        $this->report_description = $report_description;
    }

    public function setVersion_id($version_id) {
        $this->version_id = $version_id;
    }

    public function getVersion_id() {
        return $this->version_id;
    }

    public function getVersion_description() {
        return $this->version_description;
    }

    public function setVersion_description($version_description) {
        $this->version_description = $version_description;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getVersion_seq() {
        return $this->version_seq;
    }

    public function setVersion_seq($version_seq) {
        $this->version_seq = $version_seq;
    }

    public function getResultCount() {
        return $this->resultCount;
    }

    public function setResultCount($resultCount) {
        $this->resultCount = $resultCount;
    }
}

?>
