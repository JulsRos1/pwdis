<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    if ($_GET['action'] = 'restore') {
        $postid = intval($_GET['pid']);
        $query = mysqli_query($con, "update tblposts set Is_Active=1 where id='$postid'");
        if ($query) {
            $msg = "Post restored successfully ";
        } else {
            $error = "Something went wrong . Please try again.";
        }
    }


    // Code for Forever deletionparmdel

    if ($_GET['presid']) {
        $id = intval($_GET['presid']);

        // Retrieve associated images of the post
        $getImagesQuery = mysqli_query($con, "SELECT image FROM tblpostimages WHERE postId = '$id'");
        while ($imageRow = mysqli_fetch_assoc($getImagesQuery)) {
            $imageToDelete = $imageRow['image'];
            // Delete the image file from the server
            unlink("postimages/" . $imageToDelete);
        }

        // Delete associated images from tblpostimages
        $deleteImagesQuery = mysqli_query($con, "DELETE FROM tblpostimages WHERE postId = '$id'");

        // Proceed with deleting the post from tblposts if images are deleted successfully
        if ($deleteImagesQuery) {
            $deletePostQuery = mysqli_query($con, "DELETE FROM tblposts WHERE id = '$id'");
            if ($deletePostQuery) {
                $delmsg = "Post deleted forever";
            } else {
                $error = "Failed to delete post";
            }
        } else {
            $error = "Failed to delete associated images";
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>PWDIS | Manage Posts</title>

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="../plugins/morris/morris.css">

        <!-- jvectormap -->
        <link href="../plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />


        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include('includes/topheader.php'); ?>

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('includes/leftsidebar.php'); ?>


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">


                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Trashed Posts </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Posts</a>
                                        </li>
                                        <li class="active">
                                            Trashed Posts
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-sm-6">



                                <?php if ($delmsg) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Oh snap!</strong> <?php echo htmlentities($delmsg); ?>
                                    </div>
                                <?php } ?>


                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">


                                        <div class="table-responsive">
                                            <table class="table table-colored table-centered table-inverse m-0">
                                                <thead>
                                                    <tr>

                                                        <th>Title</th>
                                                        <th>Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $query = mysqli_query($con, "select tblposts.id as postid,tblposts.PostTitle as title,tblcategory.CategoryName as category from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId where tblposts.Is_Active=0");
                                                    $rowcount = mysqli_num_rows($query);
                                                    if ($rowcount == 0) {
                                                    ?>
                                                        <tr>

                                                            <td colspan="4" align="center">
                                                                <h3 style="color:red">No record found</h3>
                                                            </td>
                                                        <tr>
                                                            <?php
                                                        } else {
                                                            while ($row = mysqli_fetch_array($query)) {
                                                            ?>
                                                        <tr>
                                                            <td><b><?php echo htmlentities($row['title']); ?></b></td>
                                                            <td><?php echo htmlentities($row['category']) ?></td>

                                                            <td>
                                                                <a href="trash-posts.php?pid=<?php echo htmlentities($row['postid']); ?>&&action=restore" onclick="return confirm('Do you really want to restore ?')"> <i class="ion-arrow-return-right" title="Restore this Post"></i></a>
                                                                &nbsp;
                                                                <a href="trash-posts.php?presid=<?php echo htmlentities($row['postid']); ?>&&action=perdel" onclick="return confirm('Do you really want to delete ?')"><i class="fa fa-trash-o" style="color: #f05050" title="Permanently delete this post"></i></a>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                        } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div> <!-- container -->

                    </div> <!-- content -->

                    <?php include('includes/footer.php'); ?>

                </div>


                <!-- ============================================================== -->
                <!-- End Right content here -->
                <!-- ============================================================== -->


            </div>
            <!-- END wrapper -->



            <script>
                var resizefunc = [];
            </script>

             <!-- jQuery  -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/detect.js"></script>
            <script src="assets/js/fastclick.js"></script>
            <script src="assets/js/jquery.blockUI.js"></script>
            <script src="assets/js/waves.js"></script>
            <script src="assets/js/jquery.slimscroll.js"></script>
            <script src="assets/js/jquery.scrollTo.min.js"></script>

            <!-- Dashboard Init js -->
            <script src="assets/pages/jquery.blog-dashboard.js"></script>

            <!-- App js -->
            <script src="assets/js/jquery.core.js"></script>
            <script src="assets/js/jquery.app.js"></script>

    </body>

    </html>
<?php } ?>