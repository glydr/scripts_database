<?php

class Metadata extends DomainObject {
    private $name;
    private $version_id;
    
    function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setVersion_id($version_id) {
    	$this->version_id = $version_id;
    }

    public function getVersion_id() {
    	return $this->version_id;
    }


}

?>