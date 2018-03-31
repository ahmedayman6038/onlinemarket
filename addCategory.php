<?php
include("header.php");
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
$nameErr = "";
?>
<?php
   
if(isset($_POST["submit"])) {
    $ok = 1;
  
    if (!preg_match("/([a-zA-Z0-9])/",$_POST["name"])) {
        $nameErr = "Not on correct format"; 
        $ok = 0;
    }

    // Check if $ok is set to 0 by an error
    if ($ok != 0) {
        $sql = 'INSERT INTO `category`(`cname`, `desc`) VALUES ("'.$_POST["name"].'","'.$_POST['desc'].'")';
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            header("Location: category.php" );
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    }
}
?>
<h2>Create</h2>

<form action="addCategory.php" method="post">
   <div class="form-horizontal">
        <h4>Category</h4>
        <hr>
       
        <div class="form-group">
            <label class="control-label col-md-2">Category Name</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line"  name="name" required>
                <span class="text-danger"><?php echo $nameErr ?></span>
            </div>
        </div>

       
        <div class="form-group">
            <label class="control-label col-md-2">Category descrebtion</label>
            <div class="col-md-10">
                <textarea type="text" class="form-control text-box single-line"  name="desc" required rows="10"></textarea>
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
    <a href="category.php">Back to List</a>
</div>

<?php
include("footer.php");
?>