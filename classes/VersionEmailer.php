<?php


class VersionEmailer extends Emailer {
    private $user;
    private $report;
    private $version;
    
    function __construct(User $user, Report $report, Version $version, $public_web_root) {
        parent::__construct(5, 'email_log.txt', $user->getEmail(), '');
        $this->user = $user;
        $this->report = $report;
        $this->version = $version;
        $link = $public_web_root . '/index.php?type=edit_report'
                            . '&id=' . $report->getId()
                            . '&version=' . $version->getSeq();
        $this->setSubject('North Region Scripts Database');
        $this->setBody('A new script or version has been added to the database.  Please follow this link and fill out the needed information.  ' . $link);
        $this->setHeaders('From: donotreply@ascension.org');
    }

}

?>
