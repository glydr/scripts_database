<?php


class User extends DomainObject {
    private $cerner_username;
    private $ldap_username;
    private $display_name;
    private $email;
    private $active_ind;
    private $is_admin;
    private $is_ccl_writer;
    
    function __construct($cerner_username) {
        $this->cerner_username = $cerner_username;
    }
    
    public function getCerner_username() {
        return $this->cerner_username;
    }

    public function getActive_ind() {
        return $this->active_ind;
    }

    public function setActive_ind($active_ind) {
        $this->active_ind = $active_ind;
    }
    
    public function getLdap_username() {
        return $this->ldap_username;
    }

    public function setLdap_username($ldap_username) {
        $this->ldap_username = $ldap_username;
    }

    public function getDisplay_name() {
        if ($this->display_name !== '') {
            return $this->display_name;
        } else {
            return $this->cerner_username;
        }
    }

    public function setDisplay_name($display_name) {
        $this->display_name = $display_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getIs_admin() {
        return $this->is_admin;
    }

    public function setIs_admin($is_admin) {
        $this->is_admin = $is_admin;
    }

    public function getIs_ccl_writer() {
        return $this->is_ccl_writer;
    }

    public function setIs_ccl_writer($is_ccl_writer) {
        $this->is_ccl_writer = $is_ccl_writer;
    }

    public function setCerner_username($cerner_username) {
        $this->cerner_username = $cerner_username;
    }



}

?>
