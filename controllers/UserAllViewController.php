<?php

class UserAllViewController implements ICommand {
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'user_view_all') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        /* @var $session Session */

                // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        if (!$session->getIs_admin()) {
            echo "Not Authorized to Edit";
            exit;
        }
        
        $userMapper = $registry->get('UserMapper');
        $queueMapper = $registry->get('QueueMapper');
        
        $users = $userMapper->findAll();
        
        // Check for any pending reports for this user
        $pending = array();
        foreach ($users as $user) {
            $items = $queueMapper->findAllByUserId($user->getId());
            $pending[$user->getId()] = $items->count();
        }
        
        // Load View
        $request->setObject('users', $users);
        $request->setObject('pending', $pending);
        include './views/user_all_view.php';
        return true;
    }

}

?>
