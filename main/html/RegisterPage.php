<html>
<head>
    <title>Register Page</title>
    <link rel="stylesheet" href="../css/RegisterLoginPageStyle.css"> <!-- RegisterLoginPageStyle.css -->
</head>
<body>
    <div class="header">
        <div class="inner-header">
            <div class="logo-container">
                <h1>Cyber <span>Resource</span></h1>
            </div>
            <ul class="navigation">
                <a href="./MainHomePage.html"><li>Home</li></a>
                <a href="./RegisterPage.php"><li>Register</li></a>
                <a href="./LoginPage.php"><li>Login</li></a>
            </ul>
        </div>
    </div>
    <div class="form-container">
        <form action="../php/config.php" method="post" enctype="multipart/form-data">
            <h3>Register</h3>

            <?php 
            session_start();
            // Generate CSRF token
            if (empty($_SESSION['token'])) {
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }
            if (isset($_SESSION['error'])) {
                echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') . "</p>";
                unset($_SESSION['error']); 
            }
            ?>

            <input type="text" name="name" placeholder="Enter username" class="box" required>
            <input type="email" name="email" placeholder="Enter email" class="box" required>
            <input type="password" name="password" placeholder="Enter password" class="box" required>
            <input type="password" name="cpassword" placeholder="Confirm password" class="box" required>
            <select name="role" class="box" required>
                <option value="" disabled selected>Choose role</option>
                <option value="Company">Company</option>
                <option value="Customer">Customer</option>
            </select>
            <br><br>
            Choose a profile picture
            <input type="file" class="box" accept="image/jpg, image/jpeg, image/png" name="profile_image">
            <input type="hidden" name="register" value="1">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            <input type="submit" value="Register Now" class="btn">
            <p>Already have an account? <a href="./LoginPage.php">Login now</a></p>
        </form>
    </div>
</body>
</html>
