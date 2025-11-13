<?php
include "connection.php";

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $found = 0;

  $data = mysqli_query($conn, "SELECT * FROM user WHERE username ='$username' AND password='$password'");
  $result = mysqli_fetch_array($data);
  if (!empty($result['username'])) {
    $found = 1;
    session_start();
    $_SESSION['id'] = $result['user_id'];
    $_SESSION['name'] = $result['name'];
    $_SESSION['rights'] = $result['rights'];
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $rights = $result['rights'];
  }

  if ($found == 0) {
    $dr = mysqli_query($conn, "SELECT * FROM workshop WHERE username='$username' AND password='$password'");
    $drs = mysqli_fetch_array($dr);
    if (!empty($drs['username'])) {
      $found = 1;
      session_start();
      $_SESSION['id'] = $drs['ownerid'];
      $_SESSION['name'] = $drs['wname'];
      $_SESSION['rights'] = $drs['rights'];
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
      $rights = $drs['rights'];
    }
  }

  if ($found == 0) {
    echo "<script>alert('Invalid Username or Password');</script>";
  } else {
    if ($rights == 'A') header("location:adminpanel.php");
    elseif ($rights == 'U') header('location:userhpage.php');
    elseif ($rights == 'W') header('location:workshophpage.php');
    elseif ($rights == 'NW') echo "<script>alert('Your registration is still pending with admin');</script>";
    elseif ($rights == 'R') echo "<script>alert('Rejected');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>OBAS - Login</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

  <!-- Icon Fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries -->
  <link href="cb/lib/animate/animate.min.css" rel="stylesheet">
  <link href="cb/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Bootstrap & Template Styles -->
  <link href="cb/css/bootstrap.min.css" rel="stylesheet">
  <link href="cb/css/style.css" rel="stylesheet">

  <style>
    body {
      background-image: url('cb/img/login-bg.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Montserrat', sans-serif;
    }

    /* Login Card Styling */
    .login-card {
      background: rgba(253, 253, 253, 0.97);
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(188, 189, 189, 1);
      color: #0e0d0dff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(254, 255, 255, 1); /* golden glow */
    }

    .login-card h2 {
      color: #050505ff;
    }

    .login-card .text-muted {
      color: #000000ff !important;
    }
.
    .login-card .form-control {
      background-color: rgba(0, 0, 0, 0.2);
      border: none;
      color: #0c0909ff;
    }

    .login-card .form-control::placeholder {
      color: #000000ff;
    }

    .login-card .input-group-text {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #000000ff;
    }

    .login-card .btn-danger {
      background: linear-gradient(to right, #120170, #530404);
      border: none;
      font-weight: 600;
    }

    .login-card .btn-danger:hover {
      background: linear-gradient(to right, #530404, #120170);
      box-shadow: 0 0 12px rgba(255,215,0,0.6);
    }

    .login-card .btn-outline-secondary {
      border-color: #0a0a0aff;
      color: #050404ff;
    }

    .login-card .btn-outline-secondary:hover {
      background-color: #f80404ff;
      color: #ffffff;
    }
  </style>
</head>

<body>

<!-- Login Form Section -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="login-card p-4">
        <div class="text-center mb-4">
          <h2 class="fw-bold">Login to <span class="text-warning">Your Account</span></h2>
          <p class="small text-muted">Access your dashboard and manage your roadside support</p>
        </div>
        <form method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="remember" name="remember-me">
            <label class="form-check-label" for="remember">Remember me</label>
          </div>
          <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-danger">Login</button>
          </div>
          <div class="text-center mt-3">
            <button onclick="history.back()" class="btn btn-outline-secondary btn-sm">
              <i class="fas fa-arrow-left"></i> Go Back
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JS Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="cb/lib/wow/wow.min.js"></script>
<script src="cb/lib/easing/easing.min.js"></script>
<script src="cb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="cb/js/main.js"></script>

</body>
</html>
