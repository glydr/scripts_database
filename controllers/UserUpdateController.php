<?php


class UserUpdateController implements ICommand {
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'user_update') {
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
        $queueMapper = $registry->get('QueueMapper');
        
        $user_id = filter_var($request->get('user_id'), FILTER_VALIDATE_INT);
        if ($user_id === FALSE) {
            echo "Invalid Submission";
            exit;
        }
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
        $user = $userMapper->find($user_id);
        
        // Set new values
        $user->setDisplay_name($display_name);
        $user->setLdap_username($ldap_username);
        $user->setCerner_username($cerner_username);
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
        
        // Save and load next view
        if ($userMapper->update($user)) {
            // Send any items from the queue
            $pending = $queueMapper->findAllByUserId($user_id);
            foreach ($pending as $item) {
                $itemEmailer = new ItemEmailer($item, $user, WEB_ROOT);
                $itemEmailer->send();
                $item->setActive_ind(0);
                $queueMapper->update($item);
            }
            header('Location:index.php?type=user_view&user_id=' . $user->getId());
        } else {
            $request->setObject('action', 'user_update');
            $request->setObject('user', $user);
            $request->setObject('error', 'Unable to save, please try again!');
            include './views/edit_user_view.php';
        }
        return true;
    }

}

?>
