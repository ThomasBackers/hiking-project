<?php
session_start();

if (!$_SESSION) {
    header('location:login.php');
}

require_once("connection.php");

try {
    $id = $_GET['id']; // get id through query string
    //var_dump($id);
    $q = $pdo->prepare("delete from hikes where ID = '$id'");

    //To execute the query set into $q (PDOStatement) object
    $q->execute();
    header("location:index.php"); // redirects to all records page
    exit;
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
?>
