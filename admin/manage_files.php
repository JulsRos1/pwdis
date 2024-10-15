<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Handle Delete action
    if (isset($_GET['del'])) {
        $id = intval($_GET['del']);

        // Delete the file entry from the database
        $query = mysqli_query($con, "SELECT file_path FROM uploaded_Files WHERE id = $id");
        $result = mysqli_fetch_assoc($query);
        $filePath = $result['file_path'];

        // Delete the file from the directory
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
        }

        // Delete the record from the database
        mysqli_query($con, "DELETE FROM uploaded_Files WHERE id = $id");

        echo "<script>alert('File deleted successfully');</script>";
    }

    // Handle Update action (from modal)
    if (isset($_POST['update'])) {
        $id = intval($_POST['file_id']);
        $title = $_POST['title'];

        // Update the file details
        $query = mysqli_query($con, "UPDATE uploaded_Files SET title = '$title' WHERE id = $id");
        if ($query) {
            echo "<script>alert('File updated successfully');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Manage uploaded files">
        <meta name="author" content="Your Company">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>PWDIS | Manage Files</title>

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <script src="assets/js/modernizr.min.js"></script>
    </head>

    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include('includes/topheader.php'); ?>
            <!-- Left Sidebar Start -->
            <?php include('includes/leftsidebar.php'); ?>
            <!-- Left Sidebar End -->

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
                                    <h4 class="page-title">Manage Uploaded Files</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Manage Files </a>
                                        </li>
                                        <li class="active">
                                            Manage Uploaded Files
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <!-- Table displaying uploaded files -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Uploaded Files</h4>
                                    <div class="table-responsive">
                                        <table class="table table-colored table-centered table-inverse m-0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>File Name</th>
                                                    <th>Date Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Fetch files from the database
                                                $query = mysqli_query($con, "SELECT * FROM uploaded_Files ORDER BY date_created DESC");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($row['id']); ?></td>
                                                        <td><?php echo htmlentities($row['title']); ?></td>
                                                        <td><?php echo htmlentities($row['file_name']); ?></td>
                                                        <td><?php echo htmlentities($row['date_created']); ?></td>
                                                        <td>
                                                            <!-- Update button triggers modal -->
                                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal<?php echo $row['id']; ?>">Update</a>
                                                            <!-- Delete button -->
                                                            <a href="manage_files.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
                                                        </td>
                                                    </tr>

                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="updateModalLabel">Update File</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" action="manage_files.php">
                                                                        <div class="form-group">
                                                                            <label for="title">File Title</label>
                                                                            <input type="text" class="form-control" name="title" value="<?php echo htmlentities($row['title']); ?>" required>
                                                                        </div>
                                                                        <input type="hidden" name="file_id" value="<?php echo $row['id']; ?>">
                                                                        <button type="submit" name="update" class="btn btn-success">Update</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                                    $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include('includes/footer.php'); ?>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>

    </html>

<?php } ?>