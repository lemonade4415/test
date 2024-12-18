<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../html/LoginPage.php");
  exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>
<html>
<head>
    <title>Admin Home Page</title>
    <link rel="stylesheet" href="../css/UserHomePageStyle.css"> <!-- UserHomePageStyle.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <section class="container">
        <div class="center">
            <h1>Welcome back, <?php echo htmlspecialchars($username); ?>!</h1>
        </div>

        <div class="container-content">
        <div class="box">
                <a href="./admin-reviewlistings.php">
                    <img src="../../Image/glass.png">
                </a>
                <h3>Review Listings</h3>
                <h5>Accept or reject job listings here</h5>
            </div>

            <div class="box">
                <a href="./admin-reviewusers.php">
                    <img src="../../Image/workers.png">
                </a>
                <h3>Review Users</h3>
                <h5>Review user profile here</h5>
            </div>

            <div class="box">
                <a href="./admin-reviewcompany.php">
                    <img src="../../Image/officebuildingicons.png">
                </a>
                <h3>Review Company</h3>
                <h5>Review company profile here</h5>
            </div>

            <div class="box">
                <a href="./admin-approvedlistings.php">
                    <img src="../../Image/approvedicon.png">
                </a>
                <h3>Approved Listings</h3>
                <h5>View approved job listings here</h5>
            </div>
            
            <div class="box">
                <form action="../php/config.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
                    <button type="submit" name="logout" style="background: none; border: none; cursor: pointer;">
                        <img src="../../Image/logout.png" alt="Logout">
                    </button>
                </form>
                <h3>Logout</h3>
                <h5>Logout of your account here</h5>
            </div> 
        </div>
    </section>
</body>
</html>