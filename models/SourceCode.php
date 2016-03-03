<?php

class SourceCode extends DomainObject {
    private $version_id;
    private $source;
    
    function __construct($source) {
        $this->source = $source;
    }

    public function getSource() {
        return $this->source;
    }

    public function getVersion_id() {
        return $this->version_id;
    }

    public function setVersion_id($version_id) {
        $this->version_id = $version_id;
    }

}

?>
