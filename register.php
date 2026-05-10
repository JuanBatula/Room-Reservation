<?php
include 'connect.php';
?>

<h2>User Registration</h2>

<div>
	<form method="POST">
		<pre>
			First Name:<input type="text" name="txtfname">
			Last Name:<input type="text" name="txtlname">
			Gender:
			<select name="txtgender">
			<option value="">----</option>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
			</select>

			Mobile Number: <input type="text" name="txtmobile">
			Program: <input type="text" name="txtprogram">
			Year_level:
			<select name="txtyear_level">
			 <option value="">----</option>
			 <option value="1">1</option>
			 <option value="2">2</option>
			 <option value="3">3</option>
			 <option value="4">4</option>
			</select>
			Email: <input type="text" name="txtemail">
			Password: <input type="password" name="txtpassword">
		
			<input type="submit" name="btnRegister" value="Register">
			Already have an account? <a href="login.php">Login</a>
		</pre>
	</form>
</div>

<?php
if(isset($_POST['btnRegister'])){
    $fname = trim($_POST['txtfname']);
    $lname = trim($_POST['txtlname']);
    $gender = trim($_POST['txtgender']);
    $mobile = trim($_POST['txtmobile']);
    $email = trim($_POST['txtemail']);
    $password_input = trim($_POST['txtpassword']);
    $program = trim($_POST['txtprogram']);
	$year_level = trim($_POST['txtyear_level']);

    if(empty($fname) || empty($lname) || empty($gender) || empty($mobile) || empty($email) || empty($password_input) || empty($program) || empty($year_level)){
        echo "<script>
                alert('All fields are required.');
              </script>";
    }else{
        $password = password_hash($password_input, PASSWORD_DEFAULT);

        $check = mysqli_query($connection, "SELECT * FROM tbuser WHERE email='$email'");

        if(mysqli_num_rows($check) > 0){
            echo "<script>
                    alert('Email already exists.');
                  </script>";
        }else{
            mysqli_query($connection, "INSERT INTO tbuser(first_name, last_name, email, password, gender, mobile_number)
            VALUES('$fname','$lname','$email','$password', '$gender', '$mobile')");

            $user_id = mysqli_insert_id($connection);

            mysqli_query($connection, "INSERT INTO tbstudent(user_id, program, year_level) VALUES('$user_id', '$program', '$year_level' )");
            
            echo "<script>
                    alert('Registration Successful.');
                    window.location='login.php';
                  </script>";

			header("location: login.php");
		
        }
    }
}
?>