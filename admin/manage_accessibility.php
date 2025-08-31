<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit;
}

// Display messages
$delmsg = isset($_SESSION['delete_success']) ? 'Accessibility entry deleted successfully' : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['delete_success']);
unset($_SESSION['error']);
unset($_SESSION['success']);

// Fetch accessibility data from the database
$accessibilityQuery = "SELECT * FROM place_accessibility";
$accessibilityResult = mysqli_query($con, $accessibilityQuery);

// Delete entry functionality
if (isset($_GET['delete'])) {
    $accessibilityId = intval($_GET['delete']);

    // Begin transaction
    mysqli_begin_transaction($con);
    try {
        // Delete the accessibility entry
        $deleteAccessibility = "DELETE FROM place_accessibility WHERE id = ?";
        $stmt = mysqli_prepare($con, $deleteAccessibility);
        mysqli_stmt_bind_param($stmt, 'i', $accessibilityId);
        mysqli_stmt_execute($stmt);

        // Commit transaction
        mysqli_commit($con);

        // Set session variable for success
        $_SESSION['delete_success'] = true;

        // Redirect to avoid form resubmission
        header("Location: manage_accessibility.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaction if there was an error
        mysqli_rollback($con);
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: { popup: 'swal-popup' }
                    });
                });
              </script>";
    }
}

