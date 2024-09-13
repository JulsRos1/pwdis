<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PWDIS</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="css/modern-business.css" rel="stylesheet">

  <!-- Custom styles -->
  <style>
    /* Container for images */
    .image-container {
      width: 100%;
      height: 450px;
      /* Fixed height */
      overflow: hidden;
      /* Ensures image does not overflow container */
      position: relative;
    }

    .image-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;/
    }

    .card {
      border: none;
      transition: transform 0.3s, box-shadow 0.3s;
      margin-bottom: 20px;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-read-more {
      background-color: #007bff;
      border: none;
      color: white;
      transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btn-read-more:hover {
      background-color: #0056b3;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .pagination .page-item .page-link {
      border-radius: 20px;
      transition: background-color 0.3s;
    }

    .pagination .page-item .page-link:hover {
      background-color: #007bff;
      color: white;
    }

    .fade-in {
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .fade-in.show {
      opacity: 1;
    }

    .card-container {
      max-width: 700px;
      margin: 0 auto;
    }

    .card-body p {
      font-size: 12px
    }

    .card-footer {
      font-size: 12px
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <?php include('includes/header.php');
  include('includes/config.php');
  ?>

  <!-- Page Content -->
  <div class="container mt-5 pt-3">
    <div id="loading-overlay">
      <div id="loading-spinner"></div>
    </div>

    <div class="row" style="margin-top: 4%">
      <!-- Blog Entries Column -->
      <div class="col-md-8 card-container">
        <!-- Blog Post -->
        <?php
        if (isset($_GET['pageno'])) {
          $pageno = $_GET['pageno'];
        } else {
          $pageno = 1;
        }
        $no_of_records_per_page = 8;
        $offset = ($pageno - 1) * $no_of_records_per_page;

        $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
        $result = mysqli_query($con, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $query = mysqli_query($con, "SELECT tblposts.id as pid, tblposts.PostTitle as posttitle, tblposts.PostImage, tblcategory.CategoryName as category, tblcategory.id as cid, tblposts.PostingDate as postingdate FROM tblposts LEFT JOIN tblcategory ON tblcategory.id=tblposts.CategoryId WHERE tblposts.Is_Active=1 ORDER BY tblposts.id DESC LIMIT $offset, $no_of_records_per_page");
        while ($row = mysqli_fetch_array($query)) {
        ?>
          <div class="card mb-4">
            <div class="image-container">
              <img class="card-img-top fade-in" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
            </div>
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h5>
              <p><b>Category:</b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a></p>
              <a href="post-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="btn btn-primary btn-read-more">Read More &rarr;</a>
            </div>
            <div class="card-footer text-muted">
              Posted on <?php echo htmlentities($row['postingdate']); ?>
            </div>
          </div>
        <?php } ?>

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
          <li class="page-item <?php if ($pageno <= 1) echo 'disabled'; ?>">
            <a href="<?php if ($pageno > 1) echo "?pageno=" . ($pageno - 1); ?>" class="page-link">Prev</a>
          </li>
          <li class="page-item <?php if ($pageno >= $total_pages) echo 'disabled'; ?>">
            <a href="<?php if ($pageno < $total_pages) echo "?pageno=" . ($pageno + 1); ?>" class="page-link">Next</a>
          </li>
          <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
        </ul>
      </div>

      <!-- Sidebar Widgets Column -->
      <?php include('includes/sidebar.php'); ?>
    </div>
  </div>

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var elements = document.querySelectorAll('.fade-in');

      function checkScroll() {
        elements.forEach(function(element) {
          var elementPosition = element.getBoundingClientRect().top;
          var windowHeight = window.innerHeight;
          if (elementPosition < windowHeight * 0.75 && elementPosition > -element.clientHeight) {
            element.classList.add('show');
          }
        });
      }

      checkScroll();
      window.addEventListener('scroll', function() {
        checkScroll();
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      });
    });

    document.addEventListener("DOMContentLoaded", function() {
      var readMoreButtons = document.querySelectorAll('.btn-read-more');
      readMoreButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
          event.preventDefault();
          document.body.style.transition = 'opacity 0.5s ease';
          document.body.style.opacity = 0;
          setTimeout(function() {
            window.location.href = button.getAttribute('href');
          }, 1000);
        });
      });
    });
  </script>
</body>

</html>