<?php
include("header.php");
require("DatabaseConnection.php");
if(!isset($_SESSION["userId"])){
    header("Location: login.php");
  }
  if($_SESSION["userType"] != "admin"){
    header("Location: login.php");
  }
?>
<h2>Products</h2>

<p>
    <a href="addProduct.php">Create New</a>
</p>
<table class="table">
    <tr>
        <th>
            ID
        </th>
        <th>
            Name
        </th>
        <th>
            Category Name
        </th>
        <th>
            Price
        </th>
        <th>
            Image
        </th>
        <th></th>
    </tr>

<?php
$sql = "SELECT product.id,product.pname,category.cname,product.price,product.img FROM product,category WHERE product.categoryId = category.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>
            {$row["id"]}
        </td>
        <td>
             {$row["pname"]}
        </td>
        <td>
            {$row["cname"]}
        </td>
        <td>
            "."$"."{$row["price"]}
        </td>
        <td>
             <img src='uploads/{$row["img"]}' width='150' height='100'/>
        </td>
        <td>
            <a href='editProduct.php?id={$row["id"]}'>Edit</a> |
            <a href='deleteProduct.php?id={$row["id"]}&img={$row["img"]}'>Delete</a>
        </td>
    </tr>";
    }
} else {
    echo '<tr class="text-center"><td></td><td>No data to show</td><td></td></tr>';
}

?>
   

</table>
<?php
$conn->close();
include("footer.php");

?>