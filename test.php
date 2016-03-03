<?php
$date = date('m/d/Y h:i:s a', time());
echo "hello from cron $date\n";
mail('brian.stephens@borgess.com', 'Extract Running NRS', 'Extract has started.', 'From: donotreply@ascension.org');
mail('brian.stephens@borgess.com', 'Extract Running NRS', 'Extract has finished.', 'From: donotreply@ascension.org');
?>
