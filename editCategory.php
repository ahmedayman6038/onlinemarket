<?php
include("header.php");
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
$categoryId = $_GET["id"];
$sql = "SELECT `id`, `cname`, `desc` FROM `category` WHERE id=".$categoryId."";
$result = $conn->query($sql);
$rowData;
if ($result->num_rows > 0) {
    $rowData = $result->fetch_assoc(); 
}
$nameErr = "";
$name = $desc = "";
?>
<?php
   
if(isset($_POST["submit"])) {
    $ok = 1;
  
  
    if (!preg_match("/([a-zA-Z0-9])/",$_POST["name"])) {
        $nameErr = "not on correct format"; 
        $ok = 0;
    }

    if ($ok != 0) {
        $name = test_input($_POST["name"]);
        $desc = test_input($_POST['desc']);
        $sql2 = 'UPDATE `category` SET cname="'.$name.'",`desc`="'.$desc.'" WHERE id='.$rowData["id"].'';
        if ($conn->query($sql2) === TRUE) {
            $conn->close();
            header("Location: category.php" );
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
        
    }
}
?>
<h2>Edit</h2>

<form action="editCategory.php?id=<?php echo $_GET["id"]?>" method="post">
   <div class="form-horizontal">
        <h4>Category</h4>
        <hr>
       
        <div class="form-group">
            <label class="control-label col-md-2">Category Name</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line"  name="name" value="<?php echo $rowData["cname"]?>" required>
                <span class="text-danger"><?php echo $nameErr ?></span>
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-md-2">Category descrebtion</label>
            <div class="col-md-10">
                <textarea type="text" class="form-control text-box single-line" name="desc" required rows="10"><?php echo $rowData["desc"]?></textarea>
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
    <a href="category.php">Back to List</a>
</div>

<?php
include("footer.php");
?>