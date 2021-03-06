<?php
session_start();

if (!$_SESSION) {
  header('location:login.php');
}

require_once('connection.php');

try {
	$id = $_GET['id'];
	$q = $pdo->prepare("SELECT * FROM hikes WHERE ID = $id");
	$q->execute();
	$hike = $q->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
	echo $e->getMessage();
	exit;
}

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
		$intId = intval($id);

    $update_form_query = $pdo->prepare(
      'UPDATE hikes
			SET name = :name,
					difficulty = :difficulty,
					distance = :distance,
					duration = :duration,
					elevationGain = :elevation_gain
			WHERE ID = :ID'
    );
    $update_form_query->bindParam(':name', $name, PDO::PARAM_STR);
    $update_form_query->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
    $update_form_query->bindParam(':distance', $distance, PDO::PARAM_STR);
    $update_form_query->bindParam(':duration', $duration, PDO::PARAM_STR);
    $update_form_query->bindParam(':elevation_gain', $elevation_gain, PDO::PARAM_INT);
		$update_form_query->bindParam(':ID', $intId, PDO::PARAM_INT);

    // execute returns a boolean so let's check it
    if (!$update_form_query->execute()) {
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
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Hiking Project</title>
		<link href="./styles/main.min.css" rel="stylesheet">
	</head>
	<body>
		<?php include 'header.php' ?>
		<section class="create">

			
			<form class="create__form" method="post" action="">
				<h2 class="create__form__heading">
					Update
				</h2>

				<div class="create__form__input-field">
					<div class="grid-item">
						<label for="name">Name</label>
						<input type="text" name="name" maxlength="255" value="<?php echo $hike['name']; ?>">
					</div>

					<div class="create__form__input-field">
						<label for="difficulty">Difficulty</label>
						<select name="difficulty">
							<?php
							$all_values = [
								'very easy',
								'easy',
								'moderate',
								'hard',
								'very hard'
							];
							foreach ($all_values as $value) {
								if ($value === $hike['difficulty']) {
									echo 
									"<option value=\"$value\" selected=\"selected\">
										$value
									</option>";
								} else {
									echo
									"<option value=\"$value\">
										$value
									</option>";
								}
							}
							?>
						</select>
					</div>

					<div class="create__form__input-field">
						<label for="distance">Distance</label>
						<input type="number" name="distance" min="0" step="0.01" value="<?php echo $hike['distance']; ?>">
					</div>

					<div class="create__form__input-field">
						<label for="duration">Duration</label>
						<div name="duration">
							<input type="number" name="hours" min="0" max="24" value="<?php echo substr($hike['duration'], 0, 2); ?>">
							Hours
							<input type="number" name="minutes" min="0" max="59" value="<?php echo substr($hike['duration'], 3, 2); ?>">
							Minutes
							<input type="number" name="seconds" min="0" max="59" value="<?php echo substr($hike['duration'], 6, 2); ?>">
							Seconds
						</div>
					</div>

					<div class="create__form__input-field">
						<label for="elevation_gain">Elevation gain</label>
						<input type="number" name="elevation_gain" min="0" value="<?php echo $hike['elevationGain']; ?>">
					</div>

					<input class="create__form__button" type="submit" value="submit">

					<a class="create__form__link" href="./index.php">list of records</a>
				</div>
			</form>
		</section>
	</body>
</html>
