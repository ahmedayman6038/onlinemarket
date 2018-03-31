<?php
include("header.php");
require("DatabaseConnection.php");
if(empty($_GET["id"])){
    header("Location: login.php");
}
if($_GET["add"] == "true"){
    $sql4 = 'SELECT * FROM `cart` WHERE userId='.$_GET["id"].' and productId='.$_GET["pid"].'';
    $result4 = $conn->query($sql4);
    if ($result4->num_rows == 0) {
        $sql = 'INSERT INTO `cart`(`userId`, `productId`) VALUES ('.$_GET["id"].','.$_GET["pid"].')';
        if ($conn->query($sql) === TRUE) {
            
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

?>

<div class="form-horizontal">
        <h2>Shopping Cart</h2>
        <hr>
</div>

<div class="row">
<div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $sql = 'SELECT cart.id,product.pname,category.cname,product.price,product.img,product.desc FROM product,category,cart WHERE cart.userId='.$_GET["id"].' and cart.productId=product.id and product.categoryId = category.id';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo'

                    <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" style="padding-right:4px" href=""> <img class="media-object" src="uploads/'.$row["img"].'" style="width: 150px; height: 150px;"> </a>
                            <div class="media-body" style="padding-left:5px">
                                <h4 class="media-heading">'.$row["pname"].'</h4>
                                <h5 class="media-heading cat">'.$row["cname"].'</h5>
                                <span>'.$row["desc"].'</span>
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input type="text" class="form-control" id="exampleInputEmail1" value="1">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$'.$row["price"].'</strong></td>
                        <td class="col-sm-1 col-md-1">
                        <a href="deleteCart.php?id='.$_SESSION["userId"].'&cid='.$row["id"].'">
                        <button type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </button></a></td>
                    </tr>
    
        

            
            ';
        }
    }else{
        echo '
    <tr>
        <td>   </td>
        <td>Sorry No Data Availble To Show</td>
        <td>   </td>
        <td>   </td>
    </tr>
        ';
    }

    ?>
       <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <a href="index.php">
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </button></a></td>
                        <td>
                        <button type="button" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </button></td>
                    </tr>
      </tbody>
            </table>
        </div>
    </div>


<?php
include("footer.php");
?>