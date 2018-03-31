<?php
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
$id = $_GET["id"];

$sql = "DELETE FROM category WHERE id=$id";
if ($conn->query($sql) === TRUE) {
  $conn->close();
  header("Location: category.php" );
} else {
  header("Location: category.php" );
    echo "Error deleting record: " . $conn->error;
}


?>