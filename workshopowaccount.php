<?php
session_start();
include "headerworkshop.php"; 
include 'connection.php';

$owner = null;
if (isset($_SESSION['id']) && $_SESSION['rights'] == 'W') {
  $ownerid = $_SESSION['id'];

  if (isset($_POST['update'])) {
    $wname = $_POST['wname'];
    $sname = $_POST['sname'];
    $cperson = $_POST['cperson'];
    $wnumber = $_POST['wnumber'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $upi_id = $_POST['upi_id'];

    $uploadDir = "workshopowuploads/";

    $qr_code = $_POST['existing_qr'];
    if (isset($_FILES['qr_code']) && $_FILES['qr_code']['error'] == 0) {
      $qr_name = basename($_FILES['qr_code']['name']);
      $qr_target = $uploadDir . time() . "_qr_" . $qr_name;
      if (move_uploaded_file($_FILES['qr_code']['tmp_name'], $qr_target)) {
        $qr_code = $qr_target;
      }
    }

    $photo = $_POST['existing_photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
      $photo_name = basename($_FILES['photo']['name']);
      $photo_target = $uploadDir . time() . "_photo_" . $photo_name;
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target)) {
        $photo = $photo_target;
      }
    }

    mysqli_query($conn, "
      UPDATE workshop SET 
        wname='$wname', sname='$sname', cperson='$cperson', wnumber='$wnumber', 
        email='$email', location='$location', upi_id='$upi_id', qr_code='$qr_code', 
        photo='$photo'
      WHERE ownerid='$ownerid'
    ");
    echo "<script>alert('Profile updated successfully'); window.location.href='workshopowaccount.php';</script>";
  }

  $query = mysqli_query($conn, "SELECT * FROM workshop WHERE ownerid='$ownerid'");
  if ($query && mysqli_num_rows($query) > 0) {
    $owner = mysqli_fetch_array($query);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Workshop Owner Account</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="woa/css/bootstrap.min.css" rel="stylesheet">
  <link href="woa/css/style.css" rel="stylesheet">

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
  box-shadow: 0 4px 12px rgba(18, 137, 216, 1); /* Always visible shadow */
  color: #ffffff;
  max-width: 600px;
  margin: 0 auto; /* Center horizontally */
}

   .card-box:hover {
  transform: none;
  box-shadow: 0 4px 12px rgba(255, 29, 29, 1);
}

    label {
      color: #000000ff;
    }

    .form-control,
.form-control-sm {
  background: rgba(255,255,255,0.1);
  color: #000000ff;
  border: 1px solid rgba(255,255,255,0.3);
  font-size: 1rem;
  padding: 0.5rem 0.75rem;
}

input[type="file"] {
  margin: 0 auto;
  display: block;
}
label {
  color: #ffffffff;
  font-weight: 500;
}

    .form-control:focus {
      background: rgba(255,255,255,0.2);
      color: #ffffff86;
      border-color: #11a7bb;
      box-shadow: none;
    }

    .btn-custom {
      background-color: #11a7bb;
      color: #000000ff;
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
  </style>
</head>
<body>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-4">
      <h2 class="fw-bold" style="font-family: 'Montserrat', sans-serif; color: white;">
        Your <span style="color:#11a7bb;">Workshop Profile</span>
      </h2>
      <p class="text-white">View and manage your workshop details securely.</p>
    </div>

    <?php if ($owner) { ?>
      <form method="POST" enctype="multipart/form-data" id="profileForm">
        <div class="mb-3 text-center">
          <?php if (!empty($owner['photo']) && file_exists($owner['photo'])) { ?>
            <img src="<?php echo $owner['photo'] . '?v=' . time(); ?>" class="rounded-circle border mb-2" width="100" height="100">
          <?php } else { ?>
            <i class="fa fa-user-circle fa-4x text-info mb-2"></i>
          <?php } ?>
          <input type="hidden" name="existing_photo" value="<?php echo $owner['photo']; ?>">
          <input type="file" name="photo" class="form-control form-control-sm mt-2" style="max-width:300px; margin:0 auto;" disabled>
        </div>

        <?php
          $fields = [
            'wname' => 'Workshop Name',
            'sname' => 'Service Type',
            'cperson' => 'Contact Person',
            'wnumber' => 'Phone',
            'email' => 'Email',
            'location' => 'Location',
            'upi_id' => 'UPI ID'
          ];
          foreach ($fields as $key => $label) {
        ?>
          <div class="mb-3">
            <label class="form-label"><?php echo $label; ?></label>
            <input type="text" name="<?php echo $key; ?>" class="form-control form-control-sm" value="<?php echo $owner[$key]; ?>" readonly>
          </div>
        <?php } ?>

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control form-control-sm" value="<?php echo $owner['username']; ?>" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">QR Code</label><br>
          <?php if (!empty($owner['qr_code']) && file_exists($owner['qr_code'])) { ?>
            <img src="<?php echo $owner['qr_code'] . '?v=' . time(); ?>" width="100" class="mb-2"><br>
          <?php } else { ?>
            <p class="text-muted">No QR code uploaded.</p>
          <?php } ?>
          <input type="hidden" name="existing_qr" value="<?php echo $owner['qr_code']; ?>">
          <input type="file" name="qr_code" class="form-control form-control-sm" disabled>
        </div>

        <div class="text-center mt-4">
          <button type="button" class="btn btn-custom rounded-pill px-4" id="editBtn">Edit</button>
          <button type="submit" name="update" class="btn btn-custom rounded-pill px-4 d-none" id="saveBtn">Save</button>
          <button type="button" onclick="window.location.href='workshophpage.php'" class="btn btn-outline-light btn-sm rounded-pill ms-2">Back</button>
        </div>

        <div class="text-center mt-3">
          <a href="changepassword.php" class="btn btn-danger rounded-pill px-4">
            <i class="fas fa-key"></i> Change Password
          </a>
        </div>
      </form>
    <?php } else { ?>
      <div class="alert alert-warning text-center text-white bg-transparent border border-warning">
        Unable to load workshop details. Please log in again.
      </div>
    <?php } ?>
  </div>
</div>

  <script>
  document.getElementById('editBtn').addEventListener('click', function () {
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input[type="text"], input[type="file"]');
    inputs.forEach(input => input.removeAttribute('readonly'));
    inputs.forEach(input => input.removeAttribute('disabled'));
    document.getElementById('saveBtn').classList.remove('d-none');
    this.classList.add('d-none');
  });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="woa/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="woa/js/main.js"></script>

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
