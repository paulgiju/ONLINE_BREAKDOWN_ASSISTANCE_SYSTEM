<?php 
session_start();
include "connection.php"; 

$wid = $_SESSION['id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search !== '') {
  $data = mysqli_query($conn, "SELECT * FROM booking WHERE wid='$wid' AND reqno LIKE '%$search%' ORDER BY reqno DESC");
} else {
  $data = mysqli_query($conn, "SELECT * FROM booking WHERE wid='$wid' ORDER BY reqno DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Workshop Owner | Service Requests</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="whb/css/bootstrap.min.css" rel="stylesheet">
  <link href="whb/css/style.css" rel="stylesheet">

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
      box-shadow: 0 4px 12px rgba(0, 225, 255, 1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(255, 36, 36, 1);
    }

    .table-hover tbody tr:hover {
      background-color: rgba(255,255,255,0.1);
    }

    .status-new { color: #0dcaf0; font-weight: bold; }
    .status-accepted { color: #11a7bb; font-weight: bold; }
    .status-rejected { color: #ff4c4c; font-weight: bold; }
    .status-completed { color: #ffffff; font-weight: bold; }

    .btn-custom {
  background-color: #11a7bb !important;
  color: #fff !important;
  border: none !important;
  border-radius: 50px !important;
  padding: 0.4rem 1rem !important;
  font-weight: 600 !important;
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
  </style>
</head>

<body>

<?php include 'headerworkshop.php'; ?>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0 text-white">All Service Requests</h4>
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
            <th>Vehicle No</th>
            <th>Complaint</th>
            <th>Landmark</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($data) > 0) {
            while ($r = mysqli_fetch_array($data)) {
              $status = $r['status'];
              $statusClass = match($status) {
                'Accepted' => 'status-accepted',
                'Rejected' => 'status-rejected',
                'Completed' => 'status-completed',
                'New Complaint' => 'status-new',
                default => 'text-white'
              };
          ?>
            <tr>
              <td><?php echo $r['reqno']; ?></td>
              <td><?php echo $r['reqdate']; ?></td>
              <td><?php echo $r['reqtime']; ?></td>
              <td><?php echo $r['uid']; ?></td>
              <td><?php echo $r['phone']; ?></td>
              <td><?php echo $r['vehicleno']; ?></td>
              <td><?php echo $r['complaint']; ?></td>
              <td><?php echo $r['landmark']; ?></td>
              <td class="<?php echo $statusClass; ?>"><?php echo $status; ?></td>
              <td>
                <?php if ($status == 'New Complaint') { ?>
                  <a href="woap.php?id=<?php echo $r['reqno']; ?>" class="btn btn-custom btn-sm">Accept</a>
                  <a href="wor.php?id=<?php echo $r['reqno']; ?>" class="btn btn-danger btn-sm">Reject</a>
                <?php } else { ?>
                  <span class="text-white">—</span>
                <?php } ?>
              </td>
            </tr>
          <?php 
            }
          } else {
            echo "<tr><td colspan='10' class='text-center text-white'>No requests found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="whb/lib/wow/wow.min.js"></script>
<script src="whb/lib/easing/easing.min.js"></script>
<script src="whb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="whb/js/main.js"></script>
</body>
</html>
