<?php
require_once 'config.php';

$date = date('m/d/Y h:i:s a', time());
echo "Starting extract $date\n";
mail('brian.stephens@borgess.com', 'Extract Running NRS', 'Extract has started.', 'From: donotreply@ascension.org');

$db = new Database(HOST, USER, PASS, DATABASE);
$db->connect();

$tableMapper = new TableMapper($db);
$sourceCodeMapper = new SourceCodeMapper($db);
$versionMapper = new VersionMapper($db, $tableMapper, $sourceCodeMapper);
$reportMapper = new ReportMapper($db, $versionMapper);
$userMapper = new UserMapper($db);
$queueMapper = new QueueMapper($db);

// Create the extractor and its observers
$extractor = new ExtractProcessor($db, $tableMapper, $sourceCodeMapper, $versionMapper, $reportMapper, $userMapper);
$extractor->addObserver(new NewVersionNotifier(WEB_ROOT, $userMapper, $queueMapper));
$extractor->run();

echo "\n----------------------- END ------------------------------\n";
mail('brian.stephens@borgess.com', 'Extract Running NRS', 'Extract has finished.', 'From: donotreply@ascension.org');
?>
