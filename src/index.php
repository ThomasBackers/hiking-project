<?php
require 'db-config.php';

try {
  $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $OPTIONS);
  echo 'Successfully connected!';

  $query = $pdo->prepare('SELECT * FROM hikes');
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $pdo_exception) {
  echo 'ERROR: '.$pdo_exception->getMessage();
}
?>
<pre>
  <?php print_r($results); ?>
</pre>
