<?php


class ExecutingFrom extends DomainObject {
    private $description;
    private $active_ind;
    
    function __construct($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getActive_ind() {
        return $this->active_ind;
    }

    public function setActive_ind($active_ind) {
        $this->active_ind = $active_ind;
    }


    
}

?>
