<?php
include "connection.php";

if (isset($_POST['submit'])) {
    $name     = $_POST['name'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // Handle photo upload
    $photo = '';
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "images/";
        $photo = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);
    }

    // Check if username already exists
    $check_query = "SELECT * FROM user WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        // Insert new user
        $query = "INSERT INTO user(name, phone, email, username, password, photo) 
                  VALUES('$name', '$phone', '$email', '$username', '$password', '$photo')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Registration Successful');</script>";
        } else {
            echo "<script>alert('Registration Failed');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>User Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="abt/css/bootstrap.min.css" rel="stylesheet">
  <link href="abt/css/style.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('rb/img/big_portfolio_item_5.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'Montserrat', sans-serif;
      color: #ffffff;
    }

    .form-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 15px;
    }

    /* Registration Card Styling */
    .form-wrapper {
      background: rgba(5, 5, 5, 0.67);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(255,255,255,0.2);
      max-width: 600px;
      width: 100%;
      color: #fcf8f8ff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .form-wrapper:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(255, 0, 0, 0.97); /* golden glow */
    }

    .form-wrapper h3 {
      color: #fdfbfbff;
      font-weight: 700;
    }

    .form-wrapper .form-control {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #f7f3f3ff;
    }

    .form-wrapper .form-control::placeholder {
      color: #fdfcfcff;
    }

    .form-wrapper label {
      color: #fcfbfbff;
      font-weight: 600;
    }

    .form-wrapper .btn-danger {
      background: linear-gradient(to right, #120170, #530404);
      border: none;
      font-weight: 600;
    }

    .form-wrapper .btn-danger:hover {
      background: linear-gradient(to right, #530404, #120170);
      box-shadow: 0 0 12px rgba(255,215,0,0.6);
    }

    .form-wrapper a {
      color: #ffd700;
      text-decoration: none;
    }

    .form-wrapper a:hover {
      text-decoration: underline;
    }
    .footer-top {
      background: linear-gradient(to right, #120170, #000000, #530404);
      padding: 15px 0;
      color: #ffffff;
    }
    .footer-bottom {
      background: #000000;
      padding: 10px 0;
      text-align: center;
      color: #ffffff;
    }
  </style>
</head>
<body>

<?php include 'headerhome.php'; ?>

<!-- Registration Form -->
<div class="form-section">
  <div class="form-wrapper">
    <h3 class="mb-4 text-center">Create Your Account</h3>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" required placeholder="Enter your name">
      </div>
      <div class="form-group mb-3">
        <label class="form-label">Phone</label>
        <input type="tel" class="form-control" name="phone" required placeholder="Enter your phone number">
      </div>
      <div class="form-group mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required placeholder="Enter your email">
      </div>
      <div class="form-group mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" required placeholder="Choose a username">
      </div>
      <div class="form-group mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required placeholder="Create a password">
      </div>
      <div class="form-group mb-4">
        <label class="form-label">Upload Photo</label>
        <input type="file" class="form-control" name="photo" accept="image/*">
      </div>
      <div class="d-grid">
        <button type="submit" name="submit" class="btn btn-danger rounded-pill">Register</button>
      </div>
      <div class="text-center mt-3">
        <span class="text-muted">Already have an account?</span>
        <a href="login2.php">Login here</a>
      </div>
    </form>
  </div>
</div>

<!-- JS Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="abt/js/main.js"></script>
<!-- Footer Top Bar -->
<div class="footer-top">
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
<div class="footer-bottom">
  <small>
    &copy; <?php echo date("Y"); ?> Online Breakdown Assistance System. All rights reserved.
  </small>
</div>

</body>
</html>
