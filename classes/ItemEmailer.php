<?php


class ItemEmailer extends Emailer {
    
    function __construct(QueueItem $item, User $user, $public_web_root) {
        parent::__construct(4, '', $user->getEmail(), '');
        $link = $public_web_root . '/index.php?type=edit_report'
                            . '&id=' . $item->getReport_id()
                            . '&version=' . $item->getVersion_seq();
        $this->setSubject('North Region Scripts Database');
        $this->setBody('A new script or version has been added to the database.  Please follow this link and fill out the needed information.  ' . $link);
        $this->setHeaders('From: donotreply@lourdes.com');
    }

}
?>
