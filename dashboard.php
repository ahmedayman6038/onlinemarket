<?php include("header.php");
    require("DatabaseConnection.php");
?>

<?php
 if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
  $products = $users = $categories = $carts = 0;
  $sql1 = "SELECT COUNT(*) FROM product"; 
  $result1 = $conn->query($sql1);
  $row1 = $result1->fetch_assoc();
  $products = $row1["COUNT(*)"];

  $sql2 = "SELECT COUNT(*) FROM user"; 
  $result2 = $conn->query($sql2);
  $row2 = $result2->fetch_assoc();
  $users = $row2["COUNT(*)"];

  $sql3 = "SELECT COUNT(*) FROM category"; 
  $result3 = $conn->query($sql3);
  $row3 = $result3->fetch_assoc();
  $categories = $row3["COUNT(*)"];

  $sql4 = "SELECT COUNT(*) FROM cart"; 
  $result4 = $conn->query($sql4);
  $row4 = $result4->fetch_assoc();
  $carts = $row4["COUNT(*)"];

  $conn->close();
?>
<div class="dashboard">
<h1>Welcome To Dashboard</h1>
<h3>You Can Manage WebSite Her</h3>

<div class="row counters">
    <div class="col-md-3">
    <div class="counter">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      <h2 class="timer count-title count-number" data-to="<?php echo $products?>" data-speed="1000"></h2>
       <p class="count-text ">Product</p>
    </div>
</div>

  <div class="col-md-3">
    <div class="counter">
    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
      <h2 class="timer count-title count-number" data-to="<?php echo $categories?>" data-speed="1000"></h2>
      <p class="count-text ">Category</p>
    </div>
</div>

  <div class="col-md-3">
    <div class="counter">
    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
      <h2 class="timer count-title count-number" data-to="<?php echo $users?>" data-speed="1000"></h2>
      <p class="count-text ">User</p>
    </div>
</div>

  <div class="col-md-3">
    <div class="counter">
    <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
      <h2 class="timer count-title count-number" data-to="<?php echo $carts?>" data-speed="1000"></h2>
      <p class="count-text ">Product Added To Cart</p>
    </div>
</div>
</div>

</div>


<?php include("footer.php")?>