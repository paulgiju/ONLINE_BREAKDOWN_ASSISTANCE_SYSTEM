<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Online Breakdown Assistance System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

  <!-- Bootstrap & Custom Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="hb/css/style.css" rel="stylesheet">
  <?php include 'headerhome.php'; ?>

  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Montserrat', sans-serif;
      color: #ffffff;
      background: linear-gradient(135deg, #fefeffff, #000000, #a10303ff);
      background-size: 400% 400%;
      transition: background-position 6.0s ease;
    }

    /* Hero Section */
    .hero-section {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    .hero-section video {
      position: absolute;
      top: 50%;
      left: 50%;
      min-width: 100%;
      min-height: 100%;
      width: auto;
      height: auto;
      z-index: 0;
      transform: translate(-50%, -50%);
      object-fit: cover;
    }

    .hero-overlay {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      color: #fff;
      padding: 20px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .hero-content h1 {
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #ffffff;
    }

    .hero-content h2 {
      font-size: 3.5rem;
      font-weight: 900;
      color: #fcfbf9ff;
      margin-bottom: 20px;
    }

    .hero-content p {
      font-size: 1.2rem;
      margin: 5px 0;
    }

    /* Scroll Icon */
    .scroll-icon-img {
      width: 40px;
      transition: transform 0.3s ease;
    }
    .scroll-icon-img:hover {
      transform: scale(1.2);
    }

    /* Testimonials */
    .testimonial-section {
      background-color: rgba(255,255,255,0.05);
      padding: 60px 0;
    }

    .testimonial-section h2 {
      font-weight: 700;
      margin-bottom: 20px;
      color: #ffffff;
    }

    .testimonial-section .card {
      border: none;
      background-color: rgba(255,255,255,0.1);
      box-shadow: 0 0 12px rgba(247, 7, 7, 1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: #ffffff;
    }

    .testimonial-section .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 25px rgba(0, 17, 255, 1); /* golden glow */
    }

    .testimonial-section .card img {
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }

    .testimonial-section .card-title {
      font-weight: 600;
      color: #fdfdfbff;
    }

    .testimonial-section .card-text {
      font-size: 0.95rem;
      color: #ffffff;
    }

    /* Footer */
    .footer-top {
      background: linear-gradient(to right, #120170, #000000, #530404);
      padding: 15px 0;
      color: #ffffff;
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

<!-- Hero Section -->
<div class="hero-section">
  <video autoplay muted loop playsinline>
    <source src="homepagebg.MP4" type="video/mp4">
    Your browser does not support the video tag.
  </video>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1>Welcome to</h1>
    <h2>Online Breakdown Assistance System</h2>
    <p>Helping you find nearby workshops exactly when you need help the most</p>
    <p>Locate | Request | Get Assist</p>

    <!-- Scroll Icon -->
    <div class="scroll-icon-inline">
      <a href="#testimonials">
        <img src="hb/img/scroll-icon.png" alt="Scroll Down" class="scroll-icon-img">
      </a>
    </div>
  </div>
</div>

<!-- Reviews & Testimonials Section -->
<div id="testimonials" class="testimonial-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Reviews & Testimonials</h2>
      <p class="lead">Real feedback from users who've experienced our roadside assistance.</p>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      $testimonials = [
        ["img" => "hb/img/big_portfolio_item_1.png", "name" => "Charlotte", "surname" => "Davies", "text" => "Used during a family trip. Excellent experience and very reliable."],
        ["img" => "hb/img/big_portfolio_item_2.jpg", "name" => "Amelia", "surname" => "Watson", "text" => "Quick, efficient and friendly service. Absolutely lifesaver on the motorway!"],
        ["img" => "hb/img/big_portfolio_item_3.jpg", "name" => "George", "surname" => "Turner", "text" => "Quick response, highly prepared for roadside assistance."],
        ["img" => "hb/img/big_portfolio_item_4.jpg", "name" => "Rita", "surname" => "Reynolds", "text" => "Impressive service! Honest work with workmanship and great attention to detail."],
        ["img" => "hb/img/big_portfolio_item_5.png", "name" => "Anonymous", "surname" => "", "text" => "Excellent experience so far — the nearest workshop reached within 20 minutes."],
        ["img" => "hb/img/big_portfolio_item_6.webp", "name" => "Isla", "surname" => "Reynolds", "text" => "Simple to use — it connected me with a mechanic nearby within minutes."]
      ];

      foreach ($testimonials as $t) {
        echo '<div class="col">
                <div class="card h-100 text-center">
                  <img src="' . $t["img"] . '" class="card-img-top img-fluid rounded" alt="' . $t["name"] . ' ' . $t["surname"] . '">
                  <div class="card-body">
                    <h5 class="card-title">' . $t["name"] . ' <em>' . $t["surname"] . '</em></h5>
                    <p class="card-text">“' . $t["text"] . '”</p>
                  </div>
                </div>
              </div>';
      }
      ?>
    </div>
  </div>
</div>

<!-- Footer Top Bar -->
<div class="footer-top">
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
<div class="footer-bottom">
  <small>
    &copy; <?php echo date("Y"); ?> Online Breakdown Assistance System. All rights reserved.
  </small>
</div>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="hb/js/main.js"></script>

<!-- Cursor-based gradient animation -->
<script>
document.addEventListener("mousemove", function(e) {
  let x = e.clientX / window.innerWidth;
  let y = e.clientY / window.innerHeight;
  document.body.style.backgroundPosition = `${x * 100}% ${y * 100}%`;
});
</script>

</body>
</html>
