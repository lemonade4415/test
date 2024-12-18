<?php
session_start();
unset($_SESSION['error']); 

require '../php/config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Company') {
  header("Location: ../html/LoginPage.php");
  exit();
}

$username = htmlspecialchars($_SESSION['username']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['role'] == 'Company') {
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    // Validasi CSRF token
    if (!$token || $token !== $_SESSION['token']) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit();
    }
    // Sanitize user inputs to prevent XSS
    $jobTitle = filter_input(INPUT_POST, 'jobTitle', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $jobDescription = filter_input(INPUT_POST, 'jobDescription', FILTER_SANITIZE_STRING);
    $jobType = filter_input(INPUT_POST, 'jobType', FILTER_SANITIZE_STRING);
    $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_NUMBER_INT);
    $benefits = filter_input(INPUT_POST, 'benefits', FILTER_SANITIZE_STRING);

    // Server-side validation
    if (empty($jobTitle) || empty($location) || empty($jobDescription) || empty($jobType) || empty($salary) || empty($benefits)) {
        $_SESSION['error'] = "Please fill in all required fields.";
    } else if(!preg_match("/^[a-zA-Z ]*$/", $jobTitle)){
        $_SESSION['error'] = "Job title can only contain alphabet characters";
    } else if(!preg_match("/^[a-zA-Z0-9.\/ ]*$/", $location)){
        $_SESSION['error'] = "Location can only contain alphanumeric characters";
    } else if(!preg_match("/^[a-zA-Z0-9 ]*$/", $jobDescription)){
        $_SESSION['error'] = "Job description can only contain alphanumeric characters";
    } else if(!preg_match("/^[a-zA-Z-]*$/", $jobType)){
        $_SESSION['error'] = "Job type can only contain alphabet characters";
    } else if(!preg_match("/^[0-9.,]*$/", $salary)){
        $_SESSION['error'] = "Salary can only contain numeric characters";
    } else if (!preg_match("/^[a-zA-Z0-9. ]*$/", $benefits)){
        $_SESSION['error'] = "Job benefits can only contain alphanumeric characters";
    } else {
        $stmt = $conn->prepare("INSERT INTO job_listings (username, job_title, location, job_description, job_type, salary, benefits) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $jobTitle, $location, $jobDescription, $jobType, $salary, $benefits);

        if ($stmt->execute()) {
            $success_message = "Job listing created successfully!";
        } else {
            $error_message = "Error creating new job listings";
        }

        $stmt->close();
        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Company Job Listing Creation</title>
  <link rel="stylesheet" href="../css/CompanyJobListingCreationStyle.css">
</head>
<body>
  <div class="container">
    <header class="header">
      <img src="../../Image/logo.png" alt="Website Logo">
      <h4>CYBER <br> RESOURCE</h4>
    </header>
    <main class="main">
      <h2>Create Job Listing</h2>
      <?php 
            session_start();
            // Generate CSRF token
            if (empty($_SESSION['token'])) {
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }
      ?>

      <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php unset($_SESSION['error']); ?>
      <?php elseif (!empty($success_message)): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php elseif (!empty($error_message)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="form-group">
          <label for="job-title">Nama Pekerjaan:</label>
          <input type="text" id="job-title" name="jobTitle" required>
        </div>
        <div class="form-group">
          <label for="location">Alamat:</label>
          <input type="text" id="location" name="location">
        </div>
        <div class="form-group">
          <label for="job-description">Short Description:</label>
          <textarea id="job-description" name="jobDescription" rows="10" required></textarea>
        </div>
        <div class="form-group">
          <label for="job-type">Job Type:</label>
          <select name="jobType" required>
            <option value="">Select Job Type</option>
            <option value="full-time">Full Time</option>
            <option value="part-time">Part Time</option>
            <option value="contract">Contract</option>
            <option value="freelance">Freelance</option>
          </select>
        </div>
        <div class="form-group">
          <label for="salary">Jangkauan Gaji*:</label>
          <input type="number" id="salary" name="salary">
        </div>
        <div class="form-group">
          <label for="benefits">Benefit*:</label>
          <textarea id="benefits" name="benefits" rows="5"></textarea>
        </div>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
        <button type="submit">Create Job Listing</button>
      </form>
      <a href="./CompanyJobListing.php">
        <label type="button" class="btn-lg btn-primary">Back</label>
      </a>
    </main>
  </div>
</body>
</html>
