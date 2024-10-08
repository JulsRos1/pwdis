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

            // Redirect to the same page after deletion
            header('Location: manage_user.php');
            exit;
        } catch (Exception $e) {
            // Rollback transaction if there was an error
            mysqli_rollback($con);
            echo "Error: " . $e->getMessage();
        }
    }
    // ... rest of your code ...
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar and Sidebar -->
        <?php include('includes/topheader.php'); ?>
        <?php include('includes/leftsidebar.php'); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
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
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($userResult) > 0) {
                                            while ($row = mysqli_fetch_assoc($userResult)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                    <td><?php echo $row['FirstName']; ?></td>
                                                    <td><?php echo $row['LastName']; ?></td>
                                                    <td><?php echo $row['Barangay']; ?></td>
                                                    <td><?php echo $row['Email']; ?></td>
                                                    <td>
                                                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                        <a href="manage_user.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No users found.</td></tr>";
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
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->

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

    <script>
      $(document).ready(function() {
        // Show the confirmation modal and set the href of the delete button
        $('.btn-danger').on('click', function(event) {
          event.preventDefault();
          var deleteUrl = $(this).attr('href');
          $('#confirmDeleteBtn').attr('href', deleteUrl);
          $('#confirmationModal').modal('show');
        });
      });
    </script>

</body>

</html>

<?php } ?>
