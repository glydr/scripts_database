<?php
session_start();
require_once 'config.php';

$registry = Registry::instance();
$session = new Session();

// Verify that user is logged in
if (!$session->getMy_person_id()) {
    if (isset($_GET['type']) && !empty($_GET['type'])) {
        switch ($_GET['type']) {
            case 'user_edit':
                if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
                    $params = '?redirect=user_edit&user_id=' . $_GET['user_id'];
                }
                break;
            case 'edit_report':
                if (isset($_GET['id']) && !empty($_GET['id']) &&
                    isset($_GET['version']) && !empty($_GET['version'])) {
                    $params = '?redirect=edit_report&id=' . $_GET['id'] . '&version=' . $_GET['version'];
                }
                break;
            default:
                $params = '';
        }
    }
    header('Location: login.php' . $params);
}

$registry->setSession($session);
$db = new Database(HOST, USER, PASS, DATABASE);
$db->connect();
$registry->setDatabase($db);

//Load mappers into registry
$registry->set('TableMapper', new TableMapper($db));
$registry->set('SourceCodeMapper', new SourceCodeMapper($db));
$registry->set('VersionMapper', new VersionMapper($db, $registry->get('TableMapper'), $registry->get('SourceCodeMapper')));
$registry->set('ReportMapper', new ReportMapper($db, $registry->get('VersionMapper')));
$registry->set('UserMapper', new UserMapper($db));
$registry->set('MinistryMapper', new MinistryMapper($db));
$registry->set('AudienceMapper', new AudienceMapper($db));
$registry->set('ExecutingFromMapper', new ExecutingFromMapper($db));
$registry->set('QueueMapper', new QueueMapper($db));
$registry->set('MetaMapper', new MetaMapper($db));

// Command Chain
$request = new Request();

if (!$request->get('type')) {
    // Load index view
    $request->add_Property('type', 'index');
}

// Create the command chain
$cmdChain = new RequestCommandChain();
$cmdChain->addCommand( new ViewSourceController() );
$cmdChain->addCommand( new ReportViewController() );
$cmdChain->addCommand( new ReportEditController() );
$cmdChain->addCommand( new ReportUpdateController() );
$cmdChain->addCommand( new VersionViewController() );
$cmdChain->addCommand( new IndexController() );
$cmdChain->addCommand( new SearchController() );
$cmdChain->addCommand( new UserEditController() );
$cmdChain->addCommand( new UserUpdateController() );
$cmdChain->addCommand( new UserViewController() );
$cmdChain->addCommand( new UserAllViewController() );
$cmdChain->addCommand( new UserNewController() );
$cmdChain->addCommand( new UserCreateController() );

// Execute the request against the command chain
$cmdChain->runCommand($request);

?>
