<?php
// $query = $pdo->prepare('INSERT INTO hikes VALUES()');
// $query->execute();
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
  }
}
?>

<section class="create">
  <h2 class="create__heading">
    Create
  </h2>

  <form method="post" action="">
    <label for="name">name</label>
    <input
      type="text"
      name="name"
      maxlength="255"
    >

    <label for="difficulty">difficulty</label>

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

    <label for="distance">distance</label>
    <input
      type="number"
      name="distance"
      min="0"
      step="0.01"
    >

    <label for="duration">duration</label>
    <div name="duration">
      <input
          type="number"
          name="hours"
          min="0"
          max="24"
      >
      hours
      <input
          type="number"
          name="minutes"
          min="0"
          max="59"
      >
      minutes
      <input
          type="number"
          name="seconds"
          min="0"
          max="59"
      >
      seconds
    </div>

    <label for="elevation_gain">elevation gain</label>
    <input
      type="number"
      name="elevation_gain"
      min="0"
    >

    <input type="submit" value="submit">
  </form>
</section>
