<?php
session_start();
include "connection.php";
include "headeruser.php";

if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'U') {
  header("Location: ../login2.php");
  exit();
}

$uid = $_SESSION['id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search !== '') {
  $query = mysqli_query($conn, "
    SELECT reqno, wid, rating, review, reqdate 
    FROM booking 
    WHERE uid='$uid' AND rating IS NOT NULL AND reqno LIKE '%$search%' 
    ORDER BY reqdate DESC
  ");
} else {
  $query = mysqli_query($conn, "
    SELECT reqno, wid, rating, review, reqdate 
    FROM booking 
    WHERE uid='$uid' AND rating IS NOT NULL 
    ORDER BY reqdate DESC
  ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Ratings & Reviews | Online Breakdown Assistance</title>
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
      background: #1c1c1c;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(226, 20, 20, 1);
    }

     .card-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(35, 57, 255, 1);
}


    .table-hover tbody tr:hover {
      background-color: rgba(0, 0, 0, 0.88);
    }

    .floating-back {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
    }

    .star-rating {
      color: #ffc107;
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
      background-color: #a30000;
      transform: scale(1.05);
    }

    .table-dark-bg {
  background-color: #000000ff;
  color: white;
}

.table-dark-bg thead {
  background-color: #b41d1dff;
  color: white;
}

.table-dark-bg tbody tr:hover {
  background-color: rgba(255,255,255,0.05);
}

  </style>
</head>
<body>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-4">
      <h2 class="text-white fw-bold" style="font-family: 'Montserrat', sans-serif;">Your <span class="text-danger">Ratings & Reviews</span></h2>
      <p class="section-description d-inline-block mt-2 text-white">See what you've shared about your service experiences.</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
      <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search Request No" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-custom">Search</button>
      </form>
    </div>

    <?php if (mysqli_num_rows($query) > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover text-white align-middle">
          <thead class="table-dark">
            <tr>
              <th>Request No</th>
              <th>Workshop ID</th>
              <th>Rating</th>
              <th>Review</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_array($query)): ?>
              <tr>
                <td><?php echo $row['reqno']; ?></td>
                <td><?php echo $row['wid']; ?></td>
                <td class="star-rating">
                  <?php for ($i = 0; $i < $row['rating']; $i++): ?>
                    <i class="fas fa-star"></i>
                  <?php endfor; ?>
                  <span class="text-white ms-1">(<?php echo $row['rating']; ?>)</span>
                </td>
                <td><?php echo $row['review']; ?></td>
                <td><?php echo $row['reqdate']; ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center text-dark">You haven't submitted any reviews yet.</div>
    <?php endif; ?>
  </div>
</div>

<!-- Floating Back Button -->
<div class="floating-back">
  <a href="userhpage.php" class="btn btn-danger rounded-circle shadow">
    <i class="fas fa-arrow-left"></i>
  </a>
</div>

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
