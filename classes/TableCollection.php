<?php


class TableCollection extends BaseCollection {
    
    public function getCount() {
        $this->notifyAccess();
        return count($this->objects);
    }
    
    /** Returns a TableCollection of items that are in $otherCollection
     * but that are not in $baseCollection.  Returns FALSE if they are
     * equal
     * 
     * @param TableCollection $baseCollection
     * @param TableCollection $otherCollection
     */
    public static function collection_diff(TableCollection $baseCollection, TableCollection $otherCollection) {
        $returnCollection = new TableCollection();
        foreach ($otherCollection as $o) {
            $otherInBase = FALSE;
            foreach ($baseCollection as $b) {
                if ($b === $o) {
                    $otherInBase = TRUE;
                }
            }
            if (!$otherInBase) {
                $returnCollection->add($o);
            }
        }
        if ($returnCollection->getCount() === 0) {
            return FALSE;
        } else {
            return $returnCollection;
        }
    }
    
}

?>
