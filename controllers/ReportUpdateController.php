<?php

class ReportUpdateController implements ICommand {
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'update_report') {
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
        $versionMapper = $registry->get('VersionMapper');
        $audienceMapper = $registry->get('AudienceMapper');

                // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        // Parse the request
        $script_id = filter_var($request->get('script_id'), FILTER_VALIDATE_INT);
        $version_id = filter_var($request->get('version_id'), FILTER_VALIDATE_INT);
        if ($script_id === FALSE || $version_id === FALSE) {
            echo "Invalid Submission";
            exit;
        }
        
        // Load the report
        /* @var $report Report */
        $report = $reportMapper->find($script_id);
        $report->setTitle($request->get('title'));
        $report->setDescription($request->get('description'));
        $report->setSn_task_num($request->get('sn_num'));
        
        $audiences = new AudienceCollection();
        foreach ($request->get('target') as $id) {
            $audience = $audienceMapper->find($id);
            $audiences->add($audience);
        }
        $report->setAudiences($audiences);
        
        $report->setExecutedLocations(implode(';', $request->get('execution')));
        
        // Find the version
        /* @var $version Version */
        foreach ($report->getVersions() as $temp) {
            if ($temp->getId() == $version_id) {
                $version = $temp;
                $temp->setVersion_info($request->get('version_description'));
                $temp->setSource_name($request->get('source_path'));
            }
        }
        if (!isset($version)) {
            echo "Invalid Link";
            exit;
        }
        
        // Save
        $reportMapper->update($report);
        $versionMapper->update($version);
        $audienceMapper->updateAudienceReltnForScript($report->getId(), $report->getAudiences());
        header('Location: index.php?type=view_report&id=' . $report->getId());
        return true;
    }
    
    

}

?>
