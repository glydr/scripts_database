<?php
echo "Migration turned off";
exit;


require_once 'config.php';

$db = new Database(HOST, USER, PASS, DATABASE);
$db->connect();

$sql = "SELECT * FROM scripts WHERE 1";
$db->query($sql);

foreach ($db->getAllResults() as $result) {
    echo '<br>';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    
    foreach (explode(';', $result['audiences']) as $id) {
        if ($id != '') {
            $insert = "INSERT INTO script_target_reltn
                        (id, script_id, target_audience_id, active_ind) 
                        VALUES(null, {$result['id']}, $id, 1)";
            echo '<br>' . $insert;
            echo $db->execute($insert);
        }
    }
}


?>
