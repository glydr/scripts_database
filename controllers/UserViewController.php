<?php

class UserViewController implements ICommand {
    public function onCommand($name, \Request $request) {
        if ($name !== 'user_view') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        $userMapper = $registry->get('UserMapper');
        $queueMapper = $registry->get('QueueMapper');
        
        $user_id = filter_var($request->get('user_id'), FILTER_VALIDATE_INT);
        if ($user_id === FALSE) {
            echo "Invalid Submission";
            exit;
        }
        $user = $userMapper->find($user_id);
        
        // Check for any pending reports for this user
        $pending = $queueMapper->findAllByUserId($user_id);
        
        // Load the view
        $request->setObject('user', $user);
        $request->setObject('pending', $pending);
        include './views/user_view.php';
        return true;
    }

}

?>
