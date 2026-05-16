<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CIT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>

<div class="register-page">

    <!-- ── Left: hero panel ── -->
    <div class="register-hero">
        <div class="hero-deco"></div>
        <div class="hero-content">
            <img src="images/citofficiallogo.png" alt="CIT Logo" class="hero-logo">
            <div class="hero-eyebrow">Room Reservation System</div>
            <h1 class="hero-title">Join <span>CIT</span><br>Today</h1>
            <p class="hero-desc">Create your account to start reserving rooms, lecture halls, and study spaces across campus.</p>
            <div class="hero-chips">
                <span class="chip">Lecture Halls</span>
                <span class="chip">Study Pods</span>
                <span class="chip">Labs</span>
                <span class="chip">Conference Rooms</span>
            </div>
        </div>
    </div>

    <!-- ── Right: form panel ── -->
    <div class="register-form-panel">
        <div class="register-box">
            <div class="gold-line"></div>
            <h2>Create an account</h2>
            <p class="subtitle">Fill in your details to get started</p>

            <form method="POST">
                <div class="field-grid">

                    <div class="field-group">
                        <label for="txtfname">First Name</label>
                        <input type="text" id="txtfname" name="txtfname" placeholder="e.g. Juan">
                    </div>

                    <div class="field-group">
                        <label for="txtlname">Last Name</label>
                        <input type="text" id="txtlname" name="txtlname" placeholder="e.g. Dela Cruz">
                    </div>

                    <div class="field-group">
                        <label for="txtgender">Gender</label>
                        <select id="txtgender" name="txtgender">
                            <option value="">-- Select --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="txtmobile">Mobile Number</label>
                        <input type="text" id="txtmobile" name="txtmobile" placeholder="e.g. 09xxxxxxxxx">
                    </div>

                    <div class="field-group">
                        <label for="txtprogram">Program</label>
                        <input type="text" id="txtprogram" name="txtprogram" placeholder="e.g. BSIT">
                    </div>

                    <div class="field-group">
                        <label for="txtyear_level">Year Level</label>
                        <select id="txtyear_level" name="txtyear_level">
                            <option value="">-- Select --</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>

                    <div class="field-group full">
                        <label for="txtemail">Email Address</label>
                        <input type="text" id="txtemail" name="txtemail" placeholder="you@cit.edu">
                    </div>

                    <div class="field-group full">
                        <label for="txtpassword">Password</label>
                        <input type="password" id="txtpassword" name="txtpassword" placeholder="••••••••">
                    </div>

                </div>

                <input type="submit" name="btnRegister" value="Create Account" class="btn-register-submit">
            </form>

            <div class="register-footer">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>
        </div>
    </div>

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

</body>
</html>