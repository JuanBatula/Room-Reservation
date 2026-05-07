<?php
    session_start();
    include 'connect.php';
?>

<link rel="stylesheet" href="styles/header.css">

<div>

    <h2>Login</h2>

	<form method="post">
		<pre>			
			Email:<input type="text" name="txtemail">	
			Password:<input type="password" name="txtpassword">				
			
			<input type="submit" name="btnLogin" value="Login"> 
		</pre>
	</form>
</div>



<?php
if(isset($_POST['btnLogin'])){
    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];

    $result = mysqli_query($connection,"SELECT * FROM tbuser WHERE email='$email'");

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password,$user['password'])){
            $user_id = $user['user_id'];

            $checkAdmin = mysqli_query($connection,"SELECT * FROM tbadmin WHERE user_id=$user_id");

            $checkStudent = mysqli_query($connection,"SELECT * FROM tbstudent WHERE user_id='$user_id'");

             $checkFaculty = mysqli_query($connection,"SELECT * FROM tbfaculty WHERE user_id='$user_id'");

            if(mysqli_num_rows($checkAdmin) > 0){
                $_SESSION['admin_id'] = $user_id;
                header("location: admin/dashboard.php");
            } else if(mysqli_num_rows($checkStudent) > 0 || mysqli_num_rows($checkFaculty) > 0) {
                $_SESSION['user_id'] = $user_id;
                header("location: user/dashboard.php");
            } 
			exit();
        } else {
            echo "<script language='javascript'>
				alert('Incorrect password!');s
			</script>";
        }
    } else {
        echo "<script language='javascript'>
				alert('User not found!');s
			</script>";
    }
}
?>