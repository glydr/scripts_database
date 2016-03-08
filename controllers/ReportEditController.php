<?php

class ReportEditController implements ICommand {

    public function onCommand($name, \Request $request) {
        if ($name !== 'edit_report') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        /* @var $session Session */
        
        if (!$session->getIs_ccl_writer()) {
            echo "Not Authorized to Edit";
            exit;
        }
        
        $reportMapper = $registry->get('ReportMapper');
        $userMapper = $registry->get('UserMapper');
        $ministryMapper = $registry->get('MinistryMapper');
        $audienceMapper = $registry->get('AudienceMapper');
        $executingFromMapper = $registry->get('ExecutingFromMapper');

        // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        // Extract vars from GET 
        $report_id = filter_var($request->get('id'), FILTER_VALIDATE_INT);
        if ($report_id === FALSE) {
            echo "Invalid Report Id";
            exit;
        }
        $version_num = filter_var($request->get('version'), FILTER_VALIDATE_INT);
        if ($version_num === FALSE) {
            echo "Invalid Link";
            exit;
        }
                
        // Load the report
        $report = $reportMapper->find($report_id);
        foreach ($report->getVersions() as $temp) {
            if ($temp->getSeq() == $version_num) {
                $version = $temp;
            }
        }
        if (!isset($version)) {
            echo "Invalid Link";
            exit;
        }
        $user = $userMapper->find($version->getUser_id());
        $request->setObject('report', $report);
        $request->setObject('version', $version);
        $request->setObject('user', $user);
        
        // Load the ministries
        $ministry = $ministryMapper->find($report->getMinistry());
        $request->setObject('ministry', $ministry);
        
        // Load target audience
        $audiences = $audienceMapper->findAll();
        
        
        $selected_audiences = $report->getAudiences(); 
        $request->setObject('audiences', $audiences);
        $request->setObject('selected_audiences', $selected_audiences);
        
        // Load executing from
        $executed_froms = $executingFromMapper->findAll();
        $selected_executed_froms = explode(';', $report->getExecutedLocations());
        $request->setObject('executed_froms', $executed_froms);
        $request->setObject('selected_executed_from', $selected_executed_froms);
        
        // Load view
        include './views/edit_report_view.php';
        return true;
    }
}

?>
