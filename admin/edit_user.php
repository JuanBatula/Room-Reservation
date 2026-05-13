<?php
include '../connect.php';
include '../includes/header.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbuser WHERE user_id=$id"));
?>

<h2>Edit User</h2>

<form method="POST">
    <pre>
    First Name: <input type="text" name="fname"
    value="<?php echo $data['first_name']; ?>">

    Last Name: <input type="text" name="lname"
    value="<?php echo $data['last_name']; ?>">

    Email: <input type="text" name="email"
    value="<?php echo $data['email']; ?>">

    <input type="submit" name="btnUpdate" value="Update">
    </pre>
</form>

<?php

if(isset($_POST['btnUpdate'])){

mysqli_query($connection, "UPDATE tbuser SET
first_name='".$_POST['fname']."',
last_name='".$_POST['lname']."',
email='".$_POST['email']."'
WHERE user_id=$id");

header("location: users.php");

}
?>