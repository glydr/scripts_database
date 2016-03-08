<?php


class VersionViewController implements ICommand {
    public function onCommand($name, \Request $request) {
        if ($name !== 'version_view') {
            return false;
        }
        
        $registry = Registry::instance();
        $session = $registry->getSession();
        $versionMapper = $registry->get('VersionMapper');
        $userMapper = $registry->get('UserMapper');
        $reportMapper = $registry->get('ReportMapper');

                // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        $version_id = filter_var($request->get('version_id'), FILTER_VALIDATE_INT);
        if ($version_id === FALSE) {
            echo "Invalid Submission";
            exit;
        }
        
        // Load data
        $version = $versionMapper->find($version_id);
        if (!$version) {
            echo "Invalid Submission";
            exit;
        }
        $user = $userMapper->find($version->getUser_id());
        $title = 'Version Information';
        $report = $reportMapper->findByVersionId($version_id);
        
        // Load view
        $request->setObject('version', $version);
        $request->setObject('user', $user);
        $request->setObject('title', $title);
        $request->setObject('object_name', $report->getObject_name());
        $request->setObject('report_id', $report->getId());
        include './views/version_view.php';
        
        return true;
    }

}

?>
