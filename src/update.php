<?php
require_once('connection.php');

try {
	$id = $_GET['id'];
	$q = $pdo->prepare("SELECT * FROM hikes WHERE ID = $id");
	$q->execute();
	$hike = $q->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
	echo e->getMessage();
	exit;
}
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
		<section class="create">

			<h2 class="create__heading">
				Create
			</h2>

			<form method="post" action="">
				<div class="grid-containerx">
					<div class="grid-item"><label for="name">name</label>
						<input type="text" name="name" maxlength="255" value="<?php echo $hike['name']; ?>">
					</div>
					<div class="grid-item"><label for="difficulty">difficulty</label>
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
					<div class="grid-item"><label for="distance">distance</label>
						<input type="number" name="distance" min="0" step="0.01" value="<?php echo $hike['distance']; ?>">
					</div>
					<div class="grid-item"><label for="duration">duration</label>
						<div name="duration">
							<input type="number" name="hours" min="0" max="24" value="<?php echo substr($hike['duration'], 0, 2); ?>">
							hours
							<input type="number" name="minutes" min="0" max="59" value="<?php echo substr($hike['duration'], 3, 2); ?>">
							minutes
							<input type="number" name="seconds" min="0" max="59" value="<?php echo substr($hike['duration'], 6, 2); ?>">
							seconds
						</div>
					</div>
					<div class="grid-item"><label for="elevation_gain">elevation gain</label>
						<input type="number" name="elevation_gain" min="0" value="<?php echo $hike['elevationGain']; ?>">
					</div>
					<div class="grid-item"><input type="submit" value="submit"></div>
					<div class="grid-item">
						<div class="grid-item">
							<button><a href="./index.php">List of records</a></button>
						</div>
					</div>
				</div>
			</form>
		</section>
	</body>
</html>
