<?php
// $query = $pdo->prepare('INSERT INTO hikes VALUES()');
// $query->execute();
?>

<form method="post" action="">
    <label for="name">
        name
    </label>
    <input type="text" name="name">

    <label for="difficulty">
        difficulty
    </label>
    <input type="text" name="difficulty">

    <label for="distance">
        distance
    </label>
    <input type="number" name="distance">

    <label for="duration">
        duration
    </label>
    <div name="duration">
        <input
            type="number"
            name="hours"
            min="0"
            max="24"
        >
        :
        <input
            type="number"
            name="minutes"
            min="0"
            max="59"
        >
        :
        <input
            type="number"
            name="seconds"
            min="0"
            max="59"
        >
    </div>

    <label for="elevation_gain"></label>
    <input
        type="number"
        name="elevation_gain"
        min="0"
    >
</form>
