<?php


abstract class BaseCollection implements Iterator {
    protected $position;
    protected $raw = array();
    protected $objects = array();
    protected $mapper;
    
    function __construct($raw = NULL, $mapper = NULL) {
        $this->raw = $raw;
        $this->mapper = $mapper;
    }
    
    protected function notifyAccess() {
        if (count($this->objects) === 0 && isset($this->raw)) {
            foreach ($this->raw as $data) {
                $this->objects[] = $this->mapper->createObject($data);
            }
        }
    }
    
    public function add($obj) {
        $this->notifyAccess();
        $this->objects[] = $obj;
    }
    
    public function current() {
        $this->notifyAccess();
        return $this->objects[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        $this->notifyAccess();
        return isset($this->objects[$this->position]);
    }
    
    

}

?>
