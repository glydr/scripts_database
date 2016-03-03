<?php

class ExtractProcessor implements IObservable {
    private $db;
    private $tableMapper;
    private $sourceCodeMapper;
    private $versionMapper;
    private $reportMapper;
    private $userMapper;
    private $currentReportBeingProcessed;
    
    private $observers = array();

    function __construct($db, $tableMapper, $sourceCodeMapper, $versionMapper, $reportMapper, $userMapper) {
        $this->db = $db;
        $this->tableMapper = $tableMapper;
        $this->sourceCodeMapper = $sourceCodeMapper;
        $this->versionMapper = $versionMapper;
        $this->reportMapper = $reportMapper;
        $this->userMapper = $userMapper;
    }

    public function addObserver(IObserver $observer) {
        $this->observers[] = $observer;
    }

    private function notifyObservers($args) {
        foreach ($this->observers as $observer) {
            $observer->onChanged($this, $args);
        }
    }

    public function run() {
        $tab = '&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<br>Starting extract...';
        // Check for any new entries in the extract table
        $sql = "SELECT m.id as ministry_id, e.* 
                FROM `extract`  e
                INNER JOIN `ministry` m ON m.key = e.ministry
                WHERE e.processed_ind = 0";
        $this->db->query($sql);
        foreach ($this->db->getAllResults() as $result) {

            // Check and see if this object name already exists
            $report = $this->reportMapper->findByObjectNameAndMinistry($result['object_name'], $result['ministry_id']);
            if ($report === FALSE) {
                $report = new Report($result['object_name']);
                $report->setMinistry($result['ministry_id']);
            }
            $this->currentReportBeingProcessed = $report;
            echo '<br>' . $tab . 'Processing object: ' . $report->getObject_name();
                
            // Save the report and version
            if ($report->getId() > 0) {
                $this->reportMapper->update($report);
            } else {
                $this->reportMapper->insert($report);
            }                
                            
            // Add a new version
            $user = $this->loadUserForExtract($result['cerner_username']);
            $version = $this->createNewVersionForReport($report, $user, $result['source_code']);
            $this->addTablesToVersion($version, $result['tables']);
            $version->setSource_name($result['source_name']);
            $report->addVersion($version);
            $version->setScript_id($report->getId());
            $this->versionMapper->insert($version);

            // Mark extract entries as processed
            $sql = "UPDATE `extract` SET processed_ind = 1 WHERE id = {$result['id']}";
            $this->db->execute($sql);
        }
        echo '<br>Completed';
    }    
    
    public function getCurrentReportBeingProcessed() {
        return $this->currentReportBeingProcessed;
    }

    /**
     * Finds a user given a cerner username.  If not found, adds entry
     * to the database for the user
     * 
     * @param string $cerner_username
     * @return User
     */
    private function loadUserForExtract($cerner_username) {
        $user = $this->userMapper->findByCernerUsername($cerner_username);
        if ($user === FALSE) {
            $user = new User($cerner_username);
            $user->setActive_ind(1);
            $user->setIs_admin(0);
            $user->setIs_ccl_writer(0);
            $this->userMapper->insert($user);
        }
        return $user;
    }

    /**
     * Creates a version based on supplied information
     * 
     * @param Report $report
     * @param User $user
     * @param string $source_code
     * @return Version
     */
    private function createNewVersionForReport(Report $report, User $user, $source_code) {
        $version = new Version();
        if (!is_null($report->getLastVersion())) {
            $seq = $report->getLastVersion()->getSeq();
        } else {
            $seq = 0;
        }
        $version->setSeq(++$seq);
        $version->setBeg_eff_dt_tm(date('Y-m-d h:n:s', strtotime("now")));
        $version->setEnd_eff_dt_tm('2100-12-31 00:00:00');
        $version->setUser_id($user->getId());
        $version->setSource(new SourceCode($source_code));
        $this->notifyObservers($version);
        return $version;
    }

    /**
     * Creates table objects for each table and adds them to the 
     * supplied version.  If a new table, it will save it to
     * the database
     * 
     * @param Version $version
     * @param semicolon separated string of table names $tables
     */
    private function addTablesToVersion(Version $version, $tables) {
        $tables = explode(';', $tables);
        foreach ($tables as $table_name) {
            $tableObj = $this->tableMapper->findByName($table_name);
            if ($tableObj === FALSE) {
                $tableObj = new Table($table_name);
                $this->tableMapper->insert($tableObj);
            }
            $version->addTable($tableObj);
        }
    }
}
        

?>
