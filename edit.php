<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['email'])
    && isset($_POST['password']) && isset($_POST['user_id']) ) {
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

      $sql = "UPDATE users SET name = :n, email = :e, password = :p
              WHERE user_id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
          ':n' => $_POST['name'],
          ':e' => $_POST['email'],
          ':p' => $_POST['password'],
          ':id' => $_POST['user_id']));
      $_SESSION['success'] = 'Record updated';
      header( 'Location: index.php' ) ;
      return;
}
//verify user_id present
if ( ! isset($_GET['user_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM users where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
  $_SESSION('error') = 'Bad value for user_id';
  header( 'Location: index.php' ) ;
  return
}
//takes the old values to put into submit form in HTML view below
$n = htmlentities($row['name']);
$e = htmlentities($row['email']);
$p = htmlentities($row['password']);
$user_id = $row['user_id'];
?>

<p>Edit User</p>
<form method="post">
<p>Name:
<input type="text" name="name" value="<?= $n ?>"></p>
<p>Email:
<input type="text" name="email" value="<?= $e ?>"></p>
<p>Password:
<input type="text" name="password" value="<?= $p ?>"></p>
<input type="hidden" name="user_id" value="<?= $user_id ?>">
<p><input type="submit" value="Update"/>
<a href="index.php">Cancel</a></p>
</form>
