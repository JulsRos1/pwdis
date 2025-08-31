<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $hotlineTitle = $_POST['hotline_title'];
        $hotlineNumber = $_POST['hotline_number'];

        if ($hotlineTitle != '' && $hotlineNumber != '') {
            // Validate hotline number length
            if (strlen($hotlineNumber) < 10 || strlen($hotlineNumber) > 11) {
                $error = "Hotline number must be 10 or 11 digits long";
            } else {
                $query = mysqli_query($con, "INSERT INTO emergency_hotlines(title, number) 
                                       VALUES('$hotlineTitle', '$hotlineNumber')");
                if ($query) {
                    $msg = "Hotline successfully uploaded";
                } else {
                    $error = "Error inserting into database";
                }
            }
        } else {
            $error = "Please fill all fields";
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PWDIS | Upload Emergency Hotlines</title>
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
            <?php include('includes/topheader.php'); ?>
            <?php include('includes/leftsidebar.php'); ?>

            <div class="content-page">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Upload Emergency Hotlines</h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <?php if ($msg) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>
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
                                    <form method="post">
                                        <div class="form-group m-b-20">
                                            <label for="hotline_title">Hotline Title</label>
                                            <input type="text" class="form-control" id="hotline_title" name="hotline_title" placeholder="Enter hotline title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="hotline_number">Hotline Number</label>
                                            <input type="text" class="form-control" id="hotline_number" name="hotline_number"
                                                placeholder="Enter hotline number"
                                                pattern="^\d{10,11}$" title="Please enter a number of 10 to 11 digits length and no spacing" required>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Upload Hotline</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                    </form>
                                </div>
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