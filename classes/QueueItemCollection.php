<?php

class QueueItemCollection extends BaseCollection {
    
    public function count() {
        $this->notifyAccess();
        return count($this->objects);
    }
}

?>
