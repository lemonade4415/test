<?php
session_start();
require '../php/config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../html/LoginPage.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$sql = "SELECT name, email, age, gender, address, profession, profile_image FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $age = $row['age'];
    $gender = $row['gender'];
    $address = $row['address'];
    $profession = $row['profession'];
    $profile_image = $row['profile_image'];
} else {
    $name = "Not available";
    $email = "Not available";
    $age = "Not available";
    $gender = "Not available";
    $address = "Not available";
    $profession = "Not available";
    $profile_image = '../../Image/default_profile.jpg';
}


$stmt->close();
$conn->close();
?>

<html>
<head>
    <title>User Profile</title>
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
            $profile_image_path = "../../Image/default_profile.jpg"; 
            if (!empty($profile_image) && file_exists($profile_image)) {
                $profile_image_path = $profile_image; 
            }
            $display_image = !empty($profile_image) ? htmlspecialchars($profile_image_path) : '../../Image/default_profile.jpg';
            ?>
            <img src="<?php echo htmlspecialchars($display_image); ?>" class="img-fluid rounded" alt="logo">
            <div>
                <a href="./UserProfileEdit.php"><button class="mx-auto m-1 btn-lg btn btn-primary">Update Profile</button></a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="h2">User Profile</div>
            <table class="container-fluid table table-striped">
                <tr><th colspan="2">User Details:</th></tr>
                <tr><th><i class="fa fa-user-circle"></i> Name</th><td><?php echo htmlspecialchars($name); ?></td></tr>
                <tr><th><i class="fa fa-calendar"></i> Age</th><td><?php echo htmlspecialchars($age); ?></td></tr>
                <tr><th><i class="fa fa-envelope"></i> Email</th><td><?php echo htmlspecialchars($email); ?></td></tr>
                <tr><th><i class="fa fa-transgender"></i> Gender</th><td><?php echo htmlspecialchars($gender); ?></td></tr>
                <tr><th><i class="fa fa-briefcase"></i> Profession</th><td><?php echo htmlspecialchars($profession); ?></td></tr>
                <tr><th><i class="fa fa-home"></i> Address</th><td><?php echo htmlspecialchars($address); ?></td></tr>            
            </table>
        </div>
        <a href="./UserHomePage.php">
            <label type="button" class="btn-lg btn-primary">Back</label>
        </a>
    </div>
    
</body>
</html>