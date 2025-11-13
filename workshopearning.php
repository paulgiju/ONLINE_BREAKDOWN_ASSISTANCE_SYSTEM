<?php
session_start();
include "connection.php";
include "headerworkshop.php"; 

if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'W') {
  header("Location: login2.php");
  exit();
}

$wid = $_SESSION['id'];

// Filters
$monthFilter = $_GET['month'] ?? '';
$modeFilter = $_GET['payment_mode'] ?? '';

$where = "wid='$wid' AND amtpaid > 0";
if ($monthFilter) $where .= " AND DATE_FORMAT(reqdate, '%Y-%m') = '$monthFilter'";
if ($modeFilter) $where .= " AND payment_mode = '$modeFilter'";

// Total earnings
$totalQuery = mysqli_query($conn, "SELECT SUM(amtpaid) AS total FROM booking WHERE $where");
$total = mysqli_fetch_assoc($totalQuery)['total'] ?? 0;

// Completed services
$completedQuery = mysqli_query($conn, "SELECT COUNT(*) AS count 
                                       FROM booking 
                                       WHERE wid='$wid' 
                                       AND status IN ('Accepted','Completed')");
$completed = mysqli_fetch_assoc($completedQuery)['count'] ?? 0;

// Payment mode breakdown
$modeQuery = mysqli_query($conn, "
  SELECT payment_mode, COUNT(*) AS count, SUM(amtpaid) AS amount 
  FROM booking 
  WHERE $where 
  GROUP BY payment_mode
");

$modeData = [];
while ($row = mysqli_fetch_assoc($modeQuery)) {
  $modeData[] = $row;
}

$monthlyLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
$monthlyAmounts = array_fill(0, 12, 0);

$monthlyQuery = mysqli_query($conn, "
  SELECT MONTH(reqdate) AS month, SUM(amtpaid) AS amount 
  FROM booking 
  WHERE wid='$wid' AND amtpaid > 0 AND YEAR(reqdate) = YEAR(CURDATE()) 
  GROUP BY month
");

while ($row = mysqli_fetch_assoc($monthlyQuery)) {
  $index = $row['month'] - 1;
  $monthlyAmounts[$index] = round($row['amount']);
}

$adminCommission = array_map(fn($amt) => round($amt * 0.2), $monthlyAmounts);
$workshopRevenue = array_map(fn($amt) => round($amt * 0.8), $monthlyAmounts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Earnings Summary | Workshop Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="wesh/css/bootstrap.min.css" rel="stylesheet">
  <link href="wesh/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
      box-shadow: 0 4px 12px rgba(0, 174, 255, 1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(255, 0, 0, 1);
    }

    .btn-custom {
      background-color: #11a7bb;
      color: #fff;
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

    th, td {
      color: #ffffff;
    }

    .floating-back {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
    }

    /* Force all text inside cards, tables, and charts to white */
.card-box,
.bg-white,
.rounded,
.shadow,
.table,
.table th,
.table td,
h1, h2, h3, h4, h5, h6,
p, span, label {
  color: #ffffff !important;
  background-color: transparent !important; /* remove white backgrounds */
}

/* Table headers */
.table thead {
  background-color: rgba(255,255,255,0.1) !important;
  color: #ffffff !important;
}

/* KPI cards */
.card-box i,
.card-box h5,
.card-box h3,
.card-box h4,
.card-box p {
  color: #ffffff !important;
}

/* Chart.js text */
.chartjs-render-monitor {
  color: #ffffff !important;
}

  </style>
</head>
<body>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-4">
      <h2 class="fw-bold" style="font-family: 'Montserrat', sans-serif; color: white;">
        Your <span style="color:#11a7bb;">Earnings Summary</span>
      </h2>
      <p class="text-white">Track your income, payment modes, and completed services.</p>
    </div>

    <!-- Filters -->
    <form method="GET" class="mb-4">
      <div class="row g-2">
        <div class="col-md-4">
          <input type="month" name="month" class="form-control" value="<?php echo $monthFilter; ?>">
        </div>
        <div class="col-md-4">
          <select name="payment_mode" class="form-select">
            <option value="">All Payment Modes</option>
            <option value="UPI" <?php if ($modeFilter == 'UPI') echo 'selected'; ?>>UPI</option>
            <option value="Cash" <?php if ($modeFilter == 'Cash') echo 'selected'; ?>>Cash</option>
          </select>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-custom w-100">Apply Filters</button>
        </div>
      </div>
    </form>

    <!-- KPI Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-6 col-lg-3">
        <div class="card-box text-center">
          <i class="fas fa-rupee-sign fa-2x text-info mb-2"></i>
          <h5>Total Earnings</h5>
          <h3 class="text-info">₹<?php echo number_format($total, 2); ?></h3>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card-box text-center">
          <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
          <h5>Completed Services</h5>
          <h3 class="text-success"><?php echo $completed; ?></h3>
        </div>
      </div>
      <?php foreach ($modeData as $m): ?>
        <div class="col-md-6 col-lg-3">
          <div class="card-box text-center">
            <i class="fas fa-wallet fa-2x text-warning mb-2"></i>
            <h5><?php echo strtoupper($m['payment_mode']); ?> Payments</h5>
            <p><?php echo $m['count']; ?> transactions</p>
            <h4>₹<?php echo number_format($m['amount'], 2); ?></h4>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Charts -->
    <div class="row g-4 mb-5">
      <div class="col-md-6">
        <div class="card-box">
          <h5 class="text-center mb-3">Payment Mode Breakdown</h5>
          <canvas id="paymentChart"></canvas>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card-box">
          <h5 class="text-center mb-3">Monthly Earnings</h5>
          <canvas id="monthlyChart"></canvas>
        </div>
      </div>
    </div>
    
    
    <!-- Monthly Table -->
    <div class="card-box">
      <h5 class="mb-3">Monthly Earnings Table</h5>
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>Month</th>
            <th>Amount Earned</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i = 0; $i < count($monthlyLabels); $i++): ?>
            <tr>
              <td><?php echo $monthlyLabels[$i]; ?></td>
              <td>₹<?php echo number_format($monthlyAmounts[$i], 2); ?></td>
            </tr>
          <?php endfor; ?>
        </tbody>
      </table>
    </div>

    <!-- Yearly Revenue Chart -->
    <div class="card-box mt-5">
      <h5 class="text-center
            <h5 class="text-center mb-3">Yearly Revenue Breakdown</h5>
      <canvas id="yearlyRevenueChart"></canvas>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
      <button onclick="window.location.href='workshophpage.php'" class="btn btn-custom">
        <i class="fas fa-arrow-left"></i> Back
      </button>
    </div>
  </div>
</div>

<!-- Floating Back Button -->
<div class="floating-back">
  <a href="workshophpage.php" class="btn btn-custom rounded-circle shadow">
    <i class="fas fa-arrow-left"></i>
  </a>
</div>

<script>
  // Payment Mode Pie Chart
  const paymentChart = new Chart(document.getElementById('paymentChart'), {
    type: 'pie',
    data: {
      labels: <?php echo json_encode(array_column($modeData, 'payment_mode')); ?>,
      datasets: [{
        data: <?php echo json_encode(array_column($modeData, 'amount')); ?>,
        backgroundColor: ['#11a7bb', '#ffc107', '#28a745']
      }]
    },
    options: {
      plugins: {
        legend: { labels: { color: '#ffffff' } }
      }
    }
  });

  // Monthly Earnings Bar Chart
  const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($monthlyLabels); ?>,
      datasets: [{
        label: 'Earnings (₹)',
        data: <?php echo json_encode($monthlyAmounts); ?>,
        backgroundColor: '#11a7bb'
      }]
    },
    options: {
      plugins: {
        legend: { labels: { color: '#ffffff' } }
      },
      scales: {
        x: { ticks: { color: '#ffffff' }, grid: { color: 'rgba(255,255,255,0.1)' } },
        y: { ticks: { color: '#ffffff' }, grid: { color: 'rgba(255,255,255,0.1)' }, beginAtZero: true }
      }
    }
  });

  // Yearly Revenue Line Chart
  const ctx = document.getElementById('yearlyRevenueChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($monthlyLabels); ?>,
      datasets: [
        {
          label: 'Total Revenue',
          data: <?php echo json_encode($monthlyAmounts); ?>,
          borderColor: '#ff00eaff',
          backgroundColor: 'rgba(17,167,187,0.2)',
          tension: 0.3,
          fill: false
        },
        {
          label: 'Admin Commission (20%)',
          data: <?php echo json_encode($adminCommission); ?>,
          borderColor: '#dc3545',
          backgroundColor: 'rgba(220,53,69,0.2)',
          tension: 0.3,
          fill: false
        },
        {
          label: 'Workshop Revenue (80%)',
          data: <?php echo json_encode($workshopRevenue); ?>,
          borderColor: '#09ff42ff',
          backgroundColor: 'rgba(40,167,69,0.2)',
          tension: 0.3,
          fill: false
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Yearly Revenue Breakdown',
          font: { size: 18 },
          color: '#ffffff'
        },
        legend: { labels: { color: '#ffffff' } }
      },
      scales: {
        x: { ticks: { color: '#ffffff' }, grid: { color: 'rgba(255,255,255,0.1)' } },
        y: {
          beginAtZero: true,
          ticks: { color: '#ffffff', callback: value => '₹' + value },
          grid: { color: 'rgba(255,255,255,0.1)' }
        }
      }
    }
  });
</script>

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
<script src="wesh/js/main.js"></script>
</body>
</html>
