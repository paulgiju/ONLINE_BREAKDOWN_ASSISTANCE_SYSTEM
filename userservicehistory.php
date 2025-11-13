<?php
session_start();
include "connection.php";

if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'U') {
  header("Location: login2.php");
  exit();
}

$user_id = $_SESSION['id'];
$query = mysqli_query($conn, "
  SELECT b.reqdate, b.reqtime, b.vehicleno, b.complaint, b.landmark, b.amtpaid, b.status, b.payment_mode, w.wname, w.location
  FROM booking b
  JOIN workshop w ON b.wid = w.ownerid
  WHERE b.uid = '$user_id'
  ORDER BY b.reqdate DESC, b.reqtime DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Service History | Online Breakdown Assistance</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="ushb/css/bootstrap.min.css" rel="stylesheet">
  <link href="ushb/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <style>
    body {
      background: linear-gradient(to bottom right, #120170ff, #000000, #530404ff);
      font-family: 'Lato', sans-serif;
      color: white;
    }

    .card-box {
      background: #0f0f0fff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(170, 5, 5, 1);
    }

    .card-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(35, 57, 255, 1);
}

    .table-hover tbody tr:hover {
      background-color: rgba(255, 255, 255, 1);
    }

    .floating-back {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
    }

    th.sorting::after,
    th.sorting_asc::after,
    th.sorting_desc::after {
      color: white !important;
    }
  </style>
</head>
<body>

<?php include 'headeruser.php'; ?>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-4">
      <h2 class="text-white fw-bold" style="font-family: 'Montserrat', sans-serif;">Your <span class="text-primary">Service History</span></h2>
      <p class="section-description d-inline-block mt-2 text-white">Track all your past roadside assistance requests here.</p>
    </div>

    <div class="table-responsive">
      <table id="historyTable" class="table table-bordered table-striped table-hover text-white align-middle">
        <thead class="table-dark">
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Vehicle No</th>
            <th>Complaint</th>
            <th>Landmark</th>
            <th>Workshop</th>
            <th>Location</th>
            <th>Amount Paid</th>
            <th>Status</th>
            <th>Payment Mode</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
              <tr>
                <td><?php echo $row['reqdate']; ?></td>
                <td><?php echo $row['reqtime']; ?></td>
                <td><?php echo $row['vehicleno']; ?></td>
                <td><?php echo $row['complaint']; ?></td>
                <td><?php echo $row['landmark']; ?></td>
                <td><?php echo $row['wname']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td>₹<?php echo number_format($row['amtpaid'], 2); ?></td>
                <td>
                  <?php
                    $status = $row['status'];
                    if ($status === 'Completed') {
                      echo "<span class='badge bg-success'>Completed</span>";
                    } elseif ($status === 'Rejected') {
                      echo "<span class='badge bg-danger'>Rejected</span>";
                    } else {
                      echo "<span class='badge bg-warning text-dark'>New Complaint</span>";
                    }
                  ?>
                </td>
                <td>
                  <?php
                    $mode = strtolower(trim($row['payment_mode']));
                    if ($mode === 'upi') {
                      echo "<span class='badge bg-info text-dark'>UPI</span>";
                    } else {
                      echo "<span class='badge bg-secondary'>Cash</span>";
                    }
                  ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="10" class="text-center text-muted">No service history found.</td>
            </tr>
          <?php endif; ?>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="ushb/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="ushb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="ushb/js/main.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function() {
    $('#historyTable').DataTable({
      order: [],
      language: {
        paginate: {
          previous: '<i class="fas fa-chevron-left text-white"></i>',
          next: '<i class="fas fa-chevron-right text-white"></i>'
        }
      }
    });
  });
</script>
</body>
</html>
