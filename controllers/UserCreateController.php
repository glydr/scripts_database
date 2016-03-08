<?php

class UserCreateController implements ICommand {
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'user_create') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        /* @var $session Session */
        
        if (!$session->getIs_admin()) {
            echo "Not Authorized to Edit";
            exit;
        }
        
        $userMapper = $registry->get('UserMapper');
        $display_name = $request->get('display_name');
        $ldap_username = $request->get('ldap_username');
        $cerner_username = $request->get('cerner_username');
        $email = $request->get('email');
        $is_admin = $request->get('is_admin');
        $is_ccl_writer = $request->get('is_ccl_writer');

                // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());

        // Load the user
        /* @var $user User */
        $user = new User($cerner_username);
        // Set new values
        $user->setDisplay_name($display_name);
        $user->setLdap_username($ldap_username);
        $user->setEmail($email);
        if ($is_admin === 'on') {
            $user->setIs_admin(1);
        } else {
            $user->setIs_admin(0);
        }
        if ($is_ccl_writer === 'on') {
            $user->setIs_ccl_writer(1);
        } else {
            $user->setIs_ccl_writer(0);
        }
        $user->setActive_ind(1);
        
        // Save and load next view
        if ($userMapper->insert($user)) {
            header('Location:index.php?type=user_view&user_id=' . $user->getId());
        } else {
            $request->setObject('action', 'user_create');
            $request->setObject('user', $user);
            $request->setObject('error', 'Unable to save, please try again!');
            include './views/edit_user_view.php';
        }
        return true;
    }

}

?>
