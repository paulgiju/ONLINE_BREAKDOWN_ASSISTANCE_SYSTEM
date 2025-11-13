<?php
session_start();
include "connection.php";
include "headeruser.php";

if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'U') {
  header("Location: login2.php");
  exit();
}

$uid = $_SESSION['id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search !== '') {
  $invoices = mysqli_query($conn, "
    SELECT b.reqno, b.wid, b.amtpaid, b.payment_mode, b.reqdate, w.upi_id 
    FROM booking b 
    JOIN workshop w ON b.wid = w.ownerid 
    WHERE b.uid='$uid' AND b.amtpaid IS NOT NULL AND b.reqno LIKE '%$search%' 
    ORDER BY b.reqno DESC
  ");
} else {
  $invoices = mysqli_query($conn, "
    SELECT b.reqno, b.wid, b.amtpaid, b.payment_mode, b.reqdate, w.upi_id 
    FROM booking b 
    JOIN workshop w ON b.wid = w.ownerid 
    WHERE b.uid='$uid' AND b.amtpaid IS NOT NULL 
    ORDER BY b.reqno DESC
  ");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Invoices | Online Breakdown Assistance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

  <style>
    body {
      background: linear-gradient(to bottom right, #120170ff, #000000, #530404ff);
      font-family: 'Lato', sans-serif;
      color: white;
    }

    .card-box {
      background: #000000ff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(243, 16, 16, 1);
    }

     .card-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(35, 57, 255, 1);
}


    .table-hover tbody tr:hover {
      background-color: rgba(0, 0, 0, 1);
    }

    .btn-custom {
      background-color: #bd0d0d;
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 0.4rem 1rem;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-custom:hover {
      background-color: #000000ff;
      transform: scale(1.05);
    }

    .floating-back {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
    }

    
  </style>
</head>
<body>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-4">
      <h2 class="text-white fw-bold" style="font-family: 'Montserrat', sans-serif;">Your <span class="text-success">Invoices</span></h2>
      <p class="section-description d-inline-block mt-2 text-white">Review your payment history and download service billing details.</p>
    </div>

    <?php if (mysqli_num_rows($invoices) > 0): ?>
      <div class="table-responsive">

      <div class="d-flex justify-content-end mb-4">
  <form method="GET" class="d-flex">
    <input type="text" name="search" class="form-control me-2" placeholder="Search Request No" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit" class="btn btn-custom">Search</button>
  </form>
</div>

        <table class="table table-bordered table-striped table-hover text-white align-middle">
          <thead class="table-success text-dark">
            <tr>
              <th>Request No</th>
              <th>Workshop ID</th>
              <th>Amount Paid</th>
              <th>Payment Mode</th>
              <th>UPI ID</th>
              <th>Date</th>
              <th>Download</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_array($invoices)): ?>
              <tr>
                <td><?php echo $row['reqno']; ?></td>
                <td><?php echo $row['wid']; ?></td>
                <td>₹<?php echo $row['amtpaid']; ?></td>
                <td><?php echo $row['payment_mode']; ?></td>
                <td><?php echo ($row['payment_mode'] === 'UPI') ? $row['upi_id'] : '—'; ?></td>
                <td><?php echo $row['reqdate']; ?></td>
                <td>
                  <a href="generatepdf.php?reqno=<?php echo $row['reqno']; ?>" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-download"></i> PDF
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center text-dark">No invoices found yet.</div>
    <?php endif; ?>
  </div>
</div>

<!-- Floating Back Button -->
<div class="floating-back">
  <a href="userhpage.php" class="btn btn-danger rounded-circle shadow">
    <i class="fas fa-arrow-left"></i>
  </a>
</div>

<?php include 'footernew.php'; ?>
</body>
</html>
