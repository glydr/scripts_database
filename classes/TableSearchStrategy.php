<?php


class TableSearchStrategy implements ISearchStrategy {
    
    public function getSQL($wordToSearchFor) {
        return "SELECT 
                    s.id as report_id,
                    s.object_name as object_name,
                    s.description as description,
                    s.title as title,
                    s.ministry_id,
                    v.id as version_id,
                    v.version_info as version_info,
                    v.seq as seq
                FROM tables t,
                    version_table_reltn vtr,
                    versions v,
                    scripts s
                WHERE t.name = '$wordToSearchFor'
                AND vtr.table_id = t.id
                AND v.id = vtr.version_id
                AND s.id = v.script_id";
    }

}

?>
