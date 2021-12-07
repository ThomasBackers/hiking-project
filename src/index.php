<?php
require 'utils.php';
require 'connection.php';

$query = $pdo->prepare('SELECT * FROM hikes');
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>

  <body>
    <?php include 'create.php';?>
  </body>
</html>
