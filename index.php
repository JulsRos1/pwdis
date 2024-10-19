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
  <meta name="author" content="">
  <title>PWDIS</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/sidebar.css">
</head>

<body>
  <!-- Sidebar -->
  <?php include("includes/sidebar.php"); ?>
  <!-- Page Content -->
  <div id="main">
    <button class="openbtn" onclick="openNav()">&#9776;</button>

    <!-- Rest of your page content -->
    <div class="container">
      <div class="row" style="margin-top: 4%">
        <div class="col-md-8 card-container card-custom">
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
        <?php include('includes/right-sidebar.php'); ?>
      </div>
    </div>
    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
  </div>


  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script>
    // Function to open sidebar
    function openNav() {
      document.getElementById("mySidebar").style.width = "250px";
      document.getElementById("main").style.marginLeft = "250px";
    }

    // Function to close sidebar
    function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.marginLeft = "0";
    }
  </script>

</body>

</html>