<?php

class Session 
{
    protected $my_person_id;
    protected $my_name;
    protected $is_hr;
    protected $ldapUserName;
    protected $mode;
    protected $is_ccl_writer;
    protected $is_admin;
    
    function __construct() {
        if (isset($_SESSION['my_person_id']) && !empty($_SESSION['my_person_id'])) {
            $this->my_person_id = $_SESSION['my_person_id'];
        }
        
        if (isset($_SESSION['my_name']) && !empty($_SESSION['my_name'])) {
            $this->my_name = $_SESSION['my_name'];
        }
        
        if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])) {
            $this->is_admin = $_SESSION['is_admin'];
        }
        if (isset($_SESSION['is_ccl_writer']) && !empty($_SESSION['is_ccl_writer'])) {
            $this->is_ccl_writer = $_SESSION['is_ccl_writer'];
        }
        
        if (isset($_SESSION['ldap']) && !empty($_SESSION['ldap'])) {
            $this->ldapUserName = $_SESSION['ldap'];
        }
        
         if (isset($_SESSION['mode']) && !empty($_SESSION['mode'])) {
            $this->mode = $_SESSION['mode'];
        }     

        if (isset($_SESSION['meta_alert']) && !empty($_SESSION['meta_alert'])) {
            $this->meta_alert = $_SESSION['meta_alert'];
        }   
    }
    
    public function getMy_person_id() {
        return $this->my_person_id;
    }

    public function setMy_person_id($my_person_id) {
        $this->my_person_id = $my_person_id;
        $_SESSION['my_person_id'] = $my_person_id;
    }
    
    public function getMy_name() {
        return $this->my_name;
    }

    public function setMy_name($my_name) {
        $this->my_name = $my_name;
        $_SESSION['my_name'] = $my_name;
    }

    public function getLdapUserName() {
        return $this->ldapUserName;
    }

    public function setLdapUserName($ldapUserName) {
        $this->ldapUserName = $ldapUserName;
        $_SESSION['ldap'] = $ldapUserName;
    }

    public function getMode() {
        return $this->mode;
    }

    public function setMode($mode) {
        $this->mode = $mode;
        $_SESSION['mode'] = $mode;
    }

    public function getIs_ccl_writer() {
        return $this->is_ccl_writer;
    }

    public function setIs_ccl_writer($is_ccl_writer) {
        $this->is_ccl_writer = $is_ccl_writer;
        $_SESSION['is_ccl_writer'] = $is_ccl_writer;
    }

    public function getIs_admin() {
        return $this->is_admin;
    }

    public function setIs_admin($is_admin) {
        $this->is_admin = $is_admin;
        $_SESSION['is_admin'] = $is_admin;
    }

    public function getMeta_Alert_Fired() {
        return $this->meta_alert;
    }

    public function setMeta_Alert_fired($meta_alert) {
        $this->meta_alert = $meta_alert;
        $_SESSION['meta_alert'] = $meta_alert;
    }

            
        
    // RPG Utility functions
    public function loadAndClearFromSession($name) {
        if (isset($_SESSION[$name])) {
            $temp = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $temp;
        }
    }
    
    public function saveToSession($name, $val) {
	$_SESSION[$name] = $val;
    }
    
    public function saveToSessionArray($values = array()) {
        $i = @$values['seq'];
        $type = @$values['type'];
        $value = @$values['data'];
        $error = @$values['error'];
        
        $this->saveToSession('itemValue' . $i, array('type' => $type, 'value' => $value));
        $this->saveToSession('itemError' . $i, array('type' => $type, 'error' => $error));
    }

    function clearFromSession($name) {
        unset($_SESSION[$name]);
    }
}

?>
