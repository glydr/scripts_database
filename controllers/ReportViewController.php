<?php


class ReportViewController implements ICommand {
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'view_report') {
            return false;
        }
        
        $registry = Registry::instance();
        $session = $registry->getSession();
        $reportMapper = $registry->get('ReportMapper');
        $userMapper = $registry->get('UserMapper');
        $ministryMapper = $registry->get('MinistryMapper');
        $audienceMapper = $registry->get('AudienceMapper');
        $executingFromMapper = $registry->get('ExecutingFromMapper');

                // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        // Extract vars from GET and Load the report
        $report_id = filter_var($request->get('id'), FILTER_VALIDATE_INT);
        if ($report_id === FALSE) {
            echo "Invalid Report Id";
            exit;
        }
        $report = $reportMapper->find($report_id);
        
        // Load sub elements
        $audiences = $report->getAudiences();
        $ministry = $ministryMapper->find($report->getMinistry());

        $executed_froms = array();
        foreach (explode(';', $report->getExecutedLocations()) as $id) {
            $executed_froms[] = $executingFromMapper->find($id);
        }
        
        // Load data for the version_view.php sub view
        $request->setObject('title', 'Latest Version Information');
        $request->setObject('report_id', $report_id);
        $request->setObject('version', $report->getLastVersion());
        $request->setObject('user', $userMapper->find($report->getLastVersion()->getUser_id()));
        include './views/report_view.php';
        return true;
    }

}

?>
