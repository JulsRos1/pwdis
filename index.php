<?php
session_start();
include('includes/config.php');
if (!isset($_SESSION['user_login'])) {
  // Redirect the user to the login page if not logged in
  header("Location: user_login.php");
  exit;
}
?>

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
  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">



</head>

<body>

  <!-- Navigation -->
  <?php include('includes/header.php'); ?>

  <!-- Page Content -->
  <div class="container mt-5 pt-3">
    <div id="loading-overlay">
      <div id="loading-spinner"></div>
    </div>



    <div class="row" style="margin-top: 4%">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

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

        $counter = 0;
        $query = mysqli_query($con, "select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId  where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page");
        while ($row = mysqli_fetch_array($query)) {
          $counter++;
        ?>

          <div class="card mb-4">
            <img class="card-img-top fade-in" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>" style="max-width: 100%; height: auto; margin-top: 2em;">
            <div class="card-body">
              <h2 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h2>
              <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a> </p>

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
          <li class="<?php if ($pageno <= 1) {
                        echo 'disabled';
                      } ?> page-item">
            <a href="<?php if ($pageno <= 1) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno - 1);
                      } ?>" class="page-link">Prev</a>
          </li>
          <li class="<?php if ($pageno >= $total_pages) {
                        echo 'disabled';
                      } ?> page-item">
            <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno + 1);
                      } ?> " class="page-link">Next</a>
          </li>
          <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
        </ul>

      </div>

      <!-- Sidebar Widgets Column -->
      <?php include('includes/sidebar.php'); ?>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

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
          var isVisible = elementPosition < windowHeight * 0.75 && elementPosition > -element.clientHeight;

          if (isVisible) {
            element.classList.add('show');
          } else {
            element.classList.remove('show');
          }
        });
      }

      // Check for scroll position on page load
      checkScroll();

      // Add event listener for scroll
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
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var readMoreButtons = document.querySelectorAll('.btn-read-more');

      readMoreButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
          event.preventDefault();

          // Add a transition effect to the body
          document.body.style.transition = 'opacity 0.5s ease';

          // Fade out the body
          document.body.style.opacity = 0;

          // Redirect to the next PHP page after a delay (adjust as needed)
          setTimeout(function() {
            window.location.href = button.getAttribute('href');
          }, 1000);
        });
      });
    });
  </script>



</body>

</html>