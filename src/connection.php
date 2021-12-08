<?php
define('DB_DSN', 'mysql:host=188.166.24.55;dbname=jepsen5-andrewskurka;port=3306');
define('DB_USER', 'jepsen5-andrewskurka');
define('DB_PASSWORD', 'xSJ@wULb6qK76X#v}EDn');
define('OPTIONS', [
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, OPTIONS);
} catch(PDOException $pdo_exception) {
  echo $pdo_exception->getMessage();
  exit;
}
?>
