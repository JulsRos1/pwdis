<?php
session_start();
include('includes/config.php');
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['submit'])) {
  //Verifying CSRF Token
  if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
      $name = $_SESSION['name'] . " " . $_SESSION['lname'];
      $email = $_SESSION['Email'];
      $comment = $_POST['comment'];
      $postid = intval($_GET['nid']);
      $st1 = '1';
      $query = mysqli_query($con, "insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
      if ($query) :
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                    title: 'Success!',
                    text: 'Comment successfully submitted, Thank you for your feedback!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                  }).then(() => {
                   
                  });
                });
              </script>";
      else :
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
      endif;
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

  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">
  <style>
    .post-images {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }

    .post-image {
      width: 100%;
      height: auto;
      object-fit: cover;
    }
  </style>



</head>

<body>

  <!-- Navigation -->
  <?php include('includes/header.php'); ?>

  <!-- Page Content -->
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
              <h2 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h2>
              <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a> |
              </p>
              <hr />
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
              <p class="card-text"><?php echo substr($row['postdetails'], 0); ?></p>
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
        $query = mysqli_query($con, "select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
        while ($row = mysqli_fetch_array($query)) {
        ?>
          <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
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
  </script>

</body>

</html>