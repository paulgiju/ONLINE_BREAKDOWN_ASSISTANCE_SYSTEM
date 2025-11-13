<?php
session_start();
include "connection.php";
include "headerworkshop.php"; 

if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'W') {
  header("Location: login2.php");
  exit();
}

$wid = $_SESSION['id'];
$query = mysqli_query($conn, "
  SELECT b.reqno, b.reqdate, b.reqtime, b.vehicleno, b.complaint, b.landmark, b.amtpaid, b.payment_mode, b.rating, b.review,
         u.name AS uname, u.phone AS uphone
  FROM booking b
  JOIN user u ON b.uid = u.user_id
  WHERE b.wid = '$wid' AND b.status = 'Completed'
  ORDER BY b.reqno DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Workshop Service History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="wshb/css/bootstrap.min.css" rel="stylesheet">
  <link href="wshb/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

  <style>
    body {
      background: linear-gradient(to bottom right, #000000, #11a7bbff);
      font-family: 'Lato', sans-serif;
      color: white;
    }

    .card-box {
      background: rgba(255,255,255,0.05);
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(0, 195, 255, 1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(255, 0, 0, 1);
    }

    .table-hover tbody tr:hover {
      background-color: rgba(255,255,255,0.1);
    }

    .btn-custom {
      background-color: #11a7bb;
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 0.4rem 1rem;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-custom:hover {
      background-color: #ffffff;
      color: #11a7bb;
      border: 1px solid #11a7bb;
      transform: scale(1.05);
    }

    .floating-back {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
    }

    th, td {
      color: #ffffff;
    }
  </style>
</head>
<body>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-4">
      <h2 class="fw-bold" style="font-family: 'Montserrat', sans-serif; color: white;">
        Your <span style="color:#11a7bb;">Service History</span>
      </h2>
      <p class="text-white">Track all completed roadside assistance jobs.</p>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>Request No</th>
            <th>Date</th>
            <th>Time</th>
            <th>Vehicle No</th>
            <th>Complaint</th>
            <th>Landmark</th>
            <th>User Name</th>
            <th>Phone</th>
            <th>Amount Paid</th>
            <th>Payment Mode</th>
            <th>Rating</th>
            <th>Review</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
              <tr>
                <td><?php echo $row['reqno']; ?></td>
                <td><?php echo $row['reqdate']; ?></td>
                <td><?php echo $row['reqtime']; ?></td>
                <td><?php echo $row['vehicleno']; ?></td>
                <td><?php echo $row['complaint']; ?></td>
                <td><?php echo $row['landmark']; ?></td>
                <td><?php echo $row['uname']; ?></td>
                <td><?php echo $row['uphone']; ?></td>
                <td>₹<?php echo number_format($row['amtpaid'], 2); ?></td>
                <td><?php echo $row['payment_mode']; ?></td>
                <td><?php echo str_repeat('⭐', $row['rating']); ?></td>
                <td><?php echo $row['review']; ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="12" class="text-center text-white">No completed services found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <button onclick="window.location.href='workshophpage.php'" class="btn btn-custom">
        <i class="fas fa-arrow-left"></i> Back
      </button>
    </div>
  </div>
</div>

<!-- Floating Back Button -->
<div class="floating-back">
  <a href="workshophpage.php" class="btn btn-custom rounded-circle shadow">
    <i class="fas fa-arrow-left"></i>
  </a>
</div>

<!-- Footer Top Bar -->
<div class="container-fluid py-3 mt-5" style="background: linear-gradient(to right, #000000, #11a7bbff);">
  <div class="d-flex justify-content-between align-items-center px-4 flex-wrap">
    <div class="small text-white d-flex align-items-center gap-4 mb-2 mb-md-0">
      <span><i class="fa fa-map-marker-alt me-2 text-info"></i> 
        <a href="#" class="text-white text-decoration-none">Find A Location</a>
      </span>
      <span><i class="fa fa-phone-alt me-2 text-info"></i> +91 9876543210</span>
      <span><i class="fa fa-envelope me-2 text-info"></i> help@help.com</span>
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
<script src="wshb/js/main.js"></script>
</body>
</html>
