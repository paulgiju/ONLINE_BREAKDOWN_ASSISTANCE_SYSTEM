<?php include 'connection.php'; ?>
<?php include 'headeradmin.php'; ?>
<?php
session_start();
?>
<?php
$data = mysqli_query($conn, "SELECT * FROM workshop ORDER BY rights = 'NW' DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Workshop Approval</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="awa/css/bootstrap.min.css" rel="stylesheet">
  <link href="awa/css/style.css" rel="stylesheet">
  <style>
    body {
  font-family: 'Montserrat', sans-serif;
  color: #ffffff;

  /* Static gradient background */
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
.main-heading .admin { color: #ffffffff; }   /* gold accent */
.main-heading .dashboard { color: #ffffffff; }

.section-title {
  font-size: 1.6rem;
  color: #ff0000ff;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30px;
}

.table-section {
  background-color: rgba(255,255,255,0.1);
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 12px rgba(255, 2, 2, 1);
  color: #ffffff;
}



.table th {
  background-color: #0d1b3d;
  color: white;
}
.table td {
  vertical-align: middle;
  color: #ffffff;
}

/* Floating Back Button */
.back-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #f5f5f4ff;
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
  background-color: #030303ff;
  color: #f5f4f8ff;
  transform: scale(1.05);
}

  </style>
</head>
<body>

<!-- Page Heading -->
<div class="container">
  <h1 class="main-heading"><span class="admin">Admin</span> <span class="dashboard">Workshop Approval</span></h1>
</div>

<!-- Workshop Table -->
<div class="container py-5">
  <h2 class="section-title">All Workshops (Pending & Registered)</h2>
  <div class="table-section">
    <div class="table-responsive">
      <table class="table table-bordered table-striped text-center">
        <thead>
          <tr>
            <th>Owner ID</th>
            <th>Workshop Name</th>
            <th>Type of Service</th>
            <th>Email</th>
            <th>Contact Person</th>
            <th>Workshop Number</th>
            <th>Location</th>
            <th>Photo</th>
            <th>Username</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($result = mysqli_fetch_array($data)) { ?>
          <tr>
            <td><?php echo $result['ownerid']; ?></td>
            <td><?php echo $result['wname']; ?></td>
            <td><?php echo $result['sname']; ?></td>
            <td><?php echo $result['email']; ?></td>
            <td><?php echo $result['cperson']; ?></td>
            <td><?php echo $result['wnumber']; ?></td>
            <td><?php echo $result['location']; ?></td>
            <td><img src="<?php echo $result['photo']; ?>" width="60" height="60" class="rounded-circle"></td>
            <td><?php echo $result['username']; ?></td>
            <td>
              <?php echo ($result['rights'] == 'NW') 
                ? '<span class="badge bg-warning">Pending</span>' 
                : '<span class="badge bg-success">Registered</span>'; ?>
            </td>
            <td>
              <?php if ($result['rights'] == 'NW') { ?>
              <div class="d-flex justify-content-center gap-2">
                <a href="adminWA.php?id=<?php echo $result['ownerid']; ?>" class="btn btn-success btn-sm">Accept</a>
                <a href="adminWR.php?id=<?php echo $result['ownerid']; ?>" class="btn btn-danger btn-sm">Reject</a>
              </div>
              <?php } else { echo '-'; } ?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

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

<!-- Scripts -->
<script src="awa/js/bootstrap.bundle.min.js"></script>
<script src="awa/js/main.js"></script>
<a href="adminpanel.php" class="back-btn">← Back</a>

</body>
</html>
