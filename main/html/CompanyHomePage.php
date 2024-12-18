<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Company') {
  header("Location: ../html/LoginPage.php");
  exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>
<html>
<head>
    <title>Home Page</title>
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
                <a href="./CompanyJobListing.php">
                    <img src="../../Image/hook.png">
                </a>
                <h3>Company Job Listing</h3>
                <h5>Create Jobs</h5>
            </div>
            

            <div class="box">
                <a href="./CompanyViewingApplicantPage.php">
                    <img src="../../Image/workers.png">
                </a>
                <h3>View Applicant Profile</h3>
                <h5>Find the perfect candidate</h5>
            </div>

            <div class="box">
                <a href="./CompanyProfile.php">
                    <img src="../../Image/officebuildingicons.png">
                </a>
                <h3>Company Profile</h3>
                <h5>Create your company profile</h5>
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