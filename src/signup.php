<?php
require_once 'connection.php';

session_start();

if(!empty($_POST)) {
    if(isset($_POST['username'], $_POST['email'], $_POST['password']) &&
      !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])
    ) {
      $username = strip_tags($_POST['username']);
      
      if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        exit('invalid e-mail address');
      }
      
      $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

      $q = $pdo->prepare(
        'INSERT INTO users(username, email, passwordHash)
        VALUES (:username, :email, :password_hash)'
      );
      $q->bindParam(':username', $username, PDO::PARAM_STR);
      $q->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
      $q->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);
      
      if (!$q->execute()) {
        exit('unable to join the database or unable to execute query');
      }

      $ID = $pdo->lastInsertId();
      $_SESSION['user'] = [
        'ID'=> $ID,
        'username' => $username,
        'email' => $_POST['email']
      ];

      header("location: index.php");
  } else {
    exit("it is mandatory to fill all the fields up");
  }
}
?>
<h1>User subscription</h1>

    <form method="post" action="">
        <div>
            <label for="username">Login :</label>
            <input type="text" name="username">
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email">
        </div>
        <div>
            <label for="password">Password :</label>
            <input type="password" name="password">
        </div>
        <button type="submit">Subscribe</button>
    </form>
