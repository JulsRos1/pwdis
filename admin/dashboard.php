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

    // Disability Data
    $disabilityQuery = "SELECT disability_type, COUNT(*) as user_count FROM users GROUP BY disability_type";
    $disabilityResult = $con->query($disabilityQuery);

    $disabilityLabels = [];
    $disabilityData = [];

    while ($row = $disabilityResult->fetch_assoc()) {
        $disabilityLabels[] = $row['disability_type'];
        $disabilityData[] = (int) $row['user_count'];
    }

    // User Count by Barangay
    $barangayQuery = "SELECT barangay, COUNT(*) as user_count FROM users GROUP BY barangay";
    $barangayResult = $con->query($barangayQuery);

    $barangayLabels = [];
    $barangayData = [];

    while ($row = $barangayResult->fetch_assoc()) {
        $barangayLabels[] = $row['barangay'];
        $barangayData[] = (int) $row['user_count'];
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <title> PWDIS | Admin Dashboard</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <style>
            .chart-container {
                width: 100%;
                height: 400px;
                margin: 20px 50px;
                padding: 20px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .chart-row {
                display: flex;
                justify-content: center;
                margin-bottom: 30px;
            }

            .chart-col {
                flex: 1;
                max-width: 600px;
                margin: 0 15px;
            }

            .chart-title {
                font-size: 16px;
                color: #333;
                margin-bottom: 15px;
                font-weight: 500;
            }
        </style>
    </head>

    <body class="fixed-left">
        <div id="wrapper">
            <div class="topbar">
                <div class="topbar-left">
                    <a href="index.html" class="logo"><span>NP<span>Admin</span></span><i class="mdi mdi-layers"></i></a>
                </div>
                <?php include('includes/topheader.php'); ?>
            </div>

            <?php include('includes/leftsidebar.php'); ?>

            <div class="content-page">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Dashboard</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">PWDIS</a></li>
                                        <li><a href="#">Admin</a></li>
                                        <li class="active">Dashboard</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <a href="manage_user.php">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="card-box widget-box-one">
                                        <i class="fas fa-users fa-lg widget-one-icon"></i>
                                        <div class="wigdet-one-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Users</p>
                                            <?php
                                            $query = mysqli_query($con, "select * from users");
                                            $countusers = mysqli_num_rows($query);
                                            ?>
                                            <h2><?php echo htmlentities($countusers); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="manage-posts.php">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="card-box widget-box-one">
                                        <i class="fas fa-file-alt widget-one-icon fa-lg"></i>
                                        <div class="wigdet-one-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Posts">Resources</p>
                                            <?php
                                            $query = mysqli_query($con, "select * from tblposts where Is_Active=1");
                                            $countposts = mysqli_num_rows($query);
                                            ?>
                                            <h2><?php echo htmlentities($countposts); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="manage_reviews.php">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="card-box widget-box-one">
                                        <i class="fas fa-star fa-lg widget-one-icon"></i>
                                        <div class="wigdet-one-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Reviews</p>
                                            <?php
                                            $query = mysqli_query($con, "select * from reviews");
                                            $countreviews = mysqli_num_rows($query);
                                            ?>
                                            <h2><?php echo htmlentities($countreviews); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-6">
                                    <div class="chart-container">
                                        <canvas id="disabilityPieChart"></canvas>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-md-5 col-sm-6">
                                    <div class="chart-container">
                                        <canvas id="ratingChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-6">
                                    <div class="chart-container">
                                        <canvas id="accessibilityChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-6">
                                    <div class="chart-container">
                                        <canvas id="barangayChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include('includes/footer.php'); ?>
                </div>
            </div>

            <script>
                // Common options for all charts to ensure uniformity
                const commonOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const label = tooltipItem.label || '';
                                    const value = tooltipItem.raw || 0; // Default to 0 if no data
                                    return `${label}: ${value > 0 ? value : 'No Data'}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: '',
                            },
                            grid: {
                                display: false, // Hide vertical grid lines for cleaner look
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '',
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)', // Subtle grid lines for y-axis
                            }
                        }
                    }
                };

                // Accessibility Line Chart
                console.log('Accessibility Labels:', <?php echo json_encode($accessibilityLabels); ?>);
                console.log('Accessibility Data:', <?php echo json_encode($accessibilityData); ?>);
                const ctxAccessibility = document.getElementById('accessibilityChart').getContext('2d');
                const accessibilityChart = new Chart(ctxAccessibility, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($accessibilityLabels); ?>,
                        datasets: [{
                            label: 'Accessibility Count of Places',
                            data: <?php echo json_encode($accessibilityData); ?>,
                            backgroundColor: 'rgba(38, 185, 154, 0.2)',
                            borderColor: '#26B99A',
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#26B99A',
                            borderWidth: 3,
                            fill: true
                        }]
                    },
                    options: {
                        ...commonOptions,
                        scales: {
                            ...commonOptions.scales,
                            x: {
                                ...commonOptions.scales.x,
                                title: {
                                    display: true,
                                    text: 'Accessibility Levels'
                                }
                            },
                            y: {
                                ...commonOptions.scales.y,
                                title: {
                                    display: true,
                                    text: 'Count'
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
                            label: 'Places Ratings',
                            data: <?php echo json_encode($ratingData); ?>,
                            backgroundColor: '#3498DB',
                            borderColor: '#3498DB',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        ...commonOptions,
                        scales: {
                            ...commonOptions.scales,
                            x: {
                                ...commonOptions.scales.x,
                                title: {
                                    display: true,
                                    text: 'Ratings'
                                }
                            },
                            y: {
                                ...commonOptions.scales.y,
                                title: {
                                    display: true,
                                    text: 'Count'
                                }
                            }
                        }
                    }
                });

                // Disability Pie Chart
                const ctxPie = document.getElementById('disabilityPieChart').getContext('2d');
                const disabilityPieChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($disabilityLabels); ?>,
                        datasets: [{
                            label: 'Users per Disability Type',
                            data: <?php echo json_encode($disabilityData); ?>,
                            backgroundColor: [
                                '#F39C12', '#3498DB', '#E74C3C', '#9B59B6', '#1ABC9C'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        ...commonOptions
                    }
                });

                // Barangay Bar Chart
                const ctxBarangay = document.getElementById('barangayChart').getContext('2d');
                const barangayChart = new Chart(ctxBarangay, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($barangayLabels); ?>,
                        datasets: [{
                            label: 'Users per Barangay',
                            data: <?php echo json_encode($barangayData); ?>,
                            backgroundColor: '#1ABC9C',
                            borderColor: '#16A085',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        ...commonOptions,
                        scales: {
                            ...commonOptions.scales,
                            x: {
                                ...commonOptions.scales.x,
                                title: {
                                    display: true,
                                    text: 'Barangay'
                                }
                            },
                            y: {
                                ...commonOptions.scales.y,
                                title: {
                                    display: true,
                                    text: 'User Count'
                                }
                            }
                        }
                    }
                });
            </script>

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
    </body>

    </html>
<?php } ?>