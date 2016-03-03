<?php


class MetaCollection extends BaseCollection {
    
    public function getCount() {
        $this->notifyAccess();
        return count($this->objects);
    }
    
    /** Returns a MetaCollection of items that are in $otherCollection
     * but that are not in $baseCollection.  Returns FALSE if they are
     * equal
     * 
     * @param MetaCollection $baseCollection
     * @param MetaCollection $otherCollection
     */
    public static function collection_diff(MetaCollection $baseCollection, MetaCollection $otherCollection) {
        $returnCollection = new MetaCollection();
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
