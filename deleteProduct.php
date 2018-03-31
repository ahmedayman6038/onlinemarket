<?php
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
  
$id = $_GET["id"];
$img = "uploads/".$_GET["img"];
if($_GET["img"] != "blank.jpg"){
    unlink($img);
}
$sql2 = "DELETE FROM cart WHERE productId=$id";
$conn->query($sql2);
$sql = "DELETE FROM product WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    $conn->close();
    header("Location: product.php" );
} else {
    echo "Error deleting record: " . $conn->error;
}


?>