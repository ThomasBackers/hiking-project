<?php

require_once("connection.php");

try {
    //this returns a PDOStatement object
    $q = $pdo->prepare("SELECT ID,name, difficulty, distance, duration, elevationGain FROM hikes");
    //To execute the query set into $q (PDOStatement) object
    $q->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
// PDO::FETCH_ASSOC to display only the columns as keys in the array returned
$hikes = $q->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hikes</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Hikes</h1>
    <?php
    //display the datas
    foreach ($hikes as $hike) : ?>
        <div class="grid-container">
            <div class="grid-item"><?php echo $hike["ID"]; ?></div>
            <div class="grid-item"><?php echo $hike["name"]; ?></div>
            <div class="grid-item"><?php echo $hike["difficulty"]; ?></div>
            <div class="grid-item"><?php echo $hike["distance"]; ?></div>
            <div class="grid-item"><?php echo $hike["duration"]; ?></div>
            <div class="grid-item"><?php echo $hike["elevationGain"]; ?></div>
            <div class="grid-item">
                <form method="post" action="delete.php?id=<?php echo $hike["ID"]; ?>" onsubmit="return confirm('Really Delete?');"><input type="submit" name="delete-record" value="Delete record"></input></form>
            </div>
            <div class="grid-item">
                <form method="post" action="update.php?id=<?php echo $hike["ID"]; ?>"><input type="submit" name="update-record" value="Update record"></input></form>
            </div>
            <div class="grid-item">
                <form method="POST" action="create.php">
                    <input type="submit" value="Create new" />
                </form>
            </div>
        </div>
    <?php endforeach; ?>


</body>

</html>