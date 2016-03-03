<?php

class UserNewController implements ICommand {
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'new_user') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        /* @var $session Session */
        
        if (!$session->getIs_admin()) {
            echo "Not Authorized to Edit";
            exit;
        }
        
        $user = new User('');
        
        // Load the view
        $request->setObject('action', 'user_create');
        $request->setObject('user', $user);
        include './views/edit_user_view.php';
        return true;
    }

}

?>
