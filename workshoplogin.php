<?php
include "connection.php";

if (isset($_POST['submit'])) {
    $wname      = $_POST['wname'];
    $sname      = $_POST['sname'];
    $email      = $_POST['email'];
    $cperson    = $_POST['cperson'];
    $wnumber    = $_POST['wnumber'];
    $location   = $_POST['location'];
    $upi_id     = $_POST['upi_id'];

    $qr_code = '';
    if (!empty($_FILES['qr_code']['name'])) {
        $target_dir = "images/";
        $qr_code = $target_dir . basename($_FILES["qr_code"]["name"]);
        move_uploaded_file($_FILES["qr_code"]["tmp_name"], $qr_code);
    }

    $password   = $_POST['password'];
    $username   = $_POST['username'];

    // Check if username already exists
    $check_query = "SELECT username FROM workshop WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        // Handle photo upload
        $photo = '';
        if (!empty($_FILES['photo']['name'])) {
            $target_dir = "images/";
            $photo = $target_dir . basename($_FILES["photo"]["name"]);
            move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);
        }

        $query = "INSERT INTO workshop(wname, sname, email, cperson, wnumber, password, photo, username, location, upi_id, qr_code)
                  VALUES('$wname', '$sname', '$email', '$cperson', '$wnumber', '$password', '$photo', '$username', '$location', '$upi_id', '$qr_code')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Workshop Registered Successfully');</script>";
        } else {
            echo "<script>alert('Registration Failed: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Workshop Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="abt/css/bootstrap.min.css" rel="stylesheet">
  <link href="abt/css/style.css" rel="stylesheet">
  <style>
    body {
      background-image: url('wb/img/big_portfolio_item_1.png');
      background-size: cover;
      background-position: center;
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
    /* Workshop Registration Card Styling */
    .form-wrapper {
      background: rgba(0, 0, 0, 0.7);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(255, 255, 255, 1);
      max-width: 700px;
      width: 100%;
      color: #ffffff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .form-wrapper:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(255,255,255,0.6); /* white glow */
    }
    .form-wrapper h3 {
      color: #ffffff;
      font-weight: 700;
    }
    .form-wrapper .form-control {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #ffffff;
    }
    .form-wrapper .form-control::placeholder {
      color: #f0f0f0;
    }
    .form-wrapper select.form-control {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #ffffff;
      appearance: none;
      padding-right: 30px;
    }
    .form-wrapper .btn-danger {
      background: linear-gradient(to right, #120170, #530404);
      border: none;
      font-weight: 600;
    }
    .form-wrapper .btn-danger:hover {
      background: linear-gradient(to right, #530404, #120170);
      box-shadow: 0 0 12px rgba(255,255,255,0.6);
    }
    .form-wrapper a {
      color: #ffffff;
      text-decoration: none;
    }
    .form-wrapper a:hover {
      text-decoration: underline;
    }
    /* Footer */
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

<div class="form-section">
  <div class="form-wrapper">
    <h3 class="mb-4 text-center">Workshop Registration</h3>
    <form method="POST" enctype="multipart/form-data">
      <input type="text" class="form-control mb-3" name="wname" required placeholder="Workshop Name">
      <select class="form-control mb-3" name="sname" required>
        <option value="">Select Service Type</option>
        <option value="All">All</option>
        <option value="Car">Car</option>
        <option value="Bike">Bike</option>
        <option value="Scooter">Scooter</option>
        <option value="Bus">Bus</option>
        <option value="Truck">Truck</option>
      </select>
      <input type="email" class="form-control mb-3" name="email" required placeholder="Email">
      <input type="text" class="form-control mb-3" name="cperson" required placeholder="Contact Person">
      <input type="text" class="form-control mb-3" name="wnumber" required placeholder="Workshop Number">
      <input type="text" class="form-control mb-3" name="location" required placeholder="Location">
      <input type="file" class="form-control mb-3" name="photo" accept="image/*">
      <input type="text" class="form-control mb-3" name="upi_id" placeholder="UPI ID (if applicable)">
      <input type="file" class="form-control mb-3" name="qr_code" accept="image/*">
      <input type="text" class="form-control mb-3" name="username" required placeholder="Username">
      <input type="password" class="form-control mb-4" name="password" required placeholder="Password">
      <button type="submit" name="submit" class="btn btn-danger w-100 rounded-pill">Register</button>

      <!-- Login prompt -->
      <div class="text-center mt-3">
        <span class="text-muted">Already have an account?</span>
        <a href="login2.php">Login here</a>
      </div>
    </form>
  </div>
</div>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.
