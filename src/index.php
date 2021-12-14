<?php
session_start();

if (!$_SESSION) {
  header('location:login.php');
}

require_once("connection.php");

try {
    //this returns a PDOStatement object
    $q = $pdo->prepare("SELECT ID,name, difficulty, distance, duration, elevationGain, created_at, modified_at FROM hikes");
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
    <link href="./styles/main.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include 'header.php'?>
    
    <div class="logout-div">
        <a class="logout" href="logout.php">logout</a>
    </div>

    <section class="hikes">
        <?php
        //display the datas
        foreach ($hikes as $hike) : ?>
            <div class="hike">
                <div class="hike__id"><?php echo $hike["ID"]; ?></div>

                <div class="hike__name"><?php echo $hike["name"]; ?></div>

                <div class="hike__difficulty">
                    <span>Difficulty:</span> <?php echo $hike["difficulty"]; ?>
                </div>

                <div class="hike__distance">
                    <span>Distance:</span> <?php echo $hike["distance"]; ?> m
                </div>

                <div class="hike__duration">
                    <span>Duration:</span> <?php echo $hike["duration"]; ?>
                </div>

                <div class="hike__elevation">
                    <span>Elevation gain:</span> <?php echo $hike["elevationGain"]; ?> m
                </div>

                <?php if ($hike["modified_at"] == null) : ?>
                    <div class = "hike__date" >
                        Created at <?php echo $hike["created_at"]; ?>
                    </div>
                <?php else : ?>
                    <div class = "hike__date" >
                        Modified at <?php echo $hike["modified_at"]; ?>
                    </div>
                <?php endif ?>

                <div class="hike__delete">
                    <form class="delete-form" method="post" action="delete.php?id=<?php echo $hike["ID"]; ?>">
                        <input type="submit" name="delete-record" value="Delete record"></input>
                    </form>
                </div>

                <div class="hike__update">
                    <form method="post" action="update.php?id=<?php echo $hike["ID"]; ?>">
                        <input type="submit" name="update-record" value="Update record"></input>
                    </form>
                </div>

                <div class="hike__create">
                    <form method="POST" action="create.php">
                        <input type="submit" value="Create new" />
                    </form>
                </div>

            </div>
        <?php endforeach; ?>
    </section>

    <script type="text/javascript" src="scripts.js"></script>  
</body>
</html>
