<?php
require 'db-config.php';

$query = $pdo->prepare('SELECT * FROM hikes');
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<pre>
  <?php print_r($results); ?>
</pre>
