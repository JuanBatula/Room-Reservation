<?php
include '../connect.php';
include '../includes/header.php';

/*
$result = mysqli_query($connection, "SELECT * FROM tbuser");
*/

$result = mysqli_query($connection, "SELECT u.* FROM tbuser u 
          INNER JOIN tbstudent s ON u.user_id = s.user_id");
?>

<h2>Users</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php while($row=mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo $row['user_id']; ?></td>
        <td>
        <?php
        echo $row['first_name']." ".$row['last_name'];
        ?>
        </td>
        <td><?php echo $row['email']; ?></td>
        <td>
        <a href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a>|
        <a href="delete_user.php?id=<?php echo $row['user_id']; ?>"
        onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>