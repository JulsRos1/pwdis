<?php
session_start();
include('includes/config.php');
error_reporting(0);
function convertLinksToButtons($content)
{
    $pattern = '/<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\1[^>]*>(.*?)<\/a>/i';
    $replacement = '<a href="$2" target="_blank" style="display: inline-block; padding: 5px 10px; font-size:12px; background-color: #161C27; color: #ffffff !important; text-decoration: none; border-radius: 4px; margin: 4px; border: 1px solid #007bff; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor=\'#0b5ed7\'; this.style.borderColor=\'#0a58ca\';" onmouseout="this.style.backgroundColor=\'#161C27\'; this.style.borderColor=\'#007bff\';">$3</a>';
}

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // For adding post  
    if (isset($_POST['submit'])) {
        $posttitle = mysqli_real_escape_string($con, $_POST['posttitle']); // Escape the title
        $catid = $_POST['category'];
        $postdetails = mysqli_real_escape_string($con, convertLinksToButtons($_POST['postdescription']));
        $arr = explode(" ", $posttitle);
        $url = implode("-", $arr);

        // Handle featured image upload
        if ($_FILES["featureimage"]["name"] != '') {
            $featuredImage = $_FILES["featureimage"]["name"];

            // Get the image extension
            $extension = pathinfo($featuredImage, PATHINFO_EXTENSION);

            // Generate a unique file name using md5 hash
            $featuredImageNew = md5(uniqid()) . '.' . $extension;

            // Move the uploaded image to the desired location
            move_uploaded_file($_FILES["featureimage"]["tmp_name"], "postimages/" . $featuredImageNew);

            // Set the featured image filename
            $featureImageFilename = $featuredImageNew;
        } else {
            $featureImageFilename = ''; // No featured image uploaded
        }

        // Initialize an empty array to store uploaded image names for post images
        $uploadedImages = array();

        // Loop through the uploaded files for post images only if there are images uploaded
        if (!empty($_FILES["postimages"]["name"][0])) {
            foreach ($_FILES["postimages"]["name"] as $key => $image) {
                $imgfile = $_FILES["postimages"]["name"][$key];

                // Get the image extension
                $extension = pathinfo($imgfile, PATHINFO_EXTENSION);

                // Generate a unique file name using md5 hash
                $imgnewfile = md5(uniqid()) . '.' . $extension;

                // Move the uploaded image to the desired location
                move_uploaded_file($_FILES["postimages"]["tmp_name"][$key], "postimages/" . $imgnewfile);

                // Add the uploaded image name to the array
                $uploadedImages[] = $imgnewfile;
            }
        }

        // Convert the array of uploaded image names to a comma-separated string
        $postImages = implode(',', $uploadedImages);

        // Check if there are any images uploaded for the post
        if (empty($featureImageFilename)) {
            echo "<script>alert('Please upload a featured image.');</script>";
        } else {
            $status = 1;
            $query = mysqli_query($con, "INSERT INTO tblposts(PostTitle,CategoryId,PostDetails,PostUrl,Is_Active,PostImage) VALUES('$posttitle','$catid','$postdetails','$url','$status','$featureImageFilename')");
            if ($query) {
                // Get the ID of the inserted post
                $postId = mysqli_insert_id($con);

                // Insert the image filenames into tblpostimages table
                foreach ($uploadedImages as $img) {
                    mysqli_query($con, "INSERT INTO tblpostimages(postId, image) VALUES ('$postId', '$img')");
                }

                $msg = "Post successfully added ";
            } else {
                $error = "Something went wrong. Please try again.";
            }
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
        <title>PWDIS | Add Post</title>

        <!-- Summernote css -->
        <link href="../plugins/summernote/summernote.css" rel="stylesheet" />
        <!-- Dropzone css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

        <!-- Select2 -->
        <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <!-- Jquery filer css -->
        <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
        <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />

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

        <!-- Begin page -->
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
                                    <h4 class="page-title">Add Post </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Post</a>
                                        </li>
                                        <li>
                                            <a href="#">Add Post </a>
                                        </li>
                                        <li class="active">
                                            Add Post
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <!---Success Message--->
                                <?php if ($msg) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>

                                <!---Error Message--->
                                <?php if ($error) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                <?php } ?>


                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="p-6">
                                    <div class="">
                                        <form name="addpost" method="post" enctype="multipart/form-data">
                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Post Title</label>
                                                <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Enter title" required>
                                            </div>



                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Category</label>
                                                <select class="form-control" name="category" id="category" required>
                                                    <option value="">Select Category </option>
                                                    <?php
                                                    // Feching active categories
                                                    $ret = mysqli_query($con, "select id,CategoryName from  tblcategory where Is_Active=1");
                                                    while ($result = mysqli_fetch_array($ret)) {
                                                    ?>
                                                        <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card-box">
                                                        <h4 class="m-b-30 m-t-0 header-title"><b>Post Details</b></h4>
                                                        <textarea class="summernote" name="postdescription"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="control-group form-group">
                                                <div class="controls">
                                                    <label>Featured Image:</label>
                                                    <span class="input-group-text"><i class="fas fa-camera"></i></span>
                                                    <input type="file" class="form-control" name="featureimage" required>
                                                </div>
                                            </div>


                                            <div class="control-group form-group">
                                                <div class="controls">
                                                    <label>Post Images (Optional):</label>
                                                    <input type="file" id="postImagesInput" class="form-control" name="postimages[]" multiple>
                                                </div>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Save and Post</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Discard</button>
                                        </form>
                                    </div>
                                </div> <!-- end p-20 -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->



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

        <script>
            jQuery(document).ready(function() {
                $('.summernote').summernote({
                    height: 240,
                    minHeight: null,
                    maxHeight: null,
                    focus: false,
                    callbacks: {
                        onCreateLink: function(url) {
                            // Get the selected node
                            const selection = window.getSelection();
                            const range = selection.getRangeAt(0);
                            const links = range.commonAncestorContainer.getElementsByTagName('a');

                            for (let link of links) {
                                // Add target="_blank" and styling
                                link.setAttribute('target', '_blank');
                                link.style.display = 'inline-block';
                                link.style.padding = '8px 16px';
                                link.style.backgroundColor = '#007bff';
                                link.style.color = '#ffffff';
                                link.style.textDecoration = 'none';
                                link.style.borderRadius = '4px';
                                link.style.margin = '4px';
                                link.style.border = 'none';
                                link.style.fontWeight = '500';
                            }
                            return url;
                        }
                    },
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });

            // Select2
            $(".select2").select2();

            $(".select2-limiting").select2({
                maximumSelectionLength: 2
            });
        </script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>



    </body>

    </html>
<?php } ?>