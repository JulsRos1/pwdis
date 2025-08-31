<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Handle Delete action
    if (isset($_GET['action']) && $_GET['action'] == 'del' && isset($_GET['id'])) {
        $id = intval($_GET['id']);

        // Fetch the file path from the database
        $query = mysqli_query($con, "SELECT file_path FROM uploaded_files WHERE id = $id");
        if ($query) {
            $result = mysqli_fetch_assoc($query);
            $filePath = $result['file_path'];

            // Construct the correct file path
            $fullPath = '.' . $filePath;

            // Check if the file exists and delete it
            if ($filePath && file_exists($fullPath)) {
                if (unlink($fullPath)) { // Delete the file
                    // Delete the record from the database
                    mysqli_query($con, "DELETE FROM uploaded_files WHERE id = $id");
                    $_SESSION['delmsg'] = "File deleted successfully from both database and folder";
                    header("Location: manage_materials.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Error deleting file from folder. Database record not deleted.";
                    header("Location: manage_materials.php");
                    exit();
                }
            } else {
                // Delete the database record only
                mysqli_query($con, "DELETE FROM uploaded_files WHERE id = $id");
                $_SESSION['delmsg'] = "File not found in the folder. Database record deleted.";
                header("Location: manage_materials.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Error fetching file details.";
            header("Location: manage_materials.php");
            exit();
        }
    }

    // Display messages
    $delmsg = isset($_SESSION['delmsg']) ? $_SESSION['delmsg'] : '';
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    unset($_SESSION['delmsg']);
    unset($_SESSION['error']);
    unset($_SESSION['success']);

    // Add this at the top with other PHP code
    if(isset($_POST['update'])) {
        $file_id = intval($_POST['file_id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        
        // Check if a new file was uploaded
        if(!empty($_FILES['new_file']['name'])) {
            $new_file = $_FILES['new_file']['name'];
            $new_file_temp = $_FILES['new_file']['tmp_name'];
            
            // Get the file extension
            $extension = pathinfo($new_file, PATHINFO_EXTENSION);
            $allowed = array("pdf", "doc", "docx");
            
            if(in_array($extension, $allowed)) {
                // Get the old file info to delete it
                $old_file_query = mysqli_query($con, "SELECT file_path FROM uploaded_files WHERE id = '$file_id'");
                $old_file_info = mysqli_fetch_assoc($old_file_query);
                
                // Delete old file
                if($old_file_info['file_path']) {
                    $old_file_path = '.' . $old_file_info['file_path'];
                    if(file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }
                
                // Upload new file
                $targetDir = "uploaded_files/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                $targetFilePath = $targetDir . basename($new_file);
                
                if(move_uploaded_file($new_file_temp, $targetFilePath)) {
                    // Update database with new file info
                    $update_query = mysqli_query($con, "UPDATE uploaded_files SET 
                        title='$title', 
                        description='$description',
                        file_name='$new_file',
                        file_path='/uploaded_files/$new_file'
                        WHERE id='$file_id'");
                    
                    if($update_query) {
                        $_SESSION['success'] = "File updated successfully with new file";
                    } else {
                        $_SESSION['error'] = "Database update failed";
                    }
                } else {
                    $_SESSION['error'] = "Failed to upload new file";
                }
            } else {
                $_SESSION['error'] = "Only PDF and Word files are allowed";
            }
        } else {
            // Update only title and description
            $update_query = mysqli_query($con, "UPDATE uploaded_files SET 
                title='$title', 
                description='$description'
                WHERE id='$file_id'");
            
            if($update_query) {
                $_SESSION['success'] = "File details updated successfully";
            } else {
                $_SESSION['error'] = "Failed to update file details";
            }
        }
        
        header("Location: manage_materials.php");
        exit();
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Add these styles -->
        <style>
            #materialSearch {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            /* Table styling improvements */
            .table-responsive {
                overflow-x: auto;
            }
            
            .table > tbody > tr > td {
                vertical-align: middle;
                max-width: 300px; /* Adjust this value as needed */
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            
            .description-cell {
                max-width: 300px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .title-cell {
                max-width: 200px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            /* Tooltip styles */
            .tooltip-text {
                position: relative;
                cursor: pointer;
            }
            
            .tooltip-text:hover::after {
                content: attr(data-full-text);
                position: absolute;
                left: 0;
                top: 100%;
                background: #333;
                color: #fff;
                padding: 5px;
                border-radius: 4px;
                z-index: 1000;
                white-space: normal;
                min-width: 200px;
                max-width: 400px;
                word-wrap: break-word;
            }
        </style>
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
                                    <h4 class="page-title">Manage Disability Laws and Rights files</h4>
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

                        <!-- Add this after your page title box -->
                        <div class="row">
                            <div class="col-sm-12">
                                <?php if ($success) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>Success!</strong> <?php echo htmlentities($success); ?>
                                    </div>
                                <?php } ?>

                                <?php if ($delmsg) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>Success!</strong> <?php echo htmlentities($delmsg); ?>
                                    </div>
                                <?php } ?>

                                <?php if ($error) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Table displaying uploaded files -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <div class="m-b-30">
                                        <a href="upload_materials.php">
                                            <button id="addToTable" class="btn btn-success waves-effect waves-light">Add <i class="mdi mdi-plus-circle-outline"></i></button>
                                        </a>
                                    </div>

                                    <!-- Add search input -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="text" id="materialSearch" placeholder="Search materials...">
                                        </div>
                                    </div>

                                    <h4 class="m-t-0 header-title">Uploaded Files</h4>
                                    <div class="table-responsive">
                                        <table class="table table-colored table-centered table-inverse m-0 table-modern">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>File Name</th>
                                                    <th>Description</th>
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
                                                        <td class="title-cell tooltip-text" data-full-text="<?php echo htmlspecialchars($row['title']); ?>">
                                                            <?php echo htmlentities($row['title']); ?>
                                                        </td>
                                                        <td><?php echo htmlentities($row['file_name']); ?></td>
                                                        <td class="description-cell tooltip-text" data-full-text="<?php echo htmlspecialchars($row['description']); ?>">
                                                            <?php echo htmlentities($row['description']); ?>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal<?php echo $row['id']; ?>">Update</a>
                                                            <a href="manage_materials.php?action=del&id=<?php echo $row['id']; ?>" 
                                                               class="btn btn-danger btn-sm" 
                                                               onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
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
                                                                    <form method="post" action="manage_materials.php" enctype="multipart/form-data">
                                                                        <div class="form-group">
                                                                            <label for="title">File Title</label>
                                                                            <input type="text" class="form-control" name="title" value="<?php echo htmlentities($row['title']); ?>" required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label for="description">Description</label>
                                                                            <textarea class="form-control" name="description" rows="4"><?php echo htmlentities($row['description']); ?></textarea>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Current File: <?php echo htmlentities($row['file_name']); ?></label>
                                                                            <input type="file" class="form-control" name="new_file">
                                                                            <small class="text-muted">Leave empty to keep the current file</small>
                                                                        </div>
                                                                        
                                                                        <input type="hidden" name="file_id" value="<?php echo $row['id']; ?>">
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" name="update" class="btn btn-success">Update</button>
                                                                        </div>
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

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <!-- Add this before the closing body tag -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Real-time search functionality
                var materialSearch = document.getElementById('materialSearch');
                var table = document.querySelector('.table-modern');

                if (materialSearch && table) {
                    materialSearch.addEventListener('keyup', function() {
                        var searchValue = this.value.toLowerCase();
                        var rows = table.getElementsByTagName('tr');

                        // Start from index 1 to skip the header row
                        for (var i = 1; i < rows.length; i++) {
                            var row = rows[i];
                            var rowText = row.textContent.toLowerCase();

                            if (rowText.indexOf(searchValue) > -1) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                }

                // Initialize tooltips if you're using Bootstrap's tooltip component
                $('[data-toggle="tooltip"]').tooltip();
            });

            // Auto-hide alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var alerts = document.getElementsByClassName('alert');
                    for(var i = 0; i < alerts.length; i++) {
                        alerts[i].style.display = 'none';
                    }
                }, 5000);
            });
        </script>

    </body>

    </html>

<?php } ?>