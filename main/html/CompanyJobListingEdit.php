<?php
session_start();
require '../php/config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Company') {
    header("Location: ../html/LoginPage.php");
    exit();
}

$username = $_SESSION['username'];

if (isset($_GET['id'])) {
    $job_id = intval($_GET['id']);
    if ($job_id <= 0) {
        $_SESSION['error'] = "Invalid job listing ID.";
        header("Location: ./CompanyJobListing.php");
        exit();
    }
} else {
    $_SESSION['error'] = "No job listing specified.";
    header("Location: ./CompanyJobListing.php");
    exit();
}

$sql = "SELECT * FROM job_listings WHERE id = ? AND username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("is", $job_id, $username);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $job = $result->fetch_assoc();
} else {
    $_SESSION['error'] = "Job listing not found or you do not have permission to edit it.";
    header("Location: ./CompanyJobListing.php");
    exit();
}

$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    } else if (!preg_match("/^[a-zA-Z0-9 .\-]*$/", $jobTitle)) {
        $_SESSION['error'] = "Job title can only contain letters, numbers, spaces, dots, and hyphens.";
    } else if (!preg_match("/^[a-zA-Z0-9 .,\-\/]*$/", $location)) {
        $_SESSION['error'] = "Location can only contain letters, numbers, spaces, dots, commas, slashes, and hyphens.";
    } else if (!preg_match("/^[a-zA-Z0-9 .,;:'\"()\-\n\r]*$/", $jobDescription)) {
        $_SESSION['error'] = "Job description contains invalid characters.";
    } else if (!preg_match("/^[a-zA-Z \-]*$/", $jobType)) {
        $_SESSION['error'] = "Job type can only contain letters, spaces, and hyphens.";
    } else if (!preg_match("/^[0-9.,]*$/", $salary)) {
        $_SESSION['error'] = "Salary can only contain numbers, dots, and commas.";
    } else if (!preg_match("/^[a-zA-Z0-9 .,;:'\"()\-\n\r]*$/", $benefits)) {
        $_SESSION['error'] = "Benefits contain invalid characters.";
    } else {
        // Update job listing 
        $sql_update = "UPDATE job_listings SET job_title = ?, location = ?, job_description = ?, job_type = ?, salary = ?, benefits = ? WHERE id = ? AND username = ?";
        $stmt_update = $conn->prepare($sql_update);

        if ($stmt_update === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt_update->bind_param("ssssssis", $jobTitle, $location, $jobDescription, $jobType, $salary, $benefits, $job_id, $username);

        if ($stmt_update->execute()) {
            $_SESSION['success'] = "Job listing updated successfully!";
            $stmt_update->close();
            $conn->close();
            header("Location: ./CompanyJobListing.php");
            exit();
        } else {
            $_SESSION['error'] = "Error updating job listing.";
        }

        $stmt_update->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Job Listing</title>
    <link rel="stylesheet" href="../css/CompanyJobListingCreationStyle.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <img src="../../Image/logo.png" alt="Website Logo">
            <h4>CYBER <br> RESOURCE</h4>
        </header>
        <main class="main">
            <h2>Edit Job Listing</h2>
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
            <?php elseif (isset($_SESSION['success'])): ?>
                <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="job-title">Job Title:</label>
                    <input type="text" id="job-title" name="jobTitle" value="<?php echo htmlspecialchars($job['job_title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="job-description">Job Description:</label>
                    <textarea id="job-description" name="jobDescription" rows="10" required><?php echo htmlspecialchars($job['job_description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="job-type">Job Type:</label>
                    <select name="jobType" required>
                        <option value="">Select Job Type</option>
                        <option value="full-time" <?php if ($job['job_type'] == 'full-time') echo 'selected'; ?>>Full Time</option>
                        <option value="part-time" <?php if ($job['job_type'] == 'part-time') echo 'selected'; ?>>Part Time</option>
                        <option value="contract" <?php if ($job['job_type'] == 'contract') echo 'selected'; ?>>Contract</option>
                        <option value="freelance" <?php if ($job['job_type'] == 'freelance') echo 'selected'; ?>>Freelance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="benefits">Benefits:</label>
                    <textarea id="benefits" name="benefits" rows="5" required><?php echo htmlspecialchars($job['benefits'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
                <button type="submit">Update Job Listing</button>
            </form>

            <a href="./CompanyJobListing.php">
                <label type="button" class="btn-lg btn-primary">Back</label>
            </a>
        </main>
    </div>
</body>
</html>