<?php 
session_start(); 
include "connection.php";

if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'U') {
  header("Location: login2.php");
  exit();
}

$uid = $_SESSION['id'];

$data = mysqli_query($conn, "SELECT * FROM workshop WHERE rights='W'");
$locdata = mysqli_query($conn, "SELECT DISTINCT location FROM workshop");
$notes = mysqli_query($conn, "SELECT * FROM notifications WHERE uid='$uid' ORDER BY created_at DESC LIMIT 5");

$user = null;
$query = mysqli_query($conn, "SELECT name, photo, phone, email FROM user WHERE user_id='$uid'");
if ($query && mysqli_num_rows($query) > 0) {
  $user = mysqli_fetch_array($query);
}

if (isset($_POST['submit'])) {
  $loc = $_POST['loc'];
  $data = mysqli_query($conn, "SELECT * FROM workshop WHERE rights='W' AND location='$loc'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>User Homepage | Online Breakdown Assistance</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="uhb/lib/animate/animate.min.css" rel="stylesheet">
  <link href="uhb/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="uhb/css/bootstrap.min.css" rel="stylesheet">
  <link href="uhb/css/style.css" rel="stylesheet">

  <style>
  body {
  margin: 0;
  padding: 0;
  min-height: 100vh;
  font-family: 'Lato', sans-serif;
  color: white;

  /* Animated gradient with 4 colors visible at once */
  background: linear-gradient(135deg, #00643eff, #000000ff, #050049ff, #000000ff);
  background-size: 600% 600%;
  animation: gradientFlow 20s ease infinite;
}

@keyframes gradientFlow {
  0%   { background-position: 0% 50%; }
  25%  { background-position: 50% 100%; }
  50%  { background-position: 100% 50%; }
  75%  { background-position: 50% 0%; }
  100% { background-position: 0% 50%; }
}



.card-box {
  background: #ffffffa6;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 4px 12px rgba(255, 9, 9, 1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(0, 14, 141, 1);
}

.btn-custom {
  background-color: #bd0d0dff;
  color: #fff;
  border: none;
  border-radius: 50px;
  padding: 0.5rem 1.25rem;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-custom:hover {
  background-color: #faf7f7ff;
  transform: scale(1.05);
}


  </style>
</head>
<body>


<!-- Top Info Bar with Taller Gradient Background -->
<div class="container-fluid py-3" style="background: linear-gradient(to right, #120170ff, #000000, #530404ff);">
  <div class="d-flex justify-content-between align-items-center px-4 flex-wrap">
    <div class="small text-white d-flex align-items-center gap-4 mb-2 mb-md-0">
      <span><i class="fa fa-map-marker-alt me-2 text-warning"></i> <a href="#" class="text-white text-decoration-none">Find A Location</a></span>
      <span><i class="fa fa-phone-alt me-2 text-warning"></i> +91 9876543210</span>
      <span><i class="fa fa-envelope me-2 text-warning"></i> help@help.com</span>
    </div>
    <div class="d-flex align-items-center gap-3">
      <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
      <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
      <a href="#" class="text-white"><i class="fa fa-user-circle"></i></a>
    </div>
  </div>
</div>

<!-- Main Navigation Bar with Taller Gradient Background -->
<nav class="navbar navbar-expand-lg navbar-dark py-3" style="background: linear-gradient(to right, #120170ff, #000000, #530404ff);">
  <div class="container-fluid px-4">
    <div class="d-flex w-100 justify-content-between align-items-center">
      <a class="navbar-brand fw-bold d-flex align-items-center text-white" href="#">
        <i class="fas fa-car me-2 text-danger"></i>
        <span class="text-uppercase">Online Breakdown Assistance System</span>
      </a>
      <ul class="navbar-nav d-flex flex-row gap-4 mb-0">
        <li class="nav-item"><a class="nav-link text-white" href="homepage.php">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="login2.php">Login</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="registration.php">User Registration</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="workshoplogin.php">Workshop Owner Registration</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="contact.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="aboutus.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>



<!-- Heading -->
<div class="container-fluid py-5" style="background: transparent;">

  <div class="container text-center">
    <h1 class="fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 2.5rem;">
      <span  style="color: #ffffffff;">Your Dashboard</span>
    </h1>
    <p class="section-description d-inline-block mt-3">
      Request assistance, explore services, and manage your vehicle support — all in one place.
    </p>
  </div>
</div>

<!-- Reservation + User Control Section -->
<div class="container-fluid bg-secondary py-5">
  <div class="container">
    <div class="row justify-content-center g-4">
      <!-- Request Assistance -->
      <div class="col-md-6">
        <div class="bg-light rounded p-4 h-100">
          <h4 class="mb-4">Request Assistance</h4>
          <form method='POST'>
            <select class="form-select mb-3" name="loc">
              <option selected>Select Your Location</option>
              <?php while ($locresult = mysqli_fetch_array($locdata)) { ?>
                <option value="<?php echo $locresult['location']; ?>"><?php echo $locresult['location']; ?></option>
              <?php } ?>
            </select>
            <button class="btn btn-custom mt-2 w-100 mb-3" type="submit" name="submit">Book Now</button>
          </form>
          <h6 class="text-muted">Available Locations:</h6>
          <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
            <ul class="list-unstyled mb-0">
              <?php mysqli_data_seek($locdata, 0); while ($locresult = mysqli_fetch_array($locdata)) { ?>
                <li><i class="fas fa-map-marker-alt text-primary me-2"></i><?php echo $locresult['location']; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>

      <!-- User Control -->
      <div class="col-md-6">
        <div class="bg-light rounded p-4 h-100 text-center profile-box">
          <?php if ($user): ?>
            <p class="text-muted mb-2">Welcome back, <strong><?php echo htmlspecialchars($user['name']); ?></strong>!</p>
            <img src="<?php echo (!empty($user['photo']) && file_exists($user['photo'])) ? $user['photo'] : 'useruploads/default.png'; ?>" alt="Profile" style="width:70px; height:70px; object-fit:cover; border-radius:50%; border:2px solid #0d3c61;">
            <h5><?php echo htmlspecialchars($user['name']); ?></h5>
            <p class="mb-1"><i class="fas fa-phone-alt text-muted me-2"></i><?php echo $user['phone']; ?></p>
            <p class="mb-3"><i class="fas fa-envelope text-muted me-2"></i><?php echo $user['email']; ?></p>

            <a href="logout.php" class="btn btn-outline-primary btn btn-custom mt-2">
              <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>

            <div class="dropdown mt-2">
              <button class="btn btn-primary dropdown-toggle btn btn-custom mt-2" type="button" id="moreOptions" data-bs-toggle="dropdown" aria-expanded="false">
                More Options
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreOptions">
                <li><a class="dropdown-item" href="contact.php"><i class="fas fa-question-circle me-2"></i>Help</a></li>
                <li><a class="dropdown-item" href="aboutus.php"><i class="fas fa-headset me-2"></i>Customer Care</a></li>
              </ul>
            </div>
          <?php else: ?>
            <p class="text-muted">Unable to load profile.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Activity Section -->
<div class="container-fluid service py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 2.5rem;">
        <span  style="color: #ffffffff;">Your Activity</span>
      </h1>
      <p class="section-description d-inline-block mt-3">
        Track your service requests, monitor progress, and manage your roadside assistance history.
      </p>
    </div>
    <div class="row g-4 justify-content-center">
      <!-- View Requests -->
      <div class="col-md-6 col-lg-4">
        <div class="card-box text-center h-100">
          <i class="fa fa-tasks fa-2x text-danger mb-3"></i>
          <h5 class="fw-bold">View Your Requests</h5>
          <p>Check your past and current service requests and stay updated on their status.</p>
          <a href="userviewrqst.php" class="btn btn-custom mt-2">Go to Requests</a>
        </div>
      </div>

      <!-- Service History -->
      <div class="col-md-6 col-lg-4">
        <div class="card-box text-center h-100">
          <i class="fa fa-history fa-2x text-danger mb-3"></i>
          <h5 class="fw-bold">Service History</h5>
          <p>View your completed service requests and track past assistance.</p>
          <a href="userservicehistory.php" class="btn btn-custom mt-2">View History</a>
        </div>
      </div>

      <!-- Invoices -->
      <div class="col-md-6 col-lg-4">
        <div class="card-box text-center h-100">
          <i class="fas fa-file-invoice-dollar fa-2x text-danger mb-3"></i>
          <h5 class="fw-bold">Your Invoices</h5>
          <p>View payment details and download invoices for completed services.</p>
          <a href="userinvoice.php" class="btn btn-custom mt-2">View Invoices</a>
        </div>
      </div>

      <!-- Reviews -->
      <div class="col-md-6 col-lg-4">
        <div class="card-box text-center h-100">
          <i class="fa fa-star fa-2x text-danger mb-3"></i>
          <h5 class="fw-bold">Your Ratings & Reviews</h5>
          <p>See feedback you've submitted for completed service requests.</p>
          <a href="userreview.php" class="btn btn-custom mt-2">View Reviews</a>
        </div>
      </div>

      <!-- Notifications -->
      <div class="col-md-6 col-lg-4">
        <div class="card-box text-center h-100">
          <i class="fas fa-bell fa-2x text-danger mb-3"></i>
          <h5 class="fw-bold">Notifications</h5>
          <p>Stay updated on your request status, payments, and service progress.</p>
          <a href="usernoti.php" class="btn btn-custom mt-2">View Notifications</a>
        </div>
      </div>

      <!-- Account -->
      <div class="col-md-6 col-lg-4">
        <div class="card-box text-center h-100">
          <i class="fa fa-user-circle fa-2x text-danger mb-3"></i>
          <h5 class="fw-bold">View Your Account</h5>
          <p>See your profile details and manage your account settings.</p>
          <a href="useraccount.php" class="btn btn-custom mt-2">Go to Account</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Workshop Section -->
<div class="container-fluid categories py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 2.5rem;">
        <span  style="color: #ffffffff;">Available Workshops</span>
      </h1>
          <p class="section-description d-inline-block mt-3">
        Choose your vehicle type to match service needs accurately.
      </p>
    </div>
    <div class="row g-4">
      <?php while ($result = mysqli_fetch_array($data)) { ?>
        <div class="col-md-6 col-lg-3">
          <div class="card-box text-center">
            <img src="<?php echo $result['photo']; ?>" class="img-fluid mb-3" alt="Workshop">
            <h5><?php echo $result['wname']; ?></h5>
            <p><?php echo $result['wnumber']; ?> • <?php echo $result['location']; ?> •  <?php echo $result['sname']; ?></p>
            <a href="userrequesth.php?id=<?php echo $result['ownerid']; ?>" class="btn btn-custom mt-2">Book Now</a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<!-- Process Section -->
<div class="container-fluid steps bg-secondary py-5">
  <div class="container">
    <div class="text-center text-white mb-5">
      <h1 class="display-5" style="color: #ffffffff;"> Our Process</span></h1>
      <p>Register → Locate workshop → Request help → Get assistance → Track status.</p>
    </div>
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="card-box text-center">
          <h4>Come In Contact</h4>
          <p>Reach out anytime—our team is ready to assist you</p>
          <div class="text-primary fw-bold">01.</div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card-box text-center">
          <h4>Choose Car Model</h4>
          <p>Select your vehicle type to match service needs accurately.</p>
          <div class="text-primary fw-bold">02.</div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card-box text-center">
          <h4>Get your service instantly</h4>
          <p>Request help, connect fast, and receive roadside support without delay.</p>
          <div class="text-primary fw-bold">03.</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="uhb/lib/jquery/jquery.min.js"></script>
<script src="uhb/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="uhb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="uhb/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

</body>
</html>
