<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // For uploading files
    if (isset($_POST['submit'])) {
        $fileTitle = $_POST['filetitle'];

        // Handle file upload
        if ($_FILES["uploadfile"]["name"] != '') {
            $file = $_FILES["uploadfile"]["name"];
            $fileTempName = $_FILES["uploadfile"]["tmp_name"];

            // Get the file extension
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $allowed = array("pdf", "doc", "docx");

            // Check if the uploaded file is a PDF or Word file
            if (in_array($extension, $allowed)) {
                // Set the target directory (absolute path)
                $targetDir = "uploaded_files/";

                // Create the target directory if it doesn't exist
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                // Set the full file path
                $targetFilePath = $targetDir . basename($file);

                // Move the uploaded file to the desired location
                if (move_uploaded_file($fileTempName, $targetFilePath)) {
                    // Insert the file details into the database
                    $query = mysqli_query($con, "INSERT INTO uploaded_files(title, file_name, file_path, date_created) VALUES('$fileTitle', '$file', '/uploaded_files/$file', NOW())");

                    if ($query) {
                        $msg = "File successfully uploaded";
                    } else {
                        $error = "Error inserting into database";
                    }
                } else {
                    $error = "Failed to upload file";
                }
            } else {
                $error = "Only PDF and Word files are allowed";
            }
        } else {
            $error = "Please choose a file to upload";
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

        <title>PWDIS | Upload Disability Materials</title>

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <script src="assets/js/modernizr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    </head>

    <body class="fixed-left">
        <div id="wrapper">
            <!-- Top Bar Start -->
            <?php include('includes/topheader.php'); ?>
            <!-- ========== Left Sidebar Start ========== -->
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
                                    <h4 class="page-title">Upload Disability Laws and Rights files</h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Success Message -->
                                <?php if ($msg) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>

                                <!-- Error Message -->
                                <?php if ($error) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="p-6">
                                    <div class="">
                                        <form name="uploadfile" method="post" enctype="multipart/form-data">
                                            <div class="form-group m-b-20">
                                                <label for="filetitle">File Title</label>
                                                <input type="text" class="form-control" id="filetitle" name="filetitle" placeholder="Enter file title" required>
                                            </div>

                                            <div class="control-group form-group">
                                                <div class="controls">
                                                    <label>Select File (PDF or Word):</label>
                                                    <input type="file" class="form-control" name="uploadfile" required>
                                                </div>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Upload File</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                        </form>
                                    </div>
                                </div> <!-- end p-20 -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->

                <?php include('includes/footer.php'); ?>
            </div>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>
        <!-- Select 2 -->
        <script src="../plugins/select2/js/select2.min.js"></script>
        <!-- Jquery filer js -->
        <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>

        <!-- page specific js -->
        <script src="assets/pages/jquery.blog-add.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
    </body>

    </html>
<?php } ?>