<?php
session_start();
include 'connection.php';
?>
<div class="container-fluid py-2" style="background: linear-gradient(to right, #000000, #11a7bbff);">
  <div class="d-flex justify-content-between align-items-center px-4">
    <div class="small text-white d-flex align-items-center gap-4">
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

<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to right, #000000, #11a7bbff);">
  <div class="container-fluid px-4">
    <div class="d-flex w-100 justify-content-between align-items-center">
      <a class="navbar-brand fw-bold d-flex align-items-center text-white" href="#">
        <i class="fas fa-car me-2 text-info"></i>
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
if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'W') {
  header("Location: login2.php");
  exit();
}

$wid = $_SESSION['id'];
$year = date("Y");
$month = date("m");

// Revenue for current month only
$monthResult = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT SUM(amtpaid) AS total FROM booking 
  WHERE wid='$wid' AND status='Completed' AND YEAR(reqdate) = '$year' AND MONTH(reqdate) = '$month'
"));
$monthTotal = round($monthResult['total'] ?? 0);
$monthCommission = round($monthTotal * 0.20);
$monthNet = $monthTotal - $monthCommission;


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Workshop Owner Homepage</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries -->
  <link href="wshb/lib/animate/animate.min.css" rel="stylesheet">
  <link href="wshb/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Bootstrap & Template Styles -->
  <link href="wshb/css/bootstrap.min.css" rel="stylesheet">
  <link href="wshb/css/style.css" rel="stylesheet">

  <style>
    .dashboard-card {
      min-height: 280px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(19, 128, 172, 1);
      background-color: #000000ff;
    }
    .dashboard-card h5 {
      font-weight: 600;
    }
    .dashboard-card i {
      font-size: 2rem;
    }


    body {
  margin: 0;
  padding: 0;
  min-height: 100vh;
  font-family: 'Lato', sans-serif;
  color: white;
  background: linear-gradient(-45deg, #000000, #11a7bb, #000000ff, #11a7bb);
  background-size: 400% 400%;
  animation: gradientShift 15s ease infinite;
}

@keyframes gradientShift {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}


.dashboard-card {
  background-color: rgba(255, 255, 255, 0.74);
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 4px 12px rgba(255, 0, 0, 1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 195, 255, 1);
}

.btn-custom {
  background-color: #11a7bb;
  color: #fff;
  border: none;
  border-radius: 50px;
  padding: 0.5rem 1.25rem;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-custom:hover {
  background-color: #ffffff;
  color: #11a7bb;
  border: 1px solid #11a7bb;
  transform: scale(1.05);
}

.text-sky {
  color: #ffffffff;
}

/* Force white text for muted and secondary classes */
.text-muted,
.text-secondary,
.text-dark,
.text-body,
.text-black {
  color: #ffffff !important;
}

/* Optional: white text inside cards and dropdowns */
.card-box,
.dropdown-menu {
  color: #ffffff;
}

/* Optional: white text for headings and paragraphs */
h1, h2, h3, h4, h5, h6,
p, span, label, small {
  color: #ffffff;
}

.dropdown-menu .dropdown-item {
  color: #ffffff !important;
  background-color: transparent;
}

.custom-dropdown {
  background-color: #000000; /* Black background */
}

.custom-dropdown .dropdown-item {
  color: #ffffff; /* White text */
}

.custom-dropdown .dropdown-item:hover {
  background-color: #11a7bb; /* Sky blue hover */
  color: #ffffff;
}


  </style>
</head>
<body>

<!-- Workshop Dashboard Section -->
<div class="container-fluid py-5 ">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="display-5 fw-bold">
   <span class="text-sky">Workshop Owner Dashboard</span>
</h1>
      <p>Manage your services, track history, and respond to requests efficiently.</p>
      <?php
        $owner_id = $_SESSION['id'];
        $owner = null;
        $owner_query = mysqli_query($conn, "SELECT wname, photo, wnumber, email FROM workshop WHERE ownerid='$owner_id'");
        if ($owner_query && mysqli_num_rows($owner_query) > 0) {
          $owner = mysqli_fetch_array($owner_query);
        }
        ?>

        <?php if ($owner): ?>
          <div class="row justify-content-center mb-4">
            <div class="col-md-10">
              <div class=" p-3 rounded shadow d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                  <img src="<?php echo (!empty($owner['photo']) && file_exists($owner['photo'])) ? $owner['photo'] : 'useruploads/default.png'; ?>" alt="Owner Photo" class="me-3" style="width: 70px; height: 70px; object-fit: cover; border-radius: 50%; border: 2px solid #0d3c61;">
                  <div>
                    <h6 class="mb-1 text-success fw-bold"><?php echo htmlspecialchars($owner['wname']); ?></h6>
                    <div class="text-muted small">
                      <i class="fas fa-phone-alt me-1"></i><?php echo $owner['wnumber']; ?> &nbsp; | &nbsp;
                      <i class="fas fa-envelope me-1"></i><?php echo $owner['email']; ?>
                    </div>
                  </div>
                </div>
                <div class="dropdown">
                  <button class="btn btn-success btn-sm rounded-pill dropdown-toggle" type="button" id="moreOptions" data-bs-toggle="dropdown" aria-expanded="false">
                    More Options
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="moreOptions">
  <li><a class="dropdown-item" href="contact.php"><i class="fas fa-question-circle me-2"></i>Help</a></li>
  <li><a class="dropdown-item" href="aboutus.php"><i class="fas fa-headset me-2"></i>Customer Care</a></li>
  <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
</ul>

                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>


    </div>

    

    <!-- Top Row: 3 Cards -->
    <div class="row g-4">
      <!-- Recent Service Requests -->
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <div>
            <i class="fas fa-tasks text-success mb-3"></i>
            <h5>Recent Service Requests</h5>
            <p>View and respond to new customer assistance requests.</p>
          </div>
          <a href="workshopvrqst.php" class="btn btn-custom rounded-pill mt-2">View Requests</a>
        </div>
      </div>

      <!-- Service History -->
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <div>
            <i class="fas fa-history text-success mb-3"></i>
            <h5>Service History</h5>
            <p>View completed service requests and track your earnings.</p>
          </div>
          <a href="workshopservicehistory.php" class="btn btn-custom rounded-pill mt-2">View History</a>
        </div>
      </div>

      <!-- Earnings Summary -->
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <div>
            <i class="fas fa-chart-line text-success mb-3"></i>
            <h5>Earnings Summary</h5>
            <p>View your total income, payment breakdown, and monthly earnings.</p>
          </div>
          <a href="workshopearning.php" class="btn btn-custom rounded-pill mt-2">View Earnings</a>
          </div>
      </div>
    </div>

 <!-- Bottom Row: Feedback, Notifications & Profile -->
<div class="row g-4 mt-3 justify-content-center">
  <!-- User Feedback -->
  <div class="col-md-6 col-lg-4">
    <div class="dashboard-card text-center">
      <div>
        <i class="fas fa-star text-success mb-3"></i>
        <h5>User Feedback</h5>
        <p>See reviews and ratings submitted by users for your completed services.</p>
      </div>
      <a href="workshopreview.php" class="btn btn-custom rounded-pill mt-2">View Feedback</a>
    </div>
  </div>

  <!-- Notifications -->
  <div class="col-md-6 col-lg-4">
    <div class="dashboard-card text-center">
      <div>
        <i class="fas fa-bell text-success mb-3"></i>
        <h5>Notifications</h5>
        <p>Stay updated with service requests, payments, feedback, and admin messages.</p>
      </div>
      <a href="workshopnoti.php" class="btn btn-custom rounded-pill mt-2">View Notifications</a>
    </div>
  </div>

  <!-- Profile & Settings -->
  <div class="col-md-6 col-lg-4">
    <div class="dashboard-card text-center">
      <div>
        <i class="fas fa-user-cog text-success mb-3"></i>
        <h5>Profile & Settings</h5>
        <p>Update your workshop details, availability, and contact info.</p>
      </div>
      <a href="workshopowaccount.php" class="btn btn-custom rounded-pill mt-2">Edit Profile</a>
    </div>
  </div>
</div>


<!-- Monthly Revenue Line Chart Section -->
<div class="container py-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold" style="font-family: 'Montserrat', sans-serif; color: white;">
      <span class="text-info">Monthly</span> <span style="color: #ffffff;">Revenue Overview</span>
    </h2>
    <p style="color: white;">Earnings and commission breakdown for <?php echo date("F Y"); ?>.</p>
  </div>
  <canvas id="monthlyRevenueChart" height="120"></canvas>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Total Revenue', 'Your Revenue', 'Admin Commission'],
    datasets: [{
      label: 'Amount in ₹',
      data: [
        <?php echo $monthTotal; ?>,
        <?php echo $monthNet; ?>,
        <?php echo $monthCommission; ?>
      ],
      borderColor: '#11a7bb',
      backgroundColor: 'rgba(17, 167, 187, 0.2)',
      tension: 0.3,
      fill: true,
      pointBackgroundColor: ['#11a7bb', '#ffffff', '#ff4c4c'],
      pointRadius: 6
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        display: false,
        labels: {
          color: '#ffffff'
        }
      },
      title: {
        display: true,
        text: 'Workshop Revenue – <?php echo date("F Y"); ?>',
        font: { size: 18 },
        color: '#ffffff'
      },
      tooltip: {
        bodyColor: '#ffffff',
        titleColor: '#ffffff',
        backgroundColor: '#333333'
      }
    },
    scales: {
      x: {
        ticks: {
          color: '#ffffff'
        },
        grid: {
          color: 'rgba(255,255,255,0.1)'
        }
      },
      y: {
        beginAtZero: true,
        ticks: {
          color: '#ffffff',
          callback: value => '₹' + value
        },
        grid: {
          color: 'rgba(255,255,255,0.1)'
        }
      }
    }
  }
});
</script>




