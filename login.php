<?php
    session_start();
    include 'connect.php';
?>

<link rel="stylesheet" href="styles/login.css">

<div class="login-page">

    <!-- ── Left: brand panel ── -->
    <div class="login-hero">
        <div class="hero-deco"></div>
        <div class="hero-content">
            <img src="images/citofficiallogo.png" alt="CIT Logo" class="hero-logo">
            <div class="hero-eyebrow">Room Reservation System</div>
            <h1 class="hero-title">Reserve Your<br>Space At <span>CIT</span></h1>
            <p class="hero-desc">Access world-class facilities, modern study pods, and fully-equipped lecture halls for your academic and collaborative needs.</p>
            <div class="hero-chips">
                <span class="chip">Lecture Halls</span>
                <span class="chip">Study Pods</span>
                <span class="chip">Labs</span>
                <span class="chip">Conference Rooms</span>
            </div>
        </div>
    </div>

    <!-- ── Right: form panel ── -->
    <div class="login-form-panel">
        <div class="login-box">
            <div class="gold-line"></div>
            <h2>Welcome back</h2>
            <p class="subtitle">Sign in to your account to continue</p>

            <form method="post">
                <div class="field-group">
                    <label for="txtemail">Email address</label>
                    <input type="text" id="txtemail" name="txtemail" placeholder="you@cit.edu">
                </div>
                <div class="field-group">
                    <label for="txtpassword">Password</label>
                    <input type="password" id="txtpassword" name="txtpassword" placeholder="••••••••">
                </div>
                <input type="submit" name="btnLogin" value="Sign In" class="btn-login-submit">
            </form>

            <div class="login-footer">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>

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