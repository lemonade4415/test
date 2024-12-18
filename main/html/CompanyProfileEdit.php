<?php
session_start();
require '../php/config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Company') {
    header("Location: ../html/LoginPage.php");
    exit();
}

// Generate CSRF token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    echo "<div style='color: red;'>";
    foreach ($_SESSION['errors'] as $error) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }
    echo "</div>";
    unset($_SESSION['errors']); 
}

$username = htmlspecialchars($_SESSION['username']);

$current_username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE name = ? AND role = 'Company'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $_SESSION['error'] = "User not found!";
    exit();
}

$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<html>
<head>
    <title>Company Profile Edit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid p-5 bg-primary text-white text-left pd">
        <h1>Cyber <span>Resource</span></h1>
        <p>We make hiring easy</p>
    </div>
    <div class="row col-8 border rounded mx-auto mt-5 p-2 shadow-lg">
        <div class="col-md-4 text-center mt-5">
        <?php
            $profile_image = $user['profile_image'];
            $profile_image_path = "../../Image/default_profile.jpg"; 
            if (!empty($profile_image) && file_exists($profile_image)) {
                $profile_image_path = $profile_image; 
            }
            $profile_image = !empty($user['profile_image']) ? htmlspecialchars($profile_image_path) : '../../Image/default_profile.jpg';
            ?>
            <img src="<?php echo htmlspecialchars($profile_image); ?>" class="js-image img-fluid rounded" alt="Profile Image">
            <form action="../php/config.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="form_type" value="company_profile">
            <div class="text-left mt-3">
                <label for="formFileLg" class="form-label">Change Profile Image</label>
                <input onchange="display_image(this.files[0])" class="form-control form-control-lg" id="formFileLg" type="file" accept="image/jpg, image/jpeg, image/png" name="profile_image">
            </div>
        </div>
        <div class="col-md-8">
            <div class="h2">Edit Profile</div>
            <input type="hidden" name="edit_profile" value="1">
                <table class="container-fluid table table-striped">
                    <tr><th colspan="2">Company Details:</th></tr>
                    <tr><th><i class="fa fa-user-circle"></i> Company Name</th>
                        <td><input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo htmlspecialchars($user['name']); ?>" required></td>

                    <tr><th><i class="fa fa-user-circle"></i> Password</th>
                    <td><input type="password" class="form-control" name="password" placeholder="New Password (leave blank to keep current)" minlength="8"></td>

                    <tr>
                        <th><i class="fa fa-lock"></i> Confirm Password</th>
                        <td><input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" minlength="8"></td>
                    </tr>

                    <tr><th><i class="fa fa-envelope"></i> Company Email</th>
                    <td><input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required></td>

                    <tr><th><i class="fa fa-briefcase"></i> Company Specialty</th>
                        <td><input type="text" class="form-control" name="CompanySpecialization" placeholder="companyspecialty" value="<?php echo htmlspecialchars($user['CompanySpecialization']); ?>"></td>


                    <tr><th><i class="fa fa-home"></i> Address</th>
                        <td><input type="text" class="form-control" name="address" placeholder="address" value="<?php echo htmlspecialchars($user['address']); ?>"></td>

                </table>
            <div class="p-2">
                <a href="./CompanyProfile.php">
                    <label type="button" class="btn-lg btn-primary">Back</label>
                </a>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
                <button type="submit" class="btn-lg btn-primary float-end">Save</button>
            </div>
        </form>
        </div>
    </div>
</body>
</html>
<script>
    console.log(URL);
    function display_image(file)
    {
        var img = document.querySelector(".js-image");
        img.src = URL.createObjectURL(file);
    }
</script>
