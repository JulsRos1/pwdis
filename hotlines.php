<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_login'])) {
    header("Location: user_login.php");
    exit;
} else {
    $query = mysqli_query($con, "SELECT * FROM emergency_hotlines ORDER BY title ASC");
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Emergency Hotlines</title>
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="css/sidebar.css" rel="stylesheet">
        <style>
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
            }

            .content-page {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .hotline-card {
                margin-bottom: 30px;
                box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
                border-radius: 12px;
                transition: 0.3s;
                padding: 20px;
                margin-top: 30px;
            }

            .hotline-card:hover {
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            }

            .page-title {
                margin-top: 20px;
            }

            .hotline-icon {
                font-size: 30px;
                color: #007bff;
            }

            .hotline-details {
                padding: 10px;
            }

            .call-button {
                margin-top: 10px;
            }
        </style>
    </head>

    <body class="fixed-left">
        <div class="top-header">
            <div class="logo-header">
                <a href="dashboard.php">
                    <img src="images/pwdislogo.png" alt="pwdislogo" class="logo-image">
                </a>
            </div>
            <button class="openbtn" onclick="toggleNav()">&#9776;</button>
        </div>
        <?php include("includes/sidebar.php"); ?>
        <div id="main">
            <div id="wrapper1">
                <div class="content-page">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <h4 class="page-title">Emergency and Support Hotlines</h4>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <?php
                                while ($row = mysqli_fetch_array($query)) {
                                    $hotlineNumber = htmlentities($row['number']);
                                    $isMobile = preg_match('/^0\d{10}$/', $hotlineNumber);
                                    $isLandline = preg_match('/^\d{3}\d{7}$/', $hotlineNumber); // Landline: 3 digits followed by 7 digits
                                    $iconClass = $isMobile ? 'fas fa-mobile-alt' : ($isLandline ? 'fas fa-phone' : 'fas fa-phone');

                                    // Prepare call link
                                    $callLink = "tel:" . preg_replace('/[() ]/', '', $hotlineNumber);

                                    // Format landline for display
                                    $formattedNumber = $isLandline ? '(' . substr($hotlineNumber, 0, 3) . ') ' . substr($hotlineNumber, 3, 3) . ' ' . substr($hotlineNumber, 6) : $hotlineNumber;
                                ?>
                                    <div class="col-md-6 col-lg-4 col-12">
                                        <div class="card hotline-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="hotline-icon mr-3">
                                                        <i class="<?php echo $iconClass; ?>"></i>
                                                    </div>
                                                    <div class="hotline-details">
                                                        <h5 class="card-title"><?php echo htmlentities($row['title']); ?></h5>
                                                        <p class="card-text"><?php echo $formattedNumber; ?></p>
                                                        <a href="<?php echo $callLink; ?>" class="btn btn-primary">Call Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                    <?php include('includes/footer.php'); ?>
                </div>
            </div>

            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script>
                function toggleNav() {
                    const sidebar = document.getElementById("mySidebar");
                    if (sidebar.style.width === "250px") {
                        closeNav();
                    } else {
                        openNav();
                    }
                }
                // Function to open sidebar
                function openNav() {
                    document.getElementById("mySidebar").style.width = "250px";
                    document.getElementById("main").style.marginLeft = "250px";
                }

                // Function to close sidebar
                function closeNav() {
                    document.getElementById("mySidebar").style.width = "0";
                    document.getElementById("main").style.marginLeft = "0";
                }
            </script>
    </body>

    </html>
<?php } ?>