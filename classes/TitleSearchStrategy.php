<?php


class TitleSearchStrategy implements ISearchStrategy {
    
    public function getSQL($wordToSearchFor) {
        return "SELECT 
                    s.id as report_id,
                    s.object_name as object_name,
                    s.description as description,
                    s.title as title,
                    s.ministry_id,
                    '' as version_id,
                    '' as version_info,
                    '' as seq
                FROM scripts s
                WHERE s.title LIKE '%$wordToSearchFor%'";
    }

}

?>
