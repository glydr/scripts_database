<?php

class Registry
{
    private static $instance;
    private $session;
    private $database;
    private $objects = array();
    
    private function __construct() {}

    static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new Registry();
        }
        return self::$instance;
    }
    
    public function getSession() {
        return $this->session;
    }

    public function setSession(Session $session) {
        $this->session = $session;
    }
    
    public function getDatabase() {
        return $this->database;
    }

    public function setDatabase(Database $database) {
        $this->database = $database;
    }

    public function get($key) {
        if (array_key_exists($key, $this->objects)) {
            return $this->objects[$key];
        }
        return false;
    }
    
    public function set($key, $obj) {
        $this->objects[$key] = $obj;
    }


}

?>
