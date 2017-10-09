<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {

  //data validation
  if ( strlen($_POST['name']) < 1 || strlen($_POST['password']) <1) {
    $_SESSION['error'] = 'Missing data';
    header("Location: add.php");
    return
  }

  if ( strpos($_POST['email'], '@') === false ) {
    $_SESSION['error'] = 'Bad data';
    header("Location: add.php");
    return;
  }

  $sql = "INSERT INTO users (name, email, password) VALUES (:n, :e, :p)";
  $stmt = $pdo->prepare($sql);
  $stmt-> execute(array(
    ':n' => $_POST['name'],
    ':e' => $_POST['email'],
    ':p' => $_POST['password']));
    $_SESSION['success'] = 'Record added';
    header( 'Location: index.php' ) ;
    return;

}

//flash message
if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}
?>

<p>Add a New User</p>
<form method="post">
<p>Name:
<input type="text" name="name"></p>
<p>Email:
<input type="text" name="email"></p>
<p>Password:
<input type="password" name="password"></p>
<p><input type="submit" value="Add New"/>
<a href="index.php">Cancel</a></p>
</form>
