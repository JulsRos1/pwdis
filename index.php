<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>PWDIS</title>

  <!-- CSS FILES -->
  <link href="landingstyles/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="landingstyles/landing.css" rel="stylesheet" />
  <link rel="manifest" href="manifest.json">
  <!--

TemplateMo 581 Kind Heart Charity

https://templatemo.com/tm-581-kind-heart-charity

-->
</head>

<body id="section_1">
  <nav class="navbar navbar-expand-lg bg-light shadow-lg">
    <div class="container">
      <div class="logo">
        <a href="index.php">
          <img src="landingimages/pwdislogo.png" alt="pwdislogo">
        </a>
      </div>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link click-scroll" href="#top">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_3">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link click-scroll" href="usermanual.php" target="_blank">Installation Guide</a>
          </li>
          <li class="nav-item ms-3">
            <a
              class="nav-link custom-btn custom-border-btn btn"
              href="user_login.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <section class="hero-section hero-section-full-height">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-12 p-0">
            <div id="hero-slide" class="carousel carousel-fade slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <!-- First Carousel Item -->
                <div class="carousel-item active">
                  <img src="landingimages/PWD.jpg" class="carousel-image img-fluid" alt="..." />
                  <!-- Dark Overlay and Text Content -->
                  <div class="carousel-overlay">
                    <div class="carousel-content text-center">
                      <h2 class="carousel-title">Empowering People with Disabilities</h2>
                      <p class="carousel-text">Join us in creating a more inclusive world. Access inclusive information and resources, map accessibility, and connect with the community.</p>
                      <a href="user_register.php" class="btn btn-primary carousel-cta">Join Us!</a>
                    </div>
                  </div>
                </div>

                <!-- Second Carousel Item -->
                <div class="carousel-item">
                  <img src="landingimages/pwdbg.jpg" class="carousel-image img-fluid" alt="..." />
                  <!-- Dark Overlay and Text Content -->
                  <div class="carousel-overlay">
                    <div class="carousel-content text-center">
                      <h2 class="carousel-title">Together, We Break Barriers</h2>
                      <p class="carousel-text">Your support makes a difference. Help us promote accessibility and foster community inclusion.</p>
                      <a href="user_register.php" class="btn btn-primary carousel-cta">Join Us!</a>
                    </div>
                  </div>
                </div>
              </div>

              <button class="carousel-control-prev" type="button" data-bs-target="#hero-slide" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>

              <button class="carousel-control-next" type="button" data-bs-target="#hero-slide" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>


    <section class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 col-12 text-center mx-auto">
            <h2 class="mb-5">Welcome to PWDIS</h2>
          </div>

          <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 text-center">
            <div class="featured-block d-flex justify-content-center align-items-center">
              <a href="donate.html" class="d-block">
                <img src="landingimages/map-location.png" class="featured-block-image img-fluid" alt="" />
                <p class="featured-block-text"> <strong>Mapping Accessibility</strong></p>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 text-center">
            <div class="featured-block d-flex justify-content-center align-items-center">
              <a href="donate.html" class="d-block">
                <img src="landingimages/working.png" class="featured-block-image img-fluid" alt="" />
                <p class="featured-block-text"><strong>Information and Resources</strong></p>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 text-center">
            <div class="featured-block d-flex justify-content-center align-items-center">
              <a href="donate.html" class="d-block">
                <img src="landingimages/partners.png" class="featured-block-image img-fluid" alt="" />
                <p class="featured-block-text"><strong>Community</strong></p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>



    <section class="section-padding" id="section_3">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-12 text-center mb-4">
            <h2>What we provide</h2>
          </div>
          <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
            <div class="custom-block-wrap">
              <img
                src="landingimages/needaccess.jpg"
                class="custom-block-image img-fluid"
                alt="" />

              <div class="custom-block">
                <div class="custom-block-body">
                  <h5 class="mb-3">Mapping Accessibility</h5>

                  <p class="text-justify" style="text-align: justify;">
                    Mapping accessibility is crucial for empowering individuals with disabilities by providing them with the necessary information to navigate spaces confidently.
                    Our system enables users to document and share accessibility features of various locations, such as wheelchair-accessible entrances, parking areas, restrooms,
                    and seating options. Users can contribute by rating and reviewing these features, helping others make informed decisions about accessibility. This collaborative
                    effort not only enriches the map with up-to-date information but also fosters a community of awareness and support for accessibility.
                  </p>


                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
            <div class="custom-block-wrap">
              <img
                src="landingimages/info.jpg"
                class="custom-block-image img-fluid"
                alt="" />

              <div class="custom-block">
                <div class="custom-block-body">
                  <h5 class="mb-3">Information and Resources</h5>

                  <p class="text-justify" style="text-align: justify;">
                    Access to inclusive information and resources is vital for individuals with disabilities to fully engage in their community. Our system aims to centralize essential
                    resources such as programs for persons with disabilities (PWD), events, assistance services, disability rights materials, and emergency support hotlines, and more.
                    By providing a comprehensive repository of information, we empower users to easily find the help they need, stay informed about their rights, and connect with resources
                    that promote independence and inclusion.
                  </p>

                </div>

              </div>
            </div>
          </div>



          <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
            <div class="custom-block-wrap">
              <img
                src="landingimages/community.jpg"
                class="custom-block-image img-fluid"
                alt="" />

              <div class="custom-block">
                <div class="custom-block-body">
                  <h5 class="mb-3">Community</h5>

                  <p>
                    Our system brings a platform for real-time communication among individuals with disabilities. Users can engage in private conversations or participate in community forum,
                    fostering a supportive environment where they can exchange experiences, advice, and information. This interaction not only builds connections but also creates a sense of belonging, empowering
                    users to share challenges, celebrate successes, and collaborate on solutions. By strengthening community ties, we promote collective advocacy and enhance the overall quality of life for individuals
                    with disabilities.
                  </p>


                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <?php include("includes/footer.php"); ?>

    </footer>
    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
          navigator.serviceWorker.register('service-worker.js').then((registration) => {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
          }).catch((error) => {
            console.log('ServiceWorker registration failed: ', error);
          });
        });
      }
    </script>

    <!-- JAVASCRIPT FILES -->
    <script src="landingjs/jquery.min.js"></script>
    <script src="landingjs/bootstrap.min.js"></script>
    <script src="landingjs/jquery.sticky.js"></script>
    <script src="landingjs/click-scroll.js"></script>
    <script src="landingjs/counter.js"></script>
    <script src="landingjs/custom.js"></script>
</body>

</html>