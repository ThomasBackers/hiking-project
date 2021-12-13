<?php
session_start();

if (!$_SESSION) {
  header('location:login.php');
}

require_once("connection.php");
// $query = $pdo->prepare('INSERT INTO hikes VALUES()');
// $query->execute();

// duration values formatter needed into create.php
function duration_formatter($post_value) {
  strlen($post_value) === 1 ? $final_value = '0'.$post_value : $final_value = $post_value;
  return $final_value;
}

if (!empty($_POST)) {
  if (
    // let's check if everything is set
    isset(
      $_POST['name'],
      $_POST['difficulty'],
      $_POST['distance'],
      $_POST['hours'],
      $_POST['minutes'],
      $_POST['seconds'],
      $_POST['elevation_gain']
    ) &&
    // if everything is fulfilled too
    !empty($_POST['name']) &&
    !empty($_POST['difficulty']) &&
    !empty($_POST['distance']) &&
    !empty($_POST['hours']) &&
    !empty($_POST['minutes']) &&
    !empty($_POST['seconds']) &&
    !empty($_POST['elevation_gain'])
  ) {
    // let's sanitize the name
    $name = strip_tags($_POST['name']);
    // and the difficulty
    $difficulty = strip_tags($_POST['difficulty']);
    // let's also change the distance into a float
    $distance = $_POST['distance'];
    // let's change the time elements into integers
    $hours = duration_formatter($_POST['hours']);
    $minutes = duration_formatter($_POST['minutes']);
    $seconds = duration_formatter($_POST['seconds']);
    // this one is for checking if time value is null
    if (intval($hours) + intval($minutes) + intval($seconds) !== 0) {
      $duration = "$hours:$minutes:$seconds";
    } else {
      exit;
    }
    // finally elevation_gain has to be an integer
    $elevation_gain = intval($_POST['elevation_gain']);

    $create_form_query = $pdo->prepare(
      'INSERT INTO hikes(name, difficulty, distance, duration, elevationGain)
      VALUES (:name, :difficulty, :distance, :duration, :elevation_gain)'
    );
    $create_form_query->bindParam(':name', $name, PDO::PARAM_STR);
    $create_form_query->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
    $create_form_query->bindParam(':distance', $distance, PDO::PARAM_STR);
    $create_form_query->bindParam(':duration', $duration, PDO::PARAM_STR);
    $create_form_query->bindParam(':elevation_gain', $elevation_gain, PDO::PARAM_INT);

    // execute returns a boolean so let's check it
    if (!$create_form_query->execute()) {
      exit;
    }
    header("location:index.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hiking Project</title>
  <link href="./styles/main.min.css" rel="stylesheet">
</head>

<body>
  <?php include 'header.php'?>

  <section class="create">
    <form class="create__form" class="create__form" method="post" action="">
      <h2 class="create__form__heading">
        Create
      </h2>
      

      <div class="grid-containerxx">
        <div class="create__form__input-field">
          <label for="name">Name</label>
          <input type="text" name="name" maxlength="255">
        </div>
        <div class="create__form__input-field">
          <label for="difficulty">Difficulty</label>
          <select name="difficulty">
            <option value="very easy">
              very easy
            </option>

            <option value="easy">
              easy
            </option>

            <option value="moderate">
              moderate
            </option>

            <option value="hard">
              hard
            </option>

            <option value="very hard">
              very hard
            </option>
          </select>
        </div>

        <div class="create__form__input-field">
          <label for="distance">Distance</label>
          <input type="number" name="distance" min="0" step="0.01">
        </div>

        <div class="create__form__input-field">
          <label for="duration">Duration</label>
          <div name="duration">
            <input type="number" name="hours" min="0" max="24">
            Hours
            <input type="number" name="minutes" min="0" max="59">
            Minutes
            <input type="number" name="seconds" min="0" max="59">
            Seconds
          </div>
        </div>

        <div class="create__form__input-field">
          <label for="elevation_gain">Elevation gain</label>
          <input type="number" name="elevation_gain" min="0">
        </div>

        <input class="create__form__button" type="submit" value="submit">


        <a class="create__form__link" href="./index.php">list of records</a>

      </div>
    </form>
  </section>
</body>
