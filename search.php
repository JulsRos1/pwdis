<?php
session_start();
error_reporting(0);
include('includes/config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>PWDIS | Search Page</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sidebar.css" rel="stylesheet">
  <style>
    .card {
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
    }

    .card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
  </style>

</head>

<body>
  <div class="top-header">
    <button class="openbtn" onclick="toggleNav()">&#9776;</button>
  </div>

  <!-- Sidebar -->
  <?php include("includes/sidebar.php"); ?>
  <!-- Page Content -->
  <div id="main">
    <div class="container">



      <div class="row" style="margin-top: 4%">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <!-- Blog Post -->
          <?php
          if ($_POST['searchtitle'] != '') {
            $st = $_SESSION['searchtitle'] = $_POST['searchtitle'];
          }
          $st;





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


          $query = mysqli_query($con, "select tblposts.PostImage as pimg, tblposts.id as pid,tblposts.PostTitle as posttitle,tblcategory.CategoryName as category,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId where tblposts.PostTitle like '%$st%' and tblposts.Is_Active=1 LIMIT $offset, $no_of_records_per_page");

          $rowcount = mysqli_num_rows($query);
          if ($rowcount == 0) {
            echo "No record found";
          } else {
            while ($row = mysqli_fetch_array($query)) {


          ?>

              <div class="card mb-4">
                <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['pimg']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                <div class="card-body">
                  <h2 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h2>

                  <a href="post-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                  Posted on <?php echo htmlentities($row['postingdate']); ?>

                </div>
              </div>
            <?php } ?>

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
          <?php } ?>




          <!-- Pagination -->




        </div>

        <!-- Sidebar Widgets Column -->
        <?php include('includes/right-sidebar.php'); ?>
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
      function toggleNav() {
        const sidebar = document.getElementById("mySidebar");
        if (sidebar.style.width === "250px") {
          closeNav();
        } else {
          openNav();
        }
      }

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


    </head>
</body>

</html>