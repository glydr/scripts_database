<?php


class ObjectWatcher {
    private $all = array();
    private static $instance;
    
    function __construct() {}
    
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new ObjectWatcher();
        }
        return self::$instance;
    }
    
    private function globalKey(DomainObject $obj) {
        $key = get_class($obj) . "." . $obj->getId();
        return $key;
    }
    
    public static function add(DomainObject $obj) {
        $inst = self::instance();
        $inst->all[$inst->globalKey($obj)] = $obj;
    }
    
    public static function exists($classname, $id) {
        $inst = self::instance();
        $key = $classname . "." . $id;
        if(isset($inst->all[$key])) {
            return $inst->all[$key];
        }
        return null;
    }

}

?>
