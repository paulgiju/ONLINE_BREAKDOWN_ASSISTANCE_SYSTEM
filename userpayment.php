<?php
session_start();
include "connection.php";

$reqno = $_GET['id'];
$bdata = mysqli_fetch_assoc(mysqli_query($conn, "SELECT wid, uid FROM booking WHERE reqno='$reqno'"));
$wid = $bdata['wid'];
$uid = $bdata['uid'];

$wdata = mysqli_fetch_assoc(mysqli_query($conn, "SELECT upi_id, qr_code, wname FROM workshop WHERE ownerid='$wid'"));
$upi_id = $wdata['upi_id'];
$qr_code = $wdata['qr_code'];
$wname = $wdata['wname'];

$now = date("Y-m-d H:i:s");
$title = "UPI Payment Received";
$message = "Payment for Request #$reqno has been confirmed via UPI.";
$type = "payment";
$icon = "fas fa-wallet";
mysqli_query($conn, "
  INSERT INTO workshop_notification (wid, title, message, type, icon) 
  VALUES ('$wid', '$title', '$message', '$type', '$icon')
");
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>UPI Payment | Online Breakdown Assistance</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="upb/css/bootstrap.min.css" rel="stylesheet">
  <link href="upb/css/style.css" rel="stylesheet">
  <style>
 
body {
  margin: 0;
  padding: 0;
  min-height: 100vh;
  font-family: 'Lato', sans-serif;
  color: white;

  /* Static gradient background */
  background: linear-gradient(to bottom right, #120170, #000000, #530404);
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-size: cover;
}

/* Card container styling */
.bg-light {
  background: rgba(160, 160, 160, 1) !important;
  color: #ffffff !important;
}

h4 {
  color: #ac0505ff;
  font-weight: 600;
}

p, strong {
  color: #000000ff;
}

.text-muted {
  color: #cccccc !important;
}

/* QR code image styling */
img {
  border: 2px solid #ff0101ff;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(7, 218, 255, 1);
}

/* Button styling */
.btn-success {
  background-color: #11a7bb;
  border: none;
  border-radius: 50px;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-success:hover {
  background-color: #ffffff;
  color: #11a7bb;
  border: 1px solid #13e3ffff;
  transform: scale(1.05);
}


  </style>
</head>
<body>

<?php include 'headeruser.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="bg-light p-4 rounded shadow text-center">
        <h4 class="mb-3">Pay via UPI</h4>
        <p><strong>UPI ID:</strong> <?php echo $upi_id; ?></p>
        <?php if (!empty($qr_code)) { ?>
          <img src="<?php echo $qr_code; ?>" alt="QR Code" class="img-fluid mb-3" style="max-width: 300px;">
        <?php } else { ?>
          <p class="text-muted">QR code not available.</p>
        <?php } ?>
        <button onclick="window.location.href='userhpage.php'" class="btn btn-success w-100">Complete Payment</button>
      </div>
    </div>
  </div>
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

<script src="upb/js/main.js"></script>
</body>
</html>
