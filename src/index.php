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
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <a href="logout.php">logout</a>

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
            <?php if ($hike["modified_at"] == null) : ?>

                <div class = "grid-item" > Created at <?php echo $hike["created_at"]; ?> </div>

            <?php else : ?>

                <div class = "grid-item" > Modified at <?php echo $hike["modified_at"]; ?> </div>

            <?php endif ?>
            <div class="grid-item">
                <form class="delete-form" method="post" action="delete.php?id=<?php echo $hike["ID"]; ?>">
                    <input type="submit" name="delete-record" value="Delete record"></input>
                </form>
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
    <script>
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your record has been deleted.',
                        'success'
                    )
                    e.target.submit()
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Database is safe :)',
                        'error'
                    )
                }
            })
        })        
    </script>
</body>
</html>
