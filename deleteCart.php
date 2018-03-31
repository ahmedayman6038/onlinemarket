<?php
require("DatabaseConnection.php");
$userid = $_GET["id"];
$id = $_GET["cid"];
$sql = "DELETE FROM cart WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    $conn->close();
    $url = "cart.php?id=".$userid."&add=false";
    header("Location: " . $url);
} else {
    echo "Error deleting record: " . $conn->error;
}



?>