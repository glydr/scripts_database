<?php


class MetadataController implements ICommand {
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'metadata') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        /* @var $session Session */
        
        // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        include './views/metadata_view.php';
        return true;
    }

}

?>
