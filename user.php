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
<h2>Users</h2>

<p>
    <a href="addUser.php">Create New</a>
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
            Email
        </th>
        <th>
            Telephone
        </th>
        <th>
            Type
        </th>
        <th></th>
    </tr>

<?php
$sql = "SELECT `id`, `name`, `email`, `password`, `telephone`, `type` FROM `user`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>
            {$row["id"]}
        </td>
        <td>
             {$row["name"]}
        </td>
        <td>
            {$row["email"]}
        </td>
        <td>
            {$row["telephone"]}
        </td>
        <td>
            {$row["type"]}
        </td>
        <td>
            <a href='editUser.php?id={$row["id"]}'>Edit</a> |
            <a href='deleteUser.php?id={$row["id"]}'>Delete</a>
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