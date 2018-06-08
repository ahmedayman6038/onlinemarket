<?php
include("header.php");
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
$nameErr = $emailErr = $passwordErr = $telephoneErr  = $userErr = "";
$name = $email = $password = $telephone = "";
?>
<?php
   
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

    if(!empty($_POST["telephone"])){
        if (!filter_var($_POST["telephone"], FILTER_SANITIZE_NUMBER_INT)) {
            $telephoneErr = "Only numbers allowed"; 
            $ok = 0;
        }
    }

    // Check if $ok is set to 0 by an error
    if ($ok != 0) {
        $name = test_input($_POST["name"]);
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);
        $telephone = test_input($_POST["telephone"]);
        $sql7 = "SELECT * FROM `user` WHERE email='".$email."' or password='".$password."'";
        $result = $conn->query($sql7);
        if ($result->num_rows > 0) {
            $userErr = "User Email or Password Alerady Exist";
        }else{
            $sql = 'INSERT INTO `user`(`name`, `email`, `password`, `telephone`, `type`) VALUES ("'.
            $name.'","'. $email.'","'. $password.'","'. $telephone.'","'. $_POST["type"].'")';
            if ($conn->query($sql) === TRUE) {
                $conn->close();
                header("Location: user.php" );
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
    }
}
?>
<h2>Create</h2>

<form action="addUser.php" method="post">
   <div class="form-horizontal">
        <h4>User</h4>
        <hr>
       
        <div class="form-group">
            <label class="control-label col-md-2">User Name</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line"  name="name" required>
                <span class="text-danger"><?php echo $nameErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">User Email</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line"  name="email" required>
                <span class="text-danger"><?php echo $emailErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">User Password</label>
            <div class="col-md-10">
                <input type="password" class="form-control text-box single-line"  name="password" required>
                <span class="text-danger"><?php echo $passwordErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">User Telephone</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line"  name="telephone">
                <span class="text-danger"><?php echo $telephoneErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">User Type</label>
            <div class="col-md-10">
            <select class="form-control text-box single-line" name="type">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <span class="text-danger"><?php echo $userErr?></span>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="Create" class="btn btn-default" name="submit">
            </div>
        </div>
    </div>
</form>


<div>
    <a href="user.php">Back to List</a>
</div>

<?php
include("footer.php");
?>