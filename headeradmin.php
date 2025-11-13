<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="ha/css/bootstrap.min.css" rel="stylesheet">
  <link href="ha/css/style.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
    }
    .navbar {
      background-color: #0d1b3d;
    }
    .navbar-brand {
      font-weight: 900;
      font-size: 1.6rem;
      color: #dc3545 !important;
    }
    .nav-link {
      color: #fff !important;
      font-weight: 500;
      margin-right: 15px;
    }
    .nav-link:hover {
      color: #ffc107 !important;
    }
    .logout-btn {
      color: #fff;
      font-weight: bold;
      background-color: #dc3545;
      border: none;
      padding: 6px 12px;
      border-radius: 5px;
      text-decoration: none;
    }
    .logout-btn:hover {
      background-color: #c82333;
      color: #fff;
    }
  </style>
</head>
<body>

<!-- Admin Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand me-5" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="adminNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3">
        <li class="nav-item"><a class="nav-link" href="adminpanel.php"><i class="fas fa-user-circle"></i> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="adminworkshopapproval.php"><i class="fas fa-check-circle"></i> Workshop Approval</a></li>
        <li class="nav-item"><a class="nav-link" href="adminauthorizedwork.php"><i class="fas fa-tools"></i> Authorized Workshops</a></li>
        <li class="nav-item"><a class="nav-link" href="adminrevenuepage.php"><i class="fas fa-chart-line"></i> Total Revenue</a></li>
        <li class="nav-item"><a class="nav-link" href="adminourcust.php"><i class="fas fa-users"></i> Our Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="adminservicehistory.php"><i class="fas fa-history"></i> Service History</a></li>
        <li class="nav-item"><a class="nav-link" href="adminprofile.php"><i class="fas fa-user-circle"></i> Admin Profile</a></li>
      </ul>
      <a href="logout.php" class="logout-btn ms-3"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
</nav>

<!-- Page content starts below -->
