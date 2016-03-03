<?php


class Report extends DomainObject {
    private $title;
    private $description;
    private $object_name;
    private $versions;
    private $sn_task_num;
    private $ministry;
    private $audiences;
    private $executedLocations;
    
    function __construct($object_name) {
        $this->object_name = $object_name;
    }

    public function getObject_name() {
        return $this->object_name;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getAudiences() {
        return $this->audiences;
    }

    public function setAudiences(AudienceCollection $audiences) {
        $this->audiences = $audiences;
    }
    
    public function addAudience(Audience $audience) {
        if ($this->audiences === null) {
            $this->audiences = parent::getCollection('Audience');
        }
        $this->audiences->add($audience);
    }
    
    public function getVersions() {
        return $this->versions;
    }

    public function setVersions(VersionCollection $versions) {
        $this->versions = $versions;
    }
    
    public function addVersion(Version $version) {
        if ($this->versions === null) {
            $this->versions = parent::getCollection('Version');
        }
        $this->versions->add($version);
    }
    
    public function getLastVersion() {
        $seq = 0;
        $latest = null;
        if (isset($this->versions)) {
            foreach ($this->versions as $version) {
                if ($version->getSeq() > $seq) {
                    $seq = $version->getSeq();
                    $latest = $version;
                }
            }
        }
        return $latest;
    }

    public function getSn_task_num() {
        return $this->sn_task_num;
    }

    public function setSn_task_num($sn_task_num) {
        $this->sn_task_num = $sn_task_num;
    }
    
    public function getMinistry() {
        return $this->ministry;
    }

    public function setMinistry($ministry) {
        $this->ministry = $ministry;
    }
    
    public function getMinistries() {
        return $this->ministries;
    }

    public function getExecutedLocations() {
        return $this->executedLocations;
    }

    public function setExecutedLocations($executedLocations) {
        $this->executedLocations = $executedLocations;
    }



    
}

?>
