<?php

class ViewSourceController implements ICommand {

    public function onCommand($name, \Request $request) {
        if ($name !== 'view_source') {
            return false;
        }
        
        $registry = Registry::instance();
        $session = $registry->getSession();
        $versionMapper = $registry->get('VersionMapper');

                // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        $version_id = filter_var($request->get('version_id'), FILTER_VALIDATE_INT);
        if (!$version_id) {
            echo "Invalid Link";
            exit;
        }

        // Load the version and get the source
        $version = $versionMapper->find($version_id);
        $source = $version->getSource()->getSource();
        $cclFormatter = new CCLFormatter($source);
        echo $cclFormatter->getFormattedVersion();
        
        return true;
    }

}

?>
