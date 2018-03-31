<?php include("header.php");
require("DatabaseConnection.php");
?>

<form action="index.php">
   <div class="form-horizontal">
        <h2>Our Products</h2>
        <hr>

        <div class="form-group">
            <label class="control-label col-md-2">Filter by Category</label>
            <div class="col-md-10">
            <select class="form-control text-box single-line" style="display:inline;" name="category">
                <?php
                $sql = "SELECT `id`, `cname` FROM `category`";
                $result = $conn->query($sql);
                
                while($row = $result->fetch_assoc()) {
                echo "<option value='{$row["id"]}'>{$row["cname"]}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Filter" class="btn btn-default" name="submit">
            </div>
        </div>
    </div>
</form>
<?php

if(isset($_GET["submit"])){
    $sql = "SELECT product.id,product.pname,category.cname,product.price,product.img,product.desc FROM product,category WHERE product.categoryId = category.id and product.categoryId =".$_GET["category"]."";    
}else{
    $sql = "SELECT product.id,product.pname,category.cname,product.price,product.img,product.desc FROM product,category WHERE product.categoryId = category.id";    
}
$result = $conn->query($sql);
$result2 = $conn->query($sql);
echo '<div class="row">';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo '
    <div class="col-md-4">
          <div class="thumbnail">
            <img src="uploads/'.$row["img"].'" alt="" class="img-responsive" width="200" heigh="200">
            <div class="caption">
              <h4 class="pull-right">$'.$row["price"].'</h4>
              <h4>'.$row["pname"].'</h4>
              <p class="cat">'.$row["cname"].'</p>
            </div>
            <div class="ratings">
              <p>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                 (15 reviews)
              </p>
            </div>
            <div class="space-ten"></div>
            <div class="btn-ground text-center">
            <a href="cart.php?pid='.$row["id"].'&id=';
            if(isset($_SESSION["userId"])){echo $_SESSION["userId"];}
            echo '&add=true"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button></a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#product'.$row["id"].'"><span class="glyphicon glyphicon-search"></span> View Details</button>
            </div>
            <div class="space-ten"></div>
          </div>    
    </div>';
    }
    echo '</div>';
while($row2 = $result2->fetch_assoc()) {
    echo '
<div class="modal fade product_view" id="product'.$row2["id"].'">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
            <h3 class="modal-title">'.$row2["pname"].'</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 product_img">
                    <img src="uploads/'.$row2["img"].'" class="img-responsive" width="200" height="200">
                </div>
                <div class="col-md-6 product_content">
                    <h4>Product Id: <span>'.$row2["id"].'</span></h4>
                    <div class="rating">
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        (15 reviews)
                    </div>
                    <p>'.$row2["desc"].'</p>
                    <h3 class="cost"><span class="glyphicon glyphicon-usd"></span> '.$row2["price"].'</h3>
                   
                    <div class="space-ten"></div>
                    <div class="btn-ground">
                    <a href="cart.php?pid='.$row2["id"].'&id=';
                    if(isset($_SESSION["userId"])){echo $_SESSION["userId"];}
                      echo '&add=true"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    ';
    }
} else {
    echo '<h3 class="text-center">NO Data Avaliable To Show<h3>';
}
?>

   





<?php include("footer.php")?>