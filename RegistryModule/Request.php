<?php

class Request 
{
    protected $errors;
    protected $properties = array();
    protected $objects = array();
    
    function __construct() {
        $this->properties = $_REQUEST;
    }

    public function get_Errors() {
        return $this->errors;
    }
    
    public function set_Errors($errors) {
        $this->errors = $errors;
    }

    public function get($key) {
        if (array_key_exists($key, $this->properties)) {
            return $this->properties[$key];
        } else {
            return false;
        }
        
    }
    
    public function add_Property($key, $value) {
        $this->properties[$key] = $value;
    }
    
    public function setObject($key, $object) {
        $this->objects[$key] = $object;
    }
    
    public function getObject($key) {
        if (array_key_exists($key, $this->objects)) {
            return $this->objects[$key];
        } else {
            return false;
        }
    }
    
    public function debug() {
        print_r($this->properties);
    }

}


?>
