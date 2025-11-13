<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>OBAS - Contact & Reviews</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

  <!-- Icon Fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries -->
  <link href="cb/lib/animate/animate.min.css" rel="stylesheet">
  <link href="cb/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Bootstrap & Template Styles -->
  <link href="cb/css/bootstrap.min.css" rel="stylesheet">
  <link href="cb/css/style.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      color: #ffffff;
      background: linear-gradient(135deg, #120170, #000000, #530404);
      background-size: 400% 400%;
      transition: background-position 0.2s ease;
    }

    /* Card Styling */
    .team .p-4, .testimonial .p-3, .blog .p-4 {
      background: rgba(255,255,255,0.1) !important;
      color: #ffffff;
      box-shadow: 0 0 12px rgba(255, 3, 3, 1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .team .p-4:hover, .testimonial .p-3:hover, .blog .p-4:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(252, 252, 252, 1);
    }

    .team h5, .testimonial h6, .blog h5 {
      color: #ffffff;
      font-weight: 600;
    }
    .team p, .testimonial p, .blog p {
      color: #ddd;
    }

    .btn-danger {
      background: linear-gradient(to right, #120170, #530404);
      border: none;
      font-weight: 600;
    }
    .btn-danger:hover {
      background: linear-gradient(to right, #530404, #120170);
      box-shadow: 0 0 12px rgba(255,255,255,0.6);
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
    /* Uniform image styling for team section */
.team .img-fluid {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 10px;
  transition: transform 0.3s ease;
}

.team .p-4:hover .img-fluid {
  transform: scale(1.03);
}

  </style>
</head>
<body>

<?php include 'headerhome.php'; ?>

<!-- Customer Support Center -->
<div class="container-fluid team py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="display-5"> <span class="text-white">Customer Support Center</span></h1>
      <p>Customer Support Center offers 24/7 help, live assistance, issue resolution, service tracking, and guidance for smooth roadside support experience.</p>
    </div>
    <div class="row g-4">
      <!-- Team Member 1 -->
      <div class="col-md-6 col-lg-3">
        <div class="text-center p-4 rounded">
          <img src="cb/img/testimonial-3.JPG" class="img-fluid mb-3" alt="Team Member">
          <h5>John Joe</h5>
          <p>Technical Support Representative</p>
        </div>
      </div>
      <!-- Team Member 2 -->
      <div class="col-md-6 col-lg-3">
        <div class="text-center p-4 rounded">
          <img src="cb/img/attachment-img.JPG" class="img-fluid mb-3" alt="Team Member">
          <h5>James Thomas</h5>
          <p>Customer Advisor</p>
        </div>
      </div>
      <!-- Team Member 3 -->
      <div class="col-md-6 col-lg-3">
        <div class="text-center p-4 rounded">
            <img src="opt3b/img/team-2.JPG" class="img-fluid mb-3" alt="Team Member">
            <h5>Richard Helen</h5>
          <p>Technical Lead</p>
        </div>
      </div>
      <!-- Team Member 4 -->
      <div class="col-md-6 col-lg-3">
        <div class="text-center p-4 rounded">
          <img src="opt3b/img/team-3.JPG" class="img-fluid mb-3" alt="Team Member">
          <h5>Peter Fren </h5>
          <p>Operations Manager</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Our Clients Reviews -->
<div class="container-fluid testimonial py-4">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold"> <span class="text-white">Our Clients Reviews</span></h2>
      <p class="small">Learn more about our brand, services and strategies.</p>
    </div>
    <div class="row g-3 justify-content-center">
      <!-- Review 1 -->
      <div class="col-md-6 col-lg-5">
        <div class="p-3 rounded text-center">
          <img src="cb/img/testimonial-1.jpg" class="rounded-circle mb-2" style="width: 70px; height: 70px;" alt="Emily Carter">
          <h6 class="mb-1">Emily Carter</h6>
          <small class="text-muted">Travel Blogger</small>
          <p class="small mb-0">The overall program was excellent and the service was superb. Highly recommended.</p>
        </div>
      </div>
      <!-- Review 2 -->
      <div class="col-md-6 col-lg-5">
        <div class="p-3 rounded text-center">
          <img src="cb/img/testimonial-2.jpg" class="rounded-circle mb-2" style="width: 70px; height: 70px;" alt="James Patel">
          <h6 class="mb-1">James Patel</h6>
          <small class="text-muted">Business Consultant</small>
          <p class="small mb-0">Great customer service and excellent results. I will continue to work with this team.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Blog & Letters -->
<div class="container-fluid blog py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="display-5"><span class="text-white">Blog & Letters</span></h1>
      <p>Explore expert advice, vehicle safety tips, and the future of roadside assistance.</p>
    </div>
    <div class="row g-4">
      <!-- Blog 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded">
          <img src="cb/img/blog-1.jpg" class="img-fluid rounded mb-3" alt="Blog">
          <h5>Breakdown Help: How to Check Driving Fitness?</h5>
          <p>Learn key steps to assess your vehicle’s condition before travel.</p>
          <a href="#" class="btn btn-danger rounded-pill">Read More</a>
        </div>
      </div>
      <!-- Blog 2 -->
      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded">
          <img src="cb/img/blog-2.jpg" class="img-fluid rounded mb-3" alt="Blog">
          <h5>Top 5 Cars for Weekend Getaways</h5>
          <p>Discover reliable models ideal for long drives, comfort, and fuel efficiency.</p>
          <a href="#" class="btn btn-danger rounded-pill">Read More</a>
        </div>
      </div>
           <!-- Blog 3 -->
      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded">
          <img src="cb/img/blog-3.jpg" class="img-fluid rounded mb-3" alt="Blog">
          <h5>Why Online Assistance Is the Future</h5>
          <p>See how digital platforms are transforming roadside support with faster response, verified workshops, and GPS tracking.</p>
          <a href="#" class="btn btn-danger rounded-pill">Read More</a>
        </div>
      </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="cb/lib/wow/wow.min.js"></script>
<script src="cb/lib/easing/easing.min.js"></script>
<script src="cb/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="cb/js/main.js"></script>

</body>
</html>
