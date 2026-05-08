<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Reservation - CIT</title>
    <link rel="stylesheet" href="styles/index.css"> 
</head>
<body>
    <div class="hero-section">
        <div class="overlay">
            <div class="login-container">
                <header class="hero-text">
                    <h1>Reserve Your Space <br> At <span>CIT</span></h1>
                    <p>Access world-class facilities, modern study pods, and fully-equipped lecture halls for your academic and collaborative needs.</p>
                </header>

                <form action="login.php" method="POST" class="login-form">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="juan.delacruz@cit.edu" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="******" required>
                    </div>

                    <button type="submit" name="login" class="btn-login">Login</button>
                    
                    <a href="admin/login.php" class="btn-admin">Admin Login</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>