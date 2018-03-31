<?php
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
   // header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    //header("Location: login.php");
  }
  
$id = $_GET["id"];
$sql2 = "DELETE FROM cart WHERE userId=$id";
$conn->query($sql2); 
$sql = "DELETE FROM user WHERE id=$id";
if ($conn->query($sql) === TRUE) {
  $conn->close();
  header("Location: user.php" );
} else {
    echo "Error deleting record: " . $conn->error;
}


?>