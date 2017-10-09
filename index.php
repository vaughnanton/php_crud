//model
<?php
require_once "pdo.php";
session_start();
?>

//view
<html>
<head></head>
<body>
<?php
if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}

if ( isset($_SESSION['success']) ) {
  echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
  unset($_SESSION['success']);
}

echo('<table broder="1">'."\n");
$stmt = $pdo->query("SELECT name, email, password, user_id FROM users");
while ( $row = $stmt->(PDO::FETCH_ASSOC) ) {
  echo "<tr><td>";
    echo(htmlentities($row['name']));
    echo("</td><td>");
    echo(htmlentities($row['email']));
    echo("</td><td>");
    echo(htmlentities($row['password']));
    echo("</td><td>");
    echo('<a href="edit.php?user_id='.$row['user_id'].'">Edit</a> / ');
    echo('<a href="delete.php?user_id='.$row['user_id'].'">Delete</a> / ');
    echo("</td></tr>\n");
}
?>
</table>
<a href="add.php">Add New</a>
