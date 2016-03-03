<?php

class TargetAudienceSearchStrategy implements ISearchStrategy {
    
    public function getSQL($wordToSearchFor) {
        $sql = "SELECT
                    s.id as report_id,
                    s.object_name as object_name,
                    s.description as description,
                    s.title as title,
                    s.ministry_id,
                    '' as version_id,
                    '' as version_info,
                    '' as seq
                FROM target_audience ta,
                     script_target_reltn str,
                     scripts s
                WHERE ta.description = '$wordToSearchFor'
                  AND str.target_audience_id = ta.id
                  AND str.active_ind = 1
                  AND s.id = str.script_id";
        return $sql;
    }

}

?>
