<?php

class Emailer {
    
    const LOGBIT = 1;
    const TESTBIT = 2;
    const LIVEBIT = 4;
    
    private $body;
    private $subject;
    private $headers;
    private $sendToLog;
    private $sendToTestEmail;
    private $sendToLiveEmail;
    private $logFile;
    private $liveToEmail;
    private $testToEmail;
    
    
    /**
     *
     * @param int $destinations = 3 bit number 1 = log, 2 = test email, 4 = live
     *                                  these can be added to generate compound output
     *                                  eg 5 => Live and log
     * @param string $logFile = path to log file
     * @param string $liveToEmail = email address for production
     * @param string $testToEmail = email address for test / dev / monitoring
     */
    function __construct($destinations, $logFile, $liveToEmail, $testToEmail) {
        $this->logFile = $logFile;
        $this->liveToEmail = $liveToEmail;
        $this->testToEmail = $testToEmail;
        $this->processOutputDestinationChoices($destinations);
    }
    
    private function processOutputDestinationChoices($choice) {
        $this->sendToLog = $this->isChoiceSelected($choice, self::LOGBIT);
        $this->sendToTestEmail = $this->isChoiceSelected($choice, self::TESTBIT);
        $this->sendToLiveEmail = $this->isChoiceSelected($choice, self::LIVEBIT);   
    }

    private function isChoiceSelected($userChoice, $testValue) {
        return (($userChoice & $testValue) == $testValue);
    }
    
    public function send() {
        if ($this->sendToLiveEmail) {
            mail($this->liveToEmail, $this->subject, $this->body, $this->headers);
        } 
        
        //$this->sendToTestEmail = TRUE;    // Added 2/23/2015 CMM for debugging
        //$this->testToEmail = "cmmiller@lourdes.com";    // Added 2/23/2015 CMM for debugging
        if ($this->sendToTestEmail) {
            mail($this->testToEmail, $this->subject, $this->body, $this->headers);
        }
        //$this->sendToLog = TRUE;    // Added 2/23/2015 CMM for debugging
        if ($this->sendToLog) {
            error_log("----------------------------------------------------\n", 3, $this->logFile);
            error_log("To: " . $this->liveToEmail . "\n", 3, $this->logFile);
            error_log("Subject: " . $this->subject . "\n", 3, $this->logFile);
            error_log("Body: " . $this->body . "\n", 3, $this->logFile);
            error_log("Headers: " . $this->headers . "\n", 3, $this->logFile);
            error_log("\n", 3, $this->logFile);
            error_log('$sendToLog = ' . $this->sendToLog . "\n", 3, $this->logFile);
            error_log('$sendToTestEmail = ' . $this->sendToTestEmail . "\n", 3, $this->logFile);
            error_log('$sendToLiveEmail = ' . $this->sendToLiveEmail . "\n", 3, $this->logFile);
            error_log("\n", 3, $this->logFile);
            error_log("----------------------------------------------------\n", 3, $this->logFile);
            error_log("\n", 3, $this->logFile);
        }
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setHeaders($headers) {
        $this->headers = $headers;
    }

            
}
?>
