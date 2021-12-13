<?php
session_start();

require_once 'connection.php';

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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./styles/main.min.css" rel="stylesheet">
  <title>Document</title>
</head>
<body>
  <?php include 'header.php' ?>

  <section class="login-section">

    
    <form class="login-form" method="post" action="">
      <h2 class="login-form__heading">Sign up</h2>

      <div class="login-form__input-field">
          <label class="login-form__input-field__label" for="username">Login</label>
          <input class="login-form__input-field__input" type="text" name="username">
      </div>

      <div class="login-form__input-field">
          <label class="login-form__input-field__label" for="email">Email</label>
          <input class="login-form__input-field__input" type="email" name="email">
      </div>

      <div class="login-form__input-field">
          <label class="login-form__input-field__label" for="password">Password</label>
          <input class="login-form__input-field__input" type="password" name="password">
      </div>
      <button class="login-form__button" type="submit">subscribe</button>
      <a class="login-form__link" href="/login.php">login</a>
    </form>

  </section>
</body>
</html>
