<?php
include 'headeruser.php';
session_start();
include "connection.php";

$wid = $_GET['id'];
$wdata = mysqli_query($conn, "SELECT * FROM workshop WHERE ownerid='$wid'");
$result = mysqli_fetch_array($wdata);
$wname = $result['wname'];

$uid = $_SESSION['id'];
$name = $_SESSION['name'];
$cdate = date("Y-m-d");

$udata = mysqli_query($conn, "SELECT * FROM user WHERE user_id='$uid'");
$uresult = mysqli_fetch_array($udata);
$phone = $uresult['phone'];

$data = mysqli_query($conn, "SELECT MAX(reqno)+1 FROM booking");
$req = mysqli_fetch_array($data);
$reqno = empty($req[0]) ? 1 : $req[0];

if (isset($_POST['submit'])) {
  $reqno = $_POST['reqno'];
  $reqdate = $_POST['reqdate'];
  $reqtime = $_POST['reqtime'];
  $iname = $_POST['iname'];
  $phone = $_POST['phone'];
  $vehicleno = $_POST['vehicleno'];
  $complaint = $_POST['complaint'];
  $landmark = $_POST['landmark'];

  $insert = mysqli_query($conn, "
    INSERT INTO booking (reqno, reqdate, reqtime, uid, phone, complaint, landmark, vehicleno, wid, status) 
    VALUES ('$reqno', '$reqdate', '$reqtime', '$uid', '$phone', '$complaint', '$landmark', '$vehicleno', '$wid', 'New Complaint')
  ");

  if ($insert) {
    $now = date("Y-m-d H:i:s");
    $msg = "You placed a service request to $wname.";
    mysqli_query($conn, "INSERT INTO notifications (uid, message, created_at) VALUES ('$uid', '$msg', '$now')");

    $title = "New Service Request";
    $message = "You received a new service request from user $name.";
    $type = "request";
    $icon = "fas fa-tools";
    mysqli_query($conn, "
      INSERT INTO workshop_notification (wid, title, message, type, icon) 
      VALUES ('$wid', '$title', '$message', '$type', '$icon')
    ");

    echo "<script>alert('Request Submitted Successfully'); window.location.href='userhpage.php';</script>";
  } else {
    echo "<script>alert('Error in submitting request');</script>";
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

<!-- Page Heading -->
<div class="container-fluid bg-light py-5">
  <div class="container text-center">
    <h1 class="display-5"> <span class="text-primary">User   Request Dashboard</span></h1>
    <p class="lead">Fill in your service request details below.</p>
  </div>
</div>

<!-- Request Form Section -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="bg-light p-5 rounded shadow">
        <h4 class="mb-4 text-center" style="color:#ffffff;">Service Request Form</h4>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Request Number</label>
            <input type="text" name="reqno" class="form-control" value="<?php echo $reqno; ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="reqdate" class="form-control" value="<?php echo $cdate; ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="text" name="reqtime" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Informer Name</label>
            <input type="text" name="iname" class="form-control" value="<?php echo $name; ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Vehicle Number</label>
            <input type="text" name="vehicleno" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Complaint of the Car</label>
            <textarea name="complaint" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Landmark</label>
            <input type="text" name="landmark" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Workshop Name</label>
            <input type="text" name="wname" class="form-control" value="<?php echo $wname; ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Workshop ID</label>
            <input type="text" name="wid" class="form-control" value="<?php echo $wid; ?>" readonly>
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
