<?php
include("header.php");
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
$nameErr = $priceErr = $imgErr  = "";
$name = $price = $desc = ""; 
?>
<?php
   
if(isset($_POST["submit"])) {
    $image = "blank.jpg";
    $ok = 1;
    $date = date('Y-m-d H:i:s');
    $uniqe = md5(uniqid($date, true) * rand());
    if(!empty($_FILES["img"]["name"])){
        $target_dir = "uploads/";
        $target_file = $target_dir . $uniqe . "-" .basename($_FILES["img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if($check !== false) {
            $ok = 1;
        } else {
            $imgErr= "File is not an image.";
            $ok = 0;
        }
    
        // Check if file already exists
        if (file_exists($target_file)) {
            $imgErr= "Sorry, file already exists.";
            $ok = 0;
        }
    
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $imgErr= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $ok = 0;
        }
        $image = basename($_FILES["img"]["name"]);
    
    }
  
    if (!preg_match("/([a-zA-Z0-9])/",$_POST["name"])) {
        $nameErr = "Not on correct format"; 
        $ok = 0;
    }

    if (!preg_match('/^[0-9]+(?:\.[0-9]{0,2})?$/',$_POST["price"])) {
        $priceErr = "Not vaild price"; 
        $ok = 0;
    }
    // Check if $ok is set to 0 by an error
    if ($ok != 0) {
        if ($image != "blank.jpg") {
            move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
            $filename = $uniqe . "-" . $image;
        }else{
            $filename = $image;
        }
        $name = test_input($_POST["name"]);
        $desc = test_input($_POST["desc"]);
        $price = test_input($_POST["price"]);
        $sql = 'INSERT INTO `product`(`pname`, `categoryId`, `price`, `img`, `desc`) VALUES ("'.
        $name.'",'.
        $_POST['category'].','.$price.',"'.$filename.'","'.$desc.'")';
        
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            header("Location: product.php" );
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    
    }
}
?>
<h2>Create</h2>

<form action="addProduct.php" method="post" enctype="multipart/form-data">
   <div class="form-horizontal">
        <h4>Product</h4>
        <hr>
       
        <div class="form-group">
            <label class="control-label col-md-2">Product Name</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line"  name="name" required>
                <span class="text-danger"><?php echo $nameErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Product Category</label>
            <div class="col-md-10">
            <select class="form-control text-box single-line" name="category">
                <?php
                $sql = "SELECT `id`, `cname` FROM `category`";
                $result = $conn->query($sql);
                
                while($row = $result->fetch_assoc()) {
                echo "<option value='{$row["id"]}'>{$row["cname"]}</option>";
                }
                ?>
            </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Product Price</label>
            <div class="col-md-10">
                <input type="text" class="form-control text-box single-line"  name="price" required>
                <span class="text-danger"><?php echo $priceErr ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Product descrebtion</label>
            <div class="col-md-10">
                <textarea type="text" class="form-control text-box single-line"  name="desc" required rows="10"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Product Image</label>
            <div class="col-md-10">
                <input type="file" class="form-control text-box single-line" name="img">
                <span class="text-danger"><?php echo $imgErr ?></span>
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
    <a href="product.php">Back to List</a>
</div>

<?php
include("footer.php");
?>