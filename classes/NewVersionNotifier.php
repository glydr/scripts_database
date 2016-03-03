<?php


class NewVersionNotifier implements IObserver {
    private $public_web_root;
    private $userMapper;
    private $queueMapper;
    private $userIDsThatHaveEmailsSent = array();
            
    function __construct($public_web_root, UserMapper $userMapper, QueueMapper $queueMapper) {
        $this->public_web_root = $public_web_root;
        $this->userMapper = $userMapper;
        $this->queueMapper = $queueMapper;
    }
    
    public function onChanged($sender, $args) {
        $tab2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        if (get_class($sender) === 'ExtractProcessor' && get_class($args) === 'Version') {
            if (get_class($args) === 'Version') {
                /* @var $args Version */
                /* @var $report Report */
                /* @var $user User */
                $report = $sender->getCurrentReportBeingProcessed();
                $user = $this->userMapper->find($args->getUser_id());

                if ($user && $user->getEmail()) {
                    $versionEmailer = new VersionEmailer($user, $report, $args, $this->public_web_root);
                    $versionEmailer->send();
                    echo "<br>" . $tab2  . "Email sent to version owner: " . $user->getDisplay_name();
                } else {
                    if (!in_array($args->getUser_id(), $this->userIDsThatHaveEmailsSent)) {
                        $this->userIDsThatHaveEmailsSent[] = $args->getUser_id();
                        $admins = $this->userMapper->findAllActiveAdmins();
                        foreach ($admins as $admin) {
                            $newUserEmailer = new NewUserEmailer($user, $admin, $report, $args, $this->public_web_root);
                            $newUserEmailer->send();
                        }
                        $queueItem = new QueueItem($user->getId(), $report->getId(), $args->getSeq());
                        $this->queueMapper->insert($queueItem);
                        echo "<br>" . $tab2 . "No user email -- notifying admins and adding to queue pending";
                    }
                }
            }
        }
    }

}

?>
