<?php
session_start();
include('includes/config.php');
// Generating CSRF Token
if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['submit'])) {
  // Verifying CSRF Token
  if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
      $name = $_SESSION['name'] . " " . $_SESSION['lname'];
      $email = $_SESSION['Email'];
      $avatarUrl = $_SESSION['avatar_url']; // Get avatar URL from session
      $comment = $_POST['comment'];
      $postid = intval($_GET['nid']);
      $st1 = '1';
      // Insert comment along with avatar URL
      $query = mysqli_query($con, "INSERT INTO tblcomments(postId, name, email, comment, status, avatar_url) VALUES ('$postid', '$name', '$email', '$comment', '$st1', '$avatarUrl')");
      if ($query) {
        echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Comment successfully submitted, Thank you for your feedback!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {});
                        });
                      </script>";
      } else {
        echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                      </script>";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PWDIS | LB</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
  <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .post-images {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 10px;
      margin-bottom: 10px;
    }

    .post-image {
      width: 100%;
      height: auto;
      object-fit: cover;
    }

    .avatar {
      width: 30px;
      height: 30px;
    }

    .card {
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
    }

    .category:hover {
      transform: scale(1.05);
    }

    .categorybtn {
      font-size: 12px;
    }

    .card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-text a {
      display: inline-block;
      padding: 8px 16px;
      background-color: #007bff;
      color: #ffffff !important;
      text-decoration: none;
      border-radius: 4px;
      margin: 4px;
      transition: all 0.3s ease;
      border: none;
      font-weight: 500;
    }

    .card-text a:hover {
      background-color: #0056b3;
      text-decoration: none;
      transform: translateY(-1px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Add this if you want the link to appear "pressed" when clicked */
    .card-text a:active {
      transform: translateY(1px);
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="top-header">
    <div class="logo-header">
      <a href="index.php"><i class='fa fa-wheelchair'></i><span>PWD<span>IS</span></span></a>
    </div>
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
          $pid = intval($_GET['nid']);
          $query = mysqli_query($con, "SELECT tblposts.id, tblposts.PostTitle AS posttitle, tblposts.PostImage, tblcategory.CategoryName AS category, tblcategory.id AS cid, tblposts.PostDetails AS postdetails, tblposts.PostingDate AS postingdate, tblposts.PostUrl AS url FROM tblposts LEFT JOIN tblcategory ON tblcategory.id=tblposts.CategoryId WHERE tblposts.id='$pid'");
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h5>
                <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a> |
                </p>
                <hr />
                <p class="card-text"><?php echo $row['postdetails']; ?></p>

                <?php
                $postId = $row['id'];
                $imageQuery = mysqli_query($con, "SELECT image FROM tblpostimages WHERE postId='$postId'");
                $imageArray = array();
                while ($imageRow = mysqli_fetch_array($imageQuery)) {
                  $imageArray[] = $imageRow['image'];
                }
                // Check if there are images associated with the post
                if (!empty($imageArray)) {
                ?>
                  <div class="post-images">
                    <?php
                    // Reverse the image array
                    $imageArray = array_reverse($imageArray);
                    foreach ($imageArray as $image) {
                    ?>
                      <a href="admin/postimages/<?php echo htmlentities($image); ?>" class="image-link">
                        <img src="admin/postimages/<?php echo htmlentities($image); ?>" alt="Post Image" class="post-image">
                      </a>
                    <?php } ?>
                  </div>
                <?php } else { ?>
                <?php } // End if 
                ?>
              </div>
              <div class="card-footer text-muted"></div>
            </div>
          <?php } ?>
        </div>

        <!-- Sidebar Widgets Column -->
        <?php include('includes/right-sidebar.php'); ?>
      </div>
      <!-- /.row -->
      <!---Comment Section --->
      <div class="row comment" style="margin-top: -8%">
        <div class="col-md-8">
          <div class="card my-4">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
              <form name="Comment" method="post">
                <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                <div class="form-group">
                  <textarea class="form-control" name="comment" rows="3" placeholder="Comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </form>
            </div>
          </div>

          <!---Comment Display Section --->
          <?php
          $sts = 1;
          $query = mysqli_query($con, "SELECT name, comment, postingDate, avatar_url FROM tblcomments WHERE postId='$pid' AND status='$sts'");
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <div class="media mb-4">
              <img class="d-flex mr-3 rounded-circle avatar" src="<?php echo htmlentities($row['avatar_url']); ?>" alt="">
              <div class="media-body">
                <h5 class="mt-0"><?php echo htmlentities($row['name']); ?> <br />
                  <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']); ?></span>
                </h5>
                <?php echo htmlentities($row['comment']); ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php include('includes/footer.php'); ?>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Magnific Popup CSS -->
  <!-- jQuery (necessary for Magnific Popup) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Magnific Popup JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

  <script>
    // Initialize Magnific Popup
    $(document).ready(function() {
      $('.image-link').magnificPopup({
        type: 'image',
        gallery: {
          enabled: true
        }
      });
    });

    function toggleNav() {
      const sidebar = document.getElementById("mySidebar");
      if (sidebar.style.width === "250px") {
        closeNav();
      } else {
        openNav();
      }
    }
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