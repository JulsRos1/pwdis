<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Fetch data for the charts (from stats.php)
    // Accessibility Data
    $accessibilityQuery = "SELECT accessibility_level, COUNT(*) as count FROM place_accessibility GROUP BY accessibility_level";
    $accessibilityResult = $con->query($accessibilityQuery);

    $accessibilityLabels = [];
    $accessibilityData = [];

    while ($row = $accessibilityResult->fetch_assoc()) {
        $accessibilityLabels[] = $row['accessibility_level'];
        $accessibilityData[] = (int) $row['count'];
    }

    // Rating Data
    $ratingQuery = "SELECT rating, COUNT(*) as count FROM reviews GROUP BY rating";
    $ratingResult = $con->query($ratingQuery);

    $ratings = [5, 4, 3, 2, 1];
    $ratingLabels = ["5 stars", "4 stars", "3 stars", "2 stars", "1 star"];
    $ratingData = array_fill(0, count($ratings), 0);

    while ($row = $ratingResult->fetch_assoc()) {
        $rating = (int) $row['rating'];
        $ratingData[5 - $rating] = (int) $row['count'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <!-- App title -->
    <title> PWDIS | Admin Dashboard</title>
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <style>
        .chart-container {
            width: 80%; /* Adjust width to make it narrower */
            max-width: 500px; /* Maximum width */
            height: 300px; /* Adjust height to make it taller */
            margin-bottom: 30px;
        }
    </style>
</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
                <a href="index.html" class="logo"><span>NP<span>Admin</span></span><i class="mdi mdi-layers"></i></a>
            </div>
            <!-- Button mobile view to collapse sidebar menu -->
            <?php include('includes/topheader.php'); ?>
        </div>
        <!-- Top Bar End -->

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
                                <h4 class="page-title">Dashboard</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">PWDIS</a>
                                    </li>
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li class="active">
                                        Dashboard
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <!-- Existing Cards -->
                        <a href="manage-categories.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-chart-areaspline widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Categories Listed</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblcategory where Is_Active=1");
                                        $countcat = mysqli_num_rows($query);
                                        ?>
                                        <h2><?php echo htmlentities($countcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="manage-posts.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-layers widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">POSTS</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblposts where Is_Active=1");
                                        $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="trash-posts.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-layers widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">TRASH POSTS</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblposts where Is_Active=0");
                                        $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- end row -->

                    <!-- Charts Row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="chart-container">
                                <canvas id="accessibilityChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="chart-container">
                                <canvas id="ratingChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- end charts row -->

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
        // Accessibility Line Chart
        const ctxAccessibility = document.getElementById('accessibilityChart').getContext('2d');
        const accessibilityChart = new Chart(ctxAccessibility, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($accessibilityLabels); ?>,
                datasets: [{
                    label: 'Accessibility count of Places',
                    data: <?php echo json_encode($accessibilityData); ?>,
                    backgroundColor: 'rgba(38, 185, 154, 0.31)', 
                    pointbackgroundColor: 'rgba(38, 185, 154, 0.7)',
                    borderColor: 'rgba(38, 185, 154, 0.7)', 
                    pointHoverborderColor: 'rgba(220, 220, 220, 1)', 
                    pointHoverBackgroundColor: '#fff', 
                    pointborderWidth: 2,
                    fill: false // No fill under the line
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Accessibility Level'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const label = tooltipItem.label || '';
                                const value = tooltipItem.raw || 0;
                                return `${label}: ${value} places`;
                            }
                        }
                    }
                }
            }
        });

        // Rating Bar Chart
        const ctxRating = document.getElementById('ratingChart').getContext('2d');
        const ratingChart = new Chart(ctxRating, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($ratingLabels); ?>,
                datasets: [{
                    label: 'Rating Distribution',
                    data: <?php echo json_encode($ratingData); ?>,
                    backgroundColor: 'rgba(38, 185, 154, 0.31)', 
                    pointbackgroundColor: 'rgba(38, 185, 154, 0.7)',
                    borderColor: 'rgba(38, 185, 154, 0.7)', 
                    pointHoverborderColor: 'rgba(220, 220, 220, 1)', 
                    pointHoverBackgroundColor: '#fff', 
                    pointborderWidth: 2,
                    fill: false // No fill under the line
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Rating'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
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
    <script src="../plugins/switchery/switchery.min.js"></script>
    <!-- Counter js  -->
    <script src="../plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="../plugins/counterup/jquery.counterup.min.js"></script>
    <!--Morris Chart-->
    <script src="../plugins/morris/morris.min.js"></script>
    <script src="../plugins/raphael/raphael-min.js"></script>
    <!-- Dashboard init -->
    <script src="assets/pages/jquery.dashboard.js"></script>
    <!-- App js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>

</body>

</html>
<?php } ?>
