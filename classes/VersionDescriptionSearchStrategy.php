<?php


class VersionDescriptionSearchStrategy implements ISearchStrategy {

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
                FROM 
                    versions v,
                    scripts s
                WHERE v.version_info LIKE '%$wordToSearchFor%'
                AND s.id = v.script_id";
    }

}

?>
