<?php 
session_start();
include "connection.php"; 
include 'headeruser.php';

$uid = $_SESSION['id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search !== '') {
  $data = mysqli_query($conn, "SELECT * FROM booking WHERE uid='$uid' AND reqno LIKE '%$search%' ORDER BY reqno DESC");
} else {
  $data = mysqli_query($conn, "SELECT * FROM booking WHERE uid='$uid' ORDER BY reqno DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>User | Service Requests</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

  <!-- Icon Fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries -->
  <link href="whb/css/bootstrap.min.css" rel="stylesheet">
  <link href="whb/css/style.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to bottom right, #120170ff, #000000, #530404ff);
      font-family: 'Lato', sans-serif;
      color: white;
    }

    .card-box {
      background: #000000ff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(221, 0, 0, 1);
    }

    .card-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(0, 26, 255, 1);
}

    .table-hover tbody tr:hover {
      background-color: rgba(255, 255, 255, 0.05);
    }

   
    

    
  
    .btn-custom {
      background-color: #bd0d0d;
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 0.4rem 1rem;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-custom:hover {
      background-color: #a30000;
      transform: scale(1.05);
    }

    .floating-back {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
    }
  </style>
</head>
<body>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0 text-white fw-bold" style="font-family: 'Montserrat', sans-serif;">Recent Service Activity</h4>
      <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search Request No" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-custom">Search</button>
      </form>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover text-white align-middle">
        <thead>
          <tr>
            <th>Request No</th>
            <th>Date</th>
            <th>Time</th>
            <th>User ID</th>
            <th>Phone</th>
            <th>Workshop</th>
            <th>Vehicle No</th>
            <th>Complaint</th>
            <th>Landmark</th>
            <th>Status</th>
            <th>Amount Paid</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($r = mysqli_fetch_array($data)) {
            $wid = $r['wid'];
            $wnamequery = mysqli_query($conn, "SELECT wname FROM workshop WHERE ownerid='$wid'");
            $wnamefetch = mysqli_fetch_array($wnamequery);
            $wname = $wnamefetch['wname'];
            $status = strtolower(trim($r['status']));
          ?>
          <tr>
            <td><?php echo $r['reqno']; ?></td>
            <td><?php echo $r['reqdate']; ?></td>
            <td><?php echo $r['reqtime']; ?></td>
            <td><?php echo $r['uid']; ?></td>
            <td><?php echo $r['phone']; ?></td>
            <td><?php echo $wname; ?></td>
            <td><?php echo $r['vehicleno']; ?></td>
            <td><?php echo $r['complaint']; ?></td>
            <td><?php echo $r['landmark']; ?></td>
            <td>
              <?php
              if ($status === 'accepted' && $r['amtpaid'] == 0) {
                echo "<span class='badge bg-success'><i class='fas fa-check-circle me-1'></i>Accepted</span>";
              } elseif ($status === 'new complaint') {
                echo "<span class='badge bg-warning text-dark'><i class='fas fa-hourglass-start me-1'></i>Pending</span>";
              } elseif ($status === 'rejected') {
                echo "<span class='badge bg-danger'><i class='fas fa-times-circle me-1'></i>Rejected</span>";
              } else {
                echo "<span class='badge bg-secondary'><i class='fas fa-check-double me-1'></i>Completed</span>";
              }
              ?>
            </td>
            <td><?php echo $r['amtpaid']; ?></td>
            <td>
              <?php
              if ($status === 'accepted' && $r['amtpaid'] == 0) {
                echo '<a href="wcpage.php?id=' . $r['reqno'] . '" class="btn btn-primary btn-sm">Complete Work</a>';
              } elseif ($status === 'new complaint') {
                echo '<button class="btn btn-warning btn-sm" disabled>Request Pending</button>';
              } elseif ($status === 'rejected') {
                echo '<button class="btn btn-danger btn-sm" disabled>Request Rejected</button>';
              } else {
                echo '<button class="btn btn-secondary btn-sm" disabled>Work Completed</button>';
              }
              ?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Floating Back Button -->
<div class="floating-back">
  <a href="userhpage.php" class="btn btn-danger rounded-circle shadow">
    <i class="fas fa-arrow-left"></i>
  </a>
</div>

<!-- Footer Top Bar with Taller Gradient Background -->
<div class="container-fluid py-3 mt-5" style="background: linear-gradient(to right, #120170ff, #000000, #530404ff);">
  <div class="d-flex justify-content-between align-items-center px-4 flex-wrap">
    <div class="small text-white d-flex align-items-center gap-4 mb-2 mb-md-0">
      <span><i class="fa fa-map-marker-alt me-2 text-danger"></i> <a href="#" class="text-white text-decoration-none">Find A Location</a></span>
      <span><i class="fa fa-phone-alt me-2 text-danger"></i> +91 9876543210</span>
      <span><i class="fa fa-envelope me-2 text-danger"></i> help@help.com</span>
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
<div class="container-fluid bg-white text-center py-3 border-top">
  <small class="text-muted">
    &copy; <?php echo date("Y"); ?> Online Breakdown Assistance System. All rights reserved.
  </small>
</div>

<!-- JS Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="whb/lib/wow/wow.min.js"></script>
<script src="whb/lib/easing/easing.min.js"></script>
<script src="whb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="whb/js/main.js"></script>
</body>
</html>
