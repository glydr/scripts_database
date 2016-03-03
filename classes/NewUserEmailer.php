<?php


class NewUserEmailer extends Emailer {
    private $user;
    private $report;
    private $version;
    
    function __construct(User $user, User $admin, Report $report, Version $version, $public_web_root) {
        parent::__construct(5, 'email_log.txt', $admin->getEmail(), '');
        $this->user = $user;
        $this->report = $report;
        $this->version = $version;
        $link = $public_web_root . '/index.php?type=user_edit'
                                . '&user_id=' . $user->getId();
        $this->setSubject('North Region Scripts Database -- Admin Task');
        $this->setBody('A new user has been added to the database.  Please follow this link and fill out the needed information.  ' . $link);
        $this->setHeaders('From: donotreply@ascension.org');
    }

}

?>
