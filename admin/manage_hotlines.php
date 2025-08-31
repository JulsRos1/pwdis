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
        $query = mysqli_query($con, "DELETE FROM emergency_hotlines WHERE id = $id");
        if ($query) {
            $_SESSION['delmsg'] = "Hotline deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting hotline";
        }
        header("Location: manage_hotlines.php");
        exit();
    }

    // Handle Update action
    if (isset($_POST['update'])) {
        $id = intval($_POST['hotline_id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $number = mysqli_real_escape_string($con, $_POST['number']);

        // Validate hotline number
        if (strlen($number) < 10 || strlen($number) > 11) {
            $_SESSION['error'] = "Hotline number must be 10 or 11 digits long";
        } else {
            $update_query = mysqli_query($con, "UPDATE emergency_hotlines SET 
                title='$title', 
                number='$number'
                WHERE id='$id'");
            
            if ($update_query) {
                $_SESSION['success'] = "Hotline updated successfully";
            } else {
                $_SESSION['error'] = "Failed to update hotline";
            }
        }
        header("Location: manage_hotlines.php");
        exit();
    }

    // Display messages
    $delmsg = isset($_SESSION['delmsg']) ? $_SESSION['delmsg'] : '';
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    unset($_SESSION['delmsg']);
    unset($_SESSION['error']);
    unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWDIS | Manage Emergency Hotlines</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/modernizr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        #hotlineSearch {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .table > tbody > tr > td {
            vertical-align: middle;
        }
    </style>
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
                                <h4 class="page-title">Manage Emergency Hotlines</h4>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="m-b-30">
                                    <a href="upload_hotlines.php">
                                        <button class="btn btn-success waves-effect waves-light">Add Hotline <i class="mdi mdi-plus-circle-outline"></i></button>
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" id="hotlineSearch" placeholder="Search hotlines...">
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-colored table-centered table-inverse m-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Number</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "SELECT * FROM emergency_hotlines ORDER BY id DESC");
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row['id']); ?></td>
                                                    <td><?php echo htmlentities($row['title']); ?></td>
                                                    <td><?php echo htmlentities($row['number']); ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal<?php echo $row['id']; ?>">Update</a>
                                                        <a href="manage_hotlines.php?action=del&id=<?php echo $row['id']; ?>" 
                                                           class="btn btn-danger btn-sm" 
                                                           onclick="return confirm('Are you sure you want to delete this hotline?');">Delete</a>
                                                    </td>
                                                </tr>

                                                <!-- Update Modal -->
                                                <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Hotline</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="manage_hotlines.php">
                                                                    <div class="form-group">
                                                                        <label for="title">Hotline Title</label>
                                                                        <input type="text" class="form-control" name="title" 
                                                                               value="<?php echo htmlentities($row['title']); ?>" required>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label for="number">Hotline Number</label>
                                                                        <input type="text" class="form-control" name="number" 
                                                                               value="<?php echo htmlentities($row['number']); ?>" 
                                                                               pattern="^\d{10,11}$" 
                                                                               title="Please enter a number of 10 to 11 digits length" required>
                                                                    </div>
                                                                    
                                                                    <input type="hidden" name="hotline_id" value="<?php echo $row['id']; ?>">
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="update" class="btn btn-success">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            var hotlineSearch = document.getElementById('hotlineSearch');
            var table = document.querySelector('table');

            if (hotlineSearch && table) {
                hotlineSearch.addEventListener('keyup', function() {
                    var searchValue = this.value.toLowerCase();
                    var rows = table.getElementsByTagName('tr');

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

            // Auto-hide alerts after 5 seconds
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