// Update accessibility functionality
if (isset($_POST['update'])) {
    $accessibilityId = intval($_POST['id']);
    $wheelchairAccessibleParking = isset($_POST['wheelchairAccessibleParking']) ? 1 : 0;
    $wheelchairAccessibleEntrance = isset($_POST['wheelchairAccessibleEntrance']) ? 1 : 0;
    $wheelchairAccessibleRestroom = isset($_POST['wheelchairAccessibleRestroom']) ? 1 : 0;
    $wheelchairAccessibleSeating = isset($_POST['wheelchairAccessibleSeating']) ? 1 : 0;

    // Calculate the number of accessibility options checked
    $accessibilityCount = $wheelchairAccessibleParking + $wheelchairAccessibleEntrance +
        $wheelchairAccessibleRestroom + $wheelchairAccessibleSeating;

    // Determine the accessibility level based on the count
    if ($accessibilityCount === 0) {
        $accessibilityLevelText = 'Not Accessible';
    } elseif ($accessibilityCount >= 1 && $accessibilityCount <= 2) {
        $accessibilityLevelText = 'Partially Accessible';
    } else {
        $accessibilityLevelText = 'Highly Accessible';
    }

    // Begin transaction
    mysqli_begin_transaction($con);
    try {
        // Update the accessibility entry
        $updateAccessibility = "UPDATE place_accessibility SET 
            wheelchairAccessibleParking = ?, 
            wheelchairAccessibleEntrance = ?, 
            wheelchairAccessibleRestroom = ?, 
            wheelchairAccessibleSeating = ?, 
            accessibility_level = ? 
            WHERE id = ?";

        $stmt = mysqli_prepare($con, $updateAccessibility);
        mysqli_stmt_bind_param(
            $stmt,
            'iiiisi',
            $wheelchairAccessibleParking,
            $wheelchairAccessibleEntrance,
            $wheelchairAccessibleRestroom,
            $wheelchairAccessibleSeating,
            $accessibilityLevelText,
            $accessibilityId
        );

        if (mysqli_stmt_execute($stmt)) {
            // Commit transaction
            mysqli_commit($con);

            // Set session variable for success
            $_SESSION['success'] = "Accessibility features updated successfully";

            // Redirect to avoid form resubmission
            header("Location: manage_accessibility.php");
            exit;
        }
    } catch (Exception $e) {
        // Rollback transaction if there was an error
        mysqli_rollback($con);
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: manage_accessibility.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWDIS | Admin Dashboard</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal-popup {
            width: 400px;
            font-size: 1.2em;
        }

        #accessibilitySearch {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group input[type="checkbox"] {
            transform: scale(1.5);
            /* Adjust size as needed */
        }

        .form-group label {
            font-size: 1.2em;
            /* Adjust font size as needed */
        }

        .btn-group {
            display: flex;
        }

        .btn-group a {
            font-size: 1em;
            margin-right: 5px;
            /* Adjust the value as needed */
        }

        .custom-control-input {
            transform: scale(1.5);
            margin-right: 10px;
        }
        .custom-control-label {
            font-size: 1.2em;
            padding-left: 10px;
        }
        .modal-header {
            background-color: #f7f7f7;
            border-bottom: 1px solid #e5e5e5;
        }
        .modal-footer {
            background-color: #f7f7f7;
            border-top: 1px solid #e5e5e5;
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
                                <h4 class="page-title">Accessibility Management</h4>
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
                        <div class="col-lg-12">
                            <input type="text" id="accessibilitySearch" placeholder="Search accessibility records...">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="header-title">Manage Place Accessibility Records</h4>
                            <div class="table-responsive">
                                <table class="table table-colored table-bordered table-centered table-inverse m-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Contributor</th>
                                            <th>Place Name</th>
                                            <th>Accessibility Level</th>
                                            <th>PWD Accessible Parking</th>
                                            <th>PWD Accessible Entrance</th>
                                            <th>PWD Accessible Restroom</th>
                                            <th>PWD Accessible Seating</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="accessibilityTableBody">
                                        <?php
                                        if (mysqli_num_rows($accessibilityResult) > 0) {
                                            while ($row = mysqli_fetch_assoc($accessibilityResult)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['display_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['accessibility_level']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['wheelchairAccessibleParking'] ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo htmlspecialchars($row['wheelchairAccessibleEntrance'] ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo htmlspecialchars($row['wheelchairAccessibleRestroom'] ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo htmlspecialchars($row['wheelchairAccessibleSeating'] ? 'Yes' : 'No'); ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="#" class="btn btn-warning btn-xs" data-toggle="modal" 
                                                               data-target="#updateModal<?php echo $row['id']; ?>">Edit</a>
                                                            <a href="javascript:void(0);" class="btn btn-danger btn-xs delete-record" 
                                                               data-id="<?php echo $row['id']; ?>">Delete</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Update Modal -->
                                                <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Accessibility for <?php echo htmlspecialchars($row['display_name']); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    
                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" 
                                                                                   id="parking<?php echo $row['id']; ?>" 
                                                                                   name="wheelchairAccessibleParking" value="1" 
                                                                                   <?php echo $row['wheelchairAccessibleParking'] ? 'checked' : ''; ?>>
                                                                            <label class="custom-control-label" 
                                                                                   for="parking<?php echo $row['id']; ?>">PWD Accessible Parking</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" 
                                                                                   id="entrance<?php echo $row['id']; ?>" 
                                                                                   name="wheelchairAccessibleEntrance" value="1" 
                                                                                   <?php echo $row['wheelchairAccessibleEntrance'] ? 'checked' : ''; ?>>
                                                                            <label class="custom-control-label" 
                                                                                   for="entrance<?php echo $row['id']; ?>">PWD Accessible Entrance</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" 
                                                                                   id="restroom<?php echo $row['id']; ?>" 
                                                                                   name="wheelchairAccessibleRestroom" value="1" 
                                                                                   <?php echo $row['wheelchairAccessibleRestroom'] ? 'checked' : ''; ?>>
                                                                            <label class="custom-control-label" 
                                                                                   for="restroom<?php echo $row['id']; ?>">PWD Accessible Restroom</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" 
                                                                                   id="seating<?php echo $row['id']; ?>" 
                                                                                   name="wheelchairAccessibleSeating" value="1" 
                                                                                   <?php echo $row['wheelchairAccessibleSeating'] ? 'checked' : ''; ?>>
                                                                            <label class="custom-control-label" 
                                                                                   for="seating<?php echo $row['id']; ?>">PWD Accessible Seating</label>
                                                                        </div>
                                                                    </div>

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
                                            }
                                        } else {
                                            echo "<tr><td colspan='9'>No records found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
            <?php include('includes/footer.php'); ?>
        </div> <!-- content-page -->
    </div> <!-- wrapper -->

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time search functionality
            var accessibilitySearch = document.getElementById('accessibilitySearch');
            var accessibilityTableBody = document.getElementById('accessibilityTableBody');

            if (accessibilitySearch && accessibilityTableBody) {
                accessibilitySearch.addEventListener('keyup', function() {
                    var searchValue = this.value.toLowerCase();
                    var rows = accessibilityTableBody.getElementsByTagName('tr');

                    for (var i = 0; i < rows.length; i++) {
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

            // Delete functionality
            $(document).on('click', '.delete-record', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'manage_accessibility.php',
                            type: 'GET',
                            data: { delete: id },
                            success: function(response) {
                                // Remove the row from the table
                                $(e.target).closest('tr').remove();
                                
                                Swal.fire(
                                    'Deleted!',
                                    'Accessibility Update Successfuly Deleted!',
                                    'success'
                                );
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.getElementsByClassName('alert');
            for(var i = 0; i < alerts.length; i++) {
                alerts[i].style.display = 'none';
            }
        }, 5000);
    </script>

</body>

</html>

<?php
mysqli_close($con);
?>