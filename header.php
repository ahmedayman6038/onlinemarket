<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
	<link rel="stylesheet" href="styles/style.css">
    <title>Online Store</title>
</head>
<body>
    <div class="header">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                   
                    <a href="index.php" class="navbar-brand">Online Store</a>
            </div>
            <div class="navbar-collapse collapse">
               <?php 
               if(isset($_SESSION["userType"])){
                   if($_SESSION["userType"] == "admin"){
                    echo' <ul class="nav navbar-nav">
                    <li><a href="product.php">Products</a></li>
                     <li><a href="category.php">Categories</a></li>
                     <li><a href="user.php">Users</a></li>
                     </ul>';
                   }
               }
               
               
               
               ?>
                <ul class="nav navbar-nav" style="float:right;">
                    <?php
                        if(!isset($_SESSION['userId'])){
                           echo '<li><a href="login.php">Login <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a></li>';
                          echo  '<li><a href="registration.php">Registration <span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span></a></li>';
                        }else{
                          echo ' <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">';
                            echo $_SESSION['userName'] ;
                            echo ' <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="information.php"><span class="glyphicon glyphicon-pencil"></span> Account Information</a></li>
                              <li><a href="cart.php?id='.$_SESSION["userId"].'&add=false"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>
                            </ul>
                          </li>';
                            echo '<li><a href="logout.php">Logout <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a></li>';
                        }
                    ?>
                
                </ul>
            </div>
        </div>
    </div>
</div>

    <div class="container body-content">
                 
   
