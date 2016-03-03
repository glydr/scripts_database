<?php


class Ministry  extends DomainObject {
    private $name;
    private $active_ind;
    
    function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getActive_ind() {
        return $this->active_ind;
    }

    public function setActive_ind($active_ind) {
        $this->active_ind = $active_ind;
    }


}

?>
