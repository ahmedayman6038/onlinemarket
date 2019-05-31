<?php
include("header.php");
require("DatabaseConnection.php");
$error = "";
if(isset($_POST["submit"])){
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $sql = "SELECT * FROM `user` WHERE email='".$email."' and password='".$password."'";
    $result = $conn->query($sql);
    $rowData;
    if ($result->num_rows > 0) {
      $rowData = $result->fetch_assoc(); 
      $_SESSION["userId"] = $rowData["id"];
      $_SESSION["userName"] = $rowData["name"];
      $_SESSION["userType"] = $rowData["type"];
      if($_SESSION["userType"] == "admin"){
        header("Location: dashboard.php");
      }else{
        header("Location: index.php");
      }
    }else{
        $error = "User Email or Password Not Correct";
    }
}
?>



<form class="form-horizontal" method="post" action="login.php">
<fieldset>

<h2>Login</h2>
<hr>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Email:</label>  
  <div class="col-md-4">
  <input  name="email" type="text" placeholder="Enter your email" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">Password:</label>
  <div class="col-md-4">
    <input name="password" type="password" placeholder="Enter your password" class="form-control input-md" required="">
    <span class="text-danger"><?php echo $error ?></span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4 center-block">
    <input  type="submit" value="Login" name="submit" class="btn btn-primary">
  </div>
</div>

</fieldset>
</form>

<script>
  alert("Testing account to login:\nEmail: ahmedayman@gmail.com\nPassword: 0000");
</script>


<?php
include("footer.php");
?>