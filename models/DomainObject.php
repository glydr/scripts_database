<?php


abstract class DomainObject {
    private $id;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getCollection($type) {
        switch ($type) {
            case 'Table':
                return new TableCollection();
                break;
            case 'Version':
                return new VersionCollection();
                break;
            case 'Audience':
                return new AudienceCollection();
                break;
        }
    }
    
}

?>
