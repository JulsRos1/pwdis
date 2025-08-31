<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Fetch reviews from the database
    $reviewQuery = "SELECT * FROM reviews"; // Adjust the table name if necessary
    $reviewResult = mysqli_query($con, $reviewQuery);

    // Delete review functionality
    if (isset($_GET['delete'])) {
        $reviewId = intval($_GET['delete']);

        // Begin transaction
        mysqli_begin_transaction($con);
        try {
            // Delete the review
            $deleteReview = "DELETE FROM reviews WHERE id = ?";
            $stmt = mysqli_prepare($con, $deleteReview);
            mysqli_stmt_bind_param($stmt, 'i', $reviewId);
            mysqli_stmt_execute($stmt);

            // Commit transaction
            mysqli_commit($con);

            // Success message
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Review deleted successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'swal-popup'
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
                                popup: 'swal-popup'
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
        <link rel="stylesheet" href="../plugins/morris/morris.css">

        <!-- jvectormap -->
        <link href="../plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

        <!-- App css -->
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
                                    <h4 class="page-title">Reviews Management</h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" id="reviewSearch" placeholder="Search reviews..." style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="header-title">Manage Reviews</h4>
                                <div class="table-responsive">
                                    <table class="table table-colored table-bordered table-centered table-inverse m-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Contributor</th>
                                                <th>Place Name</th>
                                                <th>Place</th>
                                                <th>Review</th>
                                                <th>Rating</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reviewTableBody">
                                            <?php
                                            if (mysqli_num_rows($reviewResult) > 0) {
                                                while ($row = mysqli_fetch_assoc($reviewResult)) {
                                            ?>
                                                    <tr>
                                                        <td data-label="ID"><?php echo $row['id']; ?></td>
                                                        <td data-label="Full Name"><?php echo $row['full_name']; ?></td>
                                                        <td data-label="Display Name"><?php echo $row['display_name']; ?></td>
                                                        <td data-label="Place Type"><?php echo $row['place_type']; ?></td>
                                                        <td data-label="Review"><?php echo $row['review']; ?></td>
                                                        <td data-label="Rating"><?php echo $row['rating']; ?></td>
                                                        <td data-label="Review Date"><?php echo $row['review_date']; ?></td>
                                                        <td data-label="Actions">
                                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-record" 
                                                               data-id="<?php echo $row['id']; ?>">Delete</a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='9' class='text-center'>No reviews found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Real-time search functionality
                var reviewSearch = document.getElementById('reviewSearch');
                var reviewTableBody = document.getElementById('reviewTableBody');

                if (reviewSearch && reviewTableBody) {
                    reviewSearch.addEventListener('keyup', function() {
                        var searchValue = this.value.toLowerCase();
                        var rows = reviewTableBody.getElementsByTagName('tr');

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

                // Delete functionality using AJAX
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
                                url: 'manage_reviews.php',
                                type: 'GET',
                                data: { delete: id },
                                success: function(response) {
                                    // Remove the row from the table
                                    $(e.target).closest('tr').remove();
                                    
                                    Swal.fire(
                                        'Deleted!',
                                        'Review has been deleted.',
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
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- Dashboard Init js -->
        <script src="assets/pages/jquery.blog-dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
    </body>

    </html>

<?php } ?>