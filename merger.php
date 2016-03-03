<?php
require_once 'config.php';

$db = new Database(HOST, USER, PASS, DATABASE);
$db->connect();


echo '<br>Merging<br>';

$sql = 'SELECT i.*, m.id as ministry_id, t.id as target_id
        FROM import_mycom i
        INNER JOIN ministry m ON m.key = i.ministry
        LEFT JOIN target_audience t ON t.description = i.target
        WHERE 1';
$db->query($sql);

// Loop through all of the imports
$matches = 0;
foreach ($db->getAllResults() as $result) {
    
    // Look for a matching object
    $sql = "SELECT * 
            FROM scripts s 
            WHERE s.object_name = '{$result['object_name']}' 
            AND s.ministry_id = {$result['ministry_id']}";
    $db->query($sql);
    
    // Matched
    if ($db->getNum_rows() > 0) {
        $matches++;
        
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        echo '<br>';
        print_r($match = $db->getNextResult());
        
        
        $update = " UPDATE scripts s
                    SET title =  '{$result['title']}',
                        description = '{$result['description_full']}',
                        audiences = '{$result['target_id']}'
                    WHERE id = {$match['id']}";
        echo "<br>$update";
        $db->execute($update);
        echo '<br>----------------------------------------------------------------<br>';
    }
    
}

echo "<br>Total matches: $matches";

?>
