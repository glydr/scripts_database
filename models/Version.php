<?php


class Version extends DomainObject {
    private $script_id;
    private $source_name;
    private $beg_eff_dt_tm;
    private $end_eff_dt_tm;
    private $user_id;
    private $version_info;
    private $seq;
    private $tables;
    private $source;
    
    public function getScript_id() {
        return $this->script_id;
    }

    public function setScript_id($script_id) {
        $this->script_id = $script_id;
    }
    
    public function getSource_name() {
        return $this->source_name;
    }

    public function setSource_name($source_name) {
        $this->source_name = $source_name;
    }
    
    public function getBeg_eff_dt_tm() {
        return $this->beg_eff_dt_tm;
    }

    public function setBeg_eff_dt_tm($beg_eff_dt_tm) {
        $this->beg_eff_dt_tm = $beg_eff_dt_tm;
    }

    public function getEnd_eff_dt_tm() {
        return $this->end_eff_dt_tm;
    }

    public function setEnd_eff_dt_tm($end_eff_dt_tm) {
        $this->end_eff_dt_tm = $end_eff_dt_tm;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user) {
        $this->user_id = $user;
    }

    public function getVersion_info() {
        return $this->version_info;
    }

    public function setVersion_info($version_info) {
        $this->version_info = $version_info;
    }

    public function getSeq() {
        return $this->seq;
    }

    public function setSeq($seq) {
        $this->seq = $seq;
    }

    public function getTables() {
        return $this->tables;
    }

    public function setTables(TableCollection $tables) {
        $this->tables = $tables;
    }
    
    public function addTable(Table $table) {
        if ($this->tables === null) {
            $this->tables = parent::getCollection('Table');
        }
        $this->tables->add($table);
    }
    
    public function getSource() {
        return $this->source;
    }

    public function setSource(SourceCode $source) {
        $this->source = $source;
    }


}

?>
