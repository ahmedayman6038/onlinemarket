
<?php
include("header.php");
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
$sql = "SELECT `id`, `name`, `email`, `password`, `telephone`, `type` FROM `user` WHERE id=".$_SESSION["userId"]."";
$result = $conn->query($sql);
$rowData;
if ($result->num_rows > 0) {
    $rowData = $result->fetch_assoc(); 
}
$nameErr = $emailErr = $passwordErr = $telephoneErr = $userErr = "";
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
        $sql7 = 'SELECT * FROM `user` WHERE email="'.$_POST["email"].'" or password="'.$_POST["password"].'"';
        $result7 = $conn->query($sql7);
        if ($result7->num_rows > 1) {
            $userErr = "User Email or Password Alerady Exist";
        }else{
            $_SESSION["userName"] = $_POST["name"];
            $sql2 = 'UPDATE `user` SET `name`="'.$_POST["name"].'",`email`="'.$_POST["email"].
            '",`password`="'.$_POST["password"].'",`telephone`="'.$_POST["telephone"].'" WHERE id='.$rowData["id"].'';
            if ($conn->query($sql2) === TRUE) {
                $conn->close();
                header("Location: index.php" );
            } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            }
        }
        
    }
}
?>
<h2>Account Information</h2>

<form action="information.php" method="post">
   <div class="form-horizontal">
        <hr>
       
        <div class="form-group">
            <label class="control-label col-md-2">User Name</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line" value="<?php echo $rowData["name"]?>" name="name" required>
                <span class="text-danger"><?php echo $nameErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">User Email</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line" value="<?php echo $rowData["email"]?>" name="email" required>
                <span class="text-danger"><?php echo $emailErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">User Password</label>
            <div class="col-md-10">
                <input type="password" class="form-control text-box single-line" value="<?php echo $rowData["password"]?>" name="password" required>
                <span class="text-danger"><?php echo $passwordErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">User Telephone</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line" value="<?php echo $rowData["telephone"]?>"  name="telephone">
                <span class="text-danger"><?php echo $telephoneErr ?></span>
                <span class="text-danger"><?php echo $userErr ?></span>
            </div>
        </div>



        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="Edit" class="btn btn-default" name="submit">
            </div>
        </div>
    </div>
</form>


<div>
    <a href="index.php">Back to List</a>
</div>





<?php
include("footer.php");
?>