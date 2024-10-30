<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit;
}

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

        mysqli_stmt_execute($stmt);

        // Commit transaction
        mysqli_commit($con);

        // Set session variable for success
        $_SESSION['update_success'] = true;

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

// Display success messages
if (isset($_SESSION['update_success'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Accessibility features updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: { popup: 'swal-popup' }
                });
            });
          </script>";
    unset($_SESSION['update_success']); // Clear the session variable
}

if (isset($_SESSION['delete_success'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Accessibility entry deleted successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: { popup: 'swal-popup' }
                });
            });
          </script>";
    unset($_SESSION['delete_success']); // Clear the session variable
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
                                                            <a href="#editModal<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-warning btn-xs">Edit</a>
                                                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this entry?');">Delete</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form method="POST" action="">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Accessibility for <?php echo htmlspecialchars($row['display_name']); ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="wheelchairAccessibleParking" value="1" <?php echo $row['wheelchairAccessibleParking'] ? 'checked' : ''; ?>>
                                                                        <label for="wheelchairAccessibleParking">PWD Accessible Parking</label>

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="wheelchairAccessibleEntrance" value="1" <?php echo $row['wheelchairAccessibleEntrance'] ? 'checked' : ''; ?>>
                                                                        <label for="wheelchairAccessibleEntrance">PWD Accessible Entrance</label>

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="wheelchairAccessibleRestroom" value="1" <?php echo $row['wheelchairAccessibleRestroom'] ? 'checked' : ''; ?>>
                                                                        <label for="wheelchairAccessibleRestroom">PWD Accessible Restroom</label>

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="wheelchairAccessibleSeating" value="1" <?php echo $row['wheelchairAccessibleSeating'] ? 'checked' : ''; ?>>
                                                                        <label for="wheelchairAccessibleSeating">PWD Accessible Seating</label>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
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
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show the confirmation modal and set the href of the delete button
            $('.delete-btn').on('click', function(event) {
                event.preventDefault();
                var accessibilityId = $(this).data('id');
                $('#confirmDeleteBtn').attr('href', 'manage_accessibility.php?delete=' + accessibilityId);
                $('#confirmationModal').modal('show');
            });

            // Show the edit modal and populate the fields
            $('.edit-btn').on('click', function(event) {
                event.preventDefault();
                var accessibilityId = $(this).data('id');
                var parking = $(this).data('parking');
                var entrance = $(this).data('entrance');
                var restroom = $(this).data('restroom');
                var seating = $(this).data('seating');

                $('#editId').val(accessibilityId);
                $('#editParking').prop('checked', parking == 1);
                $('#editEntrance').prop('checked', entrance == 1);
                $('#editRestroom').prop('checked', restroom == 1);
                $('#editSeating').prop('checked', seating == 1);

                $('#editModal').modal('show');
            });

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
        });
    </script>

</body>

</html>

<?php
mysqli_close($con);
?>