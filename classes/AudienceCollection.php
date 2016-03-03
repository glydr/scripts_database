<?php


class AudienceCollection extends BaseCollection {
    
    public function containsObject(Audience $audience) {
        $this->notifyAccess();
        foreach ($this->objects as $obj) {
            if ($audience->getId() === $obj->getId()) {
                return true;
            }
        }
        return false;
    }
    
    public function getCount() {
        $this->notifyAccess();
        return count($this->objects);
    }
    
    /** Returns a AudienceCollection of items that are in $otherCollection
     * but that are not in $baseCollection.  Returns FALSE if they are
     * equal
     * 
     * @param AudienceCollection $baseCollection
     * @param AudienceCollection $otherCollection
     */
    public static function collection_diff(AudienceCollection $baseCollection, AudienceCollection $otherCollection) {
        $returnCollection = new AudienceCollection();
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
