<?php
session_start();
require '../php/config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Customer') {
  header("Location: ../html/LoginPage.php");
  exit();
}

if (isset($_SESSION['error'])) {
  echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') . "</p>";
  unset($_SESSION['error']); 
}

$username = htmlspecialchars($_SESSION['username']);
$sql = "SELECT name, address, CompanySpecialization FROM users WHERE role = 'Company'";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
  <title>User Jobs Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/UserCompanySearch.css">
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
        <li class="active"><a href="./UserCompanySearch.php">Companies</a></li>
        <li><a href="./UserCompanyJobs.php">Jobs</a></li>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Companies..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>

    <div class="col-sm-9">
      <h4><small>Company Listings</small></h4>
      <hr>

      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<h2>' . htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') . '</h2>';
              echo '<p>Address: ' . htmlspecialchars($row["address"], ENT_QUOTES, 'UTF-8') . '</p>';
              echo '<p>Company Specialization: ' . htmlspecialchars($row["CompanySpecialization"], ENT_QUOTES, 'UTF-8') . '</p>';
              echo '<p>Learn more about ' . htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') . '</p>';
              echo '<hr>';
          }
      } else {
        $_SESSION['error'] = "No companies found!";
      }

      $conn->close();
      ?>
      <a href="./UserHomePage.php">
            <label type="button" class="btn-lg btn-primary">Back</label>
      </a>

    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer>

</body>
</html>
