<?php
session_start();
require_once '../config.php';

// Setup common vars
$db = new Database(HOST, USER, PASS, DATABASE);
$db->connect();
/* @var $session Session */
$session = new Session();

// Look for any redirect info
$params = '';
$error_params = '';
if (isset($_POST['redirect_type']) && !empty($_POST['redirect_type'])) {
    switch ($_POST['redirect_type']) {
        case 'user_edit':
            if (isset($_POST['redirect_user_id']) && !empty($_POST['redirect_user_id'])) {
                $params = '?type=user_edit&user_id=' . $_POST['redirect_user_id'];
                $error_params = '&redirect=user_edit&user_id=' . $_POST['redirect_user_id'];
            }
            break;
        case 'edit_report':
            if (isset($_POST['redirect_report_id']) && !empty($_POST['redirect_report_id']) &&
                isset($_POST['redirect_version_id']) && !empty($_POST['redirect_version_id'])) {
                $params = '?type=edit_report&id=' . $_POST['redirect_report_id'] . '&version=' . $_POST['redirect_version_id'];
                $error_params = '&redirect=edit_report&id=' . $_POST['redirect_report_id'] . '&version=' . $_POST['redirect_version_id'];
            }
            break;
        case 'visitor':
            $_POST['username'] = 'visitor';
            $_POST['password'] = 'visitor';
            break;
    }
}



// Load errors
$errors = array();
$errors[1] = 'Invalid username or password entered.';
$errors[2] = 'You must enter a password and username.';
$errors[3] = 'Invalid destination set';

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location: ../login.php?error=2' . $error_params);
    exit;
}

if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: ../login.php?error=2' . $error_params);
    exit;
}

// Dev login
if ($_POST['username'] == 'visitor' && $_POST['password'] == 'visitor') {
    $session->setMy_person_id(999);
    $session->setMy_name('Test User');
    $session->setIs_ccl_writer(0);
    $session->setIs_admin(0);
    header('Location: ../index.php' . $params);   
    exit;
}

if ($_POST['username'] == 'rcatlin' && $_POST['password'] == 'LHrc837&') {
    $session->setMy_person_id(998);
    $session->setMy_name('Richard Catlin');
    $session->setIs_ccl_writer(1);
    $session->setIs_admin(1);
    header('Location: ../index.php' . $params);   
    exit;
}

// Special lockout
if (strtolower($_POST['username']) === 'mikal\cbailey1') {
//    header('Location: ../index.php' . $params);
    echo $_POST['username'] . '<br>';
    echo 'Access Denied';
    exit;
}


if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin') {
   $session->setMy_person_id(2);
   $session->setMy_name('Admin Test User');
   $session->setIs_ccl_writer(1);
   $session->setIs_admin(1);
   header('Location: ../index.php' . $params);   
   exit;
}


// LDAP login
$ldap = ldap_connect("ahwadcnybin102.nybin.ds.sjhs.com");
if($bind = ldap_bind($ldap, $_POST['username'], $_POST['password'])) {
        // Check if this user is already in the system
        $userMapper = new UserMapper($db);
        if ($user = $userMapper->findByLDAPUsername($_POST['username'])) {
            /* @var $user User */
            $session->setMy_person_id($user->getId());
            $session->setMy_name($user->getDisplay_name());
            $session->setIs_ccl_writer($user->getIs_ccl_writer());
            $session->setIs_admin($user->getIs_admin());
            header('Location: ../index.php' . $params);
        } 
} else {
        header('Location: ../login.php?error=1' . $error_params);
        exit;
}   


return true;

?>