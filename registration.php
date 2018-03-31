<?php
include("header.php");
require("DatabaseConnection.php");
$nameErr = $emailErr = $passwordErr = $cpasswordErr  = $userErr = "";

if(isset($_POST["submit"])) {
    $ok = 1;
  
    if (!preg_match("/([a-zA-Z0-9])/",$_POST["name"])) {
        $nameErr = "Not on correct format"; 
        $ok = 0;
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format"; 
        $ok = 0;
      }
    if(!preg_match("/[A-Za-z0-9]+/", $_POST["password"])){
        $passwordErr = "Only letter and numbers allowed"; 
        $ok = 0;
    }
    if($_POST["cpassword"] != $_POST["password"]){
        $cpasswordErr = "The two password is not identical"; 
        $ok = 0;
    }

    // Check if $ok is set to 0 by an error
    if ($ok != 0) {
        $sql7 = "SELECT * FROM `user` WHERE email='".$_POST["email"]."' or password='".$_POST["password"]."'";
        $result = $conn->query($sql7);
        if ($result->num_rows > 0) {
            $userErr = "User Email or Password Alerady Exist";
        }else{
            $sql = "INSERT INTO `user`(`name`, `email`, `password`,`telephone`, `type`) VALUES ('".
            $_POST["name"]."','". $_POST["email"]."','". $_POST["password"]."','','user')";
            if ($conn->query($sql) === TRUE) {
                $sql5 = "SELECT * FROM `user` WHERE email='".$_POST["email"]."' and password='".$_POST["password"]."'";
                $result = $conn->query($sql5);
                $rowData5;
                if ($result->num_rows > 0) {
                  $rowData5 = $result->fetch_assoc(); 
                  $_SESSION["userId"] = $rowData5["id"];
                  $_SESSION["userName"] = $rowData5["name"];
                  $_SESSION["userType"] = $rowData5["type"];
                }
                header("Location: index.php" );
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
        $conn->close();
    }
}
?>



<form class="form-horizontal" method="post" action="registration.php">
<fieldset>

<h2>Registration</h2>
<hr>
<div class="form-group">
<label class="control-label col-md-4">User Name</label>
<div class="col-md-4">
    <input type="text" class="form-control input-md"  name="name" required>
    <span class="text-danger"><?php echo $nameErr ?></span>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">User Email</label>
<div class="col-md-4">
    <input type="text" class="form-control input-md"  name="email" required>
    <span class="text-danger"><?php echo $emailErr ?></span>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">User Password</label>
<div class="col-md-4">
    <input type="password" class="form-control input-md"  name="password" required>
    <span class="text-danger"><?php echo $passwordErr ?></span>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">Confirm User Password</label>
<div class="col-md-4">
    <input type="password" class="form-control input-md"  name="cpassword" required>
    <span class="text-danger"><?php echo $cpasswordErr ?></span>
    <span class="text-danger"><?php echo $userErr ?></span>
</div>
</div>



<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4 center-block">
    <input  type="submit" value="Registration" name="submit" class="btn btn-primary">
  </div>
</div>

</fieldset>
</form>




<?php
include("footer.php");
?>