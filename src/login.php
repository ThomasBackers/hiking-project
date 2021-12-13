<?php
session_start();

require_once 'connection.php';

if(!empty($_POST)) {
  if(isset($_POST['username'],$_POST['password'])
    && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = strip_tags($_POST['username']);

    $q = $pdo->prepare('SELECT * FROM users WHERE username=:username');
    $q->bindParam(':username', $username, PDO::PARAM_STR);
    if(!$q->execute()) {
      exit('unable to join the database or unable to execute query');
    }

    $user = $q->fetch(PDO::FETCH_ASSOC);
    if(!$user) {
      exit('user doesn\'t exist and/or password incorrect');
    }
    if(!password_verify($_POST['password'], $user['passwordHash'])){
      exit('user doesn\'t exist and/or password incorrect');
    }

    $_SESSION['user'] = [
      'ID' => $user['ID'],
      'username' => $user['username'],
      'email' => $user['email']
    ];

    header('location:index.php');
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
  <?php include 'header.php';?>
  
  <section class="login-section">
    
    <form method="post" action="" class="login-form">
      <h2 class="login-form__heading">Login</h2>

      <div class="login-form__input-field">
        <label class="login-form__input-field__label" for="username">Username</label>
        <input class="login-form__input-field__input" type="text" name="username">
      </div>
      <div class="login-form__input-field">
        <label class="login-form__input-field__label" for="password">Password</label>
        <input class="login-form__input-field__input" type="password" name="password">
      </div>

      <button  type="submit">login</button>
      <a href="/signup.php">sign up</a>
    </form>

  </section>
</body>
</html>
