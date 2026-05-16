<?php
include '../connect.php';
include '../includes/header.php';

$result = mysqli_query($connection, "SELECT * FROM tbuser");

/*
$result = mysqli_query($connection, "SELECT u.* FROM tbuser u 
          INNER JOIN tbstudent s ON u.user_id = s.user_id");
*/
?>

<link rel="stylesheet" href="../styles/users.css">

<div class="topbar">
    <div class="topbar-left">
        <div class="topbar-accent"></div>
        <h1>User Management</h1>
    </div>
</div>
<div class="gold-bar"></div>

<div class="page">

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><span class="id-pill">#<?php echo $row['user_id']; ?></span></td>
                    <td>
                        <div class="user-name"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></div>
                    </td>
                    <td>
                        <div class="user-email"><?php echo htmlspecialchars($row['email']); ?></div>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_user.php?id=<?php echo $row['user_id']; ?>"
                               class="btn-del"
                               onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<?php include '../includes/footer.php'; ?>