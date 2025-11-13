<?php
session_start();
include 'connection.php';

$user = null;
if (isset($_SESSION['id']) && $_SESSION['rights'] == 'U') {
  $user_id = $_SESSION['id'];

  if (isset($_POST['update'])) {
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $uploadDir = "useruploads/";

    $photo = $_POST['existing_photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
      $photo_name = basename($_FILES['photo']['name']);
      $photo_target = $uploadDir . time() . "_photo_" . $photo_name;
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target)) {
        $photo = $photo_target;
      }
    }

    mysqli_query($conn, "
      UPDATE user SET 
        phone='$phone', email='$email', photo='$photo'
      WHERE user_id='$user_id'
    ");
    echo "<script>alert('Profile updated successfully'); window.location.href='useraccount.php';</script>";
  }

  $query = mysqli_query($conn, "SELECT * FROM user WHERE user_id='$user_id'");
  if ($query && mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_array($query);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>User Account</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
  body {
    margin: 0;
    padding: 0;
    background: linear-gradient(to bottom right, #120170ff, #000000, #530404ff);
    font-family: 'Lato', sans-serif;
    color: white;
  }

  .card-box {
    background: #1c1c1c;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(233, 0, 0, 1);
  }

   .card-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(35, 57, 255, 1);
}


  .btn-custom {
    background-color: #bd0d0d;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 0.4rem 1.2rem;
    font-weight: 600;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  .btn-custom:hover {
    background-color: #ffffffff;
    transform: scale(1.05);
  }

  .btn-outline-light {
    border-radius: 50px;
    font-weight: 600;
  }

  .profile-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #d81b1bff;
    box-shadow: 0 0 10px rgba(38, 7, 150, 1);
  }

  /* Centered, narrow profile box */
.card-box {
  background: #1c1c1c;
  border-radius: 12px;
  padding: 2rem;
  box-shadow: 0 4px 12px rgba(233, 0, 0, 1);
  max-width: 1000px;
  margin: 0 auto;
}

/* Smaller heading */
.card-box h2 {
  font-size: 1.5rem;
}

/* Input field width control */
.form-control-sm {
  max-width: 400px;
  margin: 0 auto;
}

/* Edit button styling */
.btn-edit {
  background-color: #198754;
  color: #fff;
  border-radius: 50px;
  padding: 0.4rem 1.2rem;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-edit:hover {
  background-color: #ffffff;
  color: #198754;
  border: 1px solid #198754;
  transform: scale(1.05);
}

  
</style>

<?php include 'headeruser.php'; ?>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-8">
      <h2 class="text-white fw-bold" style="font-family: 'Montserrat', sans-serif;">
        <span class="text-danger">Your</span> <span class="text-white">Profile</span>
      </h2>
      <p class="section-description d-inline-block mt-2 text-white">View and manage your account details securely.</p>
    </div>

    <div class="container-fluid pt-5 px-4">
  <div class="card-box text-center">
    <h2 class="text-white fw-bold mb-3" style="font-family: 'Montserrat', sans-serif;">
     
    <!-- form starts here -->


    <?php if ($user) { ?>
      <form method="POST" enctype="multipart/form-data" id="profileForm">
        <div class="mb-3 text-center">
          <?php if (!empty($user['photo']) && file_exists($user['photo'])) { ?>
            <img src="<?php echo $user['photo'] . '?v=' . time(); ?>" class="profile-img mb-2">
          <?php } else { ?>
            <i class="fa fa-user-circle fa-4x text-secondary mb-2"></i>
          <?php } ?>
          <input type="hidden" name="existing_photo" value="<?php echo $user['photo']; ?>">
          <input type="file" name="photo" class="form-control form-control-sm mt-2" style="max-width:300px; margin:0 auto;" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label text-white">Username</label>
          <input type="text" class="form-control form-control-sm" value="<?php echo $user['username']; ?>" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label text-white">Name</label>
          <input type="text" class="form-control form-control-sm" value="<?php echo $user['name']; ?>" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label text-white">Phone</label>
          <input type="text" name="phone" class="form-control form-control-sm" value="<?php echo $user['phone']; ?>" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label text-white">Email</label>
          <input type="email" name="email" class="form-control form-control-sm" value="<?php echo $user['email']; ?>" readonly>
        </div>

        <div class="text-center mt-4">
          <button type="button" class="btn btn-edit btn-sm me-2" id="editBtn">
            <i class="fas fa-edit me-1"></i> Edit
          </button>

          <button type="submit" name="update" class="btn btn-custom btn-sm d-none me-2" id="saveBtn">
            <i class="fas fa-save me-1"></i> Save
          </button>
          <a href="userhpage.php" class="btn btn-outline-light btn-sm me-2">
            <i class="fas fa-arrow-left me-1"></i> Back
          </a>
          <a href="changepassword.php" class="btn btn-outline-light btn-sm">
            <i class="fas fa-key me-1"></i> Change Password
          </a>
        </div>
      </form>
    <?php } else { ?>
      <div class="alert alert-warning text-center text-dark">
        Unable to load user details. Please log in again.
      </div>
    <?php } ?>
  </div>
</div>

<script>
  document.getElementById('editBtn').addEventListener('click', function () {
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="file"]');
    inputs.forEach(input => input.removeAttribute('readonly'));
    inputs.forEach(input => input.removeAttribute('disabled'));
    document.getElementById('saveBtn').classList.remove('d-none');
    this.classList.add('d-none');
  });
</script>

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

</html>
