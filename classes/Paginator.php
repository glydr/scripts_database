<?php


class Paginator {
    private $maxRecordsPerPage;
    private $pages = array();
    private $raw;
    private $max_pages;
    
    function __construct(Array $raw, $maxRecordsPerPage) {
        $this->max_pages = 0;
        if (count($raw) > 0) {
            $this->raw = $raw;
            $this->maxRecordsPerPage = $maxRecordsPerPage;
            $this->paginate();
        }
    }
    
    private function paginate() {
        $this->pages = array_chunk($this->raw, $this->maxRecordsPerPage, TRUE);
        $this->max_pages = (1 + count($this->pages));
    }
    
    public function getArrayForPage($page_number) {
        if ($this->hasPageNumber($page_number)) {
            return $this->pages[--$page_number];
        } else {
            return FALSE;
        }
    }

    public function hasPageNumber($page_number) {
        $page_number--;
        return array_key_exists($page_number, $this->pages);
    }

    public function getLastPageNumber() {
        return $this->max_pages;
    }
            
    
}

?>
