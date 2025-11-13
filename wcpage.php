<?php
session_start();
include "connection.php";
include "headeruser.php";

$reqno = $_GET['id'];
$result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM booking WHERE reqno='$reqno'"));

if (isset($_POST['submit'])) {
  $amt = $_POST['amt'];
  $payment_mode = $_POST['payment_mode'];
  $rating = $_POST['rating'];
  $review = $_POST['review'];

  $update = mysqli_query($conn, "
    UPDATE booking 
    SET amtpaid='$amt', payment_mode='$payment_mode', rating='$rating', review='$review', status='Completed' 
    WHERE reqno='$reqno'
  ");

  if ($update) {
    $uid = $result['uid'];
    $wid = $result['wid'];
    $wname = mysqli_fetch_assoc(mysqli_query($conn, "SELECT wname FROM workshop WHERE ownerid='$wid'"))['wname'];
    $now = date("Y-m-d H:i:s");

    $msg1 = "Service completed by $wname. Amount paid: ₹$amt via $payment_mode.";
    $msg2 = "Work request has been completed from admin.";
    $msg3 = "Thank you for your cooperation and review! – $wname";
    mysqli_query($conn, "INSERT INTO notifications (uid, message, created_at) VALUES ('$uid', '$msg1', '$now')");
    mysqli_query($conn, "INSERT INTO notifications (uid, message, created_at) VALUES ('$uid', '$msg2', '$now')");
    mysqli_query($conn, "INSERT INTO notifications (uid, message, created_at) VALUES ('$uid', '$msg3', '$now')");

    if (!empty($rating)) {
      $title = "New Feedback Received";
      $message = "User rated your service $rating stars for Request #$reqno.";
      $type = "feedback";
      $icon = "fas fa-star";
      mysqli_query($conn, "
        INSERT INTO workshop_notification (wid, title, message, type, icon) 
        VALUES ('$wid', '$title', '$message', '$type', '$icon')
      ");
    }

    if ($payment_mode === 'Cash') {
      echo "<script>alert('Payment Completed'); window.location.href='userhpage.php';</script>";
    } else {
      echo "<script>window.location.href='userpayment.php?id=$reqno';</script>";
    }
  } else {
    echo "<script>alert('Error');</script>";
  }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>User Request Dashboard | Online Breakdown Assistance</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="urh/lib/animate/animate.min.css" rel="stylesheet">
  <link href="urh/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="urh/css/bootstrap.min.css" rel="stylesheet">
  <link href="urh/css/style.css" rel="stylesheet">
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

/* Form container styling */
.bg-light {
  background: rgba(255,255,255,0.1) !important;
  color: #ffffff !important;
}

label {
  color: #ffffff;
  font-weight: 500;
}

.form-control {
  background: rgba(255, 255, 255, 0.56);
  color: #000000ff;
  border: 1px solid rgba(255,255,255,0.3);
}

.form-control:focus {
  background: rgba(255, 255, 255, 0.61);
  color: #ffffff;
  border-color: #11a7bb;
  box-shadow: none;
}

.btn-primary {
  background-color: #770303ff;
  border: none;
  border-radius: 50px;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
  background-color: #000000ff;
  color: #ffffffff;
  border: 1px solid #11a7bb;
  transform: scale(1.05);
}
  </style>
</head>
<body>

<div class="container-fluid bg-light py-5">
  <div class="container text-center">
    <h1 class="display-5"> <span  style="color:#ffffff;">User Request Dashboard</span></h1>
    <p class="lead">Fill in your service request details below.</p>
  </div>
</div>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="bg-light p-5 rounded shadow">
        <h4 class="mb-4 text-center" style="color:#ffffff;">Work Completion</h4>
        <form method="POST">
          <?php
          $fields = [
            'reqno' => 'Request Number',
            'reqdate' => 'Date',
            'reqtime' => 'Time',
            'uid' => 'User ID',
            'phone' => 'Number',
            'complaint' => 'Complaint',
            'landmark' => 'Landmark',
            'wid' => 'Workshop ID'
          ];
          foreach ($fields as $key => $label) {
            echo "<div class='mb-3'>
                    <label class='form-label'>$label</label>
                    <input type='text' name='$key' class='form-control' value='{$result[$key]}' readonly>
                  </div>";
          }
          ?>
         <div class="mb-3">
  <label class="form-label">Total Bill</label>
  <input type="text" name="amt" class="form-control" required>
</div>

<label class="form-label">Payment Mode</label>
<select name="payment_mode" class="form-control mb-3" required>
  <option value="Cash">Cash</option>
  <option value="UPI">UPI</option>
</select>

<label class="form-label">Rating (1–5)</label>
<input type="number" name="rating" class="form-control mb-3" min="1" max="5">

<div class="mb-3">
  <label class="form-label">Review</label>
  <textarea name="review" class="form-control" rows="3"></textarea>
</div>

<button type="submit" class="btn btn-primary w-100" name="submit">Submit Request</button>
</form>
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

</body>
</html>
