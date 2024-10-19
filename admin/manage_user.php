<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Fetch user data from the database
    $userQuery = "SELECT * FROM users";
    $userResult = mysqli_query($con, $userQuery);

    // Delete user functionality
    if (isset($_GET['delete'])) {
        $userId = intval($_GET['delete']);

        // Begin transaction
        mysqli_begin_transaction($con);
        try {
            // Delete private messages where the user is either sender or receiver
            $deletePrivateMessages = "DELETE FROM private_messages WHERE sender_id = ? OR receiver_id = ?";
            $stmt = mysqli_prepare($con, $deletePrivateMessages);
            mysqli_stmt_bind_param($stmt, 'ii', $userId, $userId);
            mysqli_stmt_execute($stmt);

            // Delete messages where the user is the sender
            $deleteMessages = "DELETE FROM messages WHERE user_id = ?";
            $stmt = mysqli_prepare($con, $deleteMessages);
            mysqli_stmt_bind_param($stmt, 'i', $userId);
            mysqli_stmt_execute($stmt);

            // Delete the user
            $deleteUser = "DELETE FROM users WHERE id = ?";
            $stmt = mysqli_prepare($con, $deleteUser);
            mysqli_stmt_bind_param($stmt, 'i', $userId);
            mysqli_stmt_execute($stmt);

            // Commit transaction
            mysqli_commit($con);

            // Success message
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'User deleted successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'swal-popup' // Custom class for size
                            }
                        });
                    });
                  </script>";
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
                            customClass: {
                                popup: 'swal-popup' // Custom class for size
                            }
                        });
                    });
                  </script>";
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
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            /* Custom CSS for SweetAlert */
            .swal-popup {
                width: 400px;
                font-size: 1.2em;
            }

            /* Add styles for the search input */
            #userSearch {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
        </style>
    </head>

    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar and Sidebar -->
            <?php include('includes/topheader.php'); ?>
            <?php include('includes/leftsidebar.php'); ?>

            <!-- Start right Content here -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page title -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">User Management</h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" id="userSearch" placeholder="Search users...">
                            </div>
                        </div>

                        <!-- User Management Table -->
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="header-title">Manage Users</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Barangay</th>
                                                <th>Email</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userTableBody">
                                            <?php
                                            if (mysqli_num_rows($userResult) > 0) {
                                                while ($row = mysqli_fetch_assoc($userResult)) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['Barangay']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['id']; ?>">Delete</a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>No users found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End User Management Table -->

                    </div> <!-- container -->
                </div> <!-- content -->
                <?php include('includes/footer.php'); ?>
            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

        <!-- Confirmation Modal -->
        <div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery and other scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM fully loaded and parsed');

                // Show the confirmation modal and set the href of the delete button
                $('.delete-btn').on('click', function(event) {
                    event.preventDefault();
                    var userId = $(this).data('id');
                    $('#confirmDeleteBtn').attr('href', 'manage_user.php?delete=' + userId);
                    $('#confirmationModal').modal('show');
                });

                // Real-time search functionality
                var userSearch = document.getElementById('userSearch');
                var userTableBody = document.getElementById('userTableBody');

                if (userSearch && userTableBody) {
                    console.log('Search input and table body found');

                    userSearch.addEventListener('keyup', function() {
                        console.log('Search input keyup event fired');
                        var searchValue = this.value.toLowerCase();
                        console.log('Search value:', searchValue);

                        var rows = userTableBody.getElementsByTagName('tr');
                        console.log('Number of rows:', rows.length);

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
                } else {
                    console.error('Search input or table body not found');
                }
            });
        </script>

    </body>

    </html>

<?php } ?>