<?php
session_start();
include "connection.php";

if (isset($_POST['submit'])) 
{ 
  {
   $oldpass = $_POST['t1'];
   $newpass = $_POST['t2'];
   $repass = $_POST['t3'];
   $rights = $_SESSION['rights'];
   $id = $_SESSION['id'];

  // Verify old password from database
   if ($rights == 'U' || $rights == 'A') 
   {
    $check = mysqli_query($conn, "SELECT password FROM user WHERE user_id='$id'");
    $row = mysqli_fetch_array($check);
    if ($row['password'] !== $oldpass) 
      {
      echo "<script>alert('Old Password does not match');</script>";
      exit();
      }
   } 
   elseif ($rights == 'W') 
   {
      $check = mysqli_query($conn, "SELECT password FROM workshop WHERE ownerid='$id'");
      $row = mysqli_fetch_array($check);
      if ($row['password'] !== $oldpass) 
        {
          echo "<script>alert('Old Password does not match');</script>";
          exit();
        }
    }

  // Check new password match
  if ($newpass !== $repass) 
    {
      echo "<script>alert('New Password and Re-type New Password do not match');</script>";
      exit();
    }

  // Update password
  $updated = false;
  if ($rights == 'U' || $rights == 'A') 
    {
      $update = mysqli_query($conn, "UPDATE user SET password='$newpass' WHERE user_id='$id'");
      if ($update) 
        {
          $updated = true;
        }
    } 
    elseif ($rights == 'W') 
      {
        $update = mysqli_query($conn, "UPDATE workshop SET password='$newpass' WHERE ownerid='$id'");
        if ($update) 
          {
            $updated = true;
          } 
          else 
            {
              echo "<script>alert('Update failed: " . mysqli_error($conn) . "');</script>";
              exit();
            }
      }
   } 

  // Refresh session and redirect
  if ($updated) 
    {
      if ($rights == 'U' || $rights == 'A') 
        {
          $res = mysqli_query($conn, "SELECT * FROM user WHERE user_id='$id'");
          if ($row = mysqli_fetch_array($res)) 
            {
              $_SESSION['name'] = $row['name'];
              $_SESSION['rights'] = $row['rights'];
              $_SESSION['username'] = $row['username'];
              $_SESSION['password'] = $row['password'];
              $rights = $row['rights'];
            }
        } 
        elseif ($rights == 'W') 
        {
          $res = mysqli_query($conn, "SELECT * FROM workshop WHERE ownerid='$id'");
          if ($row = mysqli_fetch_array($res)) 
          {
          $_SESSION['name'] = $row['wname'];
          $_SESSION['rights'] = $row['rights'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['password'] = $row['password'];
          $rights = $row['rights'];
          }
      }   

    echo "<script>
      alert('Password Changed Successfully');
      window.location.href = '" . (
        $rights == 'A' ? "adminpanel.php" :
        ($rights == 'U' ? "userhpage.php" :
        ($rights == 'W' ? "workshophpage.php" :
        ($rights == 'NW' ? "javascript:alert(\"Your registration is still pending with admin\")" :
        "javascript:alert(\"Rejected\")")))
      ) . "';
    </script>";
    exit();
  } 
  else 
    {
    echo "<script>alert('Failed to update password. Please try again.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Change Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

  <!-- Icon Fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries -->
  <link href="cp/lib/animate/animate.min.css" rel="stylesheet">
  <link href="cp/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Bootstrap & Template Styles -->
  <link href="cp/css/bootstrap.min.css" rel="stylesheet">
  <link href="cp/css/style.css" rel="stylesheet">

  <style>
    body {
      background-image: url('cp/img/changepassword-bg.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Montserrat', sans-serif;
      color: #ffffff;
    }

    /* Change Password Card Styling */
    .password-card {
      background: rgba(3, 2, 2, 0.76);
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(255,255,255,0.2);
      color: #ffffff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      padding: 30px;
    }

    .password-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(255,255,255,0.6);
    }

    .password-card h2 {
      color: #ffffff;
    }

    .password-card .text-muted {
      color: #ddd !important;
    }

    .password-card .form-control {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #ffffff;
    }

    .password-card .form-control::placeholder {
      color: #f0f0f0;
    }

    .password-card .input-group-text {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #ffffff;
    }

    .password-card .btn-danger {
      background: linear-gradient(to right, #120170, #530404);
      border: none;
      font-weight: 600;
    }

    .password-card .btn-danger:hover {
      background: linear-gradient(to right, #530404, #120170);
      box-shadow: 0 0 12px rgba(255,255,255,0.6);
    }

    .password-card .btn-outline-secondary {
      border-color: #ffffff;
      color: #ffffff;
    }

    .password-card .btn-outline-secondary:hover {
      background-color: #530404;
      color: #ffffff;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="password-card">
          <div class="text-center mb-4">
            <h2 class="fw-bold">Change <span class="text-danger">Password</span></h2>
            <p class="small text-muted">Update your credentials securely</p>
          </div>
          <form method="POST">
            <div class="mb-3">
              <label for="t1" class="form-label">Old Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="t1" id="t1" class="form-control" placeholder="Enter old password" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="t2" class="form-label">New Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                <input type="password" name="t2" id="t2" class="form-control" placeholder="Enter new password" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="t3" class="form-label">Re-type New Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                <input type="password" name="t3" id="t3" class="form-control" placeholder="Re-type new password" required>
              </div>
            </div>
            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-danger">Change Password</button>
              <div class="text-center mt-3">
                <button onclick="history.back()" class="btn btn-outline-secondary btn-sm">
                  <i class="fas fa-arrow-left"></i> Go Back
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- JS Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="cp/lib/wow/wow.min.js"></script>
  <script src="cp/lib/easing/easing.min.js"></script>
  <script src="cp/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="cp/js/main.js"></script>
</body>
</html>