<!-- About Section -->
<div class="container-fluid py-5 ">
  <div class="container">
    <div class="text-center mb-4">
      <h1 class="fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 2.5rem;">
        <span class="text-danger"></span> <span style="color: #ffffffff;">About Your Role</span>
      </h1>
      <p class="text-white">Your dashboard is more than a tool — it's your workshop's digital command center.</p>
    </div>
    <div class="row g-4 align-items-center">
      <div class="col-lg-5 text-center">
        <img src="whb\img\about-img.JPG" class="img-fluid rounded shadow" alt="Workshop Owner Role">
      </div>
      <div class="col-lg-7">
        <div class=" p-4 rounded shadow-sm">
          <h4 class="text-danger fw-bold mb-3">Your Mission</h4>
          <p>
            You are the first responder in a moment of need. Your mission is to deliver fast, reliable, and professional roadside assistance to users who trust your expertise. Whether it's a breakdown, a flat tire, or a service request, your workshop is the lifeline that gets vehicles back on the road.
          </p>

          <h4 class="text-danger fw-bold mt-4 mb-3">Your Role</h4>
          <p>
            As a workshop owner, you manage incoming service requests, accept or reject complaints, and coordinate real-time support. Your dashboard gives you control over your availability, service types, earnings, and customer feedback. Every action you take shapes the user experience and builds trust in your brand.
          </p>

          <h4 class="text-danger fw-bold mt-4 mb-3">Your Tools</h4>
          <p>
            You have access to a powerful set of features: QR code uploads, earnings summaries, service history, notifications, and downloadable invoices. These tools help you stay organized, respond quickly, and maintain a professional presence. You can also update your profile, manage service types, and track pending payments — all from one place.
          </p>

          <h4 class="text-danger fw-bold mt-4 mb-3">Your Impact</h4>
          <p>
            Every request you accept is a promise kept. Every service you complete is a step toward building a reputation for excellence. Your workshop is not just a business — it's a trusted partner in roadside recovery. With each interaction, you're helping users feel safe, supported, and satisfied.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="wshb/lib/wow/wow.min.js"></script>
<script src="wshb/lib/easing/easing.min.js"></script>
<script src="wshb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="wshb/js/main.js"></script>
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
