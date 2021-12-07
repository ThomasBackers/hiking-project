<?php
// $query = $pdo->prepare('INSERT INTO hikes VALUES()');
// $query->execute();
?>
<section class="create">
  <h2>Create</h2>

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
