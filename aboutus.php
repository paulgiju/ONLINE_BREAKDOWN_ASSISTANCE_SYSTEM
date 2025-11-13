<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>OBAS - About Us</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

  <!-- Icon Fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries -->
  <link href="abt/lib/animate/animate.min.css" rel="stylesheet">
  <link href="abt/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Bootstrap & Template Styles -->
  <link href="abt/css/bootstrap.min.css" rel="stylesheet">
  <link href="abt/css/style.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Montserrat', sans-serif;
      color: #ffffff;
      background: linear-gradient(135deg, #120170, #000000, #530404);
      background-size: 400% 400%;
      transition: background-position 0.2s ease;
    }

    /* Footer Section Cards */
    .footer .col-md-6.col-lg-3 {
      background: rgba(255,255,255,0.1);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(255, 255, 255, 1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .footer .col-md-6.col-lg-3:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(255,255,255,0.6);
    }

    .footer h4 {
      color: #ffffff;
      font-weight: 700;
    }

    .footer p, .footer a, .footer h6 {
      color: #dddddd;
    }

    .footer .form-control {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #ffffff;
    }

    .footer .form-control::placeholder {
      color: #f0f0f0;
    }

    .footer .btn-danger {
      background: linear-gradient(to right, #120170, #530404);
      border: none;
      font-weight: 600;
    }

    .footer .btn-danger:hover {
      background: linear-gradient(to right, #530404, #120170);
      box-shadow: 0 0 12px rgba(255,255,255,0.6);
    }

    .footer-bottom {
      background: #000000;
      padding: 10px 0;
      text-align: center;
      color: #ffffff;
    }
  </style>
</head>
<body>

<?php include 'headerhome.php'; ?>

<!-- Footer Section -->
<div class="container-fluid footer py-5">
  <div class="container">
    <div class="row g-5">
      <!-- About Us -->
      <div class="col-md-6 col-lg-3">
        <h4 class="mb-4">About Us</h4>
        <p class="mb-3">We provide fast, GPS-based breakdown assistance by connecting users to trusted workshops. Our system ensures safety, speed, and reliable support.</p>
        <div class="position-relative">
          <input class="form-control rounded-pill w-100 py-2 ps-4 pe-5" type="text" placeholder="Enter your email">
          <button type="button" class="btn btn-danger rounded-pill position-absolute top-0 end-0 py-1 mt-1 me-2">Subscribe</button>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-md-6 col-lg-3">
        <h4 class="mb-4">Quick Links</h4>
        <a href="#" class="d-block mb-2"><i class="fas fa-angle-right me-2"></i> About</a>
        <a href="#" class="d-block mb-2"><i class="fas fa-angle-right me-2"></i> Vehicle Types</a>
        <a href="#" class="d-block mb-2"><i class="fas fa-angle-right me-2"></i> Vehicle Services</a>
        <a href="#" class="d-block mb-2"><i class="fas fa-angle-right me-2"></i> Contact Us</a>
        <a href="#" class="d-block"><i class="fas fa-angle-right me-2"></i> Terms & Conditions</a>
      </div>

      <!-- Customer Care -->
      <div class="col-md-6 col-lg-3">
        <h4 class="mb-4">Customer Care</h4>
        <div class="mb-2">
          <h6 class="mb-0">Support Availability:</h6>
          <p class="mb-0">24/7 – We're here whenever you need assistance.</p>
        </div>
        <div class="mb-2">
          <h6 class="mb-0">Live Chat & Phone:</h6>
          <p class="mb-0">Always active, including weekends and holidays.</p>
        </div>
        <div>
          <h6 class="mb-0">Response Time:</h6>
          <p class="mb-0">Immediate for emergencies, within minutes for general queries.</p>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="col-md-6 col-lg-3">
        <h4 class="mb-4">Contact Info</h4>
        <p><i class="fa fa-map-marker-alt me-2"></i> Kottayam, Kerala, India</p>
        <p><i class="fa fa-envelope me-2"></i> vecheleassistance24@gmail.com</p>
        <p><i class="fa fa-phone me-2"></i> +91 9493876315</p>
        <p><i class="fa fa-phone me-2"></i> +012-345-6789</p>
        <div class="d-flex mt-3">
          <a class="btn btn-danger btn-sm-square rounded-circle me-2" href="#"><i class="fab fa-facebook-f text-white"></i></a>
          <a class="btn btn-danger btn-sm-square rounded-circle me-2" href="#"><i class="fab fa-twitter text-white"></i></a>
          <a class="btn btn-danger btn-sm-square rounded-circle me-2" href="#"><i class="fab fa-instagram text-white"></i></a>
          <a class="btn btn-danger btn-sm-square rounded-circle" href="#"><i class="fab fa-youtube text-white"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer Bottom -->
<div class="footer-bottom">
  <small>
    &copy; <?php echo date("Y"); ?> Online Breakdown Assistance System. All rights reserved.
  </small>
</div>

<!-- JS Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="abt/lib/wow/wow.min.js"></script>
<script src="abt/lib/easing/easing.min.js"></script>
<script src="abt/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="abt/js/main.js"></script>
<?php include 'footernew.php'; ?>
</body>
</html>
