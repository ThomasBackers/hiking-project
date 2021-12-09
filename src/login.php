<?php
require_once 'connection.php';

session_start();

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
<h1>User Login</h1>

<form method="post" action="">
  <div>
    <label for="username">Username</label>
    <input type="text" name="username">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" name="password">
  </div>
  <button type="submit">Login</button>
</form>
