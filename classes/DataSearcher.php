<!--
///  CHANGE LOG  ////

BAS 2015-10-15:     CLASS:          Added "cmp" function as custom sorter for search results.
                    getResults:     Added usort() utilizing cmp() to sort results alphabetically before returning them.
-->
<?php


class DataSearcher {
    private $db;
    private $results = array();
    private $records = array();
    
    function __construct(Database $db) {
        $this->db = $db;
    }

    private function sortByResult($result1,$result2) {
        reset($result1);
        reset($result2);
        $r1key = key($result1);
        $r2key = key($result2);
        return $result2[$r2key]->getResultCount() - $result1[$r1key]->getResultCount();
        //return $result1[$r1key]->getResultCount() - $result2[$r2key]->getResultCount();
    }

    private function cmp($result1,$result2) {
        // array passed from table filter formed slightly differently than that passed by target
        // determine the first key in order to properly get the title to sort by
        reset($result1);
        reset($result2);
        $r1key = key($result1);
        $r2key = key($result2);

        if(($result1[$r1key]->getTitle() !== null) || ($result2[$r2key]->getTitle() !== null)) {
            return strcmp(ltrim(strtoupper($result1[$r1key]->getTitle())),ltrim(strtoupper($result2[$r2key]->getTitle())));
        } 
        
    }

    public function find(ISearchStrategy $strategy, $word) {
        $results = array();
        $sql = $strategy->getSQL($word);
        $this->db->query($sql);
        foreach ($this->db->getAllResults() as $row) {
            $result = new SearchResult($row['object_name']);

            if(!array_key_exists($row['object_name'], $this->records)) {
                $this->records[$row['object_name']] = 1;
            }else{
                $this->records[$row['object_name']]++;
            }

            $result->setResultCount($this->records[$row['object_name']]);
            $result->setReport_id($row['report_id']);
            $result->setTitle($row['title']);
            if ($result->getTitle() === '') {
                $result->setTitle($row['object_name']);
            }
            $result->setVersion_seq($row['seq']);
            $result->setVersion_id($row['version_id']);
            $result->setReport_description($row['description']);
            if ($result->getReport_description() === '') {
                $scm = new SourceCodeMapper($this->db);
                $source = $scm->findByVersionId($result->getVersion_id());
                if ($source) {
                    $result->setReport_description('<span class="bold">No description available, showing source code snippet instead:</span>'
                        . substr($source->getSource(), 0, 300));
                }
            }
            $result->setVersion_description($row['version_info']);

            $index = $this->createResultsIndex($row['object_name'], $row['ministry_id']);

            $results[$index][$row['version_id']] = $result;
        }
        $this->results = array_merge($this->results, $results);

        return $results;
    }
    
    public function getResults() {

        //sort results alphabetically by title
        //usort($this->results, array($this,'cmp'));
        usort($this->results, array($this,'sortByResult'));

        return $this->results;
    }
    
    private function createResultsIndex($object_name, $ministry) {
        return $object_name . $ministry;
    }

     private function printstuff($array) {
        print_r($array);
    }


}

?>
