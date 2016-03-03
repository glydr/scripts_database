<?php


class UserMapper extends BaseMapper {
    
    public function createObject($row) {
        $old = $this->getFromMap($row['id']);
        if ($old) { return $old; }
        $user = new User($row['cerner_username']);
        $user->setId($row['id']);
        $user->setEmail($row['email']);
        $user->setLdap_username($row['ldap_username']);
        $user->setDisplay_name($row['display_name']);
        $user->setActive_ind($row['active_ind']);
        $user->setIs_admin($row['is_admin']);
        $user->setIs_ccl_writer($row['is_ccl_writer']);
        $this->addToMap($user);
        return $user;
    }

    public function getFindSQLStatement($id) {
        return "SELECT * FROM users WHERE id=" . $id;
    }

    public function findByCernerUsername($name) {
        $name = $this->db->realEscapeString($name);
        $sql = "SELECT * FROM users WHERE cerner_username = '$name'";
        $this->db->query($sql);
        if ($row = $this->db->getNextResult()) {
            return $this->createObject($row);
        } else {
            return false;
        }
    }
    
    public function findByLDAPUsername($username) {
        $username = $this->db->realEscapeString($username);
        $sql = 'SELECT * FROM users WHERE UPPER(ldap_username) = "' . strtoupper($username) . '"';  
        if ($this->db->query($sql)) {
            $row = $this->db->getNextResult();
            return $this->createObject($row);
        } else {
            return false;
        }
    }
    
    public function findAll() {
        $sql = "SELECT * FROM users WHERE 1";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new UserCollection($results, $this);
        } else {
            return new UserCollection();
        }
    }
    
    public function findAllActiveAdmins() {
        $sql = "SELECT * FROM users WHERE active_ind = 1 and is_admin = 1 and email != ''";
        $this->db->query($sql);
        if ($results = $this->db->getAllResults()) {
            return new UserCollection($results, $this);
        } else {
            return new UserCollection();
        }
    }


    public function insert(User $user) {
        $cerner = $this->db->realEscapeString($user->getCerner_username());
        $ldap = $this->db->realEscapeString($user->getLdap_username());
        $email = $this->db->realEscapeString($user->getEmail());
        $display = $this->db->realEscapeString($user->getDisplay_name());
        $insert = "INSERT INTO users 
                (id, cerner_username, active_ind,
                ldap_username, display_name, email,
                is_admin, is_ccl_writer) 
                VALUES (null, '$cerner',
                    {$user->getActive_ind()},
                    '$ldap', '$display',
                    '$email', {$user->getIs_admin()}, 
                    {$user->getIs_ccl_writer()})";
		
         if ($this->db->execute($insert)) {
             $user->setId($this->db->getLastInsertRowId());
             $this->addToMap($user);
             return TRUE;
         } else {
			
             return FALSE;
         }
    }
    
    public function update(User $user) {
        $cerner = $this->db->realEscapeString($user->getCerner_username());
        $ldap = $this->db->realEscapeString($user->getLdap_username());
        $email = $this->db->realEscapeString($user->getEmail());
        $display = $this->db->realEscapeString($user->getDisplay_name());
        $update = " UPDATE users 
                    SET
                        cerner_username = '$cerner',
                        active_ind = {$user->getActive_ind()},
                        ldap_username = '$ldap', 
                        display_name = '$display', 
                        email =  '$email',
                        is_admin = {$user->getIs_admin()}, 
                        is_ccl_writer = {$user->getIs_ccl_writer()}
                    WHERE id = {$user->getId()}";
         if ($this->db->execute($update)) {
             return TRUE;
         } else {
             return FALSE;
         }
    }
    
    public function targetClass() {
        return 'User';
    }

}

?>
