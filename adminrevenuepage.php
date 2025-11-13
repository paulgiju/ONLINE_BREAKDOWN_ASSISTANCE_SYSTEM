<?php include 'connection.php'; ?>
<?php include 'headeradmin.php'; ?>
<?php
session_start();
?>
<?php
// Monthly revenue
$monthly = array_fill(1, 12, 0);
$res1 = mysqli_query($conn, "SELECT MONTH(reqdate) AS m, SUM(amtpaid)*0.2 AS rev FROM booking WHERE status='Completed' GROUP BY MONTH(reqdate)");
while ($row = mysqli_fetch_assoc($res1)) {
  $monthly[(int)$row['m']] = round($row['rev']);
}
$labels = []; $data = [];
for ($i = 1; $i <= 12; $i++) {
  $labels[] = date("F", mktime(0,0,0,$i,10));
  $data[] = $monthly[$i];
}

// Workshop-wise revenue using wid
$wlabels = []; $wdata = [];
$res2 = mysqli_query($conn, "
  SELECT w.wname, SUM(b.amtpaid)*0.2 AS rev
  FROM booking b
  JOIN workshop w ON b.wid = w.ownerid
  WHERE b.status='Completed' AND w.rights='W'
  GROUP BY b.wid
");
while ($row = mysqli_fetch_assoc($res2)) {
  $wlabels[] = $row['wname'];
  $wdata[] = round($row['rev']);
}

// Summary
$res3 = mysqli_query($conn, "SELECT COUNT(*) AS total, SUM(amtpaid)*0.2 AS revenue FROM booking WHERE status='Completed'");
$summary = mysqli_fetch_assoc($res3);
$totalBookings = $summary['total'];
$totalRevenue = round($summary['revenue']);
$avgRevenue = $totalBookings ? round($totalRevenue / $totalBookings) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Revenue Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="arp/css/bootstrap.min.css" rel="stylesheet">
  <link href="arp/css/style.css" rel="stylesheet">
  <style>
  body {
  font-family: 'Montserrat', sans-serif;
  color: #ffffff;
  background: linear-gradient(to bottom right, #120170, #000000, #530404);
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-size: cover;
}

.main-heading {
  font-size: 2.8rem;
  font-weight: 900;
  text-align: center;
  margin-top: 40px;
  color: #ffffff;
}

.section-title {
  font-size: 1.6rem;
  color: #ffffff;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30px;
}

.card-box {
  background-color: rgba(255,255,255,0.1);
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 0 12px rgba(255, 0, 0, 1);
  text-align: center;
  color: #ffffff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 20px rgba(55, 0, 255, 1);
}

.card-box h4 {
  font-size: 1.2rem;
  color: #fffefeff;
}
.card-box p {
  font-size: 1.6rem;
  font-weight: bold;
  color: #ffffff;
}

.chart-box {
  background-color: rgba(255,255,255,0.1);
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 12px rgba(243, 0, 0, 1);
  color: #ffffff;
}

/* Floating Back Button */
.back-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #ffffff;
  color: #000000;
  border: none;
  border-radius: 50px;
  padding: 10px 20px;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  transition: background-color 0.3s ease, transform 0.2s ease;
  z-index: 999;
}
.back-btn:hover {
  background-color: #530404;
  color: #ffffff;
  transform: scale(1.05);
}


  </style>
</head>
<body>

<!-- Page Heading -->
<div class="container">
  <h1 class="main-heading"><span class="admin">Admin</span> <span class="dashboard">Revenue Dashboard</span></h1>
</div>

<!-- Summary Cards -->
<div class="container py-4">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card-box">
        <h4>Total Revenue</h4>
        <p>₹<?php echo $totalRevenue; ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-box">
        <h4>Total Bookings</h4>
        <p><?php echo $totalBookings; ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-box">
        <h4>Avg Revenue / Booking</h4>
        <p>₹<?php echo $avgRevenue; ?></p>
      </div>
    </div>
  </div>
</div>

<!-- Monthly Revenue Chart -->
<div class="container py-5">
  <h2 class="section-title">Monthly Revenue Overview</h2>
  <div class="chart-box">
    <canvas id="monthlyChart" height="120"></canvas>
  </div>
</div>

<!-- Workshop Revenue Chart -->
<div class="container pb-5">
  <h2 class="section-title">Workshop-wise Revenue</h2>
  <div class="chart-box">
    <canvas id="workshopChart" height="120"></canvas>
  </div>
</div>

<!-- Footer Top Bar -->
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

<!-- Floating Back Button -->
<a href="adminpanel.php" class="back-btn">← Back</a>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(monthlyCtx, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($labels); ?>,
    datasets: [{
      label: 'Monthly Revenue (₹)',
      data: <?php echo json_encode($data); ?>,
      borderColor: '#ffffff',
      backgroundColor: 'rgba(255,255,255,0.2)',
      fill: true,
      tension: 0.3,
      pointRadius: 4,
      pointBackgroundColor: '#ffffff'
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { labels: { color: '#ffffff' } },
      title: {
        display: true,
        text: 'Monthly Revenue Overview',
        color: '#ffffff',
        font: { size: 18 }
      }
    },
    scales: {
      x: { ticks: { color: '#ffffff' }, grid: { color: 'rgba(255,255,255,0.2)' } },
      y: { beginAtZero: true, ticks: { stepSize: 500, color: '#ffffff' }, grid: { color: 'rgba(255,255,255,0.2)' } }
    }
  }
});

const workshopCtx = document.getElementById('workshopChart').getContext('2d');
new Chart(workshopCtx, {
  type: 'bar',
  data: {
    labels: <?php echo json_encode($wlabels); ?>,
    datasets: [{
      label: 'Workshop Revenue (₹)',
      data: <?php echo json_encode($wdata); ?>,
      backgroundColor: 'rgba(255,255,255,0.7)',
      borderColor: '#ffffff',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { labels: { color: '#ffffff' } },
      title: {
        display: true,
        text: 'Workshop-wise Revenue',
        color: '#ffffff',
        font: { size: 18 }
      }
    },
    scales: {
      x: { ticks: { color: '#ffffff' }, grid: { color: 'rgba(255,255,255,0.2)' } },
      y: { beginAtZero: true, ticks: { stepSize: 500, color: '#ffffff' }, grid: { color: 'rgba(255,255,255,0.2)' } }
    }
  }
});
</script>

<!-- Scripts -->
<script src="arp/js/bootstrap.bundle.min.js"></script>
<script src="arp/js/main.js"></script>

</body>
</html>
