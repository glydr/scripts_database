<?php



class RequestCommandChain
{
    protected $commands = array();
    
    public function addCommand(ICommand $cmd) {
        $this->commands[] = $cmd;
    }
    
    public function runCommand(Request $request) {
        foreach ($this->commands as $cmd) {
            /* @var $cmd ICommand */
            
            $key = $request->get('type');            
            if ($cmd->onCommand($key, $request)) {
                return;
            }
        }
    }
    
}
?>
