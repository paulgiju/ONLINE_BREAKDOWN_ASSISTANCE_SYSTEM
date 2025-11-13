<?php
session_start();
include "connection.php";

if (!isset($_SESSION['id']) || $_SESSION['rights'] !== 'U') {
  header("Location: login2.php");
  exit();
}

$uid = $_SESSION['id'];
$username = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM user WHERE user_id='$uid'"))['name'];

$search = isset($_GET['search']) ? $_GET['search'] : '';
$notesQuery = "
  SELECT message, created_at 
  FROM notifications 
  WHERE uid='$uid'
";
if ($search !== '') {
  $notesQuery .= " AND message LIKE '%$search%'";
}
$notesQuery .= " ORDER BY created_at DESC";

$notes = mysqli_query($conn, $notesQuery);

$notifications = [];
while ($note = mysqli_fetch_assoc($notes)) {
  $notifications[] = [
    'type' => 'auto',
    'message' => $note['message'],
    'time' => $note['created_at']
  ];
}

$notifications[] = [
  'type' => 'welcome',
  'message' => "Welcome $username! Your account has been successfully created.",
  'time' => '0000-00-00 00:00:00'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notifications | Online Breakdown Assistance</title>
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
      box-shadow: 0 4px 12px rgba(231, 7, 7, 1);
    }

    .list-group-item {
      background-color: #fff8f8ff;
      color: white;
      border: none;
      border-bottom: 1px solid rgba(38, 209, 172, 1);
    }

    .list-group-item:hover {
      background-color: rgba(239, 238, 241, 1);
    }

    .floating-back {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
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
      background-color: #da1212ff;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<?php include 'headeruser.php'; ?>

<div class="container-fluid pt-5 px-4">
  <div class="card-box">
    <div class="text-center mb-4">
      <h2 class="text-white fw-bold" style="font-family: 'Montserrat', sans-serif;">
        <span class="text-danger">Your</span> <span class="text-white">Notifications</span>
      </h2>
      <p class="section-description d-inline-block mt-2 text-white">Stay updated on your service requests, payments, and progress.</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
      <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search message..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-custom">Search</button>
      </form>
    </div>

    <?php if (count($notifications) > 0): ?>
      <ul class="list-group">
        <?php foreach ($notifications as $n): ?>
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
              <div class="fw-bold">
                <?php
                  if ($n['type'] === 'welcome') {
                    echo '<i class="fas fa-smile text-success me-2"></i> Welcome';
                  } else {
                    echo '<i class="fas fa-bell text-primary me-2"></i> Notification';
                  }
                ?>
              </div>
              <?php echo $n['message']; ?>
            </div>
            <span class="badge bg-secondary rounded-pill">
              <?php echo ($n['time'] !== '0000-00-00 00:00:00') ? date("d M Y, h:i A", strtotime($n['time'])) : ''; ?>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <div class="alert alert-info text-center text-dark">No notifications yet.</div>
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
