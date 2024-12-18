<?php
session_start();
require '../php/config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Company') {
    header("Location: ../html/LoginPage.php");
    exit();
}

if (isset($_SESSION['error'])) {
  echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') . "</p>";
  unset($_SESSION['error']); 
}

$username = htmlspecialchars($_SESSION['username']);
$sql = "SELECT id, name, email, age, gender FROM users WHERE role = 'Customer'";
$result = $conn->query($sql);
?>

<html>
<html lang="en">
<head>
  <title>User Company Jobs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/UserCompanyJobs.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <div class="container-fluid p-5 bg-primary text-white text-left pd">
        <h1>Cyber <span>Resource</span></h1>
        <p>We make hiring easy</p>
      </div>
      <hr>
      <ul class="nav nav-pills nav-stacked">
        <li><a href="./CompanyJobListingCreation.php">Create Listings</a></li>
        <li><a href="./CompanyJobListing.php">Your Listings</a></li>
        <li><a href="./CompanyApprovedJobListing.php">Approved Listings</a></li>
        <li class="active"><a href="./CompanyViewingApplicantPage.php">View Applicant</a></li>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Your Listings..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>

        <div class="col-sm-9">
            <h4><small>View All Applicant</small></h4>
            <hr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<h2>' . htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') . '</h2>';
                  echo '<p>Email: ' . htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') . '</p>'; 
                  echo '<p>Age: ' . htmlspecialchars($row["age"], ENT_QUOTES, 'UTF-8') . '</p>';
                  echo '<p>Gender: ' . htmlspecialchars($row["gender"], ENT_QUOTES, 'UTF-8') . '</p>';
                  echo '<hr>';
              }
            } else {
              $_SESSION['error'] = "No applicants found!";
            }
            $conn->close();
            ?>
            <a href="./CompanyHomePage.php">
            <label type="button" class="btn-lg btn-primary">Back</label>
            </a>
        </div>
    </div>
</div>

<footer class="container-fluid">
    <p>Cyber Resource</p>
</footer>

</body>
</html>
