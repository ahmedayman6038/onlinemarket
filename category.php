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
<h2>Categories</h2>

<p>
    <a href="addCategory.php">Create New</a>
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
            Descreptions
        </th>
        <th></th>
    </tr>

<?php
$sql = "SELECT `id`, `cname`, `desc` FROM `category`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>
            {$row["id"]}
        </td>
        <td>
             {$row["cname"]}
        </td>
        <td>
            {$row["desc"]}
        </td>
        <td>
            <a href='editCategory.php?id={$row["id"]}'>Edit</a> |
            <a href='deleteCategory.php?id={$row["id"]}'>Delete</a>
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