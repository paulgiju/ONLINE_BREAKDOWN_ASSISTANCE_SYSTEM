<?php include 'connection.php'; ?>
<!-- Top Info Bar with Gradient Background -->
<div class="container-fluid py-2" style="background: linear-gradient(to right, #120170, #000000, #530404);">
  <div class="d-flex justify-content-between align-items-center px-4">
    <div class="small text-white d-flex align-items-center gap-4">
      <span><i class="fa fa-map-marker-alt me-2 text-warning"></i> 
        <a href="#" class="text-white text-decoration-none">Find A Location</a>
      </span>
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

<!-- Main Navigation Bar with Gradient Background -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to right, #120170, #000000, #530404);">
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

<?php
session_start();
?>

<?php
$customer_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM user"))['total'];
$workshop_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM workshop"))['total'];
$service_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM booking WHERE status='Completed'"))['total'];
$revenue_raw = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(amtpaid) AS total FROM booking WHERE status='Completed'"))['total'];
$total_revenue = $revenue_raw ? round($revenue_raw * 0.2) : 0;
?>

<?php
$monthly_data = array_fill(1, 12, 0);
$result = mysqli_query($conn, "
  SELECT MONTH(reqdate) AS month, SUM(amtpaid)*0.2 AS revenue
  FROM booking
  WHERE status='Completed'
  GROUP BY MONTH(reqdate)
");
while($row = mysqli_fetch_assoc($result)) {
  $monthly_data[(int)$row['month']] = round($row['revenue']);
}
$labels = [];
$data = [];
for ($m = 1; $m <= 12; $m++) {
  $labels[] = date("F", mktime(0, 0, 0, $m, 10));
  $data[] = $monthly_data[$m];
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="ahb/css/bootstrap.min.css" rel="stylesheet">
  <link href="ahb/css/style.css" rel="stylesheet">
  <style>
 body {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.05rem;
  color: #ffffff;

  /* Animated gradient background with distinct colors */
  background: linear-gradient(135deg, #5761B2, #c51f1fff, #0e21aaff, #8a0505ff);
  background-size: 600% 600%;
  animation: gradientFlow 7s ease infinite;
}

@keyframes gradientFlow {
  0%   { background-position: 0% 50%; }
  25%  { background-position: 50% 100%; }
  50%  { background-position: 100% 50%; }
  75%  { background-position: 50% 0%; }
  100% { background-position: 0% 50%; }
}
/* Headings */
.main-heading {
  font-size: 3.2rem;
  font-weight: 900;
  color: #ffffff;
}
.main-heading .admin { color: #ffffffff; }
.main-heading .dashboard { color: #ffffffff; }

.section-title {
  font-size: 1.8rem;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30px;
  color: #ffffffff; /* gold accent */
}

/* Dashboard cards */
.dashboard-card {
  background: rgba(204, 24, 24, 0.1);
  border-radius: 12px;
  padding: 25px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(255,255,255,0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  color: #ffffff;
}
.dashboard-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 20px rgba(55, 0, 255, 1);
}
.dashboard-card i {
  font-size: 2rem;
  color: #ff0000ff;
}
.dashboard-card h5 {
  font-weight: 700;
  margin-top: 10px;
  color: #ffffffff;
}
.dashboard-card p {
  font-size: 1.2rem;
  color: #ffffffff;
}

/* Section boxes */
.section-box {
  background: rgba(0, 0, 0, 0.79);
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(38, 0, 255, 1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  color: #ffffff;
}
.section-box:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 20px rgba(255, 0, 0, 1);
  background: rgba(255,255,255,0.2);
}
.section-box i {
  font-size: 2rem;
  color: #ff0000ff;
}
.section-box h6 {
  margin-top: 10px;
  font-weight: 600;
  color: #ffffffff;
}

/* Buttons */
.btn-outline-light {
  border-radius: 50px;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.2s ease;
}
.btn-outline-light:hover {
  background-color: #000000ff;
  color: #fdfdffff;
  transform: scale(1.05);
}

.heading-gradient {
  background: linear-gradient(135deg, #5761B2, #c51f1f, #0e21aa, #8a0505);
  background-size: 600% 600%;
  animation: gradientFlow 7s ease infinite;
}

  </style>
</head>
<body>

<!-- Header -->
<div class="container-fluid py-5 text-center heading-gradient">
  <h2 class="main-heading"><span class="admin">Admin</span> <span class="dashboard">Dashboard</span></h2>
</div>



<!-- Quick Stats -->
<div class="container-fluid py-5" style="background-color: #0d1b3d;">
  <div class="container">
    <h2 class="section-title">Quick Stats</h2>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="dashboard-card">
          <i class="fas fa-users"></i>
          <h5>Total Customers</h5>
          <p><?php echo $customer_count; ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="dashboard-card">
          <i class="fas fa-tools"></i>
          <h5>Total Workshops</h5>
          <p><?php echo $workshop_count; ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="dashboard-card">
          <i class="fas fa-check-circle"></i>
          <h5>Services Completed</h5>
          <p><?php echo $service_count; ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="dashboard-card">
          <i class="fas fa-rupee-sign"></i>
          <h5>Total Revenue</h5>
          <p>₹<?php echo number_format($total_revenue); ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Admin Actions -->
<div class="container py-5">
  <h2 class="section-title">Admin Actions</h2>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="section-box" style="background-color: #0d1b3d; color: white;">
        <i class="fas fa-user-check"></i>
        <h6>Workshop Approval</h6>
        <p class="small">Review and approve new workshop registrations.</p>
        <a href="adminworkshopapproval.php" class="btn btn-outline-light btn-sm">Approve Workshops</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="section-box" style="background-color: #0d1b3d; color: white;">
        <i class="fas fa-shield-alt"></i>
        <h6>Authorized Workshops</h6>
        <p class="small">View all workshops that are officially approved.</p>
        <a href="adminauthorizedwork.php" class="btn btn-outline-light btn-sm">View Authorized</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="section-box" style="background-color: #0d1b3d; color: white;">
        <i class="fas fa-chart-line"></i>
        <h6>Total Revenue</h6>
        <p class="small">Check monthly and yearly revenue reports.</p>
        <a href="adminrevenuepage.php" class="btn btn-outline-light btn-sm">View Revenue</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="section-box" style="background-color: #0d1b3d; color: white;">
        <i class="fas fa-users"></i>
        <h6>Our Customers</h6>
        <p class="small">Browse and manage registered users.</p>
        <a href="adminourcust.php" class="btn btn-outline-light btn-sm">View Customers</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="section-box" style="background-color: #0d1b3d; color: white;">
        <i class="fas fa-history"></i>
        <h6>Service History</h6>
        <p class="small">Track completed services and booking records.</p>
        <a href="adminservicehistory.php" class="btn btn-outline-light btn-sm">View History</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="section-box" style="background-color: #0d1b3d; color: white;">
        <i class="fas fa-user-cog"></i>
        <h6>Admin Profile</h6>
        <p class="small">Update your profile and account settings.</p>
        <a href="adminprofile.php" class="btn btn-outline-light btn-sm">Manage Profile</a>
      </div>
    </div>
  </div>
</div>


<!-- Monthly Revenue Chart -->
<div class="container pb-5">
  <h2 class="section-title">Monthly Revenue Overview</h2>
  <div class="bg-light p-4 rounded shadow">
    <canvas id="revenueChart" height="120"></canvas>
  </div>
</div>



<!-- Scripts -->
<script src="ahb/lib/jquery/jquery.min.js"></script>
<script src="ahb/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="ahb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="ahb/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($labels); ?>,
    datasets: [{
      label: 'Monthly Revenue (₹)',
      data: <?php echo json_encode($data); ?>,
      borderColor: '#1d077eff',
      backgroundColor: 'rgba(13,110,253,0.1)',
      fill: true,
      tension: 0.3,
      pointRadius: 4,
      pointBackgroundColor: '#000000ff'
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Monthly Revenue Overview',
        font: { size: 18 }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 500 }
      }
    }
  }
});
</script>
<!-- Footer Top Bar with Gradient Background -->
<div class="container-fluid py-3 mt-5" style="background: linear-gradient(to right, #120170, #000000, #530404);">
  <div class="d-flex justify-content-between align-items-center px-4 flex-wrap">
    <div class="small text-white d-flex align-items-center gap-4 mb-2 mb-md-0">
      <span><i class="fa fa-map-marker-alt me-2 text-warning"></i> 
        <a href="#" class="text-white text-decoration-none">Find A Location</a>
      </span>
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

<!-- Footer Bottom -->
<div class="container-fluid text-center py-2 border-top" style="background: #000000;">
  <small class="text-white">
    &copy; <?php echo date("Y"); ?> Online Breakdown Assistance System. All rights reserved.
  </small>
</div>

</body>
</html>

