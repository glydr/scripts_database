<?php

class IndexController implements ICommand {
    public function onCommand($name, \Request $request) {
        if ($name !== 'index') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        
        // Load all tables
        /* @var $tableMapper TableMapper */
        $tableMapper = $registry->get('TableMapper');
        $tableCollection = $tableMapper->findAll();
        
        // Load all target audiences
        /* @var $targetMapper AudienceMapper */
        $targetMapper = $registry->get('AudienceMapper');
        $targetCollection = $targetMapper->findAllDistinctThatHaveScripts();

        // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        include './views/index_view.php';
        return true;
    }

}

?>
