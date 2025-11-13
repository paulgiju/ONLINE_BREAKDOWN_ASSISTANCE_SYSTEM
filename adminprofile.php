<?php include 'connection.php'; ?>
<?php include 'headeradmin.php'; ?>

<?php
// Fetch admin details from user table
$res = mysqli_query($conn, "SELECT * FROM user WHERE rights = 'A' LIMIT 1");
$admin = mysqli_fetch_assoc($res);

$adminId = $admin['user_id'];
$adminName = $admin['name'];
$adminUsername = $admin['username'];
$adminPhoto = !empty($admin['photo']) ? $admin['photo'] : 'adminupload/default.jpg';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $newName = $_POST['name'];
  $newUsername = $_POST['username'];

  // Handle photo upload
  if (!empty($_FILES['photo']['name'])) {
    $targetDir = "adminupload/";
    $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);
    $adminPhoto = $targetFile;
    mysqli_query($conn, "UPDATE user SET photo='$adminPhoto' WHERE user_id='$adminId'");
  }

  // Update admin details
  mysqli_query($conn, "UPDATE user SET name='$newName', username='$newUsername' WHERE user_id='$adminId'");

  // Refresh data
  $res = mysqli_query($conn, "SELECT * FROM user WHERE rights = 'A' LIMIT 1");
  $admin = mysqli_fetch_assoc($res);
  $adminName = $admin['name'];
  $adminUsername = $admin['username'];
  $adminPhoto = !empty($admin['photo']) ? $admin['photo'] : 'adminupload/default.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Admin Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="ap/css/bootstrap.min.css" rel="stylesheet">
  <link href="ap/css/style.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      color: #ffffff;
      background: linear-gradient(to bottom right, #120170, #000000, #530404);
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-size: cover;
    }
    .main-heading {
      font-size: 2.8rem;
      font-weight: 900;
      text-align: center;
      margin-top: 40px;
      color: #ffffff;
    }
    .section-title {
      font-size: 1.6rem;
      color: #ffffff;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
    }
    .form-box {
      background-color: rgba(255,255,255,0.1);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(255, 13, 13, 1);
      color: #ffffff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .form-box:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(13, 49, 255, 1);
    }
    .form-box img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 20px;
  border: 3px solid #ffffffff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover effect: enlarge slightly with glow */
.form-box img:hover {
  transform: scale(1.1);
  box-shadow: 0 0 20px rgba(255, 0, 0, 1);
}

    .form-control {
      margin-bottom: 20px;
    }
    .btn-group {
      margin-top: 20px;
    }
    /* Floating Back Button */
    .back-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #ffffff;
      color: #000000;
      border: none;
      border-radius: 50px;
      padding: 10px 20px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      transition: background-color 0.3s ease, transform 0.2s ease;
      z-index: 999;
    }
    .back-btn:hover {
      background-color: #530404;
      color: #ffffff;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<!-- Page Heading -->
<div class="container">
  <h1 class="main-heading"><span class="admin">Edit</span> <span class="dashboard">Profile</span></h1>
</div>

<!-- Edit Profile Form -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form class="form-box" method="POST" enctype="multipart/form-data">
        <img src="<?php echo $adminPhoto; ?>" alt="Admin Photo">
        <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo $adminName; ?>" required>
        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $adminUsername; ?>" required>
        <label for="photo" class="form-label">Change Profile Photo</label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        <div class="btn-group d-flex justify-content-between">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
          <a href="adminpanel.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Footer Top Bar -->
<div class="container-fluid py-3 mt-5" style="background: linear-gradient(to right, #120170, #000000, #530404);">
  <div class="d-flex justify-content-between align-items-center px-4 flex-wrap">
    <div class="small text-white d-flex align-items-center gap-4 mb-2 mb-md-0">
      <span><i class="fa fa-map-marker-alt me-2 text-warning"></i> 
        <a href="#" class="text-white text-decoration-none">Find A Location</a>
      </span>
      <span><i class="fa fa-phone-alt me-2 text-warning"></i> +91 9876543210</span>
      <span><i class="fa fa-envelope me-2 text-warning"></i> help@help.com</span>
    </div>
    <div class="d-flex align-items-center gap-3">
      <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
      <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
      <a href="#" class="text-white"><i class="fa fa-user-circle"></i></a>
    </div>
  </div>
</div>

<!-- Footer Bottom -->
<div class="container-fluid text-center py-2 border-top" style="background: #000000;">
  <small class="text-white">
    &copy; <?php echo date("Y"); ?> Online Breakdown Assistance System. All rights reserved.
  </small>
</div>

<!-- Floating Back Button -->
<a href="adminpanel.php" class="back-btn">← Back</a>

<!-- Scripts -->
<script src="ap/js/bootstrap.bundle.min.js"></script>
<script src="ap/js/main.js"></script>
</body>
</html>
