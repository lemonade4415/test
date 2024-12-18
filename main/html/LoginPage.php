<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/RegisterLoginPageStyle.css"> <!-- RegisterLoginPageStyle.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    </div>
    
    <div class="form-container">
        <form action="../php/config.php" method="post" enctype="multipart/form-data">
            <h3>Login</h3>
            
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
            
            <input type="email" name="email" placeholder="enter email" class="box" required>
            <input type="password" name="password" placeholder="enter password" class="box" required>
            <input type="hidden" name="login" value="1">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            <input type="submit" value="login now" class="btn">
            <p>don't have an account? <a href="RegisterPage.php">register now</a></p>
        </form>
    </div>

    <script> // navbar for 700px screen
        var navbar = document.getElementById("navbar");

        function showMenu(){
            navbar.style.right = "0";
        }
        function hideMenu(){
            navbar.style.right = "-200px";
        }
    </script>
</body>
</html>
