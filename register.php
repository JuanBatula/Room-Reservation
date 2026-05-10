<?php
include 'connect.php';
?>

<h2>User Registration</h2>

<div>
	<form method="POST">
		<pre>
			First Name:<input type="text" name="fname">
			Last Name:<input type="text" name="lname">
			Gender:
			<select name="gender">
			<option value="">----</option>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
			</select>

			Mobile Number: <input type="text" name="mobile">
			Program: <input type="text" name="program">
			Year_level:
			<select name="year_level">
			 <option value="">----</option>
			 <option value="1">1</option>
			 <option value="2">2</option>
			 <option value="3">3</option>
			 <option value="4">4</option>
			</select>
			Email: <input type="text" name="email">
			Password: <input type="password" name="password">
		
			<input type="submit" name="btnRegister" value="Register">
			Already have an account? <a href="login.php">Login</a>
		</pre>
	</form>
</div>

<?php
if(isset($_POST['btnRegister'])){
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $gender = trim($_POST['gender']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $password_input = trim($_POST['password']);
    $program = trim($_POST['program']);
	$year_level = trim($_POST['year_level']);

